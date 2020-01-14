<?php
namespace module\account;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v041
 * @date 21/12/19
 */
if (!defined('H-KEI')) { exit; }

class funct extends database {
    
    protected function callPWCheck($pw,$ajax=FALSE) {
        $point = 0;
        $success = cb_password_strength($pw,$point);
        
        $return = ['success'=>FALSE,'point'=>0,'width'=>0,'style'=>''];
        
        $return['success'] = $success;
        $return['point'] = $point;
        $return['text'] = "";
        $return['width'] = $point*10;
        
        switch ($point) {
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
                $return['text'] = '[LANG_ACCOUNT_PWSTRENGTH_WEAK]';
                $return['style'] = 'bg-danger';
                break;
            case 5:
            case 6:
            case 7:
                $return['text'] = '[LANG_ACCOUNT_PWSTRENGTH_MEDIUM]';
                $return['style'] = 'bg-warning';
                break;
            case 8:
            case 9:
            case 10:
                $return['text'] = '[LANG_ACCOUNT_PWSTRENGTH_STRONG]';
                $return['style'] = 'bg-success';
        }
        
        if ( $ajax ) {
            global $out_html;
            $out_html->printOutAjaxContent($return);
        } else {
            return $return;
        }
    }
    
    protected function callAvatartype($email,$imagetype,$ajax=FALSE) {
        global $user;
        
        $avatar_url = $user->cb_get_user_avatar($email,200,$imagetype);
        
        $return = ['success'=>FALSE,'image_url'=>''];
        
        if ( $avatar_url ) {
            $return['success'] = TRUE;
            $return['image_url'] = $avatar_url;
        }
        
        if ( $ajax ) {
            global $out_html;
            $out_html->printOutAjaxContent($return);
        } else {
            return $return;
        }
    }

    protected function checkCorebeatApiCheck() {
        if ( CB_ACCOUNT_LOGIN_TYPE !== 'api' ) { return FALSE; }
        global $user;
        if ( $user->cb_get_user_id() > 0 && $user->cb_get_user_type() === 'corebeat_api' ) { $this->corebeat_slogin_test(); }
    }
    
    protected function loginCheck() {
        global $post;
        if ( isset($post['loginbutton']) ) {
            unset($post['loginbutton']);
            $this->cbLoginProgress();
        } elseif ( isset($post['loginapibutton']) ) {
            unset($post['loginapibutton']);
            $this->cbLoginProgressApi();
        }
    }
    
    private function cbLoginProgress() {
        global $user, $post, $handler, $out_html;
        
        if ( CB_ACCOUNT_LOGIN_TYPE !== 'local' ) { return FALSE; }
        
        $toCookie = FALSE;
        $toAdmin = FALSE;
        
        if ( isset($post['prev-page']) && !empty($post['prev-page']) ) {
            $redirectLink = $post['prev-page'];
        } else if ( $toAdmin ) {
            $redirectLink = '?admin';
        } else if ( $out_html->getContentData()['module'] === 'account' && $out_html->getContentData()['type'] === 'login' ) {
            $redirectLink = NULL;
        } else {
            $redirectLink = CB_HTTPPAGEADDRESS;
        }
        
        $checkError = $this->cbLoginProgress_checkError();
        if (!empty($checkError)) { $out_html->redirect($redirectLink); }

        if ( isset($post['remember-me']) && $post['remember-me'] == 1 ) { $toCookie = TRUE; }
        if ( isset($post['to-admin']) && $post['to-admin'] == 1 ) { $toAdmin = TRUE; }
        
        $login = $user->cb_user_log_in($post['username'], $post['password'], $toCookie);

        if ($login !== TRUE) {
            $handler->messageError('[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', TRUE, 'account_login');
            $out_html->redirect(CB_HTTPPAGEADDRESS);
        } else {
            $handler->messageSuccess('[LANG_ACCOUNT_SUCCESS_LOGIN]', TRUE, 'account_login');
            $out_html->redirect($redirectLink);
        }
    }

