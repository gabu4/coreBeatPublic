<?php
namespace module\admin\admin\settings;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 17/01/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    public function __call_settings() {
        global $post;
        
        $settingsData = $this->callSettings_dbSettings();
        
        if ( isset($post['adminModuleSettingsSave']) ) { 
            $this->callSettings_saveData($settingsData);
        }
        
        
        $html = $this->callSettings_createLook($settingsData);
        
        return $html;
    }
    
}

return; ?>