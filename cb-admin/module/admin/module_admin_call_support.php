<?php
namespace module\admin\admin\support;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 21/05/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    public function __call_support() {
        
        $html = $this->callSupport_createLook();
        
        return $html;
    }
    
}

return; ?>