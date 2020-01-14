<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 02/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class module_api extends module {
    protected $call_api = Array(); //meghívható api modulok listája
    
    public function init_api() {
        global $user;
        $this->setLevelAccess($user->cb_get_user_level());
        
        $this->moduleListLoad();
        $this->moduleListLoad_api();
    }
    
    private function moduleListLoad_api() {
        foreach ( $this->moduleList as $res ) {
            $this->moduleLoad_api($res['module_name'], $res['function']);
        }
    }
    
    private function moduleLoad_api($name, $function) {
        $path = CB_ROOTDIR.'/'.CB_API.'/'.$name.'-self';  //Alternatív modul útvonal (egyéni módosított modulokhoz) modulnév-self
        if ( !file_exists($path) ) { $path = CB_ROOTDIR.'/'.CB_API.'/'.$name; }
        if ( 
                !isset($this->call_api[$name][$function]) && 
                is_file($path.'/module.php') && 
                is_file($path.'/module_database.php') && 
                is_file($path.'/module_function.php') && 
                is_file($path.'/module_call.php')
                ) {
            $this->moduleLoad_api_e($path,$name,$function);
        }
    }
    
    private function moduleLoad_api_e($path,$name,$function) {
        if ( is_file($path.'/function.php') ) { include_once($path.'/function.php'); }
        include_once($path.'/module.php');
        if ( isset($subModuleFile) && !empty($subModuleFile) ) { $this->moduleLoad_api_subModuleFileLoad($path,$subModuleFile); }
        include_once($path.'/module_database.php');
        include_once($path.'/module_function.php');
        include_once($path.'/module_call.php');
        
        $module = 'module_api_'.$name;
        $moduleName = 'module_api\\'.$name.'\call';
        
        global $$module;
        if ( empty($$module) ) $$module = new $moduleName;
        
        if ( !isset($this->call_api[$name]) ) { $this->call_api[$name] = Array(); }

        $functionName = '__call_api_'.$function;
        $moduleName2 = $name.'_user_'.$function;
        
        if ( isset($this->levelAccessByName[$moduleName2]) && is_callable(array($moduleName, $functionName)) ) { $this->call_api[$name][$function] = 1; }
        
        if ( isset($this->levelAccessByName[$moduleName2]) && $function === 'main' && isset($allowedRights) && !empty($allowedRights) ) {
            foreach($allowedRights as $function2=>$rights ) {
                $moduleName3 = $name.'_user_'.$function2;
                if ( !isset($this->levelAccessByName[$moduleName3]) ) { continue; }
                foreach($rights as $f ) {
                    $fn = '__call_'.$f;
                    $mn = $name.'_user_'.$f;
                    if ( is_callable(array($moduleName, $fn)) ) {
                        $this->levelAccessByName[$mn] = 1;
                        $this->call[$name][$f] = 1;
                    }
                }
            }
        }
    }
    
    private function moduleLoad_api_subModuleFileLoad($path,$subModuleFile) {
        foreach ( $subModuleFile as $subModule ) {
            if ( is_file($path.'/module_'.$subModule.'.php') ) { include_once($path.'/module_'.$subModule.'.php'); }
            if ( is_file($path.'/module_database_'.$subModule.'.php') ) { include_once($path.'/module_database_'.$subModule.'.php'); }
            if ( is_file($path.'/module_function_'.$subModule.'.php') ) { include_once($path.'/module_function_'.$subModule.'.php'); }
            if ( is_file($path.'/module_call_'.$subModule.'.php') ) { include_once($path.'/module_call_'.$subModule.'.php'); }
        } 
    }
    
    /** Modul API funkció betöltése (belső)
     * 
     * @param string $cModule modul neve
     * @param string $cFunction funkció neve (__call_ előtag nélkül)
     * @param mixed $cSettings átadandó paraméterek (statikus vagy tömb, a tömb tömbként kerül átadásra!)
     * @return mixed az adott modul visszatérési eredménye
     */
    public function loadFunction_api($cModule, $cFunction, $cSettings = NULL, $pageContentLog = FALSE ) {
        $cModule = strtolower($cModule);
        $cModule_m = 'module_api_'.$cModule;
        $cFunction = strtolower($cFunction);
        
        if ($pageContentLog) { global $systemlog;$systemlog->saveModuleLog($cModule, $cFunction, $cSettings); }

        if ( !isset($this->call_api[$cModule][$cFunction]) ) { return FALSE; }
        $cFunction = "__call_api_".$cFunction;
        
        global $$cModule_m;
        $ret = $$cModule_m->$cFunction($cSettings);
        if ( $ret === '' || $ret === FALSE ) { return FALSE; }
        
        return $ret;
    }
}

return; ?>
