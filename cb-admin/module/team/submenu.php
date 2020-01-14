<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

$SUBMENU['main'] = Array();
$SUBMENU['main'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=team&funct=create", "name" => "Új munkatárs felvétele", "icon" => "fa-user-plus" );
$SUBMENU['main'][1] = Array( "type" => "space" );

$SUBMENU['create'] = Array();
$SUBMENU['create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=team&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['create'][1] = Array( "type" => "space" );
$SUBMENU['create'][2] = Array( "type" => "button", "button" => "adminModuleTeamMateSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['create'][3] = Array( "type" => "button", "button" => "adminModuleTeamMateAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );

$SUBMENU['edit'] = Array();
$SUBMENU['edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=team&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['edit'][1] = Array( "type" => "space" );
$SUBMENU['edit'][2] = Array( "type" => "button", "button" => "adminModuleTeamMateSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['edit'][3] = Array( "type" => "button", "button" => "adminModuleTeamMateAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );

return; ?>