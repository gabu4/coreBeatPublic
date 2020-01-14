<?php
namespace module\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v012
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    protected function callProductCategory_createCategoryPage($categoryData, $products, $template_extra, $class = "") {
        global $theme;
        
        $template = 'category_main'.$template_extra;
        $html = $theme->loadTemplate('product',$template,TRUE,'product');
        
        $theme->pageContentTitle = $categoryData['name'];
        
        $replace = array();
        
        $theme->contentTitle = $replace['CATEGORYTITLE'] = $categoryData['name'];
        $replace['ARTICLES'] = $products;
        $replace['TEXT'] = $categoryData['text'];
        $imgDir = CB_URI.CB_FILE."/product/catimg/";
        $imgDir_normal = $imgDir."/normal/";
        $imgDir_thumbnail = $imgDir."/small/";
        $replace['THUMBNAIL_IMAGE'] = ( !empty($categoryData['image']) ) ? "<img class='categoryThumbImage' src='".$imgDir_thumbnail.$categoryData['image']."' />" : "";
        $replace['IMAGE'] = ( !empty($categoryData['image']) ) ? "<img class='categoryImage' src='".$imgDir_normal.$categoryData['image']."' />" : "";
        $replace['CATEGORYID'] = $categoryData['cat_id'];
        $replace['CLASS'] = $class;
        
        $theme->replace($replace,$html);
        
        return $html;
    }
    
    protected function callProduct_createPage($contentData, $template_extra, $class = "", $fullPage = false) {
        global $theme, $content;
        
        $template = 'product'.$template_extra;
        $html = array();
        $html['body'] = $theme->loadTemplate('product',$template,TRUE,'product');
        
        $contentCss = 'product_'.$contentData['lang'].'_'.$contentData['product_id'].'.css';
        $contentJs = 'product_'.$contentData['lang'].'_'.$contentData['product_id'].'.js';
        $theme->addContentCss($contentCss);
        $theme->addContentJs($contentJs);
        
        $media = json_decode($contentData['media'],true);
        
        $imgDir = $this->productContentImagePathHTML;
        $imgDir2 = $this->productContentImagePath;
        $imgDir_normal = $imgDir.$this->productContentImagePath_normal;
        $imgDir2_normal = $imgDir2.$this->productContentImagePath_normal;
        $imgDir_thumbnail = $imgDir.$this->productContentImagePath_small;
        $imgDir2_thumbnail = $imgDir2.$this->productContentImagePath_small;
        
        $theme->pageContentTitle = $contentData['name'];
        
        if ( $fullPage === true && !empty($media['headerimage']) && is_file($imgDir2_normal.$media['headerimage']) ) {
            $theme->contentLogoReplace = $imgDir_normal.$media['headerimage'];
        }
        
        $replace = array();
                
        //$contentLink = "index.php?mod=product&funct=product&id=".$contentData['product_id']; //TODO: SEO nevet kéne generálni!
        // $contentLink = "index.php?p=".$contentData['product_id']; //TODO: SEO nevet kéne generálni!
        $contentLink = $content->getSeoNameFromContentID($contentData['content_id']); //TODO: SEO nevet kéne generálni!
        
        $theme->contentTitle = $replace['CONTENTTITLE'] = $contentData['name'];
        $replace['CONTENT'] = html_entity_decode($contentData['text']);
        $replace['SHORTCONTENT'] = html_entity_decode($contentData['shorttext']);
        $replace['CONTENTID'] = $contentData['product_id'];
        $replace['YOUTUBEVIDEO_CODE'] = ( isset($media['youtubevideo']) && !empty($media['youtubevideo']) ) ? $media['youtubevideo'] : "";
        
        $categories = "";
        $categoriesRaw = $this->getProductCategories($contentData['product_id'],$contentData['lang']);
        if ( !empty($categoriesRaw) ) {
            foreach ( $categoriesRaw as $cValue ) {
                $categories .= 'product_content_category_id_'.$cValue['id'].' ';
            }
        }
        
        $imgFileName = $media['thumbnail'];
        $replace['THUMBNAIL_IMAGE'] = ( is_file($imgDir2_thumbnail.$imgFileName) ) ? "<div class='thumbnail'><img class='contentThumbImage' src='".$imgDir_thumbnail.$imgFileName."' /></div>" : "";
        $replace['THUMBNAIL_IMAGE_LINK'] = ( is_file($imgDir2_thumbnail.$imgFileName) ) ? $imgDir_thumbnail.$imgFileName : "";
        $replace['IMAGE'] = ( is_file($imgDir2_normal.$imgFileName) ) ? "<div class='image'><img class='contentImage' src='".$imgDir_normal.$imgFileName."' /></div>" : "";
        $replace['IMAGE_LINK'] = ( is_file($imgDir2_normal.$imgFileName) ) ? $imgDir_normal.$imgFileName : "";
        $imgFileName = $media['productimage'];
        $replace['PRODUCT_IMAGE'] = ( is_file($imgDir2_thumbnail.$imgFileName) ) ? "<div class='productimage'><img class='contentProductImage' src='".$imgDir_thumbnail.$imgFileName."' /></div>" : "";
        $replace['PRODUCT_IMAGE_LINK'] = ( is_file($imgDir2_thumbnail.$imgFileName) ) ? $imgDir_thumbnail.$imgFileName : "";
        $replace['CDATE'] = $contentData['cre_date'];  //keszitesi ido
        $replace['MDATE'] = $contentData['mod_date'];  //modositasi ido
        $replace['CLASS'] = $class;
        $replace['CONTENTTITLE'] = $html['title'] = $contentData['name'];
        $replace['CONTENTTITLE_LINK'] = "<a class='contentTitle link' href='$contentLink'>".$contentData['name']."</a>";
        $replace['CONTENT_LINK'] = $contentLink;
        $replace['CATEGORIES'] = $categories;
        
//      $theme->tempMETAAUTH = $contentData['meta_author'];
        if ( !empty($contentData['meta_keywords']) ) {
                $theme->tempMETAKEY[] = $contentData['meta_keywords'];
        }

        if ( !empty($contentData['meta_description']) ) {
                $theme->tempMETADESC[] = $contentData['meta_description'];
        }
        
        $theme->replace($replace,$html['body']);
        
        return $html;
    }
}

return; ?>
