<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v029
 * @date 30/10/19
 */
if ( !defined('H-KEI') ) { exit; }

class session {
    private $session = FALSE;
    private $session_life = FALSE;
    private $api_token = FALSE;
    private $api_token_life = FALSE;
    
    private $data = Array(
        'user_id' => 0,
        'grouplevel' => 0,
        'lang' => CB_LANGTYPE,
        'device' => '',
        'ip' => ''
    ); //session adatok tárolása

    public function init() {
        $this->sessionStart();
        $this->removeOldSessionFromDB();
        $this->sessionCheck();
    }

    private function sessionStart() {
        session_start();
        $this->sessionId();
    }
    
    public function getData($key = NULL) {
        if ( $key !== NULL && isset($this->data['key']) ) {
            return $this->data['key'];
        } elseif ( $key !== NULL ) {
            cbd('FATAL ERROR: Requested session data not exist!',1);
        } else {
            return $this->data;
        }
    }

    private function sessionId() {
        global $is_api, $server;
        if ( $is_api === TRUE ) {
            $server_token = ( isset($server['HTTP_TOKEN']) ? trim($server['HTTP_TOKEN']) : ( isset($server['HTTP_SID']) ? trim($server['HTTP_SID']) : "" ) );
            $token_session = $this->tokenCheck($server_token);
            if ( $token_session && isset($_SESSION) && isset($_SESSION['SID']) && $_SESSION['SID'] !== $token_session ) {
                $this->removeDBSessionFromDB($_SESSION['SID']);
                $_SESSION['SID'] = $token_session;
            } elseif ( $token_session ) {
                $_SESSION['SID'] = $token_session;
            }
        } elseif ( isset($_COOKIE['CB_SID']) && !empty($_COOKIE['CB_SID']) && !$is_api ) {
            $haveCookie = $this->sessionCookieCheck($_COOKIE['CB_SID']);
            if ( $haveCookie ) {
                $_SESSION['SID'] = $_COOKIE['CB_SID'];
            } else {
                setcookie('CB_SID','','-1','/');
            }
        } 
        if ( !isset($_SESSION['SID']) || empty($_SESSION['SID']) ) {
            $_SESSION['SID'] = cb_generate_code(128);
        }
    }

    private function sessionDestroy() {
        global $database, $is_api;
        $sessDelete = Array("session" => $_SESSION['SID']);
        $a = $database->deleteFrom("#__session",$sessDelete);
        if ( !$is_api ) setcookie('CB_SID','','-1','/');
        session_unset();
        session_destroy();
    }

    public function sessionSave( $user_id = 0, $level = 0, $toCookie = FALSE ) {
        global $database, $server, $lang, $is_api;
        
        $sessionEndTime_raw = time()+ CB_SESSIONVALUE;
        $sessionEndTime = cb_time_to_date($sessionEndTime_raw);
        $sessionEndTime_long_raw = time()+ CB_SESSIONSTAYLOGINVALUE;
        $sessionEndTime_long = cb_time_to_date($sessionEndTime_long_raw);

        $sess = Array();
        $sess['session'] = $_SESSION['SID'];
        $this->data['user_id'] = $sess['uid'] = $user_id;
        $this->data['grouplevel'] = $sess['grouplevel'] = $level;
        $this->data['last_page'] = $sess['last_page'] = CB_HTTPPAGEADDRESS;
        $this->data['lang'] = $sess['lang'] = $lang->getLanguage();
        $this->data['ip'] = $sess['ip'] = $server['REMOTE_ADDR'];
        $sess['sessionrowtime'] = cb_time_to_date();
        if ( $toCookie === TRUE ) { 
            if ( !$is_api ) setcookie('CB_SID',$_SESSION['SID'],$sessionEndTime_long_raw,'/'); 
            $sess['sessionend'] = $sessionEndTime_long;
            $sess['longlive'] = 1;
        } else {
            if ( !$is_api ) setcookie('CB_SID','','-1','/'); 
            $sess['sessionend'] = $sessionEndTime;
            $sess['longlive'] = 0;
        }
        
        $deleteArray = Array();
        $deleteArray['session'] = $sess['session'];
        $r = $database->deleteFrom("#__session",$deleteArray);
        $r2 = $database->insertTo("#__session",$sess);
        
        $this->checkDosAttack($sess['ip'],$sess['session']);
        
        return $sess;
    }

    private function sessionUpdate($sess,$ip) {
        global $database;
        
        if ( $sess['longlive'] == '1' ) {
            $sessionEndTime = cb_time_to_date(time()+ CB_SESSIONSTAYLOGINVALUE);
        } else {
            $sessionEndTime = cb_time_to_date(time() + CB_SESSIONVALUE);
        }
        
        $last_page = CB_HTTPPAGEADDRESS;
        $database->doQuery(" UPDATE `#__session` SET `sessionend` = '$sessionEndTime', `ip` = '$ip', `last_page` = '$last_page' WHERE `session` = '".$sess['session']."' ");

        $this->session = $sess['session'];
        $this->session_life = $sess['sessionend'] = $sessionEndTime;

        return $sess;
    }

    private function removeDBSessionFromDB($session_id) {
        global $database;
        
        $database->doQuery(" DELETE FROM `#__session` WHERE `session` = '$session_id' ");
    }
    
