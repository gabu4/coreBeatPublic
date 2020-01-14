<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 03/09/19
 */
if ( !defined('H-KEI') ) { exit; }

class corebeat_api {
    private $api_key;
    private $api_secret;
    private $api_version = '1.0';
    private $api_url;
    
    private $requestRememberUse = TRUE;
    private $requestRemember = [];
    private $requestRememberSecond = 5;
    
    public function __construct(array $array = []){
        if ( empty($array) ) { die('corebeat_api set not filled'); }
        
        foreach ($array as $k=>$v) { $this->$k=$v; }
        if ( empty($this->api_key) ) { die('corebeat_api set api_key empty'); }
        if ( empty($this->api_secret) ) { die('corebeat_api set api_secret empty'); }
        if ( empty($this->api_version) ) { die('corebeat_api set api_version empty'); }
        if ( empty($this->api_url) ) { die('corebeat_api set api_url empty'); }
    }
    
    public function get_token() {
        $token = $this->sessionGetToken();
        if ( $token ) { return $token; }
        
        $cURL = curl_init();
        
        $url = $this->api_url.'/api/token';
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_USERPWD, $this->api_key.":".$this->api_secret);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Accept:application/json"));
        
        $result = curl_exec($cURL);
        $info = curl_getinfo($cURL);
        curl_close($cURL);
//        cbd('tokenget);cbd($result);
//        cbdl('tokenget');cbdl($result);
        
        $json = cb_is_json($result,TRUE);
        if ( $info['http_code'] === 200 ) {
            $this->sessionSaveToken($json);
            return $json['token'];
        } else {
            cb_error_log('ERROR_CB_API: Connenct error (get_token), '.$info['http_code']);
            return FALSE;
        }
    }
    
    public function get($path,$token=NULL,$force=FALSE) {
        if ( $token === NULL ) { $token = $this->sessionGetToken(); }
        if ( $token === NULL || $token === FALSE ) { return FALSE;cb_error_log('ERROR_CB_API: No token!, '.$path); }
        if ( $force !== TRUE ) { $rememberedJson = $this->requestRememberCheck($path,$token); if ( $rememberedJson ) { return $rememberedJson; } }
        $cURL = curl_init();
        
        $url = $this->api_url.'/'.$path;
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Accept:application/json","token:".$token));

        $result = curl_exec($cURL);
        $info = curl_getinfo($cURL);
        curl_close($cURL);
//        cbd($path);cbd($result);
//        cbdl($path);cbdl($result);
        
        $json = cb_is_json($result,TRUE);
        if ( $info['http_code'] === 200 ) {
            $this->sessionSaveToken($json);
            $this->requestRememberSave($path,$token,NULL,$json);
            return $json;
        } else {
            return $json;
//            cb_error_log('ERROR_CB_API: Connenct error (get|'.$path.'), '.$info['http_code']);
//            return FALSE;
        }
    }
    
    public function post($path,$data,$token=NULL,$force=FALSE) {
        if ( $token === NULL ) { $token = $this->sessionGetToken(); }
        if ( $token === NULL || $token === FALSE ) { return FALSE;cb_error_log('ERROR_CB_API: No token!, '.$path); }
        if ( empty($data) || !is_array($data) ) { return FALSE; }
        if ( $force !== TRUE ) { $rememberedJson = $this->requestRememberCheck($path,$token,$data); if ( $rememberedJson ) { return $rememberedJson; } }
        $cURL = curl_init();
        
        $url = $this->api_url.'/'.$path;
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $datajson = cb_json_encode($data);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Accept:application/json","token:".$token,"cbpost:".$datajson));
        
        curl_setopt($cURL, CURLOPT_POST, TRUE);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($cURL);
        $info = curl_getinfo($cURL);
        curl_close($cURL);
//        cbd($path);cbd($result);
//        cbdl($path);cbdl($result);
        
        $json = cb_is_json($result,TRUE);
        if ( $info['http_code'] === 200 ) {
            $this->sessionSaveToken($json);
            $this->requestRememberSave($path,$token,$data,$json);
            return $json;
        } else {
            return $json;
//            cb_error_log('ERROR_CB_API: Connenct error (post|'.$path.'), '.$info['http_code']);
//            return FALSE;
        }
    }
    
    private function sessionGetToken() {
        if ( isset($_SESSION['corebeat_api']) && isset($_SESSION['corebeat_api']['token']) && !empty($_SESSION['corebeat_api']['token']) ) { 
            $d = time();
//            cbd($_SESSION['corebeat_api']['token']);
            if ( strtotime($_SESSION['corebeat_api']['token_life']) > $d ) {
                if ( $_SESSION['corebeat_api']['token_life_last_time'] <= (time() - 2) || $_SESSION['corebeat_api']['token_life_uses'] >= 10 ) {
                    return $this->get('api/token_update',$_SESSION['corebeat_api']['token'])['token'];
                } else {
                    $_SESSION['corebeat_api']['token_life_uses']++;
                    return $_SESSION['corebeat_api']['token'];
                }
            }
        }
        return FALSE;
    }
    
    private function sessionSaveToken($json) {
        if ( isset($json['token']) && !empty($json['token']) ) {
            $_SESSION['corebeat_api']['token'] = $json['token'];
            $_SESSION['corebeat_api']['token_life'] = $json['token_life'];
            $_SESSION['corebeat_api']['token_life_last_time'] = time();
            $_SESSION['corebeat_api']['token_life_uses'] = 0;
            return TRUE;
        }
        return FALSE;
    }
    
    private function requestRememberCheck($path,$token,$data=[]) {
        global $user, $handler;
        if ( $this->requestRememberUse !== TRUE ) { return FALSE; }
        if ( is_array($data) ) { $data = implode("|",$data); }
        $crc = crc32($path.$token).crc32($data.$user->cb_get_user_id());
        $json = $handler->getDataOverSessionTimed('cb_api',$crc);
        if ( !$json ) { return FALSE; }
        return $json;
    }
    
    private function requestRememberSave($path,$token,$data=[],$json="") {
        global $user, $handler;
        if ( $this->requestRememberUse !== TRUE ) { return FALSE; }
        if ( is_array($data) ) { $data = implode("|",$data); }
        $crc = crc32($path.$token).crc32($data.$user->cb_get_user_id());
        $handler->setDataOverSessionTimed('cb_api',$crc,$json,$this->requestRememberSecond);
        return TRUE;
    }
}

?>