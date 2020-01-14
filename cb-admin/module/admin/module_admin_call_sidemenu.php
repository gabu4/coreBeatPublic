<?php
namespace module\admin\admin\sidemenu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 11/11/17
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    public function __call_menu() {
        $html = $this->createSideMenu();
        
        return $html;
    }
    
}

return; ?>