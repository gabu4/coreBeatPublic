<?php
namespace module\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 20/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    public function media_decode($m) {
        $m2 = json_decode($m,true);
        if (!empty($m2)) { foreach ( $m2 as $k=>$v ) { if (!empty($v)) {$m2[$k] = json_decode($v,true);} } }
        return $m2;
    }
    
    protected function callCatalog_createElementFrame($id, $categoryData, $catalogs, $template_extra, $class = "", $fullPage = false) {
        global $theme;
        
        $template = 'catalog_page'.$template_extra;
        
        $html = $theme->loadTemplate('catalog',$template,TRUE,'catalog');
        
        $theme->pageContentTitle = $categoryData['name'];
        
        $replace = array();
        
        $theme->contentTitle = $replace['CATEGORYTITLE'] = ($id !== 0 ) ? $categoryData['name'] : '[LANG_CATALOG_DEFAULT_HEADER_TITLE]';
        $replace['CATALOGS'] = $catalogs;
        $replace['TEXT'] = $categoryData['text'];
        $imgDir = CB_URI.CB_FILE."/catalog/category_image/";
        $imgDir_normal = $imgDir."/normal/";
        $imgDir_thumbnail = $imgDir."/small/";
        $replace['THUMBNAIL_IMAGE'] = ( !empty($categoryData['image']) ) ? "<img class='categoryThumbImage' src='".$imgDir_thumbnail.$categoryData['image']."' />" : "";
        $replace['IMAGE'] = ( !empty($categoryData['image']) ) ? "<img class='categoryImage' src='".$imgDir_normal.$categoryData['image']."' />" : "";
        $replace['ORIGINAL_IMAGE'] = ( !empty($categoryData['image']) ) ? "<img class='categoryImage' src='".$imgDir.'/'.$categoryData['image']."' />" : "";
        $replace['CATEGORYID'] = $categoryData['category_id'];
        $replace['CLASS'] = $class;
        
        $theme->replace($replace,$html);
        
        return $html;
    }
    
    protected function callCatalog_createElement($contentData, $template_extra, $class = "", $fullPage = false) {
        global $theme, $out_html, $media;
        
        if ( $fullPage === true ) {$template = 'catalog_fullpage'.$template_extra;} else {$template = 'catalog_element'.$template_extra;}
        $html = array();
        $html['body'] = $theme->loadTemplate('catalog',$template,TRUE,'catalog');
        
        $contentCss = 'catalog_'.$contentData['lang'].'_'.$contentData['catalog_id'].'.css';
        $contentJs = 'catalog_'.$contentData['lang'].'_'.$contentData['catalog_id'].'.js';
        $theme->addContentCss($contentCss);
        $theme->addContentJs($contentJs);
        
        $media2 = $this->media_decode($contentData['media']);
        
        $mediaThumbnail = $media->media_get($media2['thumbnail']);
        $mediaHeaderimage = $media->media_get($media2['headerimage']);
        $mediaCatalogimage = $media->media_get($media2['catalogimage']);
        
        $imgDir_html = $media->get_media_path_html();
        $imgDir_root = $media->get_media_path_root();
        $imgDir_html_thumbnail = $media->get_media_thumbnail_path_html();
        $imgDir_root_thumbnail = $media->get_media_thumbnail_path_root();
        
        $theme->pageContentTitle = $contentData['name'];
        
        if ( $fullPage === true && cb_is_not_empty($mediaHeaderimage[0]) && is_file($imgDir_root.$mediaHeaderimage[0]['file_name']) ) {
            $theme->contentLogoReplace = $imgDir_html.$mediaHeaderimage[0]['file_name'];
        }
        
        $replace = [
            'THUMBNAIL_SMALL_GROUP'=>'','THUMBNAIL_SMALL_IMAGE_LINK_0'=>CB_URI.CB_MODULE.'/catalog/img/nincskep.png','THUMBNAIL_SMALL_IMAGE_0'=>'',
            'THUMBNAIL_NORMAL_GROUP'=>'','THUMBNAIL_NORMAL_IMAGE_LINK_0'=>CB_URI.CB_MODULE.'/catalog/img/nincskep.png','THUMBNAIL_NORMAL_IMAGE_0'=>'',
            'IMAGE_GROUP'=>'','IMAGE_GALLERY_SMALL'=>'','IMAGE_GALLERY_NORMAL'=>'','IMAGE_LINK_0'=>CB_URI.CB_MODULE.'/catalog/img/nincskep.png','IMAGE_0'=>'',
            ];
        
        $contentLink_1 = "index.php?mod=catalog&funct=catalog&id=".$contentData['catalog_id'];
        //if ( CB_IS_SEO === 'true' ) { $contentLink_2 = $out_html->getSeoNameFromContentID($contentData['content_id']); }  //seo nevek kilőve, javítás kell
        $contentLink = ( isset($contentLink_2) && !empty($contentLink_2) ) ? $contentLink_2 : $contentLink_1;
        
        $theme->contentTitle = $replace['CONTENTTITLE'] = $contentData['name'];
        $replace['CONTENT'] = html_entity_decode($contentData['text']);
        $replace['SHORTCONTENT'] = html_entity_decode($contentData['shorttext']);
        $replace['CONTENTID'] = $contentData['catalog_id'];
        $replace['SKU'] = $contentData['sku'];
        $replace['YOUTUBEVIDEO_CODE'] = ( isset($media2['youtubevideo']) && !empty($media2['youtubevideo']) ) ? $media2['youtubevideo'] : "";
        
        $categories = "";
        $category_logos_raw = [];
        $category_logos = "";
        
        $categoriesRaw = $this->getCatalogCategories($contentData['catalog_id'],$contentData['lang']);
        if ( !empty($categoriesRaw) ) {
            foreach ( $categoriesRaw as $cValue ) {
                $categories .= 'catalog_content_category_id_'.$cValue['id'].' ';
                if ( is_file(CB_ROOTDIR.'/'.CB_FILE."/catalog/logo/logo_".$cValue['id'].".png") ) {
                    $category_logos_raw[$cValue['id']] = CB_URI.CB_FILE."/catalog/logo/logo_".$cValue['id'].".png";
                }
            }
        }
        
        if ( !empty($category_logos_raw) ) { $category_logos .= "<div class='category logos'>";foreach($category_logos_raw as $kcl=>$cl) { $category_logos .= "<img class='logo logo_$kcl' src='$cl' alt='' />";}$category_logos .= "</div>";}
        
        $replace['CATEGORY_LOGO'] = $category_logos;
        
        if ( !empty($mediaThumbnail) ) {
            $replace['THUMBNAIL_SMALL_GROUP'] = "<div class='thumbnail group small'>";
            $replace['THUMBNAIL_NORMAL_GROUP'] = "<div class='thumbnail group normal'>";
            foreach ($mediaThumbnail as $k=>$img) {
                $replace['THUMBNAIL_SMALL_IMAGE_LINK_'.$k] = $img['thumbnail_small']['html'];
                $replace['THUMBNAIL_SMALL_IMAGE_'.$k] = "<div class='thumbnail small'><img class='contentThumbImage' src='".$img['thumbnail_small']['html']."' /></div>";
                $replace['THUMBNAIL_SMALL_GROUP'] .= "<img class='contentThumbImage' src='".$img['thumbnail_small']['html']."' />";
                $replace['THUMBNAIL_NORMAL_IMAGE_LINK_'.$k] = $img['thumbnail_normal']['html'];
                $replace['THUMBNAIL_NORMAL_IMAGE_'.$k] = "<div class='thumbnail normal'><img class='contentThumbImage' src='".$img['thumbnail_normal']['html']."' /></div>";
                $replace['THUMBNAIL_NORMAL_GROUP'] .= "<img class='contentThumbImage' src='".$img['thumbnail_normal']['html']."' />";
            }
            $replace['THUMBNAIL_SMALL_GROUP'] .= "</div>";
            $replace['THUMBNAIL_NORMAL_GROUP'] .= "</div>";
        }
        
        if ( !empty($mediaCatalogimage) ) {
            $replace['IMAGE_GROUP'] = "<div class='image group'>";
            $replace['IMAGE_GALLERY_SMALL'] = "<div class='image gallery small'>";
            $replace['IMAGE_GALLERY_NORMAL'] = "<div class='image gallery normal'>";
            foreach ($mediaCatalogimage as $k=>$img) {
                $replace['IMAGE_LINK_'.$k] = $img['image']['html'];
                $replace['IMAGE_'.$k] = "<div class='image one'><img class='contentCatalogImage image_id_$k' src='".$img['image']['html']."' /></div>";
                $replace['IMAGE_GROUP'] .= "<img class='contentCatalogImage' src='".$img['image']['html']."' />";
                $replace['IMAGE_GALLERY_SMALL'] .= "<a href='".$img['image']['html']."'><img class='contentCatalogImage image_id_$k' src='".$img['thumbnail_small']['html']."' /></a>";
                $replace['IMAGE_GALLERY_NORMAL'] .= "<a href='".$img['image']['html']."'><img class='contentCatalogImage image_id_$k' src='".$img['thumbnail_normal']['html']."' /></a>";
            }
            $replace['IMAGE_GROUP'] .= "</div>";
            $replace['IMAGE_GALLERY_SMALL'] .= "</div>";
            $replace['IMAGE_GALLERY_NORMAL'] .= "</div>";
        }
        
        $replace['CDATE'] = $contentData['cre_date'];  //keszitesi ido
        $replace['MDATE'] = $contentData['mod_date'];  //modositasi ido
        $replace['CLASS'] = $class;
        $replace['CONTENTTITLE'] = $html['title'] = $contentData['name'];
        $replace['CONTENTTITLE_LINK'] = "<a class='contentTitle link' href='$contentLink'>".$contentData['name']."</a>";
        $replace['CONTENT_LINK'] = $contentLink;
        $replace['CATEGORIES'] = $categories;
        
        if ( !empty($contentData['meta_keywords']) ) { $theme->tempMETAKEY[] = $contentData['meta_keywords']; }
        if ( !empty($contentData['meta_description']) ) { $theme->tempMETADESC[] = $contentData['meta_description']; }
        
        $theme->replace($replace,$html['body']);
        
        return $html;
    }
}

return; ?>
