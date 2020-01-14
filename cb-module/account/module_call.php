<?php
namespace module\account;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v021
 * @date 02/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    function __construct() {
        $this->registrationSetup();
    }
    
    function init() {
        $this->checkCorebeatApiCheck();
    }
    
    public function __call_pwcheck() {
        global $post;
        
        if ( isset($post['pw']) ) {
            return $this->callPWCheck($post['pw'],TRUE);
        }
    }
    
    public function __call_avatartype() {
        global $post;
        
        if ( isset($post['email']) && isset($post['image']) ) {
            return $this->callAvatartype($post['email'],$post['image'],TRUE);
        }
    }
    
    public function __call_account_box() {
        return $this->callAcountBox_makeHtml();
    }

    public function __call_login() {
        $this->loginCheck();
        return $this->callLogin_makeHtml();
    }

    public function __call_logout() {
        return $this->callLogout();
    }

    public function __call_registration() {
        global $post, $handler, $get, $user;

        if ( (int)$user->cb_get_user_id() !== 0 ) { global $out_html;$out_html->redirect(); }

        if ( isset($post['userregistrationbutton']) ) {
            $error = $this->callRegistration_postTest($post);
            if ( empty($error) ) {
                $success = FALSE;
                $inviter_req = ( CB_ACCOUNT_LOCAL_REGISTER === 'invitation' ? TRUE:FALSE );
                if ( CB_ACCOUNT_LOCAL_REGISTER === 'normal' || $inviter_req ) {
                    $inviter_id = 0;
                    if ( isset($get['invcode']) && !empty($get['invcode']) ) {
                        $inviter_id = $this->function_checkRegistrationInvitationCode($get['invcode']);
                    }
                    if ( CB_ACCOUNT_LOGIN_TYPE === 'local' ) {
                        $success = $this->callRegistration_saveNewUser($post);
                    } elseif ( CB_ACCOUNT_LOGIN_TYPE === 'api' ) {
                        $success = $this->callRegistrationApi_saveNewUser($post);
                        if ( $success ) { return $this->callRegistration_registrationSuccess_normal(); }
                    }
                }
                if ( $success && CB_ACCOUNT_LOCAL_ACTIVATION === 'none' ) { $this->callRegistration_saveNewUser_activate($post['email']); return $this->callRegistration_registrationSuccess_normal(); }
                elseif ( $success && CB_ACCOUNT_LOCAL_ACTIVATION === 'email' ) { return $this->callRegistration_registrationSuccess_activateEmail(); }
                elseif ( $success && CB_ACCOUNT_LOCAL_ACTIVATION === 'admin' ) { return $this->callRegistration_registrationSuccess_activateAdmin(); }
            } else {
                foreach ( $error as $e ) { $handler->messageError2('NULL',$e,'danger'); }
                $handler->textErrorForInput($error,FALSE,'account_registration_error',$post);
            }
        }

        return $this->callRegistration_makeHtml();
    }

    public function __call_forgott_password() {
        global $post, $get, $handler, $user;

        if ( (int)$user->cb_get_user_id() !== 0 ) { global $out_html;$out_html->redirect(); }

        if ( isset($get['email']) && $get['email'] && $get['email'] === 'sended' ) {
            return $this->callForgotPassword_emailSended();
        } elseif ( isset($get['email']) && $get['email'] && $get['email'] === 'change' && isset($get['code']) ) {
            return $this->callForgotPassword_emailChange($get['code']);
        } elseif ( isset($get['email']) && $get['email'] && $get['email'] === 'changed' ) {
            return $this->callForgotPassword_emailChanged();
        }

        if ( isset($post['forgotpasswordbutton']) ) {
            $error = $this->callForgotPassword_postTest();
            if ( empty($error) ) {

                $success = $this->callForgotPassword_sendRecoveryEmail($post['username']);

                if ( $success ) {
                    global $out_html;
                    $link = CB_HTTPADDRESS.'/'.$out_html->getModuleFuctionName('account','forgott_password','email=sended');
                    $out_html->redirect($link);
                }
            } else {
                foreach ( $error as $text ) {
                    $handler->messageError($text, FALSE, 'account_forgott_password_error');
                }
                $handler->textErrorForInput($error,FALSE,'account_forgott_password_error',$post);
            }
        }

        return $this->callForgotPassword_makeHtml();
    }

    public function __call_settings() {
        global $get;
        if ( isset($get['f']) && $get['f'] === 'userdata' ) {
            return $this->callSetting_userdata_makeHtml();
        } elseif ( isset($get['f']) && $get['f'] === 'password' ) {
            return $this->callSetting_password_makeHtml();
        } elseif ( isset($get['f']) && $get['f'] === 'email' ) {
            return $this->callSetting_email_makeHtml();
        } elseif ( isset($get['f']) && $get['f'] === 'image' ) {
            return $this->callSetting_image_makeHtml();
        }

        return $this->callSettings_makeHtml();
    }

    public function __call_login_api() {
        $this->loginCheck();
        return $this->callLogin_makeHtml();
    }
    
    public function __call_login_fb() {
        global $module, $user, $handler, $out_html;
        
        $module->loadFunction('api','fb_connect');
        $ok = $module->loadFunction('api','fb_get_login');
        
        if ( $ok ) {
            $userdata = $module->loadFunction('api','fb_get_userdata');
            $user_id = $this->save_facebook_userdata($userdata);
            
            if ( $user_id ) {
                $data = $user->cb_get_user_data_from_id($user_id);
                $user->cb_user_log_in($data['email'],NULL,FALSE,TRUE);
            }
            
            $handler->messageSuccess('[LANG_ACCOUNT_SUCCESS_LOGIN]', TRUE, 'account_login');
            $out_html->redirect();
        }
        
        exit;
    }

    public function __call_login_gp() {
        $this->login_google_sdk();
        $ok = $this->login_google_sdk_callback();

        global $module, $user, $handler, $out_html;
        
        $module->loadFunction('api','gp_connect');
        $ok = $module->loadFunction('api','get_login');
        
        if ( $ok ) {
            $userdata = $module->loadFunction('api','gp_get_userdata');
            $user_id = $this->save_facebook_userdata($userdata);
            
            if ( $user_id ) {
                $data = $user->cb_get_user_data_from_id($user_id);
                $user->cb_user_log_in($data['email'],NULL,FALSE,TRUE);
            }
            
            $handler->messageSuccess('[LANG_ACCOUNT_SUCCESS_LOGIN]', TRUE, 'account_login');
            $out_html->redirect();
        }

        exit;
    }
}

return; ?>
