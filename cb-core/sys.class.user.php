<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v046
 * @date 20/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class user {

    private $data = [
        'user_id' => 0, //belépett felhasználó ID-ja
        'user_level' => 0, //belépett felhasználó szintje
        'user_email' => '', //belépett felhasználó emial címe
        'display_name' => '', //belépett felhasználó megjelenő név
        'user_type' => '' //belépett felhasználó típusa (local, corebeat_api, facebook, google ...)
    ]; //Felhasználói adatok tárolása
    public $dataExt = []; //Bővített felhasználói adatok tárolása
    private $data_sdk = []; //sdk user adat tároló (ha API-n keresztüli bejelentkezés történt!)
    
    public function init() {
        $this->setUserData(); //Felhasználói adatok beállítása
    }

    public function cb_get_user_id() {
        return (int) $this->data['user_id'];
    }
    
    public function cb_get_user_sdk_uid() {
        if ( empty($this->data_sdk) ) { $this->loadSdkApiDatas(); }
        if ( empty($this->data_sdk) ) { return 0; }
        return (int) $this->data_sdk['uid'];
    }
    
    public function cb_get_user_level() {
        return (int) $this->data['user_level'];
    }

    public function cb_get_user_name() {
        return ( empty($this->data['display_name']) ) ? $this->cb_get_user_email() : $this->data['display_name'];
    }
    
    public function cb_get_user_email() {
        return $this->data['user_email'];
    }
    
    public function cb_get_user_type() {
        return $this->data['user_type'];
    }
    
    // FIXME: egyenlőre userre szűrni nem lehet!
    public function cb_is_admin_access($userid = NULL) {
        global $module;
        
        $uid = ( !empty($userid) ) ? $userid : $this->cb_get_user_id();
        
        if ( $module->cb_check_access('admin','main') ) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function cb_is_admin_access_and_territory() {
        global $get;
        if ( isset($get['admin']) && $this->cb_is_admin_access() ) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function cb_is_admin_territory() {
        global $get;
        
        if ( isset($get['admin']) ) {
            return TRUE;
        }
        
        return FALSE;
    }

    /**
     *  felhasználó beléptetése ha érvényes a felhasználónév és a jelszó 
     */
    public function cb_user_log_in( $userEmail, $password, $toCookie = FALSE, $loginWithoutPassword = FALSE ) {
        global $session, $database, $module;
        
        $database->newQuery()
                        ->sSelect("id")
                        ->sSelect("level")
                        ->sSelect("login_count")
                        ->from("`#__user`")
                        ->wAndIsEqual("state","1")
                        ->wAndIsEqual("email",$userEmail);
        if ( $loginWithoutPassword !== TRUE ) {
            $cpassword = cb_password_crypt($password);
            $database->wAndIsEqual("password",$cpassword);
        }
        $result = $database->qType("row")
                        ->execute();
        
        if ( empty($result) ) { return FALSE; }
        
        $session->sessionSave( $result['id'], $result['level'], $toCookie );
        
        $result['last_login'] = cb_time_to_date();
        $result['login_count'] = (int)$result['login_count'] + 1;
        $updateData = Array( "id" => $result['id'], "last_login" => $result['last_login'], "login_count" => $result['login_count'] );
        $database->updateTo("#__user",'id',$updateData);
        
        $login = ["uid"=>$result['id']];
        $result['last_login'] = cb_time_to_date();
        $result['login_count'] = (int)$result['login_count'] + 1;
        $updateData = Array( "id" => $result['id'], "last_login" => $result['last_login'], "login_count" => $result['login_count'] );
        $database->updateTo("#__user",'id',$updateData);
        
        $this->setUserData(); //Felhasználói adatok beállítása

        $module->init(); //modul elemek újratöltése az új jogosulstágoknak megfelelően

        return TRUE;
    }
    
    /* Felhasználó kiléptetése és session alaphelyzetbe állítása */
    public function cb_user_log_out() {
        global $session, $module;

        $session->sessionSave( 0, 0, FALSE );

        $this->setUserData(); //Felhasználói adatok beállítása

        $module->init(); //modul elemek újratöltése az új jogosulstágoknak megfelelően
                
        return TRUE;
    }


    /* Felhasználói adatok beállítása, hozzáférési szint lekérdezés */
    private function setUserData() {
        global $session, $is_api, $out_html, $module;
        
        $sessdata = $session->getData();

        $this->data['user_level'] = ( !empty($sessdata['grouplevel']) ) ? $sessdata['grouplevel'] : 0;
        $this->data['user_id'] = ( !empty($sessdata['user_id']) ) ? $sessdata['user_id'] : 0;

        $userData = $this->cb_get_user_data_from_id($this->data['user_id']);
        $userDataExtra = $this->cb_get_user_data_extra($this->data['user_id']);

        $this->data['user_email'] = ( isset($userData['email']) && !empty($userData['email']) ? $userData['email'] : "" );
        $this->data['display_name'] = ( isset($userDataExtra['display_name']) && !empty($userDataExtra['display_name']) ? $userDataExtra['display_name'] : "" );
        $this->data['user_type'] = ( isset($userData['type']) && !empty($userData['type']) ? $userData['type'] : "" );
        
        if ( $userData['first_login'] === '1' && $is_api === FALSE ) {
            global $handler;
            $link = $out_html->getModuleFuctionName('account','settings','f=userdata');
            $logoutUrl = $out_html->getModuleFuctionName('account','logout');
            
            if ( $link !== CB_REQUEST_URI && $logoutUrl !== CB_REQUEST_URI ) {
                $handler->messageWarning2('','[LANG_ACCOUNT_FIRST_LOGIN_REDIRECT]','first_login');
                $out_html->redirect($link);
            }
        }
        
        $module->init();
    }

    /* Felhasználó készítése átadott paraméterek alapján

    */
    public function cb_create_user($email, $password = NULL, $type = 'local', $user_data = [], $state = 0, $level = 1) {
        global $database;
        
        if ( empty($password) || $password === NULL ) { $password = cb_generate_code(64); }
        $password_c = cb_password_crypt($password);

        $regCode = cb_generate_code(64);
        $code = cb_generate_code(5);

        $insertData = Array(
            "password" => $password_c,
            "email" => $email,
            "level" => $level,
            "state" => $state,
            "type" => $type,
            "reg_code" => $regCode,
            "reg_date" => date("Y-m-d H:i:s"),
            "code" => $code,
            "first_login" => 1
        );
        
        $res = $database->insertTo("#__user",$insertData);
        
        $account_id = $this->cb_get_user_id_from_email($email);
        if ( $res && !empty($user_data) ) {
            $this->generateUsercode($account_id,TRUE);
            foreach ( $user_data as $k=>$v ) {
                $this->cb_update_user_data_extra($account_id,$k,$v);
            }
        }
        
        return $account_id;
    }

    /* Felhasználó frissítése átadott paraméterek alapján

    */
    public function cb_update_user($account_id, $email = NULL, $password = NULL, $user_data = [], $state = NULL, $level = NULL, $first_login = NULL) {
        global $database;
        
        $updateData = Array(
            "id" => $account_id
        );
        
        if ( $email !== NULL ) { $updateData['email'] = $email; }
        if ( $state !== NULL ) { $updateData['state'] = $state; }
        if ( $level !== NULL ) { $updateData['level'] = $level; }
        if ( $first_login !== NULL ) { $updateData['first_login'] = 1; } else { $updateData['first_login'] = 0; }

        $res = $database->updateTo("#__user",'id',$updateData);
        
        if ( $res && $password !== NULL && $password !== '' && !empty($password) ) {
            $this->cb_new_password($account_id,$password);
        }
        
        if ( $res && !empty($user_data) ) {
            foreach ( $user_data as $k=>$v ) {
                $this->cb_update_user_data_extra($account_id,$k,$v);
            }
        }
        
        return $res;
    }

    public function cb_update_user_image_type($account_id, $imagetype = 'gravatar') {
        global $database;
        
        $updateData = [
            "id" => $account_id,
            "image" => $imagetype
        ];
        
        $res = $database->updateTo("#__user",'id',$updateData);
        
        return $res;
    }
    
    public function cb_delete_user($account_id = 0) {
        global $database;

        if ( $account_id <= 1 ) { return FALSE; }
        
        $result = $database->doQuery(" DELETE FROM `".CB_SQLPREF."user` WHERE `id` = '".$account_id."' "); //felhasználó törlése az adatbázisból

        if ( $result ) {
            $database->doQuery(" DELETE FROM `".CB_SQLPREF."user_data` WHERE `user_id` = '".$account_id."' "); //felhasználó extra adatainak törlése
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function generateUsercode(int $user_id, $forced = false) {
        global $database;
        
        $data = $this->cb_get_user_data_from_id($user_id);
        if ( !empty($data['code']) && $forced === false ) { return $data['code']; }
        $c = $user_id . "Bird ass, " . $data['reg_date'] . "Peter Griffin Logic" . microtime();
        $code = hash('sha256',$c);
        
        $data2 = $database->newQuery()
                        ->select("*")
                        ->from("`#__user`")
                        ->wAndIsEqual("code",$code)
                        ->wAndIsNotEqual("id",$user_id)
                        ->qType("row")
                        ->execute();
        
        if ( !empty($data2) ) {
            $code = $this->generateUsercode($user_id, true);
        } else {
            $updateData = ["id" => $user_id,"code" => $code];
            $database->updateTo("#__user","id",$updateData);
        }
        
        return $code;
    }
    
    public function cb_get_user_level_from_id(int $user_id = 0) {
        global $database;
        
        if ( $user_id === 0 ) {
            $level = 0;
        } else {
            $level = $database->newQuery()
                        ->sSelect("level")
                        ->from("`#__user`")
                        ->wAndIsEqual("id",$user_id)
                        ->qType("integer")
                        ->execute();
        }
        
        return $level;
    }
    
    public function cb_get_user_data_from_id(int $user_id = 0) {
        global $database;
        
        if ( $user_id === 0 ) { return FALSE; }
        
        $data = $database->newQuery()
                        ->select("*")
                        ->from("`#__user`")
                        ->wAndIsEqual("id",$user_id)
                        ->qType("row")
                        ->execute();
        
        if ( !empty($data) ) { return $data; }

        return FALSE;
    }
    
    public function cb_get_user_id_from_email($email) {
        global $database;
        
        $id = $database->newQuery()
                        ->sSelect("id")
                        ->from("`#__user`")
                        ->wAndIsEqual("email",$email)
                        ->qType("integer")
                        ->execute();
        
        if ( !empty($id) ) { return $id; }

        return FALSE;
    }
    
    public function cb_check_email_exist($email,int $user_id = 0) {
        global $database;
        
        $database->newQuery()->sSelect("id")->from("`#__user`")
                            ->wAndIsEqual("email",$email);
        
        if ( $user_id !== 0 ) {
            $database->wAndIsNotEqual("id",$user_id);
        }
        
        $id = $database->qType("integer")->execute();
        
        if ( !empty($id) ) { return TRUE; }
        
        return FALSE;
    }
    
    public function cb_get_data_extra_fields() {
        global $database;
        
        $dataExtraRaw = $database->newQuery()
                          ->select("*")
                          ->from("`#__user_data_fields`")
                          ->qType("array")
                          ->execute();
        
        if ( empty($dataExtraRaw) ) { return FALSE; }
        
        $dataExtra = array();
        foreach ( $dataExtraRaw as $v ) {
            $dataExtra[$v['data_key']]['ucm'] = $v['user_can_mod'];
            $dataExtra[$v['data_key']]['ucs'] = $v['user_can_see'];
            $dataExtra[$v['data_key']]['acm'] = $v['admin_can_mod'];
            $dataExtra[$v['data_key']]['default'] = $v['default_value'];
        }
        
        if ( !empty($dataExtra) ) { return $dataExtra; }
        
        return FALSE;
    }
    
    public function cb_get_user_data_extra(int $user_id = 0) {
        global $database;
        
        $extraFields = $this->cb_get_data_extra_fields();
        if ( $user_id > 0 ) {
            $dataExtraRaw = $database->newQuery()
                          ->select("*")
                          ->from("`#__user_data`")
                          ->wAndIsEqual("user_id",$user_id)
                          ->qType("array")
                          ->execute();
        
            $dataExtraR = array();
            if ( !empty($dataExtraRaw) ) {
                foreach ( $dataExtraRaw as $v ) {
                    $dataExtraR[$v['data_key']] = $v['data_value'];
                }
            }
        }
        
        $dataExtra = array();
        foreach ( $extraFields as $key=>$v ) {
                $dataExtra[$key] = ( isset($dataExtraR[$key]) ) ? $dataExtraR[$key] : $v['default'];
        }
        
        if ( !empty($dataExtra) ) { 
            if ( !empty($dataExtra) ) { return $dataExtra; }
        }
        
        return FALSE;
    }
    
    public function cb_update_user_data_extra(int $user_id = 0, $data_key = NULL, $data_value = NULL) {
        global $database;
        
        if ( $user_id === 0 || $data_key === NULL ) { return FALSE; }
        
        $data_key = strtolower(trim($data_key));
        
        $insertData = Array(
            "user_id" => $user_id,
            "data_key" => $data_key,
            "data_value" => $data_value
        );

        $result = $database->insertOrUpdate("#__user_data",$insertData);
        
        if ( $result ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function cb_remove_user_data_extra(int $user_id = 0, $data_key = NULL) {
        global $database;
        
        if ( $user_id === 0 || $data_key === NULL ) { return FALSE; }
        
        $data_key = strtolower(trim($data_key));
        
        $removeData = Array(
            "user_id" => $user_id,
            "data_key" => $data_key
        );

        $result = $database->deleteFrom("#__user_data",$removeData);
        
        if ( $result ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function cb_search_user_data(int $user_id = 0, $data_key = NULL, $data_value = NULL) {
        global $database;
        
        $database->newQuery()->select("*")->from("`#__user_data`");
        
        if ( $user_id !== 0 ) { $database->wAndIsEqual("user_id",$user_id); }
        if ( $data_key !== NULL ) { $database->wAndIsEqual("data_key",$data_key); }
        if ( $data_value !== NULL ) { $database->wAndIsLikeP("data_value",$data_value); }
        
        $result = $database->qType("array")->execute();
        
        if ( $result ) {
        
            $ret = array();
            foreach ( $result as $d ) {
                $ret[$d['user_id']] = $d;
            }
            return $ret;
        } else {
            return FALSE;
        }
    }

    public function cb_new_password(int $user_id, $password) {
        global $database;

        $password_c = cb_password_crypt($password);
        $updateData = Array( 
            "id" => $user_id,
            "password" => $password_c,
            "pass_reset_date" => 0,
            "pass_reset_code" => ""
            );
        $result = $database->updateTo("#__user",'id',$updateData);
        
        if ( $result ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cb_check_password(int $user_id, $password) {
        global $database;

        $password = cb_password_crypt($password);
//        $result = $database->getSelect("result","`id`","user"," WHERE `id` = '".$id."' AND `password` = '".$password."' ");
        $result = $database->newQuery()
                          ->sSelect("id")
                          ->from("`#__user`")
                          ->wAndIsEqual("id",$user_id)
                          ->wAndIsEqual("password",$password)
                          ->qType("result")
                          ->execute();

        if ( $result ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function cb_check_password_recovery_code($code) {
        global $database;
        
        $c = 60*60+120; //1 hour + 2 min valid time
        $time = time() - $c;
        
//        $id = $database->getSelect("result","`id`","user"," WHERE `pass_reset_code` = '$code' AND `pass_reset_date` >= '$time' ");
        $id = $database->newQuery()
                          ->sSelect("id")
                          ->from("`#__user`")
                          ->wAndIsEqual("pass_reset_code",$code)
                          ->wAndIsEqualOrBigger("pass_reset_date",$time)
                          ->qType("integer")
                          ->execute();

        if ( !empty($id) ) { return $id; }
        return FALSE;
    }
    
    public function cb_get_user_avatar($userIdOrEmail = 0,$size=200,$image=NULL) {
        $gravatarArray = ['gravatar','mp','identicon','monsterid','wavatar','retro','robohash'];
        if ( !is_numeric($userIdOrEmail) ) {
            $email = $userIdOrEmail;
        } else {
            if ( $userIdOrEmail === 0 ) { $userIdOrEmail = $this->cb_get_user_id(); }
            $d = $this->cb_get_user_data_from_id( $userIdOrEmail );
            $image = $d['image'];
            $email = $d['email'];
        }
        if ( $image === NULL ) { $image = 'gravatar'; }
        if ( in_array($image,$gravatarArray)) {
            $hash = md5( strtolower( trim( $email ) ) );
            $gravatarUrl = "https://www.gravatar.com/avatar/".$hash;
            $gravatarUrl .= "?s=".$size;
            if ( $image !== 'gravatar' ) { $gravatarUrl .= "&f=y&d=".$image; }
            return $gravatarUrl;
        }
        return FALSE;
    }
    
    public function cb_get_user_registration_date(int $account_id) {
        global $database;
        $reg_date = $database->newQuery()
                          ->sSelect("reg_date")
                          ->from("`#__user`")
                          ->wAndIsEqual("id",$account_id)
                          ->qType('result')
                          ->execute();
        if ( $reg_date ) { return $reg_date; }
        else { return FALSE; }
    }
    
    public function cb_get_user_login_last(int $account_id) {
        global $database;
        $last_login = $database->newQuery()
                          ->sSelect("last_login")
                          ->from("`#__user`")
                          ->wAndIsEqual("id",$account_id)
                          ->qType('result')
                          ->execute();
        if ( $last_login ) { return $last_login; }
        else { return FALSE; }
    }
    
    public function cb_get_user_login_count(int $account_id) {
        global $database;
        $last_login = $database->newQuery()
                          ->sSelect("login_count")
                          ->from("`#__user`")
                          ->wAndIsEqual("id",$account_id)
                          ->qType('integer')
                          ->execute();
        if ( $last_login !== FALSE ) { return $last_login; }
        else { return FALSE; }
    }
    
    public function cb_get_user_is_active_last_time(int $account_id,int $minute = 5) {
        global $database;
        
        $c = $minute * 60;
        $time = time() - $c;
        
        $date = cb_time_to_date($time);
        
        $uid = $database->newQuery()
                          ->sSelect("uid")
                          ->from("`#__session`")
                          ->wAndIsEqual("uid",$account_id)
                          ->wAndIsEqualOrBigger("sessionend",$date)
                          ->qType('integer')
                          ->execute();
        if ( $uid > 0 ) { return TRUE; }
        else { return FALSE; }
    }
    
    public function cb_check_user_code($code = NULL) {
        if ( $code === NULL ) { return FALSE; }
        
        global $database;
        
        $id = $database->newQuery()
                          ->sSelect("id")
                          ->from("`#__user`")
                          ->wAndIsEqual("code",$code)
                          ->qType("integer")
                          ->execute();
        
        if ( !empty($id) ) { return $id; }
        return FALSE;
    }
    
    private function loadSdkApiDatas() {
        $user_id = $this->cb_get_user_id();
        if ( empty($user_id) ) { return FALSE; }
        
        global $database;
        
        $data = $database->newQuery()
                          ->select("*")
                          ->from("`#__user_sdk`")
                          ->wAndIsEqual("user_id",$user_id)
                          ->qType("row")
                          ->execute();
        
        if ( empty($data) ) { return FALSE; }
        
        $this->data_sdk['uid'] = $data['uid'];
        $this->data_sdk['token'] = $data['token'];
        $this->data_sdk['picture'] = $data['picture'];
        $this->data_sdk['link'] = $data['link'];
        $this->data_sdk['first_name'] = $data['first_name'];
        $this->data_sdk['last_name'] = $data['last_name'];
        $this->data_sdk['data'] = json_decode($data['data']);
        
        return TRUE;
    }
    
    public function cb_password_strength($pw,&$point=0) {
        return cb_password_strength($pw,$point);
    }
}

return; ?>
