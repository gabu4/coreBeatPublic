<?php
namespace api\facebook;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 25/09/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    public function connect() { if ( empty($this->sdk_facebook) ) { $this->set_facebook_sdk(); } }
    
    public function get_login() { return $this->facebook_sdk_callback(); }
    
    public function get($path) { return $this->facebook_call($path); }
    
    public function get_loginbutton() { $this->__call_connect_fb(); return $this->facebook_login_button(); }
    
    public function get_userdata() { return $this->facebook_userdata(); }
    
    public function get_token() {}
    
    public function post_page() {}
    
    public function post_group() {}
}

return; ?>