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
$SUBMENU['list'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=product&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['list'][1] = Array( "type" => "space" );
$SUBMENU['list'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=product&funct=product_create", "name" => "Termék létrehozás", "class" => "bg-green", "icon" => "fa-plus-square" );

$SUBMENU['product_create'] = Array();
$SUBMENU['product_create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=product&funct=list", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['product_create'][1] = Array( "type" => "space" );
$SUBMENU['product_create'][2] = Array( "type" => "button", "button" => "adminModuleProductSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['product_create'][3] = Array( "type" => "button", "button" => "adminModuleProductSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['product_create'][4] = Array( "type" => "button", "button" => "adminModuleProductSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );

$SUBMENU['product_edit'] = Array();
$SUBMENU['product_edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=product&funct=list", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['product_edit'][1] = Array( "type" => "space" );
$SUBMENU['product_edit'][2] = Array( "type" => "button", "button" => "adminModuleProductSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['product_edit'][3] = Array( "type" => "button", "button" => "adminModuleProductSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['product_edit'][4] = Array( "type" => "button", "button" => "adminModuleProductSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );
$SUBMENU['product_edit'][5] = Array( "type" => "button", "button" => "adminModuleProductSaveCopy", "name" => "Mentés másolatként", "class" => "bg-blue", "icon" => "fa-copy" );

return; ?>