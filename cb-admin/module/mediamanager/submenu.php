<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

$SUBMENU['media_list'] = [];
$SUBMENU['media_list'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=mediamanager&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['media_list'][1] = Array( "type" => "space" );
$SUBMENU['media_list'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=mediamanager&funct=media_add", "name" => "[LANG_ADMIN_MEDIAMANAGER_NEW_MEDIA_FILE_UPLOAD]", "icon" => "fa-file-o" );
//$SUBMENU['main'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_main", "name" => "Bejegyzés kategóriák", "icon" => "fa-th-large" );
//$SUBMENU['main'][3] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=trash_main", "name" => "Lomtár" );

$SUBMENU['media_add'] = [];
$SUBMENU['media_add'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['create'][1] = Array( "type" => "space" );
$SUBMENU['create'][2] = Array( "type" => "button", "button" => "adminModuleArticleSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['create'][3] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['create'][4] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );
$SUBMENU['create'][5] = Array( "type" => "link", "link" => "#", "name" => "Előnézet", "class" => "contentPreview bg-yellow", "icon" => "fa-eye" );

$SUBMENU['edit'] = Array();
$SUBMENU['edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['edit'][1] = Array( "type" => "space" );
$SUBMENU['edit'][2] = Array( "type" => "button", "button" => "adminModuleArticleSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['edit'][3] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndExit", "name" => "Mentés és kilépés", "class" => "", "icon" => "fa-save" );
$SUBMENU['edit'][4] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndNew", "name" => "Mentés és új", "class" => "", "icon" => "fa-save" );
$SUBMENU['edit'][5] = Array( "type" => "button", "button" => "adminModuleArticleSaveCopy", "name" => "Mentés másolatként", "class" => "bg-blue", "icon" => "fa-copy" );
$SUBMENU['edit'][6] = Array( "type" => "link", "link" => "#", "name" => "Előnézet", "class" => "contentPreview bg-yellow", "icon" => "fa-eye" );

$SUBMENU['group_main'] = Array();
$SUBMENU['group_main'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['group_main'][1] = Array( "type" => "space" );
$SUBMENU['group_main'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_create", "name" => "Új kategória létrehozása", "icon" => "fa-file-o" );

$SUBMENU['group_create'] = Array();
$SUBMENU['group_create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['group_create'][1] = Array( "type" => "space" );
$SUBMENU['group_create'][2] = Array( "type" => "button", "button" => "adminModuleArticleGroupSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['group_create'][3] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndExit", "name" => "Mentés és kilépés", "icon" => "fa-save" );
$SUBMENU['group_create'][4] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndNew", "name" => "Mentés és új", "icon" => "fa-save" );

$SUBMENU['group_edit'] = Array();
$SUBMENU['group_edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa-chevron-left" );
$SUBMENU['group_edit'][1] = Array( "type" => "space" );
$SUBMENU['group_edit'][2] = Array( "type" => "button", "button" => "adminModuleArticleGroupSave", "name" => "Mentés", "class" => "bg-green", "icon" => "fa-save" );
$SUBMENU['group_edit'][3] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndExit", "name" => "Mentés és kilépés", "icon" => "fa-save" );
$SUBMENU['group_edit'][4] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndNew", "name" => "Mentés és új", "icon" => "fa-save" );
$SUBMENU['group_edit'][5] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveCopy", "name" => "Mentés másolatként", "class" => "bg-blue", "icon" => "fa-copy" );

return; ?>