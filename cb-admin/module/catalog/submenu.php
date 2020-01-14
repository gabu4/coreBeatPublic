<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

//$SUBMENU['main'] = Array();
//$SUBMENU['main'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=admin&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );

$SUBMENU['list'] = Array();
$SUBMENU['list'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=catalog&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['list'][1] = Array( "type" => "space" );
$SUBMENU['list'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=catalog&funct=catalog_create", "name" => "Termék létrehozás", "class" => "bg-green", "icon" => "fa-plus-square" );

$SUBMENU['catalog_create'] = Array();
$SUBMENU['catalog_create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=catalog&funct=list", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['catalog_create'][1] = Array( "type" => "space" );
$SUBMENU['catalog_create'][2] = Array( "type" => "button", "button" => "adminModuleCatalogSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['catalog_create'][3] = Array( "type" => "button", "button" => "adminModuleCatalogSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['catalog_create'][4] = Array( "type" => "button", "button" => "adminModuleCatalogSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );

$SUBMENU['catalog_edit'] = Array();
$SUBMENU['catalog_edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=catalog&funct=list", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['catalog_edit'][1] = Array( "type" => "space" );
$SUBMENU['catalog_edit'][2] = Array( "type" => "button", "button" => "adminModuleCatalogSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['catalog_edit'][3] = Array( "type" => "button", "button" => "adminModuleCatalogSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['catalog_edit'][4] = Array( "type" => "button", "button" => "adminModuleCatalogSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );
$SUBMENU['catalog_edit'][5] = Array( "type" => "button", "button" => "adminModuleCatalogSaveCopy", "name" => "Mentés másolatként", "class" => "bg-blue", "icon" => "fa-copy" );

return; ?>