    private function cbLoginProgressApi() {
        global $post, $handler, $module, $user, $out_html;

        if ( CB_ACCOUNT_LOGIN_TYPE !== 'api' ) { return FALSE; }

        $checkError = $this->cbLoginProgress_checkError();
        if (!empty($checkError)) { return FALSE; }
        
        $v = $module->loadFunction('api','cb_connect');
        $setup = ['email'=>$post['username'],'password'=>$post['password']];
        $login = $module->loadFunction('api','cb_get_login',$setup);
        
        if ($login !== TRUE) {
            $handler->messageError('[LANG_ACCOUNT_ERROR_LOGIN_INVALID]', TRUE, 'account_login');
            $out_html->redirect(CB_HTTPPAGEADDRESS);
            return FALSE;
        } else {
            $user_id = $this->save_corebeat_api_userdata();
            
            $user->cb_user_log_in($user->cb_get_user_data_from_id($user_id)['email'],NULL,FALSE,TRUE);
            $handler->messageSuccess('[LANG_ACCOUNT_SUCCESS_LOGIN]', TRUE, 'account_login');
            if ( $out_html->getContentData()['module'] === 'account' && $out_html->getContentData()['type'] === 'login' ) {
                $link = NULL;
            } else {
                $link = CB_HTTPPAGEADDRESS;
            }
            $out_html->redirect($link);
            return TRUE;
        }
    }
    
    protected function callLogout() {
        global $user, $handler, $get;

        $r = $user->cb_user_log_out();

        if ( $r === TRUE ) {
            $handler->messageSuccess('[LANG_ACCOUNT_SUCCESS_LOGOUT]', TRUE, 'account_logout');
            if ( $user->cb_is_admin_territory() === TRUE || isset($get['adm']) ) {
                global $out_html;$out_html->redirect(CB_INDEX.'?admin');
            } else {
                global $out_html;$out_html->redirect();
            }
        } else {
            $handler->messageSuccess('[LANG_ACCOUNT_ERROR_LOGOUT]', TRUE, 'account_logout');
            global $out_html;$out_html->redirect(CB_HTTPPAGEADDRESS);
        }
    }

    protected function cbLoginProgress_checkError() {
        global $handler, $post;
        $error = Array();

        if (empty($post['username'])) {
            $error['username'] = 1;
            $handler->messageError('[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]', FALSE, 'account_username_empty');
            return $error;
        }
        if (empty($post['password'])) {
            $error['password'] = 1;
            $handler->messageError('[LANG_ACCOUNT_ERROR_USERPASSWORD_EMPTY]', FALSE, 'account_password_empty');
            return $error;
        }

        return $error;
    }

    private function function_socialLogins(&$replace) {
        global $module;

        $replace['login_with_fb'] = "";
        $replace['login_with_gp'] = "";
        if ( $module->cb_check_access('account','login_fb') && !empty(CB_LOGIN_FB_API_CODE) && !empty(CB_LOGIN_FB_API_SECRET) ) {
            $replace['login_with_fb'] = $module->loadFunction('api','fb_get_loginbutton');
        }
        if ( $module->cb_check_access('account','login_gp') && !empty(CB_LOGIN_GP_API_CODE) && !empty(CB_LOGIN_GP_API_SECRET) ) {
            $replace['login_with_gp'] = $module->loadFunction('api','gp_get_loginbutton');
        }
    }

