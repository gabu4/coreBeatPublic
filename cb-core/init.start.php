<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 09. 26.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

function init() {
	global $theme;
	
	$theme->pageTitle = PAGETITLE;

	main();
	
	$theme->loadPageTheme();

	$theme->buildPage();

	return $theme->tempOut;
}

function main() {
	global $page, $menu, $module, $theme;
	
	if ( isset($_GET['admin']) ){
		
		$ok = $module->loadAdminFunction($_GET['admin']);
		if ( !empty($ok) ) {
			$theme->theme = ADMIN_THEMESET;
			$theme->isAdmin = 1;
			return;
		}
		
	}
	
	if ( isset($_GET['c']) ){
		$ok = $module->loadFunction($_GET['c']);
		if ( !empty($ok) ) return;
		
	}
		
	$type = $menu->actPageType;

	if ( $type == 'PAGE' ) {
		$id = ( isset($_GET['page']) and ( !empty($_GET['page']) ) ) ? $_GET['page'] : $menu->actPageVal;
		$page->loadPage($id);
	} elseif ( $type == 'MODULE' ) {
		$id = ( isset($_GET['c']) and ( !empty($_GET['c']) ) ) ? $_GET['c'] : $menu->actPageVal;
		$page->loadModule($id);
	} elseif ( $type == 'HTML' ) {
		$page->loadHtml();
	} elseif ( $type == 'POST' ) {
		$id = ( isset($_GET['post']) and ( !empty($_GET['post']) ) ) ? $_GET['post'] : $menu->actPageVal;
		$page->loadPost($id);
	} elseif ( $type == 'CAT' ) {
		$id = ( isset($_GET['cat']) and ( !empty($_GET['cat']) ) ) ? $_GET['cat'] : $menu->actPageVal;
		$page->loadCategory($id);
	}
	
}

return; ?>
