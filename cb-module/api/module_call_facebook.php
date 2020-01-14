<?php
namespace module\api\facebook;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 07/05/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_connect_fb() { if ( empty($this->sdk_facebook) ) { $this->set_facebook_sdk(); } }
    
    public function __call_get_fb_login() { return $this->facebook_sdk_callback(); }
    
    public function __call_get_fb($path) { return $this->facebook_call($path); }
    
    public function __call_get_fb_loginbutton() { $this->__call_connect_fb(); return $this->facebook_login_button(); }
    
    public function __call_get_fb_userdata() { return $this->facebook_userdata(); }
}

return; ?>