<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 10/10/19
 */
if ( !defined('H-KEI') ) { exit; }

$SUBMENU['main'] = Array();
$SUBMENU['main'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=create", "name" => "[LANG_ADMIN_ARTICLE_CREATE_NEW]", "icon" => "fa fa-file" );
$SUBMENU['main'][1] = Array( "type" => "space" );
//$SUBMENU['main'][3] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=trash_main", "name" => "Lomtár" );

$SUBMENU['create'] = Array();
$SUBMENU['create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['create'][1] = Array( "type" => "space" );
$SUBMENU['create'][2] = Array( "type" => "button", "button" => "adminModuleArticleSave", "name" => "[LANG_ADMIN_ARTICLE_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['create'][3] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndExit", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_EXIT]", "class" => "", "icon" => "fa fa-save" );
$SUBMENU['create'][4] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndNew", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_NEW]", "class" => "", "icon" => "fa fa-save" );
$SUBMENU['create'][5] = Array( "type" => "link", "link" => "#", "name" => "[LANG_ADMIN_ARTICLE_PREVIEW]", "class" => "contentPreview bg-yellow", "icon" => "fa fa-eye" );

$SUBMENU['edit'] = Array();
$SUBMENU['edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['edit'][1] = Array( "type" => "space" );
$SUBMENU['edit'][2] = Array( "type" => "button", "button" => "adminModuleArticleSave", "name" => "[LANG_ADMIN_ARTICLE_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['edit'][3] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndExit", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_EXIT]", "class" => "", "icon" => "fa fa-save" );
$SUBMENU['edit'][4] = Array( "type" => "button", "button" => "adminModuleArticleSaveAndNew", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_NEW]", "class" => "", "icon" => "fa fa-save" );
$SUBMENU['edit'][5] = Array( "type" => "button", "button" => "adminModuleArticleSaveCopy", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AS_COPY]", "class" => "bg-blue", "icon" => "fa fa-copy" );
$SUBMENU['edit'][6] = Array( "type" => "link", "link" => "#", "name" => "[LANG_ADMIN_ARTICLE_PREVIEW]", "class" => "contentPreview bg-yellow", "icon" => "fa fa-eye" );

$SUBMENU['group_main'] = Array();
$SUBMENU['group_main'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['group_main'][1] = Array( "type" => "space" );
$SUBMENU['group_main'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_create", "name" => "[LANG_ADMIN_ARTICLE_CREATE_NEW_CATEGORY]", "icon" => "fa fa-file-o" );

$SUBMENU['group_create'] = Array();
$SUBMENU['group_create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['group_create'][1] = Array( "type" => "space" );
$SUBMENU['group_create'][2] = Array( "type" => "button", "button" => "adminModuleArticleGroupSave", "name" => "[LANG_ADMIN_ARTICLE_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['group_create'][3] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndExit", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_EXIT]", "icon" => "fa fa-save" );
$SUBMENU['group_create'][4] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndNew", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_NEW]", "icon" => "fa fa-save" );

$SUBMENU['group_edit'] = Array();
$SUBMENU['group_edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=article&funct=group_main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['group_edit'][1] = Array( "type" => "space" );
$SUBMENU['group_edit'][2] = Array( "type" => "button", "button" => "adminModuleArticleGroupSave", "name" => "[LANG_ADMIN_ARTICLE_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['group_edit'][3] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndExit", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_EXIT]", "icon" => "fa fa-save" );
$SUBMENU['group_edit'][4] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveAndNew", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AND_NEW]", "icon" => "fa fa-save" );
$SUBMENU['group_edit'][5] = Array( "type" => "button", "button" => "adminModuleArticleGroupSaveCopy", "name" => "[LANG_ADMIN_ARTICLE_SAVE_AS_COPY]", "class" => "bg-blue", "icon" => "fa fa-copy" );

return; ?>