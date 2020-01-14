<?php
namespace module\admin\article\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v013
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callCreate_checkPost(&$data) {
        global $post;
        
        if ( 
            isset($post['adminModuleArticleSave']) OR
            isset($post['adminModuleArticleSaveCopy']) OR
            isset($post['adminModuleArticleSaveAndExit']) OR
            isset($post['adminModuleArticleSaveAndNew'])
            ) {
            return true;
        }
        return false;
    }
    
    protected function callCreate_savePost() {
        global $post;
        
        if ( isset($post['adminModuleArticleSave']) ) {
            $this->callCreate_savePost_save();
        } else if ( isset($post['adminModuleArticleSaveAndExit']) ) {
            $this->callCreate_savePost_saveAndExit();
        } else if ( isset($post['adminModuleArticleSaveAndNew']) ) {
            $this->callCreate_savePost_saveAndNew();
        }
    }
    
    private function callCreate_savePost_save() {
        global $handler;
        
        $article_id = $this->callCreate_savePost_asNew();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=edit&id=".$article_id);
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #006","save");
        }
    }
    
    private function callCreate_savePost_saveAndExit() {
        global $handler;
        
        $article_id = $this->callCreate_savePost_asNew();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=main");
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #007","save");
        }
    }
    
    private function callCreate_savePost_saveAndNew() {
        global $handler;
        
        $article_id = $this->callCreate_savePost_asNew();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=create");
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #001","save");
        }
    }
    
    protected function callCreate_categoryListCreate($article_id = 0) {
        $data = $this->callCreate_categoryListCreate_getData();
        
        
        $html = "";
        
        if ( !empty($data) ) {
            $dataOrdered = $this->dataOrdering($data);
            
            $dataCheck = array();
            if ( $article_id !== 0 ) {
                $dataCheck = $this->callCreate_categoryListCreate_getDataToCheck($article_id);
            }
            $html .= "<select class='selectCatList' name='catList[]' size='10' multiple>";
            
            $selected = ( empty($dataCheck) ) ? ' SELECTED ' : '';
            $html .= "<option value='0' ".$selected.">[LANG_ADMIN_ARTICLE_EDIT_NO_CATEGORY_SELECT_TEXT]</option>";
            foreach ( $dataOrdered as $ldValue ) {
                $name = "";
                for ( $i2 = 0; $i2 < $ldValue['level']; $i2++ ) {
                        $name .= "--";
                }
                $name .= $ldValue['name'];
                $selected = ( in_array($ldValue['cat_id'], $dataCheck) ) ? ' SELECTED ' : '';
                $html .= "<option value='".$ldValue['cat_id']."' ".$selected.">".$name."</option>";
            }
            $html .= "</select>";
        }
        
        return $html;
    }
    
    private function callCreate_categoryListCreate_dataOrdering_repeat($mldef, $id, $level) {
        $data = Array();

        foreach($mldef[$id] as $v) {

            $data[$v['cat_id']] = $v;
            $data[$v['cat_id']]['level'] = $level;

            if ( isset($mldef[$v['cat_id']]) ) {
                $levelNext = $level+1;
                $dataParent = $this->callCreate_categoryListCreate_dataOrdering_repeat($mldef, $v['cat_id'], $levelNext);
                $data = $data + $dataParent;
            }
            
        }

        return $data;
    }

    protected function callCreate_imageTabCreate($media = "" ) {
        global $module, $theme;
        
        $thumbnailImage = '';
        $bigThumbnailImage = '';
        $headerImage = '';
        
        $noImage = CB_ADMIN . "/module/article/img/no-thumbnail.jpg";
        
        if ( !empty($media) ) {
            $media = json_decode($media,true);
            $thumbnailImage = ( !empty($media['thumbnail']) ) ? $this->articleContentImagePathHTML.$this->articleContentImagePath_original.$media['thumbnail'] : '';
            $bigThumbnailImage = ( !empty($media['bigthumbnail']) ) ? $this->articleContentImagePathHTML.$this->articleContentImagePath_original.$media['bigthumbnail'] : '';
            $headerImage = ( !empty($media['headerimage']) ) ? $this->articleContentImagePathHTML.$this->articleContentImagePath_original.$media['headerimage'] : '';
        }
        $html = $theme->loadAdminTemplate2('article_create_tabimage',FALSE,'article');
        
        $replace = [];
        if ( $module->cb_check_access('article','content_thumbnail_upload_access','admin') ) {
            $replace['thumbnail_image'] = ( empty($thumbnailImage) ? $noImage : $thumbnailImage );
            $replace['bigthumbnail_image'] = ( empty($bigThumbnailImage) ? $noImage : $bigThumbnailImage );
        }
        
        if ( $module->cb_check_access('article','content_headerimage_upload_access','admin') ) {
            $replace['header_image'] = ( empty($headerImage) ? $noImage : $headerImage );
        }
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
    
    protected function callCreate_videoTabCreate($media = "" ) {
        global $module;
        
        $defYoutubeVideo = '';
        $defYoutubeVideoLink = '';
        
        if ( !empty($media) ) {
            $media = json_decode($media,true);
            $defYoutubeVideo = ( !empty($media['youtubevideo']) ) ? $media['youtubevideo'] : '';
        }
        $html = "";
        
        $html .= "<div class='form-group d-inline-block'>";
        
        if ( $module->cb_check_access('article','content_youtubevideo_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defYoutubeVideo)) {
                $defYoutubeVideoImg = CB_ADMIN . "/module/article/img/no-thumbnail.jpg";
            } else {
                $defYoutubeVideoImg = "https://img.youtube.com/vi/".$defYoutubeVideo."/mqdefault.jpg";
                $defYoutubeVideoLink = "<br /><a href='https://youtube.com/watch?v=".$defYoutubeVideo."' target='ytVideo'>Link</a>";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[LANG_ADMIN_ARTICLE_EDIT_IMAGE_TAB_YOUTUBE_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview_header'>";
            $html .= "<img class='' id='preview_youtubevideo' style='max-width:100%;' src='$defYoutubeVideoImg' />";
            $html .= $defYoutubeVideoLink;
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "<p id='p-youtubevideo'><input type='text' class='form-control' name='youtubevideo' id='youtubevideo' value='".$defYoutubeVideo."' /></p>";
            $html .= "</div>";
        }
        
        $html .= "<hr class='float-left' style='width:100%' />";
        
        $html .= "</div>";
        
        return $html;
    }
    
    protected function callCreate_themeLoad($data) {
        global $lang, $theme, $admin_function;
        
        $html = $theme->loadAdminTemplate2('article_create',TRUE,'article');
        
        $dl = $lang->getAllowedLanguageTypes()[0];
        
        $article_id = ( isset($data['article_id'][$dl]) ) ? $data['article_id'][$dl] : 0;
        $media = ( isset($data['media'][$dl]) ) ? $data['media'][$dl] : "";
        
        if ( !empty($data['css'][$dl]) ) {
            $cssArray = explode(',',$data['css'][$dl]);
            foreach ( $cssArray as $css ) {
                $theme->addContentCss($css);
            }
        }
        
        $replace['category_list'] = $this->callCreate_categoryListCreate($article_id);
        $replace['image_tab'] = $this->callCreate_imageTabCreate($media);
        
        $replace['ifstate0'] = '';
        $replace['ifstate1'] = ' CHECKED ';
        
        $replace['article_id'] = $article_id;
        
        $replace['langs'] = [];
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $k=>$l ) {
            if ( !empty($article_id) ) {
                $contentCss = 'article_'.$l.'_'.$article_id.'.css';
                $theme->addContentCss($contentCss);
            }
            
            $replace['langs'][$k]['lang'] = $l;
            $replace['langs'][$k]['language_flag'] = ( $showFlag === TRUE ) ? $admin_function->getLanguageFlag($l) : "";
            $replace['langs'][$k]['name'] = ( isset($data['name'][$l]) ) ? $data['name'][$l] : "";
            $replace['langs'][$k]['text'] = ( isset($data['text'][$l]) ) ? $admin_function->textareaModuleSafe($data['text'][$l]) : "";
            $replace['langs'][$k]['meta_keywords'] = ( isset($data['meta_keywords'][$l]) ) ? $data['meta_keywords'][$l] : "";
            $replace['langs'][$k]['meta_description'] = ( isset($data['meta_description'][$l]) ) ? $data['meta_description'][$l] : "";
            $replace['langs'][$k]['active'] = ( $k === 0 ? TRUE : FALSE );
        }
        
        $replace['template'] = ( isset($data['template'][$dl]) ) ? $data['template'][$dl] : "";
        $replace['class'] = ( isset($data['class'][$dl]) ) ? $data['class'][$dl] : "";
        $replace['css'] = ( isset($data['css'][$dl]) ) ? $data['css'][$dl] : "";
        $replace['js'] = ( isset($data['js'][$dl]) ) ? $data['js'][$dl] : "";
        
        foreach ( $data as $k => $v ) {
            $replace[$k] = $v[$dl];
        }
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    protected function callEdit_savePost() {
        global $post;
        
        if ( isset($post['adminModuleArticleSave']) ) {
            $this->callEdit_savePost_save();
        } else if ( isset($post['adminModuleArticleSaveCopy']) ) {
            $this->callEdit_savePost_saveCopy();
        } else if ( isset($post['adminModuleArticleSaveAndExit']) ) {
            $this->callEdit_savePost_saveAndExit();
        } else if ( isset($post['adminModuleArticleSaveAndNew']) ) {
            $this->callEdit_savePost_saveAndNew();
        }
    }
    
    private function callEdit_savePost_save() {
        global $handler;
        
        $article_id = $this->callEdit_savePost_update();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=edit&id=".$article_id);
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #002","save");
        }
        
    }
    
    private function callEdit_savePost_saveCopy() {
        global $handler;
        
        $article_id = $this->callCreate_savePost_asNew();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=edit&id=".$article_id);
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #003","save");
        }
    }
    
    private function callEdit_savePost_saveAndExit() {
        global $handler;
        
        $article_id = $this->callEdit_savePost_update();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=main");
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #004","save");
        }
    }
    
    private function callEdit_savePost_saveAndNew() {
        global $handler;
        
        $article_id = $this->callEdit_savePost_update();
        $this->callCreate_savePost_saveFile($article_id);
        
        if ( $article_id ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_SUCCESS]","save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=create");
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_ARTICLE_MESSAGE_SAVE_ERROR_IN_DB] #005","save");
        }
    }
    
}

return; ?>