    private function function_formButtons(&$replace) {
        global $user, $out_html;
        
        $replace['login_allowed_local_or_api'] = ( CB_ACCOUNT_LOGIN_TYPE === 'local' || CB_ACCOUNT_LOGIN_TYPE === 'api' || $user->cb_is_admin_territory() ? TRUE : FALSE );        
        
        $link = $out_html->getModuleFuctionName('account','login');
        $replace['login_button'] = ( $user->cb_get_user_level() === 0 && ( CB_ACCOUNT_LOGIN_TYPE === 'local' || $user->cb_is_admin_territory() ) ? TRUE : FALSE );
        $replace['login_href'] = $link;
        
        $link = $out_html->getModuleFuctionName('account','registration');
        $replace['registration_button'] = ( $user->cb_get_user_level() === 0 && CB_ACCOUNT_LOCAL_REGISTER === 'normal' ? TRUE : FALSE );
        $replace['registration_href'] = $link;
        
        $link = $out_html->getModuleFuctionName('account','forgott_password');
        $replace['forgot_password_button'] = ( $user->cb_get_user_level() === 0 ? TRUE : FALSE );
        $replace['forgot_password_href'] = $link;
        
        $link = $out_html->getModuleFuctionName('account','registration_mail_resend');
        $replace['registration_mail_resend_button'] = ( $user->cb_get_user_level() === 0 && CB_ACCOUNT_LOCAL_ACTIVATION === 'email' ? TRUE : FALSE );
        $replace['registration_mail_resend_href'] = $link;
        
        $link = $out_html->getModuleFuctionName('account','login_api');
        $replace['login_api_button'] = ( $user->cb_get_user_level() === 0 && ( CB_ACCOUNT_LOGIN_TYPE === 'api' ) ) ? TRUE : FALSE;
        $replace['login_api_href'] = $link;
    }

    protected function callAcountBox_makeHtml() {
        global $user, $theme, $out_html;
        $html = "";

        if ( $user->cb_get_user_id() === 0 && !$user->cb_is_admin_territory() ) {
            $html .= $theme->loadTemplateTwig('account_login_box',TRUE,'account');
        } else if ( $user->cb_get_user_id() > 0 && !$user->cb_is_admin_territory() ) {
            $html .= $theme->loadTemplateTwig('account_logout_box',TRUE,'account');
        } else if ( $user->cb_get_user_id() === 0 && $user->cb_is_admin_territory() ) {
            $html .= $theme->loadAdminTemplateTwig('account_login_box',TRUE,'account');
        } else if ( $user->cb_get_user_id() > 0 && $user->cb_is_admin_territory() ) {
            $html .= $theme->loadAdminTemplateTwig('account_logout_box',TRUE,'account');
        } else {
            $html .= "USER MENU ERROR!";
        }

        $replace = array();
        $replace['username'] = $user->cb_get_user_name();
        $replace['userimage'] = $user->cb_get_user_avatar($user->cb_get_user_id());
        $replace['userimage_big'] = $user->cb_get_user_avatar($user->cb_get_user_id(),500);
        $replace['userid'] = $user->cb_get_user_id();
        $replace['adminmenu'] = ( $user->cb_is_admin_access() ) ? "<a href='".CB_INDEX."?admin' target='admin_page'>Admin</a>" : "";
        $action_link = $out_html->getModuleFuctionName('account','login','',TRUE);
        $replace['action'] = $action_link;
        $replace['page_url'] = CB_HTTPPAGEADDRESS;
        $replace['user_settings_href'] = ( $user->cb_get_user_level() > 0 ) ? $out_html->getModuleFuctionName('account','settings') : "";
        $logoutLink = $out_html->getModuleFuctionName('account','logout');
        if ( $user->cb_is_admin_territory() ) {
            $logoutLink = $out_html->getModuleFuctionName('account','logout','adm');
        }
        $replace['user_logout_href'] = ( $user->cb_get_user_level() > 0 ) ? $logoutLink : "";

        $this->function_socialLogins($replace);
        $this->function_formButtons($replace);

        $theme->replaceTwig($replace,$html);

        return $html;
    }

