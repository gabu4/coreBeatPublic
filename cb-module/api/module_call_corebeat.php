<?php
namespace module\api\corebeat;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 01/07/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_cb_connect() { $this->corebeat_api_callback();return $this; }
    
    public function __call_cb_data($what) { $this->corebeat_api_callback();return $this->data_get($what); }
    
    public function __call_cb_get($path) { $this->corebeat_api_callback();return $this->corebeat_call($path); }
    
    public function __call_cb_get_login($setup) { $this->corebeat_api_callback();return $this->corebeat_api_login($setup); }
    
    public function __call_cb_get_userdata() { $this->corebeat_api_callback();return $this->corebeat_userdata(); }
    
    public function __call_cb_get_registration($setup) { $this->corebeat_api_callback();return $this->corebeat_registration($setup); }
    
    public function __call_cb_get_check_email($setup) { $this->corebeat_api_callback();return $this->corebeat_check_email($setup); }
    public function __call_cb_get_check_referral($setup) { $this->corebeat_api_callback();return $this->corebeat_check_referral($setup); }
    public function __call_cb_get_check_password($setup) { $this->corebeat_api_callback();return $this->corebeat_check_password($setup); }
}

return; ?>