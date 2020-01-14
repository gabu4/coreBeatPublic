<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

global $get, $lang;
$catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
$catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];


$SUBMENU['group_main'] = Array();
$SUBMENU['group_main'][0] = Array( "link" => CB_BASEDIR."?admin=menu&funct=group_create", "name" => "Új menücsoport létrehozása" );
$SUBMENU['group_main'][1] = Array( "type" => "space" );
$SUBMENU['group_main'][2] = Array( "link" => CB_BASEDIR."?admin=menu&funct=group_trash_main", "name" => "Menücsoport lomtár" );


$SUBMENU['group_create'] = Array();
$SUBMENU['group_create'][0] = Array( "link" => CB_BASEDIR."?admin=menu&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left"  );

$SUBMENU['group_trash_main'] = Array();
$SUBMENU['group_trash_main'][0] = Array( "link" => CB_BASEDIR."?admin=menu&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left"  );

$SUBMENU['main'] = Array();
//$SUBMENU['list'][0] = Array( "link" => CB_BASEDIR."?admin=menu&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
//$SUBMENU['list'][1] = Array( "type" => "space" );
$SUBMENU['main'][2] = Array( "link" => CB_BASEDIR."?admin=menu&funct=create&catid=".$catid."&catlang=".$catlang."", "name" => "Új menüpont", "class" => "", "icon" => "fa-bars" );
/* $SUBMENU['list'][3] = Array( "type" => "space" );
$SUBMENU['list'][4] = Array( "link" => CB_BASEDIR."?admin=menu&funct=trash_main&catid=".$catid."", "name" => "Lomtár" ); */

$SUBMENU['trash_main'] = Array();
$SUBMENU['trash_main'][0] = Array( "link" => CB_BASEDIR."?admin=menu&funct=main&catid=".$catid."&catlang=".$catlang."", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left"  );

$SUBMENU['create'] = Array();
$SUBMENU['create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=menu&funct=main&catid=".$catid."&catlang=".$catlang."", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['create'][1] = Array( "type" => "space" );
$SUBMENU['create'][2] = Array( "type" => "button", "button" => "adminModuleMenuSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['create'][3] = Array( "type" => "button", "button" => "adminModuleMenuSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['create'][4] = Array( "type" => "button", "button" => "adminModuleMenuSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );

$SUBMENU['edit'] = Array();
$SUBMENU['edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=menu&funct=main&catid=".$catid."&catlang=".$catlang."", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['edit'][1] = Array( "type" => "space" );
$SUBMENU['edit'][2] = Array( "type" => "button", "button" => "adminModuleMenuSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['edit'][3] = Array( "type" => "button", "button" => "adminModuleMenuSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['edit'][4] = Array( "type" => "button", "button" => "adminModuleMenuSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );
//$SUBMENU['edit'][5] = Array( "type" => "button", "button" => "adminModuleMenuSaveCopy", "name" => "Mentés másolatként", "class" => "blue", "class" => "bg-blue", "icon" => "fa-copy" );

return; ?>