    protected function callLogin_makeHtml() {
        global $user, $theme, $out_html;

        if ( (int)$user->cb_get_user_id() !== 0 ) { global $out_html;$out_html->redirect(); }

        $theme->loadFontAwesome();
        
        $html = $theme->loadTemplate2('account_login_page',TRUE,'account');

        $replace = array();

        $this->function_socialLogins($replace);
        $this->function_formButtons($replace);
        
        $replace['login_allowed'] = [];
        
        $action_link = $out_html->getModuleFuctionName('account','login','',TRUE);
        $replace['action'] = $action_link;
        $replace['page_url'] = CB_HTTPPAGEADDRESS;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }

    protected function callRegistration_makeHtml() {
        global $theme, $post;

        if ( CB_ACCOUNT_LOCAL_REGISTER === 'none' ) { return $theme->loadTemplate2('account_registration_closed',TRUE,'account'); }
        
        $sablon = CB_REGISTRATION_FORM;
        
        $theme->loadFontAwesome();
        
        $html = "";
        $html .= $theme->loadTemplate2('account_registration_'.$sablon,TRUE,'account');

        $replace = array();
        $replace['require_href'] = FALSE;

        if ( !empty(CB_REGISTRATION_TERM_ID) ) {
            $rPath = CB_HTTPADDRESS.'\?a='.CB_REGISTRATION_TERM_ID;
            $replace['require_href'] = $rPath;
        }

        $this->function_formButtons($replace);
        
        $replace['data_email'] = (isset($post['email'])&&!empty($post['email'])?$post['email']:'');

        $theme->mustache($replace,$html);

        return $html;
    }

    protected function callRegistration_postTest(&$data) {
        global $user, $module;

        $error = array();

        $data['email'] = ( isset($data['email']) && !empty($data['email']) ? trim($data['email']) : '' );
        
        if ( !isset($data['email']) || empty($data['email']) ) {
            $error['email'] = '[LANG_ACCOUNT_REGISTRATION_ERROR_EMAIL_EMPTY]';
        } elseif ( !cb_check_email_address($data['email']) ) {
            $error['email'] = '[LANG_ACCOUNT_REGISTRATION_ERROR_EMAIL_NOTVAILD]';
        } elseif ( 
                CB_ACCOUNT_LOGIN_TYPE === 'local' && $user->cb_check_email_exist($data['email']) ||
                CB_ACCOUNT_LOGIN_TYPE === 'api' && !$module->loadFunction('api','cb_get_check_email',$data['email'])
                ) {
            $error['email'] = '[LANG_ACCOUNT_REGISTRATION_ERROR_EMAIL_ALREADYUSED]';
        }
        
        if ( !isset($data['password']) || empty($data['password']) ) {
            $error['password'] = '[LANG_ACCOUNT_REGISTRATION_ERROR_PASSWORD_EMPTY]';
        }
        
        $password_point = 0;
        $check_password_strength = FALSE;
        if ( CB_ACCOUNT_LOGIN_TYPE === 'local' ) { $check_password_strength = cb_password_strength($data['password'],$password_point); }
        elseif ( CB_ACCOUNT_LOGIN_TYPE === 'api' ) { 
            $ret = $module->loadFunction('api','cb_get_check_password',$data['password']);
            if ( $ret ) {
                $check_password_strength = $ret;
                $d = $module->loadFunction('api','cb_data','data');
                $password_point = $d['data']['strength'];
            }
        }
        
        if ( !empty($data['password']) && !$check_password_strength ) {
            $error['password'] = '[LANG_ACCOUNT_REGISTRATION_ERROR_PASSWORD_TO_WEAK]';
        }
        
        if ( !empty(CB_REGISTRATION_TERM_ID) && ( !isset($data['account-require-checkbox-ok']) || $data['account-require-checkbox-ok'] != 1 ) ) {
            $error['account-require-checkbox-ok'] = "[LANG_ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]";
        }
        
        if ( isset($data['referral_id']) && !empty($data['referral_id']) && (
                (CB_ACCOUNT_LOGIN_TYPE === 'local' && $user->cb_check_user_code($data['referral_id']) === false) || 
                (CB_ACCOUNT_LOGIN_TYPE === 'api' && $module->loadFunction('api','cb_get_check_referral',$data['referral_id']))
                ) ) {
            $error['referral_id'] = "[LANG_ACCOUNT_REGISTRATION_ERROR_REFERRAL_ID_NOT_VALID]";
            $data['referral_id'] = "";
        }

        return $error;
    }

