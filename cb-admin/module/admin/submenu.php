<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 10/10/19
 */
if ( !defined('H-KEI') ) { exit; }

global $get;

//$SUBMENU['settings'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "red", "icon" => "fa-chevron-left" );
//$SUBMENU['settings'][1] = Array( "type" => "space" );
$SUBMENU['settings'] = [];
$SUBMENU['settings'][2] = ["type" => "button", "button" => "adminModuleSettingsSave", "name" => "[LANG_ADMIN_ADMIN_SETTINGS_SAVE]", "class" => "bg-green", "icon" => "fa fa-save"];

if ( isset($get['version']) ) {
    $SUBMENU['update'] = [];
    $SUBMENU['update'][0] = ["type" => "link", "link" => CB_BASEDIR."?admin=admin&funct=update", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left"];
    $SUBMENU['update'][1] = ["type" => "space"];
    $SUBMENU['update'][2] = ["type" => "button", "button" => "adminUpdateDownloadNow", "name" => "Verzió frissítés letöltése", "class" => "bg-green", "icon" => "fa fa-cloud-download"];
}

return; ?>