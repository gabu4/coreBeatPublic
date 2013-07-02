<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v002
|     Date: 2013. 07. 02.
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

function checkseo() {
	global $database, $module_main;
	
	$seo = $_GET['seo'];
	$val = $database->getSelect("row","*","menu"," WHERE `state` = '1' AND `seo_name` = '".$seo."' ");

	if ( !empty( $val ) ) {
		
			
		if ( $val['type'] != 'MODULE' ) { //TODO: Modul meghívást megcsinálni!
	
				$module_main->actPageVal = $val['value'];
				$module_main->menuId = $val['id'];
		print "modulmeghívás (még) nincs!";	
	//			$m = explode("|",$val['value']);
	//			$_GET['module'] = $m[0];
	//			$_GET['function'] = $m[1];
	//			$_GET['value'] = $m[2];
	//			$_GET['m'] = $val['id'];
				
		} else {
			
			$_GET[strtolower($val['value'])] = $val['type'];
			$_GET['m'] = $val['id'];
			
		}
		
	}
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
	
	if ( ( CB_IS_SEO == '1' ) AND isset($_GET['seo']) ) {
		checkseo();
	}
	
	if ( isset($_GET['m']) ) $module_main->menuId = $_GET['m'];
	
/*	if ( isset($_GET['mod']) and !empty($_GET['mod']) and isset($_GET['f']) and !empty($_GET['f']) ) {
		$module = $_GET['mod'];
		$funct = $_GET['f'];
		$type = $module_main->pageType = 'MODULE';
		
		$out = $module->getFunction(strtolower($module), strtolower($f));
		
		if ( !empty($out) ) {
			$theme->inMAIN = $out; return;
		}
	}
*/

	if ( isset($_GET['page']) ) {
	
		$module_main->pageType = 'PAGE';
		$module_main->actPageVal = $_GET['page'];
		
	} elseif ( isset($_GET['post']) ) {
	
		$module_main->pageType = 'POST';
		$module_main->actPageVal = $_GET['post'];
		
	} elseif ( isset($_GET['category']) ) {
	
		$module_main->pageType = 'CATEGORY';
		$module_main->actPageVal = $_GET['category'];
		
	}
	
//	$id = 3;
	$theme->inMAIN = $module->loadFunction('main', strtolower($module_main->pageType), $module_main->actPageVal);
	
	
	
}

return; ?>
