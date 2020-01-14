<?php
namespace module\product;
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
    
    public function __call_product($value) {
        global $content, $get, $is_ajax, $lang;
        
        if ( isset($get['admin']) ) {
            return "&#123;#MODULE,PRODUCT,PRODUCT,".$rawValue."&#125;";
        }
        
        if ( !empty($value) && is_numeric($value) ) {
            $contentData['id'] = $value;
        } else if ( !empty($value) ) {
            $contentData = (array) json_decode($value,true);
        } else if ( !empty($content->contentData['value']) ) {
            $contentData = (array) json_decode($content->contentData['value'],true);
        } else if (
            isset($get['mod']) &&
            $get['mod'] == 'product' &&
            isset($get['funct']) &&
            $get['funct'] == 'product' &&
            isset($get['id']) &&
            is_numeric($get['id']) 
            ) {
            $contentData['id'] = $get['id'];
        } else {
            return $content->loadErrorPage404();
        }
        
        $language = ( isset($contentData['language']) ) ? $contentData['language'] : $lang->getLanguage();
        $productData = $this->callMain_databaseGet($contentData,$language);
        $template_extra = ( isset($productData['template']) && !empty($productData['template']) ) ? '_'.$productData['template'] : '';
        $template_extra = ( isset($contentData['template']) && !empty($contentData['template']) ) ? '_'.$contentData['template'] : $template_extra;
        
        if ( empty($productData) ) { return $content->loadErrorPage404(); }
        
        $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $contentData['class'] : '';
        $html = $this->callProduct_createPage($productData, $template_extra, $class, true);
        
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
        global $content, $get, $lang;
        
        if ( !empty($value) && is_numeric($value) ) {
            $categoryData['id'] = $value;
        } else if ( !empty($value) ) {
            $categoryData = (array) json_decode($value,true);
        } else if ( !empty($content->contentData['value']) ) {
            $categoryData = (array) json_decode($content->contentData['value'],true);
        } else if (
            isset($get['mod']) &&
            $get['mod'] == 'product' &&
            isset($get['funct']) &&
            $get['funct'] == 'list' &&
            isset($get['id']) &&
            is_numeric($get['id']) 
            ) {
            $categoryData['id'] = $get['id'];
        } else {
            return $content->loadErrorPage404();
        }
        
        if ( isset($categoryData['id']) && !isset($categoryData['cat_id']) ) { $categoryData['cat_id'] = $categoryData['id']; }
        
        $language = ( isset($categoryData['language']) ) ? $categoryData['language'] : $lang->getLanguage();
        $limit = ( isset($categoryData['limit']) ) ? $categoryData['limit'] : NULL;
        $listData = $this->callProductCategory_dbCategoryData($categoryData['cat_id'], $language);
        $template_extra = ( isset($listData['template']) && !empty($listData['template']) ) ? '_'.$listData['template'] : '';
        $template_extra = ( isset($categoryData['template']) && !empty($categoryData['template']) ) ? '_'.$categoryData['template'] : $template_extra;
        
        $product = "";
        if ( empty($listData) ) {
            return $content->loadErrorPage404();
        } else {
            $categoryProductData = $this->callProductCategory_dbCategoryProductData($listData['cat_id'], $language, $limit);
            if ( empty($categoryProductData) ) {
                $product .= "<div class='productCategoryPageDIV emptyCategory'>[TEXT_ARTICLE_CATEGORY_EMPTY]</div>";
            } else {
                foreach ( $categoryProductData as $contentData ) {
                    $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $contentData['class'] : '';
                    $a = $this->callProduct_createPage($contentData, '_category'.$template_extra, $class);
                    $product .= $a['body'];
                }
            }
        }
        
        $class = ( isset($categoryData['class']) && !empty($categoryData['class']) ) ? $categoryData['class'] : '';
        $html = $this->callProductCategory_createCategoryPage($listData, $product, $template_extra, $class);
        
        return $html;
    }
    
    public function __call_list_random($value) {
        global $content, $lang, $get;
        
        $c = explode('|',$value);
        $category = $c[0];
        $limit = ( isset($c[1]) ) ? $c[1] : 3;
        $template2 = ( isset($c[2]) ) ? $c[2] : "";
        $notShowId = ( isset($c[3]) ) ? $c[3] : 0;
        $language = $lang->getLanguage();
        
        $rec = 0;
        if ( isset($get['rec']) || !empty($get['rec']) ) {
            $rec = explode('|', $get['rec']);
        }
        
        $listData = $this->callProductCategory_dbCategoryData($category, $language);
        
        $template = '_category';
        $template .= ( isset($listData['template']) && !empty($listData['template']) ) ? '_'.$listData['template'] : "";
        $template .= ( !empty($template2) ) ? '_'.$template2 : "";
        
        
        $product = "";
        if ( empty($listData) ) {
            return $content->loadErrorPage404();
        } else {
            if ( $rec == 0 ) {
                $categoryProductData = $this->callProductCategory_dbCategoryProductData_random($listData['cat_id'], $language, $limit, $notShowId);
            } else {
                $categoryProductData = $this->callProductCategory_dbCategoryProductData_random_rec($listData['cat_id'], $language, $limit, $notShowId, $rec);
            }
            if ( empty($categoryProductData) ) {
                $product .= "<div class='productCategoryPageDIV emptyCategory'>[TEXT_ARTICLE_CATEGORY_EMPTY]</div>";
            } else {
                foreach ( $categoryProductData as $contentData ) {
                    $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $contentData['class'] : '';
                    $a = $this->callProduct_createPage($contentData, $template, $class);
                    $product .= $a['body'];
                }
            }
        }
        
        $class = '';
        $html = $this->callProductCategory_createCategoryPage($listData, $product, $template, $class);
        
        return $html;
    }
}

return; ?>
