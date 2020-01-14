<?php
namespace module\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v013
 * @date 21/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function __call_main() {
        
    }
    
    public function __call_catalog($value) {
        global $out_html, $get, $is_ajax, $lang;
        
        if ( isset($get['admin']) ) { return "&#123;#MODULE,CATALOG,CATALOG,".$rawValue."&#125;"; }
        
        $id = 0;$template = "";$language = $lang->getLanguage();$class = "";
        if ( !is_array($value) ) { $id = $value; } else { foreach ($value as $k=>$v) { if (!empty($v)) { $$k = $v; } } }
        
        if (
            isset($get['mod']) && $get['mod'] == 'catalog' &&
            isset($get['funct']) && $get['funct'] == 'catalog' &&
            isset($get['id']) && is_numeric($get['id'])) 
            {
            $id = $get['id'];
            unset($get['mod']);unset($get['funct']);
        }
        
        if ( empty($id) ) { return $out_html->loadErrorPage404(); }
        $catalogData = $this->callMain_databaseGet($id,$language);
        $template_extra = '';
        $template_extra .= ( isset($catalogData['template']) && !empty($catalogData['template']) ) ? '_'.$catalogData['template'] : '';
        $template_extra .= ( !empty($template) ) ? '_'.$template : '';
        
        if ( empty($catalogData) ) { return $out_html->loadErrorPage404(); }
        
        $html = $this->callCatalog_createElement($catalogData, $template_extra, $class, true);
        
        if ( $is_ajax && isset($get['modal']) && $get['modal'] === '1' ) {
            global $theme;
            $json = array();
            $json['body'] = $html['body'];
            $json['title'] = $html['title'];
            
            $theme->themeModuleReplace($json['body']);
            
            print json_encode($json);exit;
        }
        
        return $html['body'];
    }

    public function __call_list($value) {
        global $out_html, $get, $lang;
        
        $id = 0;$limit = NULL;$template = "";$language = $lang->getLanguage();$random = FALSE;$class = "";
        if ( !is_array($value) ) { $id = $value; } else { foreach ($value as $k=>$v) { if (!empty($v)) { $$k = $v; } } }
        
        if ( isset($get['mod']) && $get['mod'] == 'catalog' &&
            isset($get['funct']) && $get['funct'] == 'list' &&
            isset($get['id']) && is_numeric($get['id']))
            {
            $id = $get['id'];
            unset($get['mod']);unset($get['funct']);
        }
        
        $listData = $this->callCatalogCategory_dbCategoryData($id, $language);
        $template_extra = "";
        $template_extra .= ( isset($listData['template']) && !empty($listData['template']) ) ? '_'.$listData['template'] : '';
        $template_extra .= ( !empty($template) ) ? '_'.$template : "";
        
        $catalog = "";
        if ( empty($listData) ) {
            return $out_html->loadErrorPage404();
        } else {
            $categoryCatalogData = $this->callCatalogCategory_dbCategoryCatalogData($id, $language, $limit, $random);
            if ( empty($categoryCatalogData) ) {
                $catalog .= "<div class='catalogCategoryPageDIV emptyCategory'>[TEXT_ARTICLE_CATEGORY_EMPTY]</div>";
            } else {
                foreach ( $categoryCatalogData as $out_htmlData ) {
                    $class2 = ( isset($out_htmlData['class']) && !empty($out_htmlData['class']) ) ? $out_htmlData['class'] : '';
                    $a = $this->callCatalog_createElement($out_htmlData, $template_extra, $class2);
                    $catalog .= $a['body'];
                }
            }
        }
        
        $html = $this->callCatalog_createElementFrame($id, $listData, $catalog, $template_extra, $class);
        
        return $html;
    }
    
    public function __call_list_random($value) {
        
        $value['limit'] = ( !isset($value['limit']) ) ? 4 : $value['limit'];
        $value['random'] = TRUE;
        
        return $this->__call_list($value);
        
        /*
        global $out_html, $lang, $get;
        
        $fullPage = FALSE;$limit = 3;$template = "";$own_id = 0;$language = $lang->getLanguage();
        if ( !is_array($value) ) { $id = $value; } else { foreach ($value as $k=>$v) { if (!empty($v)) { $$k = $v; } } }
        $rec = 0;if ( isset($get['rec']) || !empty($get['rec']) ) {$rec = explode('|', $get['rec']);}
        
        $listData = $this->callCatalogCategory_dbCategoryData($id, $language);
        
        $template_extra = '_list';
        $template_extra = ( isset($listData['template']) && !empty($listData['template']) ) ? '_'.$listData['template'] : "";
        $template_extra .= ( !empty($template) ) ? '_'.$template : "";
        
        $catalog = "";
        if ( empty($listData) ) {
            return $out_html->loadErrorPage404();
        } else {
            $categoryCatalogData = $this->callCatalogCategory_dbCategoryCatalogData($listData['category_id'], $language, $limit, TRUE, $own_id, $rec);
            
            if ( empty($categoryCatalogData) ) {
                $catalog .= "<div class='catalogCategoryPageDIV emptyCategory'>[TEXT_ARTICLE_CATEGORY_EMPTY]</div>";
            } else {
                foreach ( $categoryCatalogData as $out_htmlData ) {
                    $class = ( isset($out_htmlData['class']) && !empty($out_htmlData['class']) ) ? $out_htmlData['class'] : '';
                    $a = $this->callCatalog_createPage($out_htmlData, $template_extra, $class);
                    $catalog .= $a['body'];
                }
            }
        }
        
        $class = '';
        $html = $this->callCatalogCategory_createCategoryPage($listData, $catalog, $template_extra, $class);
        
        return $html; */
    }
}

return; ?>
