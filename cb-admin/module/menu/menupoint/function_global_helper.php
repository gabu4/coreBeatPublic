<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 19/04/18
 */

function functionMenuParentSelect_databaseGet( &$groupKeysRaw, &$menuListData ) {
    global $database;

    $database->newQuery();
    $database->select("*");
    $database->from("`#__menu_category` `mc`");
    $database->where("`mc`.`state` != '-1' ");
    $database->order("`mc`.`id` ASC");
    $groupKeysRaw = $database->execute();

    $database->newQuery();
    $database->select("*, `m`.`id` as `id`");
    $database->from("`#__menu` `m`, `#__content` `c`");
    $database->where("`m`.`content_id` = `c`.`id` and `m`.`state` != '-1' ");
    $database->group("`m`.`id`");
    $database->order("`m`.`category` ASC, `m`.`order` ASC, `m`.`id` ASC");
    $menuListData = $database->execute();

    if ( !empty($groupKeysRaw) && !empty($menuListData)) {
        return true;
    } else {
        return false;
    }
}

function functionMenuParentSelect_optionReply( $menu, $curParent, $l, $id, $a, $currentMenuId = 0) {
    $a .= "&nbsp;&nbsp;";
    $html = "";

    foreach ( $menu[$id] as $val ) {
        if ( $currentMenuId == $val['id'] && $l == $val['lang'] ) { continue; }
        $sel = ( $curParent == $val['id'] && $l == $val['lang'] ) ? ' SELECTED ' : '';
        $html .= "<option class='group_".$val['lang'].'_'.$val['category']."' value='".$val['id']."' $sel >".$a.$val['name']."</option>";
        if ( isset($menu[$val['id']]) AND !empty($menu[$val['id']]) ) {
            $html .= functionMenuParentSelect_optionReply( $menu, $curParent, $l, $val['id'], $a, $currentMenuId);
        }
    }

    return $html;
}

return; ?>
