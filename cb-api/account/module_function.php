<?php
namespace module_api\account;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 10/05/19
 */
if (!defined('H-KEI')) { exit; }

class funct extends database {
    protected function api_main() {
        global $gentium, $user, $out_api;
                
        $gentium->generateUserIdCode($user->cb_get_user_id());
        $userData = $user->cb_get_user_data_from_id($user->cb_get_user_id());
        $userDataExtra = $user->cb_get_user_data_extra($user->cb_get_user_id());
        
        $data = array();
        $data['id'] = (int) $user->cb_get_user_id();
        $data['email'] = $user->cb_get_user_email();
        $data['display_name'] = $user->cb_get_user_name();
        $data['first_name'] = $userDataExtra['first_name'];
        $data['last_name'] = $userDataExtra['last_name'];
        $data['account_level'] = (int) $userData['level'];
        $data['user_level'] = (int) $userDataExtra['user_level'];
        $data['user_xp'] = (int) $userDataExtra['user_xp'];
        $data['transaction_id'] = $userData['transaction_id'];
        
        $out_api->responseOut('200',NULL,$data);
    }
    
    protected function api_login() {
        global $user, $out_api, $post, $get;
        //cbd($out_api,1,1);
        //cbd($_POST,1,1);
        if (    !isset($get['user']) || 
                empty($get['user']) || 
                !isset($get['pwd']) ||
                empty($get['pwd']) ) {
            $out_api->responseOut('403','',array(),array('LOGIN_ERROR_USER_DATA_NOT_SET'));
        }
        
        $login = $user->cb_user_log_in($get['user'], $get['pwd']);
        
        if ($login != TRUE) {
            $out_api->responseOut('403',NULL,array(),array('LOGIN_ERROR_USER_DATA_NOT_VAILD'));
        } else {
            $out_api->responseOut('200','LOGIN_SUCCESS',array('sid'=>$_SESSION['SID']));
        }
    }
    
    protected function api_logout() {
        global $user, $out_api;
        
        $r = $user->cb_user_log_out();
        if ( $r === TRUE ) {
            $out_api->responseOut('200','LOGOUT_SUCCESS');
        } else {
            $out_api->responseOut('401',NULL,array(),array('AUTH_FAIL_TOKEN_NOT_FOUND'));
        }
    }
    
    protected function api_registration() {
        global $out_api, $get;
        
        $error = $this->api_registration_test($get);
        
        $data = $get;
        
        if ( $this->registrationSetup['open'] == false ) { $out_api->responseOut('406','REGISTRATION_ERROR_CURRENTLY_CLOSED'); }
        
        if ( empty($error) ) {
            if (
                        $this->registrationSetup['open'] == true &&
                        $this->registrationSetup['activate_email'] == false &&
                        $this->registrationSetup['activate_admin'] == false
                    ) {
                $success = $this->api_registration_saveNewUser($data);
                if ( $success ) { $out_api->responseOut('200','REGISTRATION_SUCCESS'); }
            } elseif (
                        $this->registrationSetup['open'] == true && 
                        $this->registrationSetup['activate_email'] == true
                    ) {
                $success = $this->api_registration_saveNewUser($data,true);
                if ( $success ) { $out_api->responseOut('200','REGISTRATION_SUCCESS_EMAIL_ACTIVATION_NEED'); }
            } elseif (
                        $this->registrationSetup['open'] == true && 
                        $this->registrationSetup['activate_admin'] == true
                    ) {
                $success = $this->api_registration_saveNewUser($data,true);
                if ( $success ) { $out_api->responseOut('200','REGISTRATION_SUCCESS_ADMIN_ACTIVATION_NEED'); }
            }
        } else {
            $out_api->responseOut('412','',array(),array('REGISTRATION_ERROR_BAD_DATA_GIVEN'),$error);
        }
    }
    
    private function api_registration_test(&$data) {
        global $user;
        
        $error = array();
        
        $data['email'] = trim($data['email']);
        $data['emailreply'] = trim($data['emailreply']);
        
        if ( cb_is_empty($data['email']) ) {
            $error['email'] = '[ACCOUNT_REGISTRATION_ERROR_EMAIL_EMPTY]';
        } elseif ( !cb_check_email_address($data['email']) ) {
            $error['email'] = '[ACCOUNT_REGISTRATION_ERROR_EMAIL_NOTVAILD]';
        } elseif ( $user->cb_check_email_exist($data['email']) ) {
            $error['email'] = '[ACCOUNT_REGISTRATION_ERROR_EMAIL_ALREADYUSED]';
        }
        
        if ( cb_is_empty($data['emailreply']) ) {
            $error['emailreply'] = '[ACCOUNT_REGISTRATION_ERROR_EMAILREPLY_EMPTY]';
        } elseif ( $data['email'] !== $data['emailreply'] ) {
            $error['emailreply'] = '[ACCOUNT_REGISTRATION_ERROR_EMAILREPLY_EMAILNOTSAME]';
        }
        
        if ( cb_is_empty($data['password']) ) {
            $error['password'] = '[ACCOUNT_REGISTRATION_ERROR_PASSWORD_EMPTY]';
        }

        if ( cb_is_empty($data['passwordreply']) ) {
            $error['passwordreply'] = "[ACCOUNT_REGISTRATION_ERROR_PASSWORDREPLY_EMPTY]";
        } elseif ( $data['password'] !== $data['passwordreply'] ) {
            $error['passwordreply'] = "[ACCOUNT_REGISTRATION_ERROR_PASSWORDREPLY_PASSWORDNOTSAME]";
        }
        
        /*
        if ( !empty(CB_REGISTRATION_TERM_ID) && ( !isset($data['accountrequirecheckboxok']) || $data['accountrequirecheckboxok'] != 1 ) ) {
            $error['accountrequirecheckboxok'] = "[ACCOUNT_REGISTRATION_ERROR_ACCREQCHECKBOX_NOTCHECKED]";
        } */
        
        return $error;
    }
    
    
    /* FIXME: ez biztos rossz, módosítani kell ha használni akarjuk! API-n keresztüli regisztráció! */
    protected function api_registration_saveNewUser($data,$inactive = false) {
        global $user;
        
        $email = $data['email'];
        $password = $data['password'];
        $displayname = ( isset($data['displayname']) && !empty($data['displayname']) ) ? $data['displayname'] : $email;
        $dataExtra = array();
        $dataExtraFields = $user->cb_get_data_extra_fields();
        if ( isset($data['first_name']) ) { $dataExtra['first_name'] = $data['first_name']; }
        if ( isset($data['last_name']) ) { $dataExtra['last_name'] = $data['last_name']; }
        if ( isset($data['displayname']) ) { $dataExtra['display_name'] = $data['displayname']; }
        
        
        $state = ( $inactive === false ) ? 1 : 2;
        $res = $user->cb_create_user($email,$password,'local',$dataExtra,$state);

        if ( $res ) {
            $account_id = $user->cb_get_user_id_from_email($email);
            global $gentium;
            $gentium->generateUserIdCode($account_id);
            
            return $account_id;
        } else {
            return false;
        }
    }
}

return;
?>
