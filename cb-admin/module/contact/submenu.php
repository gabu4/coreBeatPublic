<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

$SUBMENU['forms'] = Array();
$SUBMENU['forms'][1] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=contact&funct=forms_create", "name" => "Új űrlap létrehozása", "icon" => "fa-file-o" );

$SUBMENU['forms_create'] = Array();
$SUBMENU['forms_create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=contact&funct=forms", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['forms_create'][1] = Array( "type" => "space" );
$SUBMENU['forms_create'][2] = Array( "type" => "button", "button" => "adminModuleFormsSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['forms_create'][3] = Array( "type" => "button", "button" => "adminModuleFormsSaveAndExit", "name" => "Mentés és Kilépés", "icon" => "fa-save" );

$SUBMENU['forms_edit'] = Array();
$SUBMENU['forms_edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=contact&funct=forms", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['forms_edit'][1] = Array( "type" => "space" );
$SUBMENU['forms_edit'][2] = Array( "type" => "button", "button" => "adminModuleFormsSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['forms_edit'][3] = Array( "type" => "button", "button" => "adminModuleFormsSaveAndExit", "name" => "Mentés és Kilépés", "icon" => "fa-save" );


return; ?>