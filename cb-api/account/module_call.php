<?php
namespace module_api\account;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 01/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    function __construct() {
        $this->registrationSetup = array(
            'open' => false,
            'invite' => false,
            'activate_email' => false,
            'activate_admin' => false
        );
        
        if ( CB_REGMODE == 'normal' ) { //normál regisztráció
            $this->registrationSetup['open'] = true;
        } elseif ( CB_REGMODE == 'normal_email' ) {  //email megerősítés
            $this->registrationSetup['open'] = true;
            $this->registrationSetup['activate_email'] = true;
        } elseif ( CB_REGMODE == 'normal_admin' ) {  //admin megerősítés
            $this->registrationSetup['open'] = true;
            $this->registrationSetup['activate_admin'] = true;
        } elseif ( CB_REGMODE == 'invited' ) {  //felhasználó általi meghívás
            $this->registrationSetup['invite'] = true;
        } elseif ( CB_REGMODE == 'admin_invited' ) {  //admin általi meghívás
            $this->registrationSetup['invite'] = true;
        }
    }
    
    public function __call_api_main() {
        cb_api_user_only();
        $this->api_main();
    }
    
    public function __call_api_login($v) {
        $this->api_login();
    }
    
    public function __call_api_logout($v) {
        cb_api_user_only();
        $this->api_logout();
    }
    
    public function __call_api_registration($v) {
        $this->api_registration();
    }
}

return; ?>
