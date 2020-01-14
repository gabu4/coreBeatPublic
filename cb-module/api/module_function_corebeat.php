<?php
namespace module\api\corebeat;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 15/07/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    private $api_corebeat;
    private $corebeat_api_version = '1.0';
    private $token;
    
    private $state = "";
    private $msg = "";
    private $data = [];
    private $identity_error = [];
    private $viewstate_error = [];
    
    protected function set_corebeat_api() {
        require_once 'corebeat_api.php';

        $this->api_corebeat = new \corebeat_api([
            'api_key' => CB_ACCOUNT_API_KEY,
            'api_secret' => CB_ACCOUNT_API_SECRET,
            'api_version' => $this->corebeat_api_version,
            'api_url' => CB_ACCOUNT_API_URL,
        ]);
        
        return TRUE;
    }
    
    protected function corebeat_api_callback() {
        if ( empty($this->api_corebeat) ) { $this->set_corebeat_api(); }
        if ( !empty($this->token) ) { return TRUE; }
        $a = $this->api_corebeat->get_token();$this->save($a);
        if ( !$a ) { return FALSE; }
        $this->token = $a;
        
        return TRUE;
    }
    
    protected function corebeat_api_login($setup) {
        $a = $this->api_corebeat->post('account/login',$setup);$this->save($a);
        if ( !$a ) { return FALSE; }
        if ( $a['cb_msg'] !== 'LOGIN_SUCCESS' ) { return FALSE; }
        
        $this->corebeat_userdata();
        
        return TRUE;
    }
    
    protected function corebeat_call($path) {
        $data = $this->api_corebeat->get($path);$this->save($data);
        if ( !$data ) { return FALSE; }
        return $data;
    }
    
    protected function corebeat_userdata() {
        $userData = $this->api_corebeat->get('account/data');$this->save($userData);
        if ( !$userData || !isset($userData['user_id']) || !isset($userData['data']) ) { return FALSE; }
        
        $data = [
                'provider'=> 'corebeat_api',
                'uid'     => $userData['data']['id'],
                'token'   => $this->api_corebeat->get_token(),
                'first_name'    => $userData['data']['first_name'],
                'last_name'     => $userData['data']['last_name'],
                'display_name'  => $userData['data']['display_name'],
                'email'         => $userData['data']['email'],
                'picture'       => $userData['data']['avatar'],
                'link'          => "",
                'data'          => json_encode($userData['data']['data'])
            ];
        
        return $data;
    }
    
    protected function corebeat_registration($setup) {
        $p = [
            'email'=>$setup['email'],
            'password'=>$setup['password']
        ];
        
        if ( isset($setup['referal_id']) && !empty($setup['referal_id']) ) {
            $p['referal_id'] = $setup['referal_id'];
        }
        
        $data = $this->api_corebeat->post('account/registration',$p);$this->save($data);
        
        if ( !$data || !isset($data['state']) ) { return FALSE; }
        if ( $data['state'] !== '200' ) { return FALSE; }
        if ( $data['state'] === '412' ) { $error = $data['viewstate_error']; return $data; }
        if ( $data['cb_msg'] === 'REGISTRATION_ERROR_CURRENTLY_CLOSED' ) { return FALSE; }
        if ( $data['cb_msg'] === 'REGISTRATION_SUCCESS' ) { return FALSE; }
        if ( $data['cb_msg'] === 'REGISTRATION_SUCCESS_EMAIL_ACTIVATION_NEED' ) { return FALSE; }
        if ( $data['cb_msg'] === 'REGISTRATION_SUCCESS_ADMIN_ACTIVATION_NEED' ) { return FALSE; }
        if ( $data['cb_msg'] === 'REGISTRATION_ERROR_BAD_DATA_GIVEN' ) { return FALSE; }
        
        
        
        $data = [
                'provider'=> 'corebeat_api',
                'uid'     => $userData['data']['id'],
                'token'   => $this->api_corebeat->get_token(),
                'first_name'    => $userData['data']['first_name'],
                'last_name'     => $userData['data']['last_name'],
                'display_name'  => $userData['data']['display_name'],
                'email'         => $userData['data']['email'],
                'picture'       => $userData['data']['avatar'],
                'link'          => "",
                'data'          => json_encode($userData['data']['data'])
            ];
        
        return $data;
    }
    
    protected function corebeat_check_email($email) {
        $data = $this->api_corebeat->get('account/check_allowedemail?email='.$email);$this->save($data);
        
        if ( !$data ) { return FALSE; }
        elseif ( $data['cb_msg'] !== 'SUCCESS' ) { return FALSE; }
        
        return TRUE;
    }
    
    protected function corebeat_check_referral($referral) {
        $data = $this->api_corebeat->get('account/check_referral?referral_id='.$referral);$this->save($data);
        
        if ( !$data ) { return FALSE; }
        elseif ( $data['cb_msg'] !== 'SUCCESS' ) { return FALSE; }
        
        return TRUE;
    }
    
    protected function corebeat_check_password($password) {
        $p = [ 'password'=>$password ];
        $data = $this->api_corebeat->post('account/check_passwordstrength',$p);$this->save($data);
        
        if ( !$data ) { return FALSE; }
        elseif ( $data['cb_msg'] !== 'SUCCESS' ) { return FALSE; }
        
        return TRUE;
    }
    
    private function save($data) { 
        if ( isset($data['state']) ) { $this->state = $data['state']; }
        if ( isset($data['cb_msg']) ) { $this->msg = $data['cb_msg']; }
        if ( isset($data['identity_error']) ) { $this->identity_error = $data['identity_error']; }
        if ( isset($data['viewstate_error']) ) { $this->viewstate_error = $data['viewstate_error']; }
        if ( isset($data['token']) ) { $this->token = $data['token']; }
        if ( isset($data['data']) ) { $this->data = $data; }
    }
    
    protected function data_get($what) {
        if ( $what === 'data' ) { return $this->data; }
        elseif ( $what === 'msg' || $what === 'message' ) { return $this->msg; }
        elseif ( $what === 'state' ) { return $this->state; }
        elseif ( $what === 'token' ) { return $this->token; }
        elseif ( $what === 'identity_error' ) { return $this->identity_error; }
        elseif ( $what === 'viewstate_error' ) { return $this->viewstate_error; }
    }
    
}

return; ?>