<?php
namespace module\account;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('account');

$subModuleFile = Array();
$allowedRights = ["main"=>["pwcheck","avatartype"]];

abstract class module {
    protected $registrationSetup = array();
    protected $sdk_fb;
    protected $sdk_gp;
    
    public function registrationSetup() {
        $this->registrationSetup = array(
            'open' => false,
            'invite' => false,
            'activate_email' => false,
            'activate_admin' => false
        );
        
        if ( CB_ACCOUNT_LOCAL_REGISTER === 'none' ) { $this->registrationSetup['open'] = false; }
        elseif ( CB_ACCOUNT_LOCAL_REGISTER === 'normal' ) { $this->registrationSetup['open'] = true; }
        if ( CB_ACCOUNT_LOCAL_INVITE === 'user' ) { $this->registrationSetup['invite'] = true; }
        elseif ( CB_ACCOUNT_LOCAL_INVITE === 'admin' ) { $this->registrationSetup['invite'] = true; }
        if ( CB_ACCOUNT_LOCAL_ACTIVATION === 'email' ) { $this->registrationSetup['activate_email'] = true; }
        elseif ( CB_ACCOUNT_LOCAL_ACTIVATION === 'admin' ) { $this->registrationSetup['activate_admin'] = true; }
    }
}

return; ?>
