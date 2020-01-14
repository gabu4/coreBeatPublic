<?php
namespace module\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v024
 * @date 20/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    protected function callArticle_makeHtml($articleData, $template, $class = "", $fullPage = false) {
        global $theme;
        
        $html = array();
        $html['body'] = $theme->loadTemplateTwig('article_'.$template,FALSE,'article');
        
        $contentCss = 'article_'.$articleData['lang'].'_'.$articleData['article_id'].'.css';
        $contentJs = 'article_'.$articleData['lang'].'_'.$articleData['article_id'].'.js';
        $theme->addContentCss($contentCss);
        $theme->addContentJs($contentJs);
        
        if ( !empty($articleData['css']) ) {
            $cssArray = explode(',',$articleData['css']);
            foreach ( $cssArray as $css ) {
                $theme->addContentCss($css);
            }
        }
        
        if ( !empty($articleData['js']) ) {
            $jsArray = explode(',',$articleData['js']);
            foreach ( $jsArray as $js ) {
                $theme->addContentJs($js);
            }
        }
        
        $media = json_decode($articleData['media'],true);
        
        $imgDir = $this->articleContentImagePathHTML;
        $imgDir2 = $this->articleContentImagePath;
        $imgDir_normal = $imgDir.$this->articleContentImagePath_normal;
        $imgDir2_normal = $imgDir2.$this->articleContentImagePath_normal;
        $imgDir_thumbnail = $imgDir.$this->articleContentImagePath_small;
        $imgDir2_thumbnail = $imgDir2.$this->articleContentImagePath_small;
        
        $theme->pageContentTitle = $articleData['name'];
        
        if ( $fullPage === true && !empty($media['headerimage']) && is_file($imgDir2_normal.$media['headerimage']) ) {
            $theme->contentLogoReplace = $imgDir_normal.$media['headerimage'];
        }
        
        $replace = array();
        
        //$contentLink = "index.php?mod=article&funct=article&id=".$articleData['article_id']; //TODO: SEO nevet kéne generálni!
        $contentLink = "index.php?a=".$articleData['article_id']; //TODO: SEO nevet kéne generálni!
        
        $theme->contentTitle = $replace['contenttitle'] = $articleData['name'];
        $replace['content'] = html_entity_decode($articleData['text']);
        $replace['shortcontent'] = mb_substr(strip_tags(html_entity_decode($articleData['text'])),0,500,"UTF-8")."...";
        global $article_blogpage_categoryid, $article_blogpage_contentid;
        $article_blogpage_contentid = $replace['CONTENTID'] = $articleData['article_id'];
        
        $categories = "";
        $categoriesRaw = $this->getArticleCategories($articleData['article_id'],$articleData['lang']);
        if ( !empty($categoriesRaw) ) {
            foreach ( $categoriesRaw as $cValue ) {
                $categories .= 'article_content_category_id_'.$cValue['cat_id'].' ';
            }
        }
        
        $imgFileName = $media['thumbnail'];
        $replace['thumbnail_image'] = ( is_file($imgDir2_thumbnail.$imgFileName) ) ? "<div class='thumbnail'><img class='contentThumbImage' src='".$imgDir_thumbnail.$imgFileName."' /></div>" : "";
        $replace['thumbnail_image_link'] = ( is_file($imgDir2_thumbnail.$imgFileName) ) ? $imgDir_thumbnail.$imgFileName : "";
        $replace['image'] = ( is_file($imgDir2_normal.$imgFileName) ) ? "<div class='image'><img class='contentImage' src='".$imgDir_normal.$imgFileName."' /></div>" : "";
        $replace['image_link'] = ( is_file($imgDir2_normal.$imgFileName) ) ? $imgDir_normal.$imgFileName : "";
        $replace['create_date'] = $articleData['date_create'];  //keszitesi ido
        $replace['modify_date'] = $articleData['date_mod'];  //modositasi ido
        $replace['class'] = $class;
        $replace['id'] = $articleData['article_id'];
        $replace['contentid'] = $articleData['article_id'];
        $replace['contenttitle'] = $html['title'] = $articleData['name'];
        $replace['contenttitle_link'] = "<a class='contentTitle link' href='$contentLink'>".$articleData['name']."</a>";
        $replace['content_link'] = $contentLink;
        $replace['categories'] = $categories;
        $replace['youtubevideo_code'] = ( isset($media['youtubevideo']) && !empty($media['youtubevideo']) ) ? $media['youtubevideo'] : "";
        
        $d = $this->getArticleCategories_getBigest($articleData['article_id'],$articleData['lang']);
        $replace['category'] = ( isset($d['name']) ) ? $d['name'] : "";
        $article_blogpage_categoryid = $replace['category_id'] = ( isset($d['cat_id']) ) ? $d['cat_id'] : "";
        
        $replace['get_random_from_category'] = "{#MODULE,ARTICLE,LIST_RANDOM,$article_blogpage_categoryid|3|random|$article_blogpage_contentid}";
        
        
//      $theme->tempMETAAUTH = $articleData['meta_author'];
        if ( !empty($articleData['meta_keywords']) ) {
                $theme->tempMETAKEY[] = $articleData['meta_keywords'];
        }

        if ( !empty($articleData['meta_description']) ) {
                $theme->tempMETADESC[] = $articleData['meta_description'];
        }
        
//        $theme->mustache($replace,$html['body']);
        $theme->replaceTwig($replace,$html['body']);
        
        return $html;
    }
    
    protected function callArticleCategory_makeHtml($categoryData, $articles, $template_extra, $class = "") {
        global $theme;
        
        $template = 'category_body_'.$template_extra;
        $html = $theme->loadTemplateTwig('article_',$template,FALSE,'article');
        
        $theme->pageContentTitle = $categoryData['name'];
        
        $replace = array();
        
        $theme->contentTitle = $replace['categorytitle'] = $categoryData['name'];
        $replace['articles'] = $articles;
        $replace['text'] = $categoryData['text'];
        $imgDir = CB_URI.CB_FILE."/article/catimg/";
        $imgDir_normal = $imgDir."/normal/";
        $imgDir_thumbnail = $imgDir."/small/";
        $replace['thumbnail_image'] = ( !empty($categoryData['image']) ) ? "<img class='categoryThumbImage' src='".$imgDir_thumbnail.$categoryData['image']."' />" : "";
        $replace['image'] = ( !empty($categoryData['image']) ) ? "<img class='categoryImage' src='".$imgDir_normal.$categoryData['image']."' />" : "";
        $replace['categoryid'] = $categoryData['cat_id'];
        $replace['class'] = $class;
        
        $theme->replace($replace,$html);
        
        return $html;
    }
}

return; ?>
