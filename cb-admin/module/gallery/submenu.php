<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 08/05/18
 */
if ( !defined('H-KEI') ) { exit; }

$SUBMENU['list'] = Array();
$SUBMENU['list'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=gallery&funct=main", "name" => "[BUTTON_TEXT_BACK]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['list'][1] = Array( "type" => "space" );
$SUBMENU['list'][2] = Array( "type" => "button", "button" => "adminModuleGallerySave", "name" => "[BUTTON_TEXT_SAVE]", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['list'][3] = Array( "type" => "button", "button" => "adminModuleGallerySaveAndExit", "name" => "[BUTTON_TEXT_SAVEANDEXIT]", "icon" => "fa-save" );

return; ?>