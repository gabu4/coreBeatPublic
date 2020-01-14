<?php
namespace menupoint\menu\html;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 18/10/18
 */
if (!defined('H-KEI')) {
    exit;
}

class funct extends database {

    protected function menupointHtml_defaultData() {
        $data = Array(
            "id" => "0",
            "content_id" => "0",
            "title" => "",
            "name" => "",
            "seo_name" => "",
            "text" => "",
            "order" => "",
            "htmllink" => "",
            "groupselect" => "",
            "parentselect" => "",
            "state" => "1",
            "parent" => "0"            
        );

        return $data;
    }

    protected function menupointHtml_themeLoad($data, $id = 0) {
        global $theme;
        
        $html = $theme->loadAdminTemplate('admin_menupoint_menu', 'menupoint_html', TRUE, 'menu');
        
        $replace = array();
        
        foreach ( $data as $k => $v ) {
            $replace[strtoupper($k)] = $v;
        }
        
        $replace['TITLE'] = ( isset($data['name']) ) ? '[ADMIN_TEXT_MENUPOINT_HTML_EDIT_TITLE]' : '[ADMIN_TEXT_MENUPOINT_HTML_CREATE_TITLE]';
        $replace['NAME'] = ( isset($data['name']) ) ? $data['name'] : '';
        $replace['SEO_NAME'] = ( isset($data['seo_name']) ) ? $data['seo_name'] : '';
        $replace['TEXT'] = ( isset($data['text']) ) ? $data['text'] : '';
        $replace['ORDER'] = ( isset($data['order']) ) ? $data['order'] : '';

        $replace['LANGUAGESELECT'] = menuLanguageSelectCreate($data['catlang']);
        $replace['GROUPSELECT'] = menuGroupSelectCreate($data['catid']);
        $replace['PARENTSELECT'] = menuParentSelectCreate($data['catlang'],$data['catid'],$data);
        $replace['HTMLLINK'] = ( isset($data['html_link']) ) ? $data['html_link'] : '';
        $replace['ID'] = $id;
        
        $replace['IFSTATE0'] = ( !isset($data['state']) ) ? '' : ( $data['state'] == 0 ) ? ' CHECKED' : '';
        $replace['IFSTATE1'] = ( !isset($data['state']) ) ? ' CHECKED' : ( $data['state'] == 1 ) ? ' CHECKED' : '';
        
        $replace['IFISBLANK'] = ( !isset($data['blank']) ) ? '' : ( $data['blank'] == 1 ) ? ' CHECKED' : '';

        $theme->replace($replace, $html);

        return $html;
    }

    protected function menupointHtml_menuGroupSelectCreate($catid = 1) {
        global $database;

        $database->newQuery();
        $database->select("*");
        $database->from("`#__menu_category` `mcat`");
        $database->where("`mcat`.`state` > '0' ");
        $database->group("`mcat`.`id`");
        $database->order("`mcat`.`id` ASC");
        $menuGroupListData = $database->execute();

        $html = "";

        $html .= "<select class='form-control' name='category' size='1'>";

        foreach ($menuGroupListData as $val) {
            $sel = ( $val['id'] == $catid ) ? ' SELECTED ' : '';
            $html .= "<option value='" . $val['id'] . "' $sel data-selected='parent_" . $val['id'] . "' data-selected-raw='" . $val['id'] . "'>" . $val['name'] . "</option>";
        }

        $html .= "</select>";

        return $html;
    }

    protected function menupointHtml_menuParentSelectCreate($catid = 1, $menuData = NULL) {
        global $database;

        if ($menuData === NULL) {
            $menuData['id'] = 0;
            $menuData['parent'] = 0;
        }
        $groupKeysRaw = array();$menuListData = array();
        $this->functionMenuParentSelect_databaseGet($groupKeysRaw, $menuListData);

        $menu = array();
        $groupKeys = array();

        foreach ( $groupKeysRaw as $value ) {
            $groupKeys[$value['id']] = $value['id'];
        }

        if ( !empty($menuListData) ) {
            foreach ( $menuListData as $value ) {
                $menu[$value['category']][$value['parent']][$value['id']] = $value;
            }
        }

        $curParent = $menuData['parent'];
        $currentMenuId = $menuData['id'];
                
        $html = "";

        foreach ( array_keys($groupKeys) as $key ) {
            $style = "";
            $disabled = "";
            if ( $catid != $key ) {
                $style = " style='display:none;' ";
                $disabled = " DISABLED ";
            }
            $html .= "<select class='form-control parentSelect_parent_".$key."' name='parent[".$key."]' ".$style.$disabled." size='10'>";

            $selFirst = ( $curParent == '0' ) ? ' SELECTED ' : '';
            $html .= "<option class='group_0' value='0' $selFirst >FŐMENÜ</option>";

            if ( isset($menu[$key]) ) {
                $a = "";
                $html .= $this->functionMenuParentSelect_optionReply( $menu[$key], $curParent, 0, $a, $currentMenuId);
            }
            $html .= "</select>";
        }

        return $html;
    }

    private function functionMenuParentSelect_optionReply( $menu, $curParent, $id, $a, $currentMenuId = 0) {
        $a .= "&nbsp;&nbsp;";
        $html = "";

        foreach ( $menu[$id] as $val ) {
            if ( $currentMenuId == $val['id'] ) { continue; }
            $sel = ( $curParent == $val['id'] ) ? ' SELECTED ' : '';
            $html .= "<option class='group_".$val['category']."' value='".$val['id']."' $sel >".$a.$val['name']."</option>";
            if ( isset($menu[$val['id']]) AND !empty($menu[$val['id']]) ) {
                $html .= $this->functionMenuParentSelect_optionReply( $menu, $curParent, $val['id'], $a, $currentMenuId);
            }
        }

        return $html;
    }

    /* MENUPOINT HTML SAVE FUNCION */

    protected function menupointHtml_saveTest() {
        global $post;

        if (isset($post['adminModuleMenuSave']) OR
                isset($post['adminModuleMenuSaveAndExit']) OR
                isset($post['adminModuleMenuSaveAndNew'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function menupointHtml_saveTest_error() {
        global $post;
        $error = Array();

        return $error;
    }

    protected function menupointHtml_save_success($data) {
        global $handler;

        $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS]", true, "save");

        if (isset($data['adminModuleMenuSave'])) {
            header("Location: " . CB_INDEX . "?admin=menu&funct=edit&catid=" . $data['catid'] . "&id=" . $data['id'] . "&type=menu_html");
        } else if (isset($data['adminModuleMenuSaveAndExit'])) {
            header("Location: " . CB_INDEX . "?admin=menu#funct=main&catid=" . $data['catid'] . "");
        } else if (isset($data['adminModuleMenuSaveAndNew'])) {
            header("Location: " . CB_INDEX . "?admin=menu&funct=create&catid=" . $data['catid'] . "");
        }
    }

    protected function menupointHtml_save_error($error) {
        global $handler;

        $e = implode('<br />', $error);

        $handler->messageError($e, false, "save");
    }

}

return;
?>