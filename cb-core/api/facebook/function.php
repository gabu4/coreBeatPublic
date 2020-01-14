<?php
namespace api\facebook;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 25/09/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    protected $sdk_facebook;
    protected $facebook_sdk_version = 'v3.3';
    protected $facebook_token_raw;
    protected $facebook_token;
    
    protected function set_facebook_sdk() {
        require_once './' . CB_CORE . '/vendor/facebook/graph-sdk/vendor/autoload.php';

        $this->sdk_facebook = new \Facebook\Facebook([
            'app_id' => CB_LOGIN_FB_API_CODE,
            'app_secret' => CB_LOGIN_FB_API_SECRET,
            'default_graph_version' => $this->facebook_sdk_version,
            //'default_access_token' => $token, // optional
        ]);
    }
        
    protected function facebook_sdk_callback() {
        $helper = $this->sdk_facebook->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            print 'Graph returned an error: ' . $e->getMessage();

            return FALSE;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            print 'Facebook SDK returned an error: ' . $e->getMessage();
            return FALSE;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                print "Error: " . $helper->getError() . "\n";
                print "Error Code: " . $helper->getErrorCode() . "\n";
                print "Error Reason: " . $helper->getErrorReason() . "\n";
                print "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                print 'Bad request';
            }
            return FALSE;
        }
        
//        $oAuth2Client = $this->sdk_facebook->getOAuth2Client();
//        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $this->facebook_token_raw = $accessToken;
        $this->facebook_token = $accessToken->getValue();
        
        return TRUE;
    }
    
    protected function facebook_call($path) {
        $response = $this->sdk_facebook->get($path, $this->facebook_token);
        $data = $response->getDecodedBody();
        
        if ( !$data ) { return FALSE; }
        return $data;
    }
    
    protected function facebook_userdata() {
        $path = '/me?fields=id,name,first_name,last_name,email,picture.width(128)';
        $data = $this->facebook_call($path);
        
        if ( !$data ) { return FALSE; }
        $data2 = [
                'provider'=> 'facebook',
                'uid'     => $data['id'],
                'token'   => $this->facebook_token,
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'],
                'display_name'  => $data['name'],
                'email'         => ( isset($data['email']) ? $data['email'] : 'fakemail_fb_'.$data['id'].'@dummy-facebook.com' ),
                'picture'       => ( isset($data['picture']['data']['url']) && !empty(isset($data['picture']['data']['url'])) ? $data['picture']['data']['url'] : '' ),
                'link'          => "https://facebook.com/".$data['id'],
                'data'          => json_encode([])
            ];
        
        return $data2;
    }
    
    protected function facebook_login_button() {
        global $theme;
        
        $helper = $this->sdk_facebook->getRedirectLoginHelper();

        $redirectUrl = CB_HTTPADDRESS . '/login_fb';

        $permissions = array('email'); // Optional permissions
        $loginUrl = $helper->getLoginUrl($redirectUrl, $permissions);
        
        $html = $theme->loadTemplate2('api_facebook_loginbutton',TRUE,'api');
        
        $replace['path'] = $loginUrl;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
}

return; ?>