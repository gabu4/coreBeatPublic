<?php
namespace module\admin\menu\menulist;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callList_themeLoad($menuListDataRow,$catid,$catlang) {
        global $theme, $admin_function;
        
        $html = $theme->loadAdminTemplate('admin_menu','menulist',TRUE,'menu');
        
        $replace = Array();
        $replace['category_filter'] = $this->callList_categoryFilter($catid);
        $replace['language_filter'] = $this->callList_languageFilter($catlang);
        
        if ( !empty($menuListDataRow) ) {

            $mldef = Array();
            $menuListData = Array();

            foreach( $menuListDataRow as $mlv ) {
                $mldef[$mlv['parent']][$mlv['m_id']] = $mlv;
            }

            $menuListData = $this->functionMenuListCreate($mldef, 0, 0);
            
            $tableHead = Array();

            $tableHead[] = "[ADMIN_TEXT_MENU_CALL_MAIN_ID]";
            $tableHead[] = "[ADMIN_TEXT_MENU_CALL_MAIN_MENULISTNAME]";
            $tableHead[] = "[ADMIN_TEXT_MENU_CALL_MAIN_STATE]";
            $tableHead[] = "[ADMIN_TEXT_MENU_CALL_MAIN_ORDER]";
            $tableHead[] = '&nbsp;';
            $tableHead[] = '&nbsp;';

            $tableBody = Array();$i = 0;
            foreach ( $menuListData as $val ) {

                $tableBody[$i] = Array();

                $name = "";
                for ( $i2 = 0; $i2 < $val['level']; $i2++ ) {
                        $name .= "--";
                }
                $name .= $val['name'];
                $type = $val['ct_module']."_".$val['ct_type'];


                $tableBody[$i][] = $val['m_id'];
                $tableBody[$i][] = $name;
                $tableBody[$i][] = ( $val['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                $tableBody[$i][] = $val['order'];
                $tableBody[$i][] = "<a href='?admin=menu&funct=edit&catid=".$catid."&catlang=".$catlang."&type=".$type."&id=".$val['m_id']."'>" . $admin_function->getIcon('edit') . "</a>";
                $tableBody[$i][] = "<a href='?admin=menu&funct=trash&catid=".$catid."&catlang=".$catlang."&id=".$val['m_id']."' onclick=\"javascript:return confirm('[ADMIN_TEXT_MENU_LIST_DELETESURE]')\">" . $admin_function->getIcon('trash') . "</a>";
                
                $i++;
            }

            $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'menu_list');
        } else {
            $replace['body'] = "[ADMIN_TEXT_MENU_LIST_EMPTY]";
        }
        $theme->replace($replace, $html);
        
        return $html;
    }
    
    private function callList_categoryFilter($currentCatId) {
        $data = $this->callList_categoryListCreate_getData();
        
        $html = "";
        
        if ( !empty($data) ) {
            $html .= "<label>[ADMIN_TEXT_MENU_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE] </label> ";
            $html .= "<select class='selectCatListFilter' id='catListId' name='catList' size='1'>";
            
            $selected = ( $currentCatId != 0 && $currentCatId == -1 ) ? ' SELECTED ' : '';
            foreach ( $data as $ldValue ) {
                $selected = ( $currentCatId != 0 && $currentCatId == $ldValue['id'] ) ? ' SELECTED ' : '';
                $html .= "<option value='".$ldValue['id']."' ".$selected.">".$ldValue['name']."</option>";
            }
            $html .= "</select>";
        }
                
        return $html;
    }
    
    private function callList_languageFilter($catlang) {
        global $lang, $admin_function;
        
        $html = "";
        
        $html .= "<span class='activeCategoryLanguage' data-lang='".$catlang."'></span>";
        if ( $lang->getAllowedLanguageCount() <= 1 ) { 
            return $html;
        }
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $link = cb_link_clean(NULL,'catlang',$l);
            $active = " btn-default";
            if ( $catlang == $l ) { $active = " btn-info"; }
            $html .= "<a href='".$link."' class='btn btn-xs $active'>".$admin_function->getLanguageFlag($l)."</a>";
        }
        
        return $html;
    }
    
    private function functionMenuListCreate($mldef, $id, $level) {
        $menuListData = Array();

        foreach($mldef[$id] as $v) {

            $menuListData[$v['m_id']] = $v;
            $menuListData[$v['m_id']]['level'] = $level;

            if ( isset($mldef[$v['m_id']]) ) {
                $levelNext = $level+1;
                $menuListDataParent = $this->functionMenuListCreate($mldef, $v['m_id'], $levelNext);
                $menuListData = $menuListData + $menuListDataParent;
            }
            
        }

        return $menuListData;
    }
}

return; ?>