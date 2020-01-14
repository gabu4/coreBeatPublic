<?php
namespace module\article;
/**
 * CoreBeat SyStem Manager
 * @author GáborÉrdi [erdi.gabor@webed.hu]
 * @version v026
 * @date 23/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function __call_main($value) {
            return $this->__call_article($value);
    }
    
    /**
     * Content get by ID, not showing in admin site!
     * @param string $rawValue value<br>ID, or JSON<br>in JSON: {"id":"1","language":"hu","class":"custom","template":"main","limit":"3"}
     * @return string article HTML code
     */
    public function __call_article_id($rawValue) {
            return $this->__call_article($rawValue);
    }
    
    public function __call_article($value) {
        global $out_html, $get, $is_ajax, $lang;
        
        if ( !empty($value) && is_numeric($value) ) {
            $contentData['id'] = $value;
        } else if ( !empty($value) && is_array($value) ) {
            foreach ($value as $k=>$v) { if (!empty($v)) { $contentData[$k] = $v; } }
        } else if ( !empty($value) && cb_is_json($value) ) {
            $contentData = (array) json_decode($value,true);
        } else if ( !empty($out_html->contentData['value']) ) {
            $contentData = (array) json_decode($out_html->contentData['value'],true);
        } else if (
            isset($get['mod']) &&
            $get['mod'] == 'article' &&
            isset($get['funct']) &&
            ( $get['funct'] == 'article' ||
            $get['funct'] == 'article_id' ||
            $get['funct'] == 'main' ) &&
            isset($get['id']) &&
            is_numeric($get['id']) 
            ) {
            $contentData['id'] = $get['id'];
            unset($get['mod']);unset($get['funct']);
        }
        
        if ( !isset($contentData['id']) ) { return $out_html->loadErrorPage404(); }
        
        $contentData['language'] = (isset($contentData['language']) ? $contentData['language'] : $lang->getLanguage());
        $aData = $this->callArticle_databaseGet($contentData,$contentData['language']);
        if ( empty($aData) ) { return $out_html->loadErrorPage404(); }
        
        $contentData['class'] = (isset($contentData['class']) ? $contentData['class'] : '');
        $contentData['class'] .= (!empty($aData['class']) ? ' '.$aData['class'] : '');
        $contentData['template'] = (isset($contentData['template']) && !empty($contentData['template']) ? $contentData['template'] : ( !empty($aData['template']) ? $aData['template'] : 'default'));
        $contentData['theme'] = (isset($contentData['theme']) ? $contentData['theme'] : (!empty($aData['theme']) ? $aData['theme'] : ''));
        
        foreach ($aData as $k=>$v){if(!isset($contentData[$k])){$contentData[$k]=$v;}}
        if ( !empty($contentData['theme']) ) {global $theme;$theme->loadPageTheme($contentData['theme'],'main',TRUE);}
        
        $html = $this->callArticle_makeHtml($contentData, $contentData['template'], $contentData['class'], true);
        
        if ( $is_ajax && isset($get['modal']) && $get['modal'] === '1' ) {
            global $theme;
            $json = array();
            $json['body'] = $html['body'];
            $json['title'] = $html['title'];
            
            $theme->themeModuleReplace($json['body']);
            
            $out_html->printOutContent($json);
        }
        
        return $html['body'];
    }

    public function __call_article_category($value) {
        global $out_html, $lang, $get;
        
        if ( !empty($value) && is_numeric($value) ) {
            $categoryData['id'] = $value;
        } else if ( !empty($value) && is_array($value) ) {
            foreach ($value as $k=>$v) { if (!empty($v)) { $categoryData[$k] = $v; } }
        } else if ( !empty($value) && cb_is_json($value) ) {
            $categoryData = (array) json_decode($value,true);
        } else if ( !empty($out_html->contentData['value']) ) {
            $categoryData = (array) json_decode($out_html->contentData['value'],true);
        } else if (
            isset($get['mod']) &&
            $get['mod'] == 'article' &&
            isset($get['funct']) &&
            $get['funct'] == 'article_category' &&
            isset($get['id']) &&
            is_numeric($get['id']) 
            ) {
            $categoryData['id'] = $get['id'];
            unset($get['mod']);unset($get['funct']);
        }
        
        if ( !isset($categoryData['id']) ) { return $out_html->loadErrorPage404(); }
        
        $categoryData['language'] = isset($categoryData['language']) ? $categoryData['language'] : $lang->getLanguage();
        $cData = $this->callArticleCategory_dbCategoryData($categoryData['id'], $categoryData['language']);
        if ( empty($cData) ) { return $out_html->loadErrorPage404(); }
        
        $categoryData['name'] = (isset($categoryData['name']) ? $categoryData['name'] : $cData['name']);
        $categoryData['class'] = (isset($categoryData['class']) ? $categoryData['class'] : '');
        $categoryData['template'] = (isset($categoryData['template']) ? $categoryData['template'] : 'default');
        $categoryData['limit'] = (isset($categoryData['limit']) ? $categoryData['limit'] : 20);
        $categoryData['order'] = (isset($categoryData['order']) ? $categoryData['order'] : 'desc');
        $categoryData['text'] = (isset($categoryData['text']) ? $categoryData['text'] : $cData['text']);
        $categoryData['page'] = (isset($categoryData['page']) ? $categoryData['page'] : (isset($get['page']) && is_numeric($get['page']) ? $get['page'] : 1));
        $categoryData['theme'] = (isset($categoryData['theme']) ? $categoryData['theme'] : (!empty($cData['theme']) ? $cData['theme'] : 'default'));
        
        if ( !empty($categoryData['theme']) ) {global $theme;$theme->loadPageTheme($categoryData['theme'],'main',TRUE);}
        
        $articles = "";
        
        $categoryArticleData = $this->callArticleCategory_dbCategoryArticleData($categoryData['cat_id'], $categoryData['language'], (int)$categoryData['limit'], $categoryData['order'],(int)$categoryData['page']);
        if ( empty($categoryArticleData) ) {
            $articles .= "<div class='articleCategoryPageDIV emptyCategory'>[TEXT_ARTICLE_CATEGORY_EMPTY]</div>";
        } else {
            foreach ( $categoryArticleData as $contentData ) {
                $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $categoryData['class'].' '.$contentData['class'] : $categoryData['class'];
                $a = $this->callArticle_makeHtml($contentData, $categoryData['template'].'_category_article', $class);
                $articles .= $a['body'];
            }
        }
        
        $html = $this->callArticleCategory_makeHtml($categoryData, $articles, $categoryData['template'].'_category_body', $categoryData['class']);
        
        return $html;
    }
    
}

return; ?>
