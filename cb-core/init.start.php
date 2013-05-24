<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2013. 05. 24.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

function init() {
	global $theme;
	
	$theme->pageTitle = CB_PAGETITLE;
		
	main();
	
	$theme->loadPageTheme();

	$theme->buildPage();

	return $theme->tempOut;
}

function main() {
	global $module, $module_main, $theme, $user;
	
	if ( isset($_GET['admin']) and ( $module->haveAdmin == 1 ) ){
		
		$ok = $module->loadAdminFunction($_GET['admin']);
		if ( !empty($ok) ) {
			$theme->theme = ADMIN_THEMESET;
			return;
		}
		
	}
		
	$type = $module_main->pageType;
	$id = $module_main->actPageVal;
	
	
	if ( isset($_GET['mod']) and !empty($_GET['mod']) and isset($_GET['f']) and !empty($_GET['f']) ) {
		$module = $_GET['mod'];
		$funct = $_GET['f'];
		$type = $module_main->pageType = 'MODULE';
		
		$out = $module->getFunction(strtolower($module), strtolower($f));
		
		if ( !empty($out) ) {
			$theme->inMAIN = $out; return;
		}
	}

	if ( isset($_GET['page']) ) {
		$id = ( isset($_GET['page']) and ( !empty($_GET['page']) ) ) ? $_GET['page'] : $id;
		$type = $module_main->pageType = 'PAGE';
		$module_main->actPageVal = $id;
	} elseif ( isset($_GET['post']) ) {
		$id = ( isset($_GET['post']) and ( !empty($_GET['post']) ) ) ? $_GET['post'] : $id;
		$type = $module_main->pageType = 'POST';
		$module_main->actPageVal = $id;
	} elseif ( isset($_GET['category']) ) {
		$id = ( isset($_GET['category']) and ( !empty($_GET['category']) ) ) ? $_GET['category'] : $id;
		$type = $module_main->pageType = 'CATEGORY';
		$module_main->actPageVal = $id;
	}
	
//	$id = 3;
	$theme->inMAIN = $module->loadFunction('main', strtolower($type), $id);
	
	
	/*	
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');

		$link = $database->getSelect("result","`value`","menu"," WHERE `id` = '$id' AND `state` = '1' ");
		if ( empty($link) ) { $theme->tempREPLACE[$where] = 'Hiba'; return; }
		
		header("Location: ".$link);
	*/
	
}

return; ?>
