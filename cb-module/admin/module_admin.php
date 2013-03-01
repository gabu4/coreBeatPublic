<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2012. 10. 06.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

include_once('language/'.LANGTYPE.'.php');

class admin_admin {
	
	var $admin = 0;
	var $call = Array( "main" );
	
	function admin_admin() {
		global $user, $theme, $handler;
		
		$handler->callAdmin['main'] = $this->call;
		
	}
	
	public function __call_main() {
		global $theme;
		
		$html = $theme->loadModuleTemplate('_admin_admin_menu_template');
		
		return $html;
	}

}

?>