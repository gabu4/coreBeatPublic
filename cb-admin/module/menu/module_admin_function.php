<?php
namespace module\admin\menu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v016
 * @date 17/03/18
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: form ellenörzés és js elemek nincsenek még megírva!
class funct extends database {
    use grouplist\funct;
    use menulist\funct;
    
    protected function loadMenuFunction($cModule, $cFunction) {
        
        if ( is_file(CB_ADMIN.'/module/menu/menupoint/'.$cModule.'/'.$cFunction) ) {
            $path = CB_ADMIN.'/module/menu/menupoint/'.$cModule.'/'.$cFunction;
            $moduleName = '\menupoint\\'.$cModule.'\\'.$cFunction.'\call';
        } else {
            $path = CB_ADMIN.'/module/menu/menupoint/_default/_default';
            $moduleName = '\menupoint\_default\_default\call';
        }
        require_once('menupoint/function_global.php');
        require_once($path.'.php');
        require_once($path.'_database.php');
        require_once($path.'_function.php');
        require_once($path.'_call.php');        
        
        $module = new $moduleName;
        
        return $module->init();
    }
}

return; ?>