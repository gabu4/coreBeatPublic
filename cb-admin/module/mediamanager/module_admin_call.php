<?php
namespace module\admin\mediamanager;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    use filemanager\call;
    use media\call;
    
    public function __construct() {
        global $media_admin;
        require_once 'function_media.php';
        $media_admin = new media_admin();
    }
    
    public function __call_main() {
        global $module;
        
        $html = $module->loadAdminFunction('admin','adminmodulemenu');
        
        return $html;
    }
}

return;?>