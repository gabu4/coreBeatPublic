<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 11/08/19
 */
require_once 'function_global_helper.php';

function menuLanguageSelectCreate( $catlang ) {
    global $lang, $theme, $admin_function;
    
    $menuLanguageListData = array();
    
    if ( $lang->getAllowedLanguageCount() == 1 ) {
        $html = "<input type='hidden' name='language' value='".$catlang."' />";
        return $html;
    }
    foreach ( $lang->getAllowedLanguageTypes() as $l ) {
        $d = array();
        $d['short'] = $l;
        $d['name'] = $lang->getLanguageFullName($l);
        $d['flag'] = $admin_function->getLanguageFlag($l);
        $menuLanguageListData[] = $d;
    }

    $html = "<label>[ADMIN_TEXT_MENUPOINT_SELECTOR_LANGUAGE]</label>";

    $html .= "<select class='form-control languageSelect' name='language' size='1'>";
    foreach ( $menuLanguageListData as $val ) {
        $sel = ( $val['short'] == $catlang ) ? ' SELECTED ' : '';
        $html .= "<option value='".$val['short']."' $sel data-selected='language_".$val['short']."' data-selected-raw='".$val['short']."'>".$val['name']."</option>";
    }

    $html .= "</select>";

    return $html;
}

function menuGroupSelectCreate( $catid = 1 ) {
    global $database;

    $database->newQuery();
    $database->select("*");
    $database->from("`#__menu_category` `mcat`");
    $database->where("`mcat`.`state` > '0' ");
    $database->group("`mcat`.`id`");
    $database->order("`mcat`.`id` ASC");
    $menuGroupListData = $database->execute();

    $html = "";

    $html .= "<select class='form-control categorySelect' name='category' size='1'>";

    foreach ( $menuGroupListData as $val ) {
        $sel = ( $val['id'] == $catid ) ? ' SELECTED ' : '';
        $html .= "<option value='".$val['id']."' $sel data-selected='parent_".$val['id']."' data-selected-raw='".$val['id']."'>".$val['name']."</option>";
    }
    
    $html .= "</select>";

    return $html;
}

function menuParentSelectCreate( $catlang, $catid = 1, $menuData = NULL ) {
    global $lang;
    
    if ($menuData === NULL) {
        $menuData['id'] = 0;
        $menuData['parent'] = 0;
    }
    $groupKeysRaw = array();$menuListData = array();
    functionMenuParentSelect_databaseGet($groupKeysRaw, $menuListData);
    
    $menu = array();
    $groupKeys = array();

    foreach ( $groupKeysRaw as $value ) {
        $groupKeys[$value['id']] = $value['id'];
    }
    
    if ( !empty($menuListData) ) {
        foreach ( $menuListData as $value ) {
            $menu[$value['lang']][$value['category']][$value['parent']][$value['id']] = $value;
        }
    }

    $curParent = $menuData['parent'];
    $currentMenuId = $menuData['id'];

    $html = "";
    
    foreach ( array_keys($groupKeys) as $key ) {
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $style = "";
            $disabled = "";        
            if ( $catid != $key || $catlang != $l ) {
                $style = " style='display:none;' ";
                $disabled = " DISABLED ";
            }
            
            $html .= "<select class='form-control parentSelect parentSelect_".$l."_".$key."' name='parent[".$l."][".$key."]' ".$style.$disabled." size='10'>";

            $selFirst = ( $curParent == '0' ) ? ' SELECTED ' : '';
            $html .= "<option class='group_0' value='0' $selFirst >[ADMIN_TEXT_MENUPOINT_SELECTOR_PARENT_MAINMENU]</option>";

            if ( isset($menu[$l][$key]) ) {
                $a = "";
                $html .= functionMenuParentSelect_optionReply( $menu[$l][$key], $curParent, $l, 0, $a, $currentMenuId);
            }
            $html .= "</select>";
        }
    }

    return $html;
}
    
function savePost_getPostOrderNext($parent_id) {
    global $database;

    $database->newQuery();
    $database->select("`order`");
    $database->from("`#__menu`");
    $database->where(" `parent` = '".$parent_id."' and `state` >= '0' ");
    $database->order("`order` DESC");
    $database->limit(" 1 ");
    $database->qType("result");
    $order = $database->execute();

    if ( !$order ) { $order = 100; } else { $order = $order*1 + 100; }

    return $order;
}

function savePost_getContentTypeId($module,$type) {
    global $database;

    $database->newQuery();
    $database->select("`id`");
    $database->from("`#__content_type`");
    $database->where(" `module` = '".$module."' and `type` = '".$type."' ");
    $database->order("`id` DESC");
    $database->limit(" 1 ");
    $database->qType("result");

    return $database->execute();
}

function savePost_getNextMenuId() {
    global $database;

    $database->newQuery();
    $database->select("`id`");
    $database->from("`#__menu`");
    $database->order("`id` DESC");
    $database->limit(" 1 ");
    $database->qType("result");

    return $database->execute()+1;
}

function savePost_getNextContentId() {
    global $database;

    $database->newQuery();
    $database->select("`id`");
    $database->from("`#__content`");
    $database->order("`id` DESC");
    $database->limit(" 1 ");
    $database->qType("result");

    return $database->execute()+1;
}

return; ?>
