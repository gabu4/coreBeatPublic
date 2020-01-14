<?php
namespace module\admin\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 20/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    use lists\call;
    use product\call;
    
    public function __call_main() {
        //$html = $this->callMain_themeLoad();
        global $module;
        $html = $module->loadAdminFunction('admin','adminmodulemenu');
        
        return $html;
    }    
}

return; ?>