    protected function callSettings_makeHtml() {
        global $user, $theme, $out_html;

        if ( (int)$user->cb_get_user_id() === 0 ) { global $out_html;$out_html->redirect(); }

        $html = $theme->loadTemplate2('account_settings',TRUE,'account');
        
        $theme->loadFontAwesome();
        $replace = array();

        $replace['adminmenu'] = ( $user->cb_is_admin_access() ) ? "<a href='".CB_INDEX."?admin' class='btn btn-default m-2' target='admin_page'><i class='fas fa-user-tie fa-5x'></i><br />[LANG_ACCOUNT_MENU_ADMIN_MENU]</a>" : "";
        
        $link = $out_html->getModuleFuctionName('account','settings','f=userdata');
        $replace['usersettings_userdata'] = "<a href='".$link."' class='btn btn-default m-2'><i class='fas fa-user-edit fa-5x'></i><br />[LANG_ACCOUNT_MENU_CHANGE_SETTINGS]</a>";
        
        $link = $out_html->getModuleFuctionName('account','settings','f=password');
        $replace['usersettings_password'] = "<a href='".$link."' class='btn btn-default m-2'><i class='fas fa-key fa-5x'></i><br />[LANG_ACCOUNT_MENU_CHANGE_PASSWORD]</a>";
        
        $link = $out_html->getModuleFuctionName('account','settings','f=email');
        $replace['usersettings_email'] = "<a href='".$link."' class='btn btn-default m-2'><i class='fas fa-at fa-5x'></i><br />[LANG_ACCOUNT_MENU_CHANGE_EMAIL]</a>";
        
        $link = $out_html->getModuleFuctionName('account','settings','f=image');
        $replace['usersettings_image'] = "<a href='".$link."' class='btn btn-default m-2'><i class='fas fa-portrait fa-5x'></i><br />[LANG_ACCOUNT_MENU_CHANGE_IMAGE]</a>";
        
        $link = $out_html->getModuleFuctionName('account','logout');
        $replace['logout'] = "<a href='".$link."' class='btn btn-default'><i class='fas fa-sign-out-alt fa-5x'></i><br />[LANG_ACCOUNT_MENU_LOGOUT]</a>";

        $row = $theme->search_pregMatchAll('U',$html);
        if ( !empty($row) ) {
            global $module;
            foreach ( $row as $v ) {
                $replaceWhat = $v[0];
                $mod = strtolower($v[1]);
                $funct = strtolower($v[2]);
                $settings = ( isset($v[3]) ) ? $v[3] : "";

                $rowHtml = $module->loadFunction($mod,$funct,$settings);
                $theme->replace3($replaceWhat,$rowHtml,$html);

            }
        }

        $theme->mustache($replace,$html);
        return $html;
    }