    private function removeOldSessionFromDB() {
        global $database;

        $now = cb_time_to_date();
        
        $database->doQuery(" DELETE FROM `#__session` WHERE `sessionend` < '$now' "); //törli a lejárt sessionokat adatbázisból
    }
    
    private function sessionCheck() {
        global $database, $server;

        $now = cb_time_to_date();
        
        $database->doQuery(" DELETE FROM `#__session` WHERE `session` = '".$_SESSION['SID']."' AND `ip` != '".$server['REMOTE_ADDR']."' AND `longlive` = '0' "); //session és korábbi ip cím különbség esetén adatbázis érték törlése, ha nem longlive a belépés (kényszerített kilépés)

        $sess = $database->newQuery()->select("*")->from("`#__session`")->wAndIsEqual("session",$_SESSION['SID'])->qType("row")->execute();

        if ( !empty($sess) ) {
            $sess = $this->sessionUpdate($sess,$server['REMOTE_ADDR']);
        }

        if ( empty($sess) ) {
//            cb_error_log('assa '.$database->lastQuery());
            $this->sessionDestroy();
            $this->sessionStart();
            $this->sessionSave();
        }

        $this->data['lang'] = $sess['lang'];
        $this->data['user_id'] = $sess['uid'];
        $this->data['grouplevel'] = $sess['grouplevel'];
        $this->data['ip'] = $sess['ip'];
        
        $this->checkDosAttack($sess['ip'],$sess['session']);
    }
    
    private function sessionCookieCheck($cookie) {
        global $database;
        
        $sess = $database->newQuery()->sSelect("session")->from("`#__session`")->wAndIsEqual("session",$cookie)->wAndIsEqual("longlive",1)->qType("row")->execute();
        
        if ( !empty($sess) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function tokenCheck($token) {
        global $database;

        $this->tokenRemoveOld();
        if ( empty($token) ) { return FALSE; }
        
        $t = $database->newQuery()->select("*")->from("`#__session_token`")->wAndIsEqual("token",$token)->qType("row")->execute();
        if ( !empty($t) ) {  $this->tokenUpdate($token);return $t['session']; }
        
        return FALSE;
    }
    
    private function tokenCheckSession($session) {
        global $database;

        $this->tokenRemoveOld();
        if ( empty($session) ) { return FALSE; }
        
        $t = $database->newQuery()->select("*")->from("`#__session_token`")->wAndIsEqual("session",$session)->qType("row")->execute();
        if ( !empty($t) ) { return $t['token']; }
        
        return FALSE;
    }
    
    public function get_token() { return $this->api_token; }
    public function get_token_life() { return $this->api_token_life; }
    
    public function tokenCreate(&$token,$device) {
        global $database;
        
        $previousToken = $this->tokenCheckSession($_SESSION['SID']);
        if ( !empty($previousToken) ) { $token = $previousToken;$this->tokenUpdate($token);return TRUE; }
        
        $tokenEndTime = cb_time_to_date(time()+ CB_API_TOKEN_LIVE);

        $t = [
            'token'=>$token,
            'session'=>$_SESSION['SID'],
            'device'=>$device,
            'tokenend'=>$tokenEndTime
        ];
        $t2 = $database->insertTo("#__session_token",$t);
        
        if ( $t2 ) {
            $this->data['device'] = $device;
            $this->api_token = $token;
            $this->api_token_life = $tokenEndTime;
            return TRUE;
        }
        
        return FALSE;
    }
    
    private function tokenUpdate($token) {
        global $database;
        
        $tokenEndTime = cb_time_to_date(time()+ CB_API_TOKEN_LIVE);
        $this->api_token = $token;
        $this->api_token_life = $tokenEndTime;
        
        return $database->doQuery(" UPDATE `#__session_token` SET `tokenend` = '$tokenEndTime' WHERE `token` = '$token' ");
    }
    
    private function tokenRemoveOld() {
        global $database;

        $now = cb_time_to_date();
        $database->doQuery(" DELETE FROM `#__session_token` WHERE `tokenend` < '$now' "); //törli a lejárt tokeneket adatbázisból
    }
    
    private function tokenDestroy($token) {
        global $database;
        $tokenDelete = Array("token" => $token);
        return $database->deleteFrom("#__session_token",$tokenDelete);
    }
    
    //* DDos hoz írni api kapcsolati limitet *//
    private function checkDosAttack($ip, $sessionId) {
        global $database, $is_api;
        if ( $is_api ) { return FALSE; }
        $sessionrowtime = cb_time_to_date(time() - CB_SESSIONDDOSTIME);
        
        $c = $database->newQuery()->sCount("session")->from("`#__session`")->wAndIsEqualOrBigger("sessionrowtime",$sessionrowtime)->wAndIsEqual("ip",$ip)->qType("integer")->execute();
        
        $sdc = (int) CB_SESSIONDDOSCOUNT;
        
        $possibleDos = FALSE;
        
        if ( $c >= $sdc ) { $possibleDos = TRUE; }
        
        if ( $possibleDos === TRUE ) {
            global $out_html;
            
            $database->doQuery(" UPDATE `#__session` SET `dos` = '1' WHERE `session` = '$sessionId' ");
            
            $out_html->loadErrorPage429();
            
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getSessionId() {
        return $_SESSION['SID'];
    }
}

return; ?>