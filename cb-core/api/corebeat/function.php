<?php
namespace api\corebeat;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v012
 * @date 22/09/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
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
        $a = $this->api_corebeat->post('account/login',$setup);
        $this->save($a);
        if ( !$a ) { return FALSE; }
        if ( $a['cb_msg'] !== 'LOGIN_SUCCESS' ) { return FALSE; }
        
        $this->corebeat_userdata(TRUE);
        
        return TRUE;
    }
    
    protected function corebeat_call($path,$force) {
        $data = $this->api_corebeat->get($path,NULL,$force);$this->save($data);
        if ( !$data ) { return FALSE; }
        return $data;
    }
    
    protected function corebeat_userdata($force) {
        $userData = $this->api_corebeat->get('account/data',NULL,$force);
        $this->save($userData);
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
        
        $data = $this->api_corebeat->post('account/registration',$p,TRUE);$this->save($data);
        
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
        $data = $this->api_corebeat->get('account/check_allowedemail?email='.$email,NULL,TRUE);$this->save($data);
        
        if ( !$data ) { return FALSE; }
        elseif ( $data['cb_msg'] !== 'SUCCESS' ) { return FALSE; }
        
        return TRUE;
    }
    
    protected function corebeat_check_referral($referral) {
        $data = $this->api_corebeat->get('account/check_referral?referral_id='.$referral,NULL,TRUE);$this->save($data);
        
        if ( !$data ) { return FALSE; }
        elseif ( $data['cb_msg'] !== 'SUCCESS' ) { return FALSE; }
        
        return TRUE;
    }
    
    protected function corebeat_check_password($password) {
        $p = [ 'password'=>$password ];
        $data = $this->api_corebeat->post('account/check_passwordstrength',$p,TRUE);$this->save($data);
        
        if ( !$data ) { return FALSE; }
        elseif ( $data['cb_msg'] !== 'SUCCESS' ) { return FALSE; }
        
        return TRUE;
    }
    
    private function save($data) {
        $this->state = ( isset($data['state']) ? $data['state'] : '' );
        $this->msg = ( isset($data['cb_msg']) ? $data['cb_msg'] : '' );
        $this->identity_error = ( isset($data['identity_error']) ? $data['identity_error'] : [] );
        $this->viewstate_error = ( isset($data['viewstate_error']) ? $data['viewstate_error'] : [] );
        $this->token = ( isset($data['token']) ? $data['token'] : '' );
        $this->data = ( isset($data['data']) ? $data['data'] : [] );
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