    protected function callSetting_userdata_makeHtml() {
        global $user, $theme, $post, $out_html;

        if ( isset($post['usersettingsuserdatabutton']) ) {
            global $handler;

            $error = $this->checkSettingsSaveUserdata();

            if ( empty($error) ) {
                $r = $this->dbSettingsSaveUserdata($post);

                if ( $r ) {
                    $handler->messageSuccess('[ACCOUNT_TEXT_SETTINGS_USERDATA_SAVE_SUCCESS]',TRUE,'settings_userdata');
                    $link = $out_html->getModuleFuctionName('account','settings');
                    global $out_html;$out_html->redirect($link);
                }
            } else {
                $handler->messageError('[ACCOUNT_TEXT_ERROR_SAVE_FAILED]',FALSE,'settings_userdata');
                $handler->textErrorForInput($error,FALSE,'settings_userdata',$post);
            }
        }

        $html = "";
        $html .= $theme->loadTemplate2('account_settings_userdata',TRUE,'account');

        $userData = $user->cb_get_user_data_from_id($user->cb_get_user_id());
        $userDataExtra = $user->cb_get_user_data_extra($user->cb_get_user_id());

        $replace = array();
        $replace['adminmenu'] = "";
        $replace['back_link'] = $out_html->getModuleFuctionName('account','settings');
        $replace['display_name'] = ( isset($userData['display_name']) ) ? $userData['display_name'] : "";
        $replace['email'] = $userData['email'];

        foreach ( $userDataExtra as $k=>$v ) {
            $replace[$k] = $v;
        }

        $theme->mustache($replace,$html);

        return $html;
    }

    private function checkSettingsSaveUserdata() {
        global $post;

        $error = array();
        if ( !isset($post['first_name']) || empty(trim($post['first_name'])) ) {
            $error['first_name'] = "[ACCOUNT_TEXT_ERROR_SAVE_USERDATA_FIRST_NAME]";
        }

        if ( !isset($post['last_name']) || empty(trim($post['last_name'])) ) {
            $error['last_name'] = "[ACCOUNT_TEXT_ERROR_SAVE_USERDATA_LAST_NAME]";
        }

        return $error;
/*
        if (!isset($post['display_name']) OR empty(trim($post['display_name']))) {
            $error['display_name'] = "[ACCOUNT_TEXT_ERROR_SAVE_USERDATA_DISPLAY_NAME]";
        }
*/
    }


    protected function callSetting_password_makeHtml() {
        global $user, $theme, $post, $out_html;

        $account_id = $user->cb_get_user_id();
        if ( isset($post['usersettingspasswordbutton']) ) {
            global $handler;

            $error = $this->checkSettingsSavePassword();

            if ( empty($error) ) {

                $r = $this->dbSettingsSavePassword($account_id,$post);

                if ( $r ) {
                    $handler->messageSuccess('[ACCOUNT_TEXT_SETTINGS_PASSWORD_SAVE_SUCCESS]',TRUE,'settings_password');
                    $link = $out_html->getModuleFuctionName('account','settings');
                    global $out_html;$out_html->redirect($link);
                }
            } else {
                $handler->messageError('[ACCOUNT_TEXT_ERROR_SAVE_FAILED]',FALSE,'settings_password');
                $handler->textErrorForInput($error,FALSE,'settings_userdata',$post);
            }
        }

        $html = "";
        $html .= $theme->loadTemplate2('account_settings_password',TRUE,'account');

        $replace = array();
        $replace['back_link'] = $out_html->getModuleFuctionName('account','settings');

        $theme->mustache($replace,$html);

        return $html;
    }

