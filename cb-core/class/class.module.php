<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v003
|     Date: 2013. 01. 30.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

class module {
	// TODO: Modulkezelést megcsinálni!
	
	private $call = Array();
	private $callAdmin = Array();
	
	public $haveAdmin = 0;
	
	public $levelAccess = Array(); //hozzáférési jogosultság tábla (ID alapján)
	public $levelAccessByName = Array(); //hozzáférési jogosultságtábla (modul Neve alapján)
	
	private $moduleList = Array();
	
	public function module() {
		$this->init();
	}
	
	public function init() {
		global $user;
		$this->levelAccess($user->userLevel);
		$this->moduleInit();
	}
	
	private function moduleInit() {
		foreach ( $this->moduleList as $res ) {
			$this->moduleLoad($res['name'], $res['type'], $res['function']);
		}
	}
	
	private function moduleLoad($name, $type, $function) {
		
		
		if ($type == 'USER') {
			if ( !isset($this->call[$name]) AND is_file(CB_MODULE.'/'.$name.'/module.php') ) {
				include_once(CB_MODULE.'/'.$name.'/module_user.php');
				
				$module = 'module_'.$name;
				
				global $$module;
				$$module = new $name;
				
				$this->call[$name] = Array();
				
				$functionName = '__call_'.$function;
				if ( function_exists( call_user_func(array($$module, $functionName)) ) ) {
					$this->call[$name][$function] = '';
				}
			}
		} else if ($type == 'ADMIN') {
			if ( !isset($this->callAdmin[$name]) AND ( $this->haveAdmin == 1 ) AND ( is_file(CB_MODULE.'/'.$name.'/admin.php') ) ) {
				include_once(CB_MODULE.'/'.$name.'/module_admin.php');
				
				$module = 'module_admin_'.$name;
				
				global $$module;
				$$module = new $name;
				
				$this->callAdmin[$name] = Array();
				
				$functionName = '__call_'.$function;
				if ( function_exists( call_user_func(array($$module, $functionName)) ) ) {
					$this->callAdmin[$name][$function] = '';
				}
			}
		}
		
		
	}
	
	public function checkAccess($name) {
		global $user;
		
		if ( isset($user->levelAccessByName[$name]) AND $user->levelAccessByName[$name] == 1 ) {
			return 1;
		}
		
		return 0;
	}

/* <!-- hozzáférési szint lekérdezés */
		
	private function levelAccess($level) {
		global $database;
		
		$setup = $database->getSelect("result","`setup`","user_level"," WHERE `id` = '".$level."' ");
		
		$accBin = $this->lev_hex2bin($setup);
		
		$this->levelAccess = $this->lev_bin2acc($accBin);
		
		$this->haveAdmin = ( isset($this->levelAccess[1]) ) ? $this->levelAccess[1] : 0;
		$this->moduleList();
		
		$modName = $this->moduleName();

		foreach ( $this->levelAccess as $key => $val) {
			if ( isset($modName[$key]) ) {
				$this->levelAccessByName[$modName[$key]] = $val;
			}
		}
		
	}
	/* hozzáférési szint lekérdezés --> */

	/* <!-- kódbináris generálás */
		/* hozzáférési modul táblából bináris mátrix létrehozás */
	private function lev_acc2bin($code) {
		global $database;
		
		$maxId = $database->getSelect("result","`id`","module_details"," ORDER BY `id` DESC LIMIT 1 ");
		
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
	
		/* binális mátrixból hozzáférési modul tábla létrehozás */
	private function lev_bin2acc($code) {
		
		$accLevel = Array();
		
		for( $c=0;$c<strlen($code);$c+=1 ) {
			$a = substr( $code , $c , 1 );
			$accLevel[$c+1] = $a;
		}
		
		return $accLevel;
		
	}
	
		/* hexa mátrixból binális mátrix készítése */
	private function lev_hex2bin($code) {
		$hex = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
		$bin = array("0000","0001","0010","0011","0100","0101","0110","0111","1000","1001","1010","1011","1100","1101","1110","1111");
		$code = str_replace($hex,$bin,strtolower($code));

		return $code;
	}
	
		/* binális mátrixból hexa mátrix készítése */
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
	
	private function moduleList() {
		global $database;
		
		$reqMod = ( $this->haveAdmin != 1 ) ? " AND `1`.`type` != 'ADMIN' " : "";
		
		$table = Array();
		$table[] = "module";
		$table[] = "module_details";
		$this->moduleList = $database->getSelect("array","*, `1`.`id` `id`",$table," WHERE `0`.`id` = `1`.`module_id` AND `0`.`active` = '1' ".$reqMod." ORDER BY `0`.`priority` ASC, `1`.`module_id` ASC ");
		
	}
	
	private function moduleName() {
		
		$moduleName = Array();
		foreach ( $this->moduleList as $val ) {
			if ( isset($this->levelAccess[$val['id']]) AND ($this->levelAccess[$val['id']] == 1) ) {
				$moduleName[$val['id']] = strtolower($val['name'].'_'.$val['type'].'_'.$val['function']);
			}
		}
		
		return $moduleName;
	}

	
/* <!-- funkció meghívás modulból */

	
	private function genCallList() {
		$call = $this->call;
		
		if ( !empty($this->callList) ) unset($this->callList);
		
		foreach ( $call as $key => $val ) {
			foreach ( $val as $val2) {
				$this->callList[$val2] = $key;
			}
		}
	}
	
	private function genCallAdminList() {
		$call = $this->callAdmin;
		
		if ( !empty($this->callAdminList) ) unset($this->callAdminList);
		
		foreach ( $call as $key => $val ) {
			foreach ( $val as $val2) {
				$this->callAdminList[$val2] = $key;
			}
		}
	}
	
	public function loadFunction($who, $where = 'MAIN') {
		global $theme;
		
		$where = strtoupper($where);
		
		$this->genCallList();
		$who = strtolower($who);
		if ( !isset($this->callList[$who]) ) return 0;
		$module = $this->callList[$who];
		
		global $$module;
		
		$function = "__call_".$who;
		$ret = $$module->$function();
		if ( !$ret ) return 0;
		
		$theme->tempREPLACE[$where] = $ret;
		$this->haveFunctionCall = 1;
		
		return 1;
	}
	
	public function loadAdminFunction($who, $where = 'MAIN') {
		global $theme;
		
		$where = strtoupper($where);
		
		$this->genCallAdminList();
		$who = strtolower($who);
		if ( !isset($this->callAdminList[$who]) ) return 0;
		$module = $this->callAdminList[$who];
		
		global $$module;
		
		$function = "__call_".$who;
		$ret = $$module->$function();
		if ( !$ret ) return 0;
		
		$theme->tempREPLACE[$where] = $ret;
		$this->haveFunctionCall = 1;
		
		return 1;
	}
	
/* funkció meghívás modulból --!> */

}

return; ?>
