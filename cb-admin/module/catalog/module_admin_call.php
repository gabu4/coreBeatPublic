<?php
namespace module\admin\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v014
 * @date 21/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    use lists\call;
    use catalog\call;
    use importexport\call;
    
    public function __call_main() {
        //$html = $this->callMain_themeLoad();
        global $module;
        $html = $module->loadAdminFunction('admin','adminmodulemenu');
        
        return $html;
    }
    
    public function __call_catalog_without_image() {
        $html = $this->callCatalogWithoutImage_themeLoad();
        return $html;
    }
}

return; ?>
