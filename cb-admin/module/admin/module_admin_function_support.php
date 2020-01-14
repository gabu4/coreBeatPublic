<?php
namespace module\admin\admin\support;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 24/02/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    protected function callSupport_createLook() {
        global $theme;
        
        $html = $theme->loadAdminTemplate2('admin_support_page',TRUE,'admin');
        
        return $html;
    }
    
}

return; ?>