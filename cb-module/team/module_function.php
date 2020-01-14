<?php
namespace module\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v016
 * @date 16/06/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    protected function callTeamCategory_createCategoryPage($team) {
        global $theme;
        
        $template = 'team_list_main';
        $html = $theme->loadTemplate('team',$template,TRUE,'team');
        
        // $theme->pageContentTitle = $categoryData['name'];
        
        $replace = array();
        
    //    $theme->contentTitle = $replace['CATEGORYTITLE'] = $categoryData['name'];
        $replace['TEAM'] = $team;
        
        $theme->replace($replace,$html);
        
        return $html;
    }
    
    protected function callTeam_createPage($contentData, $template_extra, $class = "", $fullPage = FALSE) {
        global $theme, $content;
        
        if ( $fullPage === TRUE ) {
            $template = 'team_page'.$template_extra;
        } else {
            $template = 'team_list_element'.$template_extra;
        }
        $html = array();
        $html['body'] = $theme->loadTemplate('team',$template,TRUE,'team');
        
        $contentCss = 'team_member_'.$contentData['lang'].'_'.$contentData['team_id'].'.css';
        $contentJs = 'team_member_'.$contentData['lang'].'_'.$contentData['team_id'].'.js';
        $theme->addContentCss($contentCss);
        $theme->addContentJs($contentJs);
        
        $media = json_decode($contentData['media'],true);
        
        $imgDir = $this->teamContentImagePathHTML;
        $imgDir2 = $this->teamContentImagePath;
        $imgDir_normal = $imgDir.$this->teamContentImagePath_normal;
        $imgDir2_normal = $imgDir2.$this->teamContentImagePath_normal;
        
        $replace = array();
        
        if ( $fullPage ) {
            $theme->pageContentTitle = $html['title'] = $contentData['name'];
            
            $gallery = $this->getFbGalleryFiles($contentData['team_id'],$contentData['munkai']);
            
            $replace['GALLERY'] = $gallery;
        }
        
        
        $theme->contentTitle = $replace['CONTENTTITLE'] = $contentData['name'];
        
        $replace['CONTENT'] = html_entity_decode($contentData['text']);
        
        $replace['TEAM_MATE_ID'] = $contentData['team_id'];
        
        $imgFileName = $media['image'];
        $replace['IMAGE'] = ( is_file($imgDir2_normal.$imgFileName) ) ? "<div class='image'><img class='contentImage' src='".$imgDir_normal.$imgFileName."' /></div>" : "";
        
        $replace['IMAGE_LINK'] = ( is_file($imgDir2_normal.$imgFileName) ) ? $imgDir_normal.$imgFileName : "";
        $replace['HORGONY'] = cb_urlready_name($contentData['name']);
        
        $replace['CLASS'] = $class;
        $id = $contentData['team_id'];
        $munkai_link = CB_HTTPADDRESS."/".$content->getModuleFuctionName('team','works','id='.$id);
        
        $munkai = ( $contentData['munkai'] ) ? '<a class="zold-gomb" href="'.$munkai_link.'">[TEXT_TEAM_MY_WORKS]</a>' : '';
        $replace['MUNKAI'] = $munkai;

        $foglalas = ( $contentData['foglalas'] ) ? '<a target="_blank" class="zold-gomb" href="'.$contentData['foglalas'].'">[TEXT_TEAM_ONLINE_BOOKING]</a>' : '';
        $replace['FOGLALAS'] = $foglalas;
        $replace['TITULUS'] = $contentData['titulus'];
        
        
        $theme->replace($replace,$html['body']);
        
        return $html;
    }
    
    protected function getFbGalleryFiles(int $team_id, int $album_id) {
        global $theme;
        
        if ( empty($album_id) ) { return ""; }
        
        //$url = "https://graph.facebook.com/endpoint?key=value&access_token=".$this->facebookApi['app_id']."|".$this->facebookApi['app_secret']."";
        $url = "https://graph.facebook.com/oauth/access_token?client_id=".$this->facebookApi['app_id']."&client_secret=".$this->facebookApi['app_secret']."&grant_type=client_credentials";
        
        $cc = new \cb_cURL();
        $a = $cc->get($url);
                
        if ( !empty($a) ) {
            $b = json_decode($a,true);
            if ( isset($b['access_token']) ) {
                $this->facebookApi['access_token'] = $b['access_token'];
            }
        }
                
        $url = "https://graph.facebook.com/v3.0/".$album_id."/photos?fields=source,description,images,name&access_token=".$this->facebookApi['access_token']."";
        $d = $cc->get($url);
        
        //$url = "https://graph.facebook.com/v3.0/".$album_id."?fields=description&access_token=".$this->facebookApi['access_token']."";
        //$des = $cc->get($url);
        
        //cbd($des);
        
        if ( empty($d) ) { return ""; }
        
        $d2 = json_decode($d,true);
        
        
        $pageElement = 0;
        
        $thumbDir = ''.CB_TEMP."/team-gallery/";
        
        $galleryContent = "";
        foreach ( $d2['data'] as $k=>$v ) {
            
            $id = $v['id'];
            $name = ( isset($v['name']) ) ? $v['name'] : "";
            $images = array();
            $images[0] = $v['images'][0];
            $w = 0;
            foreach( $v['images'] as $k2=>$v2 ) {
                $images[$v2['width']] = $v2;
                if ( $v2['width'] > 400 && ( $v2['width'] < $w || $w == 0 ) ) {
                    $w = $v2['width'];
                }
            }
            //cbd($images);
            $source = $images[0]['source'];
            $picture = $images[$w]['source'];
            $thumbName = $team_id."-".$album_id."-".crc32($picture).".jpg";
            $sourceName = $team_id."-".$album_id."-".crc32($source).".jpg";
            
            if ( !is_file($thumbDir.$thumbName) ) {
                $tempFile = $thumbDir."-.jpg";
                file_put_contents($tempFile, fopen($picture, 'r'));
                cb_img_resize($tempFile,$thumbDir.$thumbName,CB_GALLERY_THUMBNAIL_WIDTH,CB_GALLERY_THUMBNAIL_HEIGHT);
                unlink($tempFile);
            }
            /*
            if ( !is_file($thumbDir.$sourceName) ) {
                $tempFile = $thumbDir."-.jpg";
                file_put_contents($tempFile, fopen($picture, 'r'));
                cb_img_resize($tempFile,$thumbDir.$sourceName,2000,2000);
                unlink($tempFile);
            }
            */
            $pageElement++;
            
            $g = $theme->loadTemplate('team','gallerycontent',TRUE,'team');
            
            $replace2 = array();
            $replace2['path'] = $source;
            //$replace2['path'] = $thumbDir.$sourceName;
            $replace2['paththumb'] = CB_HTTPADDRESS."/".$thumbDir.$thumbName;
            $replace2['mosaicnumber'] = $pageElement;
            $replace2['mosaicid'] = crc32($picture);
            $replace2['title'] = $name;

            $theme->replace($replace2,$g);
            
            $galleryContent .= $g;
        }
        
        return $galleryContent;
    }
}

return; ?>
