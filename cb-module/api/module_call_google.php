<?php
namespace module\api\google;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_connect_gp() { if ( empty($this->sdk_facebook) ) { $this->set_facebook_sdk(); } }
    
    public function __call_get_gp_login() { return $this->facebook_sdk_callback(); }
    
    public function __call_get_gp($path) { return $this->facebook_call($path); }
    
    public function __call_get_gp_loginbutton() { $this->__call_connect_fb(); return $this->facebook_login_button(); }
    
    public function __call_get_gp_userdata() { return $this->facebook_userdata(); }
    
}

return; ?>