    private function checkSettingsSavePassword() {
        global $post, $user;

        $error = array();

        if (!isset($post['original_password']) OR empty($post['original_password']) OR ( $user->cb_check_password($user->cb_get_user_id(), $post['original_password']) == FALSE )) {
            $error['original_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_ORIGINAL_PASSWORD_NOT_GOOD]";
        }

        if (!isset($post['new_password']) OR empty($post['new_password'])) {
            $error['new_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_MUST_BE_FILL]";
        }

        if (!isset($post['new_password_reply']) OR empty($post['new_password_reply'])) {
            $error['new_password_reply'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_REPLY_MUST_BE_FILL]";
        }

        if ($post['new_password'] != $post['new_password_reply']) {
            $error['new_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME]";
        }

        if ($post['original_password'] == $post['new_password']) {
            $error['new_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME_AS_OLD]";
        }

        return $error;
    }


    protected function callForgotPassword_makeHtml() {
        global $theme;
        $html = "";

        $html .= $theme->loadTemplate2('account_forgotpassword_page',TRUE,'account');

        return $html;
    }

    protected function callForgotPassword_postTest() {
        global $post, $user;

        $error = array();

        if ( empty($post['username']) ) {
            $error['username'] = '[LANG_ACCOUNT_ERROR_USERNAME_EMPTY]';
        } elseif ( !cb_check_email_address($post['username']) || $user->cb_get_user_id_from_email($post['username']) == false ) {
            $error['username'] = '[ACCOUNT_USERNAME_NOTVAILD_ERROR]';
        }

        return $error;
    }

    protected function callRegistration_saveNewUser($post,$active = false) {
        global $user;

        $email = $post['email'];
        $password = $post['password'];
        $data = [];
//        if ( isset($post['firstname']) ) { $data['first_name'] = $post['firstname']; }
//        if ( isset($post['lastname']) ) { $data['last_name'] = $post['lastname']; }
//        if ( isset($post['displayname']) ) { $data['display_name'] = $post['displayname']; }
        
        $state = ( $active === true ) ? 1 : 2;
        $res = $user->cb_create_user($email,$password,'local',$data,$state);
        
        if ( $res ) {
            $account_id = $user->cb_get_user_id_from_email($email);
            return $account_id;
        } else {
            return false;
        }
    }

    protected function callRegistrationApi_saveNewUser($post) {
        global $module;

        if ( CB_ACCOUNT_LOGIN_TYPE !== 'api' ) { return FALSE; }
        
        $v = $module->loadFunction('api','cb_connect');
        
        $setup = ['email'=>$post['email'],'password'=>$post['password']];
        $registration = $module->loadFunction('api','cb_get_registration',$setup);
        
        if ( $registration ) {
            return true;
        } else {
            return false;
        }
    }
    
    protected function callRegistration_saveNewUser_activate($email) {
        global $user;
        
        $account_id = $user->cb_get_user_id_from_email($email);
        $res = $user->cb_update_user($account_id,NULL,NULL,NULL,1,NULL,1);
        
        if ( $res ) {
            return $account_id;
        } else {
            return false;
        }
    }
    
    protected function callRegistration_registrationSuccess_normal() {
        global $theme;

        $html = $theme->loadTemplate2('account_registration_success',TRUE,'account');
        
        $replace = array();
        $this->function_formButtons($replace);
        
        $theme->mustache($replace,$html);

        return $html;
    }

    protected function callForgotPassword_sendRecoveryEmail($email) {
        global $user;

        $userData = $user->cb_get_user_data_from_id($user->cb_get_user_id_from_email($email));
        if ( empty($userData) ) { return FALSE; }

        $d = time();
        $codeText = $d . $userData['id'] . "Ez most már örökké jó lesz egy darabig." . $userData['email'] . $d . "Donald billentyuzetet használ, Mickey egeret.";
        $codeHash = hash('sha256',$codeText);

        $ret = $this->recoveryValidationWrite($userData['id'],$d,$codeHash);
        if ( !$ret ) { return FALSE; }

        return $this->sendRecoveryEmail($userData,$codeHash);
    }

    private function sendRecoveryEmail($data, $code) {
        global $handler, $theme, $out_html,$mail2;


        $body = $theme->loadTemplate2('account_email_userrecovery_body',FALSE,'account');
        $body_alt = $theme->loadTemplate2('account_email_userrecovery_body_alt',FALSE,'account');

        $replace = array();
        $replace['user_display_name'] = ( !empty($data['display_name']) ) ? $data['display_name'] : $data['email'];
        $link = CB_HTTPADDRESS.'/'.$out_html->getModuleFuctionName('account','forgott_password','email=change&code='.$code);
        $replace['email_recovery_link'] = $link;

        $theme->mustache($replace,$body);
        $theme->mustache($replace,$body_alt);

        $mail2->clean();
        $mail2->target($data['email']);
        $mail2->body($body);
        $mail2->body_alt($body_alt);

        $mail2->subject('[LANG_ACCOUNT_PASSWORD_RECOVERY_EMAIL_TITLE]');

        $test2 = $mail2->send(TRUE);

        if( !$test2 ) {
            $text = "[LANG_ACCOUNT_INVITATION_EMAIL_SEND_ERROR]" . ' ('.$mail2->errorInfo.')';
            $handler->messageError($text,FALSE,'message');
                return FALSE;
            }
        else {
            $text = "[LANG_ACCOUNT_INVITATION_EMAIL_SEND_SUCCESS]";
            $handler->messageSuccess($text,FALSE,'message');
                return TRUE;
        }
    }

    protected function callForgotPassword_emailSended() {
        global $theme;

        $html = $theme->loadTemplate2('account_forgotpassword_emailsend',TRUE,'account');

        return $html;
    }

    protected function callForgotPassword_emailChange($code) {
        global $user, $theme, $post, $out_html, $handler;

        $account_id = $user->cb_check_password_recovery_code($code);

        if ( !$account_id ) {
            $handler->messageError('[ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_CODE_INVAILD]',TRUE,'account_password_recovery');
            //global $out_html;$out_html->redirect();
        }

        if ( isset($post['usersettingspasswordbutton']) ) {
            global $handler;

            $error = $this->checkSettingsSavePasswordRecovery();

            if ( empty($error) ) {
                $r = $this->dbSettingsSavePassword($account_id,$post);

                if ( $r ) {
                    $handler->messageSuccess('[ACCOUNT_TEXT_SETTINGS_PASSWORD_SAVE_SUCCESS]',TRUE,'settings_password');
                    $link = CB_HTTPADDRESS.'/'.$out_html->getModuleFuctionName('account','forgott_password','email=changed');
                    global $out_html;$out_html->redirect($link);
                }
            } else {
                $handler->messageError('[ACCOUNT_TEXT_ERROR_SAVE_FAILED]',FALSE,'settings_password');
                $handler->textErrorForInput($error,FALSE,'settings_userdata',$post);
            }
        }

        $html = "";
        $html .= $theme->loadTemplate2('account_forgotpassword_changepage',TRUE,'account');

        $replace = array();

        $theme->mustache($replace,$html);

        return $html;
    }

    private function checkSettingsSavePasswordRecovery() {
        global $post, $user;

        $error = array();

        if (!isset($post['new_password']) OR empty($post['new_password'])) {
            $error['new_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_MUST_BE_FILL]";
        }

        if (!isset($post['new_password_reply']) OR empty($post['new_password_reply'])) {
            $error['new_password_reply'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_REPLY_MUST_BE_FILL]";
        }

        if ($post['new_password'] != $post['new_password_reply']) {
            $error['new_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME]";
        }

        if ($post['original_password'] == $post['new_password']) {
            $error['new_password'] = "[ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME_AS_OLD]";
        }

        return $error;
    }
    
    protected function callForgotPassword_emailChanged() {
        global $theme;

        $html = $theme->loadTemplate2('account_forgotpassword_changesuccess',TRUE,'account');

        return $html;
    }
    
    protected function save_facebook_userdata($userData) {
        $user_id = $this->saveFacebookLogin($userData);

        if ( $user_id ) {
            return $user_id;
        } else {
            return FALSE;
        }
    }
    
    protected function save_corebeat_api_userdata() {
        global $module;
        
        $userData = $module->loadFunction('api','cb_get_userdata');
        if ( !$userData ) { return FALSE; }
        $user_id = $this->saveCorebeatApiLogin($userData);
        if ( $user_id ) {
            return $user_id;
        } else {
            return FALSE;
        }
    }
    
    protected function corebeat_slogin_test() {
        global $module,$user;
        $userData = $module->loadFunction('api','cb_get_userdata');
        if ( !$userData ) { $user->cb_user_log_out();global $out_html;$out_html->redirect(TRUE); }
    }
}

return;
?>
