<?php
namespace module\admin\menu\grouplist;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callGroupMain_createView($menuGroupListData) {
        global $theme, $admin_function;
        
        if ( empty($menuGroupListData) ) { return '[ADMIN_TEXT_MENU_CALL_EMPTY]'; }
        
        $html = $theme->loadAdminTemplate('admin_menu','menugrouplist',TRUE,'menu');
        
        $tableHead = Array(
            '[ADMIN_TEXT_MENU_CALL_MAIN_ID]',
            '[ADMIN_TEXT_MENU_CALL_MAIN_MENUNAME]',
            '[ADMIN_TEXT_MENU_CALL_MAIN_STATE]',
            "&nbsp;",
            "&nbsp;",
            "&nbsp;"
            );

        $tableBody = Array();$i = 0;
        foreach ( $menuGroupListData as $val ) {

            $tableBody[$i] = Array();

            $tableBody[$i][] = $val['id'];
            $tableBody[$i][] = $val['name'];
            $tableBody[$i][] = ( $val['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
            $tableBody[$i][] = "<a href='?admin=menu&funct=main&catid=".$val['id']."'>" . $admin_function->getIcon('view') . "</a>";
            $tableBody[$i][] = "<a href='?admin=menu&funct=group_edit&catid=".$val['id']."'>" . $admin_function->getIcon('edit') . "</a>";
            $tableBody[$i][] = "<a href='?admin=menu&funct=group_trash&catid=".$val['id']."'>" . $admin_function->getIcon('trash') . "</a>";

            $i++;
        }

        $replace = Array();
        $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'menu_group_main');
        
        $theme->replace($replace, $html);
        return $html;
    }
    
    protected function group_trash_method($id) {
        global $database;
        
        $array = array();
        
        $array['id'] = $id;
        $array['state'] = '-1';
    //    $state = $database->deleteFrom('#__menu_category',$array);
        $state = $database->updateTo('#__menu_category','id',$array);
        
        return $state;
    }

    
}

return; ?>