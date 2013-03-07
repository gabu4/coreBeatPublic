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

class module_admin_admin {
	
	var $admin = 0;
	
	function module_admin_admin() {
		global $user, $theme;
		
	}
	
	public function __call_main() {
		global $theme;
		
		$html = $theme->loadModuleTemplate('_admin_admin_menu_template');
		
		return $html;
	}

}

?>