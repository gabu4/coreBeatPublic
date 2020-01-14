<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 28/10/19
 */
if ( !defined('H-KEI') ) { exit; }

global $get;

$SUBMENU['main'] = Array();
$SUBMENU['main'][0] = Array( "link" => CB_BASEDIR."?admin=account&funct=create", "name" => "[LANG_ADMIN_ACCOUNT_NEW_USER]", "icon" => "fas fa-user-plus" );
$SUBMENU['main'][1] = Array( "link" => CB_BASEDIR."?admin=account&funct=accountinvite", "name" => "[LANG_ADMIN_ACCOUNT_NEW_USER_INVITE]", "icon" => "far fa-envelope" );
//FIXME: a felhasználó meghívást újra kéne írni!

$SUBMENU['create'] = Array();
$SUBMENU['create'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=account&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['create'][1] = Array( "type" => "space" );
$SUBMENU['create'][2] = Array( "type" => "button", "button" => "adminModuleAccountSave", "name" => "[LANG_ADMIN_ACCOUNT_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['create'][3] = Array( "type" => "button", "button" => "adminModuleAccountSaveAndExit", "name" => "[LANG_ADMIN_ACCOUNT_SAVE_AND_EXIT]", "icon" => "fa fa-save" );

$SUBMENU['edit'] = Array();
$SUBMENU['edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=account&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['edit'][1] = Array( "type" => "space" );
$SUBMENU['edit'][2] = Array( "type" => "button", "button" => "adminModuleAccountSave", "name" => "[LANG_ADMIN_ACCOUNT_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['edit'][3] = Array( "type" => "button", "button" => "adminModuleAccountSaveAndExit", "name" => "[LANG_ADMIN_ACCOUNT_SAVE_AND_EXIT]", "icon" => "fa fa-save" );

$SUBMENU['details'] = Array();
$SUBMENU['details'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=account&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['details'][1] = Array( "type" => "space" );
$SUBMENU['details'][2] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=account&funct=edit&id=".@$get['id'], "name" => "[LANG_ADMIN_ACCOUNT_EDIT]", "class" => "bg-green", "icon" => "fas fa-pen" );

$SUBMENU['delete'] = Array();
$SUBMENU['delete'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=account&funct=main", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['delete'][1] = Array( "type" => "space" );
$SUBMENU['delete'][2] = Array( "type" => "button", "button" => "adminModuleAccountUserDelete", "name" => "[LANG_ADMIN_ACCOUNT_DELETE]", "class" => "bg-red", "icon" => "fas fa-trash-alt" );

$SUBMENU['permission_edit'] = Array();
$SUBMENU['permission_edit'][0] = Array( "type" => "link", "link" => CB_BASEDIR."?admin=account&funct=permission", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "bg-red", "icon" => "fa fa-chevron-left" );
$SUBMENU['permission_edit'][1] = Array( "type" => "space" );
$SUBMENU['permission_edit'][2] = Array( "type" => "button", "button" => "adminModulePermissionSave", "name" => "[LANG_ADMIN_ACCOUNT_SAVE]", "class" => "bg-green", "icon" => "fa fa-save" );
$SUBMENU['permission_edit'][3] = Array( "type" => "button", "button" => "adminModulePermissionSaveAndExit", "name" => "[LANG_ADMIN_ACCOUNT_SAVE_AND_EXIT]", "icon" => "fa fa-save" );

return; ?>