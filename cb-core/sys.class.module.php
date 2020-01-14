<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v049
 * @date 08/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class module {
    
    protected $call = Array(); //meghívható modulok listája
    protected $callAdmin = Array(); //meghívható admin modulok listája
    
    protected $haveAdmin = FALSE; //admin jogosultság színt
    protected $levelAccess = Array(); //hozzáférési jogosultság tábla (ID alapján)
    protected $levelAccessByName = Array(); //hozzáférési jogosultságtábla (modul Neve alapján)
    
    protected $moduleList = Array(); //aktív modulok listájának tárolója
    private $moduleNameList = Array(); //aktív modulok név listájának tárolója (nyelvi fájlokhoz)
    private $moduleNameListLenght = []; //aktív modulok név listájának tárolója (nyelvi fájlokhoz) /hossz alapján
    private $moduleNameListRLenght = []; //aktív modulok név listájának tárolója (nyelvi fájlokhoz) /hossz alapján fordított
    private $moduleNameListName = []; //aktív modulok név listájának tárolója (nyelvi fájlokhoz) /név alapján
    private $moduleNameListRName = []; //aktív modulok név listájának tárolója (nyelvi fájlokhoz) /név alapján fordított
    
    public function init() {
        global $user;
        
        $this->setLevelAccess($user->cb_get_user_level());
        
        $this->moduleListLoad();
        $this->moduleListInit();
    }
    
    protected function moduleListLoad() {
        foreach ( $this->moduleList as $res ) {
            $this->moduleLoad($res['module_name'], $res['type'], $res['function']);
        }
    }
    
    protected function moduleListInit() {
        foreach ( $this->moduleNameList as $res ) { $this->loadFunctionInit($res); }
        foreach ( $this->moduleNameList as $res ) { $this->loadAdminFunctionInit($res); }
    }
    
    public function cb_get_module_name_list($forLanguageScript = FALSE) {
        $m = $this->moduleNameList;
        if ( $forLanguageScript === TRUE ) { $m[] = 'sys'; }
        return $m;
    }
    
    private function moduleLoad($name, $type, $function) {
        if ($type == 'USER') {
            $this->moduleLoad_user($name, $function);
        } else if ( ($type == 'ADMIN') && ( $this->haveAdmin === TRUE ) ) {
            $this->moduleLoad_admin($name, $function);
        }
    }
    
    private function moduleLoad_user($name, $function) {
        $path = CB_ROOTDIR . '/' . CB_MODULE.'/'.$name.'-self';  //Alternatív modul útvonal (egyéni módosított modulokhoz) modulnév-self
        if ( !file_exists($path) ) { $path = CB_ROOTDIR . '/' . CB_MODULE.'/'.$name; }
        if ( 
                !isset($this->call[$name][$function]) && 
                is_file($path.'/module.php') && 
                is_file($path.'/module_database.php') && 
                is_file($path.'/module_function.php') && 
                is_file($path.'/module_call.php')
                ) {
            $this->moduleLoad_user_new($path,$name,$function);
        } else if ( 
                !isset($this->call[$name][$function]) && 
                is_file($path.'/module_user_function.php') && 
                is_file($path.'/module_user_call.php')
                ) {
            $this->moduleLoad_user_classic($path,$name,$function);
        }
    }
    
    private function moduleLoad_user_new($path,$name,$function) {
        if ( is_file($path.'/function.php') ) { include_once($path.'/function.php'); }
        include_once($path.'/module.php');
        if ( isset($subModuleFile) && !empty($subModuleFile) ) { $this->moduleLoad_subModuleFileLoad($path,$subModuleFile); }
        include_once($path.'/module_database.php');
        include_once($path.'/module_function.php');
        include_once($path.'/module_call.php');
        
        $module = 'module_'.$name;
        $moduleName = 'module\\'.$name.'\call';
        
        global $$module;
        if ( empty($$module) ) $$module = new $moduleName;
        
        if ( !isset($this->call[$name]) ) { $this->call[$name] = Array(); }

        $functionName = '__call_'.$function;
        $moduleName2 = $name.'_user_'.$function;
        
        if ( isset($this->levelAccessByName[$moduleName2]) && is_callable(array($moduleName, $functionName)) ) { $this->call[$name][$function] = 1; }
        
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
    
    private function moduleLoad_user_classic($path,$name,$function) {
        include_once($path.'/module_user_function.php');
        include_once($path.'/module_user_call.php');

        $module = 'module_'.$name;
        $moduleName = $module.'_call';

        global $$module;
        if ( empty($$module) ) $$module = new $moduleName;

        if ( !isset($this->call[$name]) ) {
            $this->call[$name] = Array();
        }

        $functionName = '__call_'.$function;

        $moduleName = $name.'_user_'.$function;
        if ( isset($this->levelAccessByName[$moduleName]) &&
             is_callable(array($$module, $functionName)) 
                ) {
            $this->call[$name][$function] = 1;
        }
    }
    
    private function moduleLoad_admin($name, $function) {
        $path = CB_ROOTDIR . '/' . CB_ADMIN.'/module/'.$name.'-self';  //Alternatív modul útvonal (egyéni módosított modulokhoz) modulnév-self
        if ( !file_exists($path) ) { $path = CB_ROOTDIR . '/' . CB_ADMIN.'/module/'.$name; }
        if ( 
                !isset($this->callAdmin[$name][$function]) && 
                is_file($path.'/module_admin.php') && 
                is_file($path.'/module_admin_database.php') && 
                is_file($path.'/module_admin_function.php') && 
                is_file($path.'/module_admin_call.php')
                ) {
            $this->moduleLoad_admin_new($path,$name,$function);
        } else if ( 
                !isset($this->callAdmin[$name][$function]) && 
                ( is_file($path.'/module_admin_function.php') ) && 
                ( is_file($path.'/module_admin_call.php') )
                ) {
                $this->moduleLoad_admin_classic($path,$name,$function);
            
        }
    }
    
    private function moduleLoad_admin_new($path,$name,$function) {
        if ( is_file($path.'/function.php') ) { include_once($path.'/function.php'); }
        include_once($path.'/module_admin.php');
        if ( isset($subModuleFile) && !empty($subModuleFile) ) { $this->moduleAdminLoad_subModuleFileLoad($path,$subModuleFile); }
        include_once($path.'/module_admin_database.php');
        include_once($path.'/module_admin_function.php');
        include_once($path.'/module_admin_call.php');

        $module = 'module_admin_'.$name;
        $moduleName = 'module\admin\\'.$name.'\call';
        
        global $$module;
        if ( empty($$module) ) $$module = new $moduleName;
        
        if ( !isset($this->callAdmin[$name]) ) { $this->callAdmin[$name] = Array(); }

        $functionName = '__call_'.$function;
        $moduleName2 = $name.'_admin_'.$function;

        if ( isset($this->levelAccessByName[$moduleName2]) && is_callable(array($moduleName, $functionName)) ) { $this->callAdmin[$name][$function] = 1; }
        
        if ( isset($this->levelAccessByName[$moduleName2]) && $function === 'main' && isset($allowedRights) && !empty($allowedRights) ) {
            foreach($allowedRights as $function2=>$rights ) {
                $moduleName3 = $name.'_user_'.$function2;
                if ( !isset($this->levelAccessByName[$moduleName3]) ) { continue; }
                foreach($rights as $f ) {
                    $fn = '__call_'.$f;
                    $mn = $name.'_admin_'.$f;
                    if ( is_callable(array($moduleName, $fn)) ) {
                        $this->levelAccessByName[$mn] = 1;
                        $this->callAdmin[$name][$f] = 1;
                    }
                }
            }
        }
    }
    
    private function moduleLoad_admin_classic($path,$name,$function) {
        include_once($path.'/module_admin_function.php');
        include_once($path.'/module_admin_call.php');

        $module = 'module_admin_'.$name;
        $moduleName = $module.'_call';

        global $$module;
        if ( empty($$module) ) $$module = new $moduleName;

        if ( !isset($this->callAdmin[$name]) ) $this->callAdmin[$name] = Array();

        $functionName = '__call_'.$function;

        $moduleName = $name.'_admin_'.$function;
        if ( isset($this->levelAccessByName[$moduleName]) &&
            is_callable(array($$module, $functionName)) ) {
            $this->callAdmin[$name][$function] = 1;
        }
    }
    
    private function moduleLoad_subModuleFileLoad($path,$subModuleFile) {
        foreach ( $subModuleFile as $subModule ) {
            if ( is_file($path.'/module_'.$subModule.'.php') ) { include_once($path.'/module_'.$subModule.'.php'); }
            if ( is_file($path.'/module_database_'.$subModule.'.php') ) { include_once($path.'/module_database_'.$subModule.'.php'); }
            if ( is_file($path.'/module_function_'.$subModule.'.php') ) { include_once($path.'/module_function_'.$subModule.'.php'); }
            if ( is_file($path.'/module_call_'.$subModule.'.php') ) { include_once($path.'/module_call_'.$subModule.'.php'); }
        }
    }
    
    private function moduleAdminLoad_subModuleFileLoad($path,$subModuleFile) {
        foreach ( $subModuleFile as $subModule ) {
            if ( is_file($path.'/module_admin_'.$subModule.'.php') ) { include_once($path.'/module_admin_'.$subModule.'.php'); }
            if ( is_file($path.'/module_admin_database_'.$subModule.'.php') ) { include_once($path.'/module_admin_database_'.$subModule.'.php'); }
            if ( is_file($path.'/module_admin_function_'.$subModule.'.php') ) { include_once($path.'/module_admin_function_'.$subModule.'.php'); }
            if ( is_file($path.'/module_admin_call_'.$subModule.'.php') ) { include_once($path.'/module_admin_call_'.$subModule.'.php'); }
        } 
    }
    
    /** Felhasználó modul hozzáférés ellenörzése (modulnév alapján)
     * 
     * @param string $mod modul neve
     * @param string $funct modulon belüli modul funkció
     * @param string $level felhasználói modul szint ( user - külső oldali, admin - adminisztrátori)
     * @return boolean TRUE akkor van hozzáférés, egyébként FALSE
     */
    public function cb_check_access($module, $function, $level = 'user') {
        $name = $module."_".$level."_".$function;
        if ( isset($this->levelAccessByName[$name]) && $this->levelAccessByName[$name] === 1 ) { return TRUE; }
        return FALSE;
    }

    public function checkLevelAccessList($level) {
        global $database;

        $setup = $database->getSelect("result","`setup`","user_level"," WHERE `id` = '".$level."' ");
        $accBin = $this->lev_hex2bin($setup);
        $levelMatrixAccess = $this->lev_bin2acc($accBin);
        $modName = $this->moduleName();
        $levelMatrixAccessByName = Array();
        
        foreach ( $levelMatrixAccess as $key => $val) {
            if ( isset($modName[$key]) ) {
                $levelMatrixAccessByName[$modName[$key]] = $val;
            }
        }
        
        return $levelMatrixAccessByName;
    }
    
    public function checkLevelAccessForModuleId($level,$id) {
        global $database;

        $setup = $database->getSelect("result","`setup`","user_level"," WHERE `id` = '".$level."' ");

        $accBin = $this->lev_hex2bin($setup);

        $levelMatrixAccess = $this->lev_bin2acc($accBin);

        return ( isset($levelMatrixAccess[$id]) and ( $levelMatrixAccess[$id] == 1 ) ) ? TRUE : FALSE;
    }
    
/* <!-- hozzáférési szint beállítás */

    protected function setLevelAccess($level) {
        global $database;

        $setup = $database->getSelect("result","`setup`","user_level"," WHERE `id` = '".$level."' ");

        $accBin = $this->lev_hex2bin($setup);

        $this->levelAccess = $this->lev_bin2acc($accBin);

        $this->haveAdmin = ( isset($this->levelAccess[1]) && ( $this->levelAccess[1] === 1 ) ) ? TRUE : FALSE;
        $this->moduleList();

        $modName = $this->moduleName();

        foreach ( $this->levelAccess as $key => $val) {
            if ( isset($modName[$key]) ) {
                $this->levelAccessByName[$modName[$key]] = (int) $val;
            }
        }
    }

    private function moduleList() {
        global $database;

        $reqMod = ( $this->haveAdmin !== TRUE ) ? " `0`.`type` != 'ADMIN' " : " 1 ";

        $table = Array();
        $table[] = "module";
        $this->moduleList = $database->getSelect("array","*",$table,"WHERE ".$reqMod." ORDER BY `0`.`module_name` ASC ");
        foreach ( $this->moduleList as $k ) {
            $this->moduleNameList[$k['module_name']] = $k['module_name'];
        }
        $this->moduleNameListLenght = $this->moduleNameList;
        $this->moduleNameListRLenght = $this->moduleNameList;
        $this->moduleNameListName = $this->moduleNameList;
        $this->moduleNameListRName = $this->moduleNameList;
        cb_array_sort_by_lenght($this->moduleNameListLenght);
        cb_array_sort_by_reverse_lenght($this->moduleNameListRLenght);
        sort($this->moduleNameListName);
        rsort($this->moduleNameListRName);
    }

    private function moduleName() {

        $moduleName = Array();
        foreach ( $this->moduleList as $val ) {
            if ( isset($this->levelAccess[$val['id']]) AND ($this->levelAccess[$val['id']] == 1) ) {
                $moduleName[$val['id']] = strtolower($val['module_name'].'_'.$val['type'].'_'.$val['function']);
            }
        }

        return $moduleName;
    }

    /* hozzáférési szint lekérdezés --> */

    /* <!-- kódbináris generálás */
            /** hozzáférési modul táblából bináris mátrix létrehozás */
    private function lev_acc2bin($code) {
        global $database;

        $maxId = $database->getSelect("result","`id`","module"," ORDER BY `id` DESC LIMIT 1 ");
        $maxId = ceil($maxId/4)*4;
        
        $bin = "";
        for( $c=1;$c<=$maxId;$c+=1 ) {
            if ( !isset($code[$c]) ) {
                $bin .= 0;
            } else {
                $bin .= $code[$c];
            }
        }
        
        return $bin;
    }

            /** binális mátrixból hozzáférési modul tábla létrehozás */
    private function lev_bin2acc($code) {

        $accLevel = Array();

        for( $c=0;$c<strlen($code);$c+=1 ) {
            $a = substr( $code , $c , 1 );
            $accLevel[$c+1] = (int) $a;
        }

        return $accLevel;

    }

            /** hexa mátrixból binális mátrix készítése */
    private function lev_hex2bin($code) {
        $hex = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
        $bin = array("0000","0001","0010","0011","0100","0101","0110","0111","1000","1001","1010","1011","1100","1101","1110","1111");
        $code = str_replace($hex,$bin,strtolower($code));

        return $code;
    }

            /** binális mátrixból hexa mátrix készítése */
    private function lev_bin2hex($code) {
        $hex = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
        $bin = array("0000","0001","0010","0011","0100","0101","0110","0111","1000","1001","1010","1011","1100","1101","1110","1111");

        $accessCode = "";
        $code = strtolower($code);
        for( $c=0;$c<strlen($code);$c+=4 ) {
            $a = substr( $code , $c , 4 );
            $accessCode .= str_replace($bin,$hex,$a);
        }

        return $accessCode;
    }
    /* kódbináris generálás --> */
    
    
    public function setupHexToAcc($hexa) {
        return $this->lev_bin2acc($this->lev_hex2bin($hexa));
    }
    
    
    public function setupAccToHex($accIdArray) {
        return $this->lev_bin2hex($this->lev_acc2bin($accIdArray));
    }
    
/* <!-- funkció meghívás modulból */

    public $loadFunctionCallForm = "";
    /** Modul funkció betöltése (belső)
     * 
     * @param string $cModule modul neve
     * @param string $cFunction funkció neve (__call_ előtag nélkül)
     * @param mixed $cSettings átadandó paraméterek (statikus vagy tömb, a tömb tömbként kerül átadásra!)
     * @return mixed az adott modul visszatérési eredménye
     */
    public function loadFunction($cModule, $cFunction, $cSettings = NULL, $pageContentLog = FALSE ) {
        $cModule = strtolower($cModule);
        $cModule_m = 'module_'.$cModule;
        $cFunction = strtolower($cFunction);
        
        if ($pageContentLog) { global $systemlog;$systemlog->saveModuleLog($cModule, $cFunction, $cSettings); }

        if ( !isset($this->call[$cModule][$cFunction]) ) { return FALSE; }
        $cFunction = "__call_".$cFunction;

        global $$cModule_m;
        $ret = $$cModule_m->$cFunction($cSettings);
        if ( $ret === '' || $ret === FALSE ) { return FALSE; }

        return $ret;
    }

    public function loadAdminFunction($cModule, $cFunction = 'main', $cSettings = NULL, $pageContentLog = FALSE) {
        $cModule = strtolower($cModule);
        $cModule_m = 'module_admin_'.$cModule;
        $cFunction = strtolower($cFunction);
        
        if ($pageContentLog) { global $systemlog;$systemlog->saveModuleLog($cModule, $cFunction, $cSettings); }

/*        if ( $cSettings == '__menupoint' ) {

            if ( !isset($this->callAdmin[$cModule]) ) { return FALSE; }
            $cFunction = "__menupoint_".$cFunction;
            $cSettings = strtolower($cSettings);

        } else {
*/
            if ( !isset($this->callAdmin[$cModule][$cFunction]) ) { return FALSE; }
            $cFunction = "__call_".$cFunction;
//        }

        global $$cModule_m;
        $ret = $$cModule_m->$cFunction($cSettings);
        if ( $ret === '' || $ret === FALSE ) { return FALSE; }

        return $ret;
    }
	
/* funkció meghívás modulból --!> */
    
    public function loadFunctionInit($cModule) {
        $cModule = strtolower($cModule);
        $cModule_m = 'module_'.$cModule;
        
        if ( !isset($this->call[$cModule]) ) { return FALSE; }
        
        global $$cModule_m;
        if ( method_exists($$cModule_m,'init')) { $ret = $$cModule_m->init(); } else { return FALSE; }
        if ( $ret === '' || $ret === FALSE ) { return FALSE; }
        
        return $ret;
    }

    public function loadAdminFunctionInit($cModule) {
        $cModule = strtolower($cModule);
        $cModule_m = 'module_admin_'.$cModule;
        
        if ( !isset($this->callAdmin[$cModule]) ) { return FALSE; }
        
        global $$cModule_m;
        if ( method_exists($$cModule_m,'init')) { $ret = $$cModule_m->init(); } else { return FALSE; }
        if ( $ret === '' || $ret === FALSE ) { return FALSE; }
        
        return $ret;
    }
}

return; ?>
