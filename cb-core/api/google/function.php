<?php
namespace module\api\google;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 08/05/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    private $sdk_google;
    private $sdk_google2;
    private $google_token_raw;
    private $google_token;
    
    protected function set_google_sdk() {
        //Include Google client library
        require_once './' . CB_CORE . '/vendor/google/apiclient/vendor/autoload.php'; // change path as needed

        /*
         * Configuration and setup Google API
         */
        $clientId = CB_LOGIN_GP_API_CODE;
        $clientSecret = CB_LOGIN_GP_API_SECRET;
        $redirectURL = CB_HTTPADDRESS . '/login_gp';

        //Call Google API
        $this->sdk_google = new \Google_Client();
        $this->sdk_google->setApplicationName(CB_LOGIN_GP_API_AP_NAME);
        $this->sdk_google->setClientId($clientId);
        $this->sdk_google->setClientSecret($clientSecret);
        $this->sdk_google->setRedirectUri($redirectURL);

        $this->sdk_google2 = new \Google_Service_Oauth2($this->sdk_google);
    }
        
    protected function google_sdk_callback() {
        global $get;

        $save = array();

        if(isset($get['code'])){
            $this->sdk_google->authenticate($get['code']);
            $_SESSION['gp_token'] = $this->sdk_google->getAccessToken();
            //$redirectURL = CB_HTTPADDRESS . '/login_gp';
            //global $out_html;$out_html->redirect(filter_var($redirectURL, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['gp_token'])) {
            $this->sdk_google->setAccessToken($_SESSION['gp_token']);
        }
        
        
        
        if ($this->sdk_google->getAccessToken()) {
            //Get user profile data from google
            $gpUserProfile = (array) $this->sdk_google2->userinfo->get();

            //Initialize User class
            $user = new \User();

            //Insert or update user data to the database
            $save = [
                'provider'=> 'google',
                'uid'     => $gpUserProfile['id'],
                'token'   => $this->sdk_google->getAccessToken()['access_token'],
                'first_name'    => $gpUserProfile['givenName'],
                'last_name'     => $gpUserProfile['familyName'],
                'display_name'  => $gpUserProfile['name'],
                'email'         => $gpUserProfile['email'],
                'picture'       => $gpUserProfile['picture'],
                'link'          => $gpUserProfile['link'],
                'data'          => json_encode([])
            ];

            if ( empty($save['email']) ) {
                $save['email'] = 'fakemail_gp_'.$gpUserProfile['id'].'@dummy-google.com';
            }

            $user_id = $this->saveGoogleLogin($save);

            if ( $user_id ) {
                global $user;

                $data = $user->cb_get_user_data_from_id($user_id);

                $user->cb_user_log_in($data['email'],NULL,FALSE,TRUE);

                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            print 'Google SDK returned an error: no vaild accessToken';exit;
        }
    }
    
    protected function google_call($path) {
        
    }
    
    protected function google_userdata() {
        
    }
    
    protected function google_login_button() {
        global $theme;
        
        $redirectUrl = CB_HTTPADDRESS . '/login_gp';
        //$this->sdk_gp->addScope('https://www.googleapis.com/auth/plus.login.email');
        $this->sdk_google->addScope('openid');
        $this->sdk_google->addScope('email');
        $this->sdk_google->addScope('profile');

        $loginUrl = $this->sdk_google->createAuthUrl();

        $html = $theme->loadTemplate2('api_google_loginbutton',TRUE,'api');
        
        $replace['path'] = $loginUrl;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
}

return; ?>