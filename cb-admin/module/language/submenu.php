<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 12/08/19
 */
if ( !defined('H-KEI') ) { exit; }

$SUBMENU['main'] = [
    
];
//$SUBMENU['main'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=language&funct=main", "name" => "[BUTTON_TEXT_BACK]", "class" => "bg-red", "icon" => "fa-chevron-left" );
//$SUBMENU['main'][1] = Array( "type" => "space" );
//$SUBMENU['main'][2] = Array( "type" => "button", "button" => "adminModuleGallerySave", "name" => "[BUTTON_TEXT_SAVE]", "class" => "bg-green", "icon" => "fa-save" );

$SUBMENU['list'] = [
    [ "type" => "link", "link" => CB_BASEDIR."?admin=language&funct=main", "name" => "[BUTTON_TEXT_BACK]", "class" => "bg-red", "icon" => "fa fa-chevron-left" ],
    [ "type" => "space" ],
    [ "type" => "link", "link" => CB_BASEDIR."?admin=language&funct=new", "name" => "[LANG_ADMIN_LANGUAGE_NEW]", "icon" => "fa fa-plus" ],
];


$SUBMENU['new'] = [
    [ "type" => "link", "link" => CB_BASEDIR."?admin=language&funct=list", "name" => "[BUTTON_TEXT_BACK]", "class" => "bg-red", "icon" => "fa fa-chevron-left" ],
    [ "type" => "space" ],
    [ "type" => "button", "button" => "adminLanguageSave", "name" => "[LANG_ADMIN_LANGUAGE_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" ],
    [ "type" => "button", "button" => "adminLanguageSaveAndNew", "name" => "[LANG_ADMIN_LANGUAGE_SAVE_AND_NEW]", "icon" => "fa fa-save" ],
    [ "type" => "button", "button" => "adminLanguageSaveAndExit", "name" => "[LANG_ADMIN_LANGUAGE_SAVE_AND_EXIT]", "icon" => "fa fa-save" ]
];

$SUBMENU['edit'] = [
    [ "type" => "link", "link" => CB_BASEDIR."?admin=language&funct=list", "name" => "[BUTTON_TEXT_BACK]", "class" => "bg-red", "icon" => "fa fa-chevron-left" ],
    [ "type" => "space" ],
    [ "type" => "button", "button" => "adminLanguageJump", "name" => "[LANG_ADMIN_LANGUAGE_JUMP]", "class" => "bg-yellow", "icon" => "fa fa-step-forward" ],
    [ "type" => "space" ],
    [ "type" => "button", "button" => "adminLanguageSave", "name" => "[LANG_ADMIN_LANGUAGE_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" ],
    [ "type" => "button", "button" => "adminLanguageSaveAndNew", "name" => "[LANG_ADMIN_LANGUAGE_SAVE_AND_NEW]", "icon" => "fa fa-save" ],
    [ "type" => "button", "button" => "adminLanguageSaveAndNext", "name" => "[LANG_ADMIN_LANGUAGE_SAVE_AND_NEXT]", "class" => "bg-blue", "icon" => "fa fa-save" ],
    [ "type" => "button", "button" => "adminLanguageSaveAndExit", "name" => "[LANG_ADMIN_LANGUAGE_SAVE_AND_EXIT]", "icon" => "fa fa-save" ],
    [ "type" => "space" ],
    [ "type" => "button", "button" => "adminLanguageDelete", "name" => "[LANG_ADMIN_LANGUAGE_DELETE]", "class" => "bg-red", "icon" => "fa fa-trash" ],
];

$SUBMENU['deprecated'] = [
    [ "type" => "link", "link" => CB_BASEDIR."?admin=language&funct=main", "name" => "[BUTTON_TEXT_BACK]", "class" => "bg-red", "icon" => "fa fa-chevron-left" ]
];

return; ?>