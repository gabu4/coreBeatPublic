<?php
namespace menupoint\article\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v019
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    
    protected function menupointArticle_defaultData() {
        $data = Array(
            "id" => "0",
            "content_id" => "0",
            "title" => "",
            "name" => "",
            "seo_name" => "",
            "text" => "",
            "order" => "",
            "groupselect" => "",
            "parentselect" => "",
            "articleselect" => "",
            "state" => "1"
        );
        
        return $data;
    }
        
    protected function menupointArticle_checkPost(&$data) {
        global $post;
        if ( 
            isset($post['adminModuleMenuSave']) OR
            isset($post['adminModuleMenuSaveAndExit']) OR
            isset($post['adminModuleMenuSaveAndNew'])
            ) {
            return true;
        }
        return false;
    }
    
    protected function menupointArticle_savePost(&$catlang, &$catid) {
        global $post;
        
        if ( isset($post['adminModuleMenuSave']) ) {
            $this->menupointArticle_savePost_save($catlang, $catid);
        } else if ( isset($post['adminModuleMenuSaveAndExit']) ) {
            $this->menupointArticle_savePost_saveAndExit($catlang, $catid);
        } else if ( isset($post['adminModuleMenuSaveAndNew']) ) {
            $this->menupointArticle_savePost_saveAndNew($catlang, $catid);
        }
    }
    
    protected function menupointArticle_editPost(&$catlang, &$catid) {
        global $post;
        
        if ( isset($post['adminModuleMenuSave']) ) {
            $this->menupointArticle_editPost_save($catlang, $catid);
        } else if ( isset($post['adminModuleMenuSaveAndExit']) ) {
            $this->menupointArticle_editPost_saveAndExit($catlang, $catid);
        } else if ( isset($post['adminModuleMenuSaveAndNew']) ) {
            $this->menupointArticle_editPost_saveAndNew($catlang, $catid);
        }
    }
    
    private function menupointArticle_savePost_save(&$catlang, &$catid) {
        global $handler;
        
        $menu_id = $this->menupointArticle_savePost_asNew($catlang, $catid);
        
        if ( $menu_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=menu&funct=edit&catid=".$catid."&catlang=".$catlang."&type=article_article&id=".$menu_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB]",false,"save");
        }
    }
    
    private function menupointArticle_savePost_saveAndExit(&$catlang, &$catid) {
        global $handler;
        
        $menu_id = $this->menupointArticle_savePost_asNew($catlang, $catid);
        
        if ( $menu_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=menu&funct=main&catid=".$catid."&catlang=".$catlang);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB]",false,"save");
        }
    }
    
    private function menupointArticle_savePost_saveAndNew(&$catlang, &$catid) {
        global $handler;
        
        $menu_id = $this->menupointArticle_savePost_asNew($catlang, $catid);
        
        if ( $menu_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=menu&funct=create&catid=".$catid."&catlang=".$catlang);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB]",false,"save");
        }
    }
    
    private function menupointArticle_editPost_save(&$catlang, &$catid) {
        global $handler;
        
        $menu_id = $this->menupointArticle_editPost_update($catlang, $catid);
        
        if ( $menu_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=menu&funct=edit&catid=".$catid."&catlang=".$catlang."&type=article_article&id=".$menu_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB]",false,"save");
        }
    }
    
    private function menupointArticle_editPost_saveAndExit(&$catlang, &$catid) {
        global $handler;
        
        $menu_id = $this->menupointArticle_editPost_update($catlang, $catid);
        
        if ( $menu_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=menu&funct=main&catid=".$catid."&catlang=".$catlang);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB]",false,"save");
        }
    }
    
    private function menupointArticle_editPost_saveAndNew(&$catlang, &$catid) {
        global $handler;
        
        $menu_id = $this->menupointArticle_editPost_update($catlang, $catid);
        
        if ( $menu_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=menu&funct=create&catid=".$catid."&catlang=".$catlang);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB]",false,"save");
        }
    }
    
    protected function functionMenuListCreate($mldef, $id, $level) {
        $menuListData = Array();

        foreach($mldef[$id] as $v) {

            $menuListData[$v['id']] = $v;
            $menuListData[$v['id']]['level'] = $level;

            if ( isset($mldef[$v['id']]) ) {
                $levelNext = $level+1;
                $menuListDataParent = $this->functionMenuListCreate($mldef, $v['id'], $levelNext);
                $menuListData = array_merge($menuListData, $menuListDataParent);
            }

        }

        return $menuListData;
    }
    
    protected function menupointArticle_themeLoad($data, $id = 0) {
        global $theme;
         
        $html = $theme->loadAdminTemplate('admin_menupoint_article','menupoint_article',TRUE,'menu');
        
        $replace = array();
        
        foreach ( $data as $k => $v ) {
            $replace[strtoupper($k)] = $v;
        }
        
        $replace['TITLE'] = ( isset($data['name']) ) ? '[ADMIN_TEXT_MENUPOINT_ARTICLE_EDIT_TITLE]' : '[ADMIN_TEXT_MENUPOINT_ARTICLE_CREATE_TITLE]';
        $replace['NAME'] = ( isset($data['name']) ) ? $data['name'] : '';
        $replace['SEO_NAME'] = ( isset($data['seo_name']) ) ? $data['seo_name'] : '';
        $replace['TEXT'] = ( isset($data['text']) ) ? $data['text'] : '';
        $replace['ORDER'] = ( isset($data['order']) ) ? $data['order'] : '';
        $replace['ID'] = $id;
        
        $replace['IFSTATE0'] = ( !isset($data['state']) ) ? '' : ( $data['state'] == 0 ) ? ' CHECKED' : '';
        $replace['IFSTATE1'] = ( !isset($data['state']) ) ? ' CHECKED' : ( $data['state'] == 1 ) ? ' CHECKED' : '';
        
        $replace['IFISBLANK'] = ( !isset($data['blank']) ) ? '' : ( $data['blank'] == 1 ) ? ' CHECKED' : '';
        
        foreach ( $replace as $key => $value ) {
            $html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
        }
        
        return $html;
    }
    
    
    
    protected function menupointArticle_menuArticleSelectCreate( $catlang, $id = 0 ) {
        global $database, $lang;
        
        $database->newQuery();
        $database->select("`article_id`,`name`,`lang`");
        $database->from("`#__article` `a`");
        $database->where("`a`.`state` = '1' ");
        $database->order("`a`.`name` ASC, `a`.`id` ASC");
        $articleListData = $database->execute();
        
        $langTypes = $lang->getAllowedLanguageTypes();
        
        $html = "";
        
        foreach ( $langTypes as $l ) {
            $disable = '';
            $hidden = '';
            if ( $catlang !== $l ) { $disable = ' DISABLED '; $hidden = ' hidden'; }
            $html .= "<select class='form-control articleSelect articleSelect_$l $hidden' name='article_id[".$l."]' size='10' $disable>";
            foreach ( $articleListData as $val ) { if ( $val['lang'] !== $l ) { continue; }
                $select = ( $id == $val['article_id'] ) ? ' SELECTED ' : '';
                $html .= "<option value='".$val['article_id']."' $select data-name='".$val['name']."'>".$val['name']." (#".$val['article_id'].")</option>";
            }
            $html .= "</select>";
        }
        
        return $html;
    }

    protected function functionMenuArticleCategorySelect( $id = 0 ) {
        global $database;

        $database->newQuery();
        $database->select("`id`,`name`");
        $database->from("`#__article_category` `ac`");
        $database->where("`ac`.`state` = '1'");
        $database->order("`ac`.`id` ASC");
        $articleCategoryListData = $database->execute();
        
        $html = "";
        
        $html .= "<select class='form-control articleCategorySelect' name='article_category_id' size='10'>";
        foreach ( $articleCategoryListData as $val ) {
            $select = ( $id == $val['id'] ) ? ' SELECTED ' : '';
            $html .= "<option value='".$val['id']."' $select >".$val['name']." (#".$val['id'].")</option>";
        }
        $html .= "</select>";

        return $html;
    }
    
}

return; ?>