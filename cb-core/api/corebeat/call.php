<?php
namespace api\corebeat;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 25/09/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    public function connect() { $this->corebeat_api_callback();return $this; }
    
    public function data($what) { $this->corebeat_api_callback();return $this->data_get($what); }
    
    public function get($path,$force=FALSE) { $this->corebeat_api_callback();return $this->corebeat_call($path,$force); }
    
    public function get_login($setup) { $this->corebeat_api_callback();return $this->corebeat_api_login($setup); }
    
    public function get_userdata($force=FALSE) { $this->corebeat_api_callback();return $this->corebeat_userdata($force); }
    
    public function get_registration($setup) { $this->corebeat_api_callback();return $this->corebeat_registration($setup); }
    
    public function get_check_email($setup) { $this->corebeat_api_callback();return $this->corebeat_check_email($setup); }
    public function get_check_referral($setup) { $this->corebeat_api_callback();return $this->corebeat_check_referral($setup); }
    public function get_check_password($setup) { $this->corebeat_api_callback();return $this->corebeat_check_password($setup); }
}

return; ?>