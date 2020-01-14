<?php
namespace module\admin\catalog\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v010
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callCatalogCreate_checkPost(&$data) {
        global $post;
        if ( 
            isset($post['adminModuleCatalogSave']) OR
            isset($post['adminModuleCatalogSaveCopy']) OR
            isset($post['adminModuleCatalogSaveAndExit']) OR
            isset($post['adminModuleCatalogSaveAndNew'])
            ) {
            return true;
        }
        return false;
    }
    
    protected function callCatalogCreate_savePost() {
        global $post;
        
        if ( isset($post['adminModuleCatalogSave']) ) {
            $this->callCatalogCreate_savePost_save();
        } else if ( isset($post['adminModuleCatalogSaveAndExit']) ) {
            $this->callCatalogCreate_savePost_saveAndExit();
        } else if ( isset($post['adminModuleCatalogSaveAndNew']) ) {
            $this->callCatalogCreate_savePost_saveAndNew();
        }
    }
    
    private function callCatalogCreate_savePost_save() {
        global $handler;
        
        $catalog_id = $this->callCatalogCreate_savePost_asNew();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=catalog_edit&id=".$catalog_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #006",false,"save");
        }
    }
    
    private function callCatalogCreate_savePost_saveAndExit() {
        global $handler;
        
        $catalog_id = $this->callCatalogCreate_savePost_asNew();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=list");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #007",false,"save");
        }
    }
    
    private function callCatalogCreate_savePost_saveAndNew() {
        global $handler;
        
        $catalog_id = $this->callCatalogCreate_savePost_asNew();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=catalog_create");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #001",false,"save");
        }
    }
    
    protected function callCatalogCreate_categoryListCreate($article_id = 0) {
        $data = $this->callCatalogCreate_categoryListCreate_getData();
        
        $html = "";
        
        if ( !empty($data) ) {
            
            $dataCheck = array();
            if ( $article_id !== 0 ) {
                $dataCheck = $this->callCatalogCreate_categoryListCreate_getDataToCheck($article_id);
            }
            $html .= "<select class='selectCatList' name='catList[]' size='10' multiple>";
            
            $selected = ( empty($dataCheck) ) ? ' SELECTED ' : '';
            $html .= "<option value='0' ".$selected.">[ADMIN_TEXT_CATALOG_NO_CATEGORY_SELECT_TEXT]</option>";
            foreach ( $data as $ldValue ) {
                $selected = ( in_array($ldValue['id'], $dataCheck) ) ? ' SELECTED ' : '';
                $html .= "<option value='".$ldValue['id']."' ".$selected.">".$ldValue['name']."</option>";
            }
            $html .= "</select>";
        }
        
        return $html;
    }
    
    protected function callCatalogCreate_imageTabCreate($media = "" ) {
        global $module;
        
        $defImage = '';
        $defHeaderImage = '';
        $defCatalogImage = '';
        $defYoutubeVideo = '';
        $defYoutubeVideoLink = '';
        
        if ( !empty($media) ) {
            $media = json_decode($media,true);
            $defImage = ( !empty($media['thumbnail']) ) ? $this->catalogContentImagePathHTML.$this->catalogContentImagePath_original.$media['thumbnail'] : '';
            $defHeaderImage = ( !empty($media['headerimage']) ) ? $this->catalogContentImagePathHTML.$this->catalogContentImagePath_original.$media['headerimage'] : '';
            $defCatalogImage = ( !empty($media['catalogimage']) ) ? $this->catalogContentImagePathHTML.$this->catalogContentImagePath_original.$media['catalogimage'] : '';
            $defYoutubeVideo = ( !empty($media['youtubevideo']) ) ? $media['youtubevideo'] : '';
        }
        $html = "";
        
        $html .= "<div class='form-group d-inline-block'>";
        
        if ( $module->cb_check_access('catalog','content_thumbnail_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defImage)) {
                $defImage = CB_ADMIN . "/module/catalog/img/no-thumbnail.jpg";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_CATALOG_IMAGE_TAB_THUMBNAIL_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview'>";
            $html .= "<img class='' id='preview_thumb' style='max-width:100%;' src='$defImage' />";
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "[ADMIN_TEXT_CATALOG_IMAGE_TAB_THUMBNAIL_ERROR]";
            $html .= "<p id='p-thumbnail_file'><input type='file' name='thumbnail_file' id='thumbnail_file' /></p>";
            $html .= "<p id='p-thumbnail_delete'><label><input type='checkbox' name='thumbnail_delete' id='thumbnail_delete' value='1' /> [ADMIN_TEXT_CATALOG_IMAGE_TAB_THUMBNAIL_DELETE]</label></p>";
            $html .= "</div>";
        }
        
        if ( $module->cb_check_access('catalog','content_catalogimage_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defCatalogImage)) {
                $defCatalogImage = CB_ADMIN . "/module/catalog/img/no-thumbnail.jpg";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_CATALOG_IMAGE_TAB_CATALOGIMG_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview_catalog'>";
            $html .= "<img class='' id='preview_catalogimage' style='max-width:100%;' src='$defCatalogImage' />";
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "[ADMIN_TEXT_CATALOG_IMAGE_TAB_CATALOGIMG_ERROR]";
            $html .= "<p id='p-catalogimage_file'><input type='file' name='catalogimage_file' id='catalogimage_file' /></p>";
            $html .= "<p id='p-catalogimage_delete'><label><input type='checkbox' name='catalogimage_delete' id='catalogimage_delete' value='1' /> [ADMIN_TEXT_CATALOG_IMAGE_TAB_CATALOGIMG_DELETE]</label></p>";
            $html .= "</div>";
        }
		
        if ( $module->cb_check_access('catalog','content_headerimage_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defHeaderImage)) {
                $defHeaderImage = CB_ADMIN . "/module/catalog/img/no-thumbnail.jpg";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_CATALOG_IMAGE_TAB_HEADERIMG_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview_header'>";
            $html .= "<img class='' id='preview_headerimage' style='max-width:100%;' src='$defHeaderImage' />";
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "[ADMIN_TEXT_CATALOG_IMAGE_TAB_HEADERIMG_ERROR]";
            $html .= "<p id='p-headerimage_file'><input type='file' name='headerimage_file' id='headerimage_file' /></p>";
            $html .= "<p id='p-headerimage_delete'><label><input type='checkbox' name='headerimage_delete' id='headerimage_delete' value='1' /> [ADMIN_TEXT_CATALOG_IMAGE_TAB_HEADERIMG_DELETE]</label></p>";
            $html .= "</div>";
        }
		
        if ( $module->cb_check_access('catalog','content_youtubevideo_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defYoutubeVideo)) {
                $defYoutubeVideoImg = CB_ADMIN . "/module/catalog/img/no-thumbnail.jpg";
            } else {
                $defYoutubeVideoImg = "https://img.youtube.com/vi/".$defYoutubeVideo."/mqdefault.jpg";
                $defYoutubeVideoLink = "<br /><a href='https://youtube.com/watch?v=".$defYoutubeVideo."' target='ytVideo'>Link</a>";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_CATALOG_IMAGE_TAB_YOUTUBE_TITLE]</h3>";
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
    
    protected function callCatalogCreate_themeLoad($data) {
        global $lang, $theme;
        
        $html = $theme->loadAdminTemplate('admin_catalog','create',TRUE,'catalog');
        
        $dl = $lang->getAllowedLanguageTypes()[0];
        
        $catalog_id = ( isset($data['catalog_id'][$dl]) ) ? $data['catalog_id'][$dl] : 0;
        $media = ( isset($data['media'][$dl]) ) ? $data['media'][$dl] : "";
        
        $replace['category_list'] = $this->callCatalogCreate_categoryListCreate($catalog_id);
        $replace['image_tab'] = $this->callCatalogCreate_imageTabCreate($media);
        
        $replace['IFSTATE0'] = '';
        $replace['IFSTATE1'] = ' CHECKED ';
        
        $replace['CATALOG_ID'] = $catalog_id;
        
        $replace['CATALOG_FIELD_NAME'] = $this->callCatalogCreate_themeLoad_articleFieldName($data);
        $replace['CONTENT_TABS'] = $this->callCatalogCreate_themeLoad_contentTabs($catalog_id);
        $replace['CONTENT_PANELS'] = $this->callCatalogCreate_themeLoad_contentPanels($data);
        $replace['META_TABS'] = $this->callCatalogCreate_themeLoad_metaTabs();
        $replace['META_PANELS'] = $this->callCatalogCreate_themeLoad_metaPanels($data);
        
        foreach ( $data as $k => $v ) {
            $replace[strtoupper($k)] = $v[$dl];
        }
        
        $theme->replace($replace, $html);
                
        return $html;
    }
    
    protected function callCatalogCreate_themeLoad_articleFieldName($data) {
        global $lang, $theme, $module, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_catalog','create_field_name',FALSE,'catalog');
            $replace = array();
            $replace['LANG'] = $l;
            $replace['LANGUAGE_FLAG'] = ( $showFlag === TRUE ) ? $admin_function->getLanguageFlag($l) : "";
            $replace['NAME'] = ( isset($data['name'][$l]) ) ? $data['name'][$l] : "";
            $replace['SEO_NAME'] = ( isset($data['content_id'][$l]) && $data['content_id'][$l] != 0 ) ? $module->loadAdminFunction('admin','getseonamefromid',$data['content_id'][$l]) : "";
            $replace['CONTENT_ID'] = ( isset($data['content_id'][$l]) ) ? $data['content_id'][$l] : "";
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    protected function callCatalogCreate_themeLoad_contentTabs($article_id = 0) {
        global $lang, $theme, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        $first = TRUE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            if ( !empty($article_id) ) {
                $contentCss = 'catalog_'.$l.'_'.$article_id.'.css';
                $theme->addContentCss($contentCss);
            }
            $h = $theme->loadAdminTemplate('admin_article','create_content_tabs',FALSE,'article');
            $replace = array();
            $replace['ACTIVE'] = "";
            $replace['ARIA_EXPANDED'] = "";
            $replace['LANG'] = $l;
            $replace['LANGUAGE_FLAG'] = ( $showFlag === TRUE ) ? $admin_function->getLanguageFlag($l) : "";
            if ( $first === TRUE ) {
                $replace['ACTIVE'] = "active";
                $replace['ARIA_EXPANDED'] = "aria-expanded='true'";
                $first = FALSE;
            }
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    protected function callCatalogCreate_themeLoad_contentPanels($data) {
        global $lang, $theme;
        
        $html = "";
        $first = TRUE;
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_catalog','create_content_panels',FALSE,'catalog');
            $replace = array();
            $replace['ACTIVE'] = "";
            $replace['LANG'] = $l;
            $replace['SHORTTEXT'] = ( isset($data['shorttext'][$l]) ) ? $data['shorttext'][$l] : "";
            $replace['TEXT'] = ( isset($data['text'][$l]) ) ? $data['text'][$l] : "";
            if ( $first === TRUE ) {
                $replace['ACTIVE'] = "active";
                $first = FALSE;
            }
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    protected function callCatalogCreate_themeLoad_metaTabs() {
        global $lang, $theme, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_article','create_meta_tabs',FALSE,'article');
            $replace = array();
            $replace['LANG'] = $l;
            $replace['LANGUAGE_FLAG'] = ( $showFlag === TRUE ) ? $admin_function->getLanguageFlag($l) : "";
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    protected function callCatalogCreate_themeLoad_metaPanels($data) {
        global $lang, $theme;
        
        $html = "";
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_article','create_meta_panels',FALSE,'article');
            $replace = array();
            $replace['LANG'] = $l;
            $replace['META_KEYWORDS'] = ( isset($data['meta_keywords'][$l]) ) ? $data['meta_keywords'][$l] : "";
            $replace['META_DESCRIPTION'] = ( isset($data['meta_description'][$l]) ) ? $data['meta_description'][$l] : "";
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    protected function callCatalogEdit_savePost() {
        global $post;
        
        if ( isset($post['adminModuleCatalogSave']) ) {
            $this->callCatalogEdit_savePost_save();
        } else if ( isset($post['adminModuleCatalogSaveCopy']) ) {
            $this->callCatalogEdit_savePost_saveCopy();
        } else if ( isset($post['adminModuleCatalogSaveAndExit']) ) {
            $this->callCatalogEdit_savePost_saveAndExit();
        } else if ( isset($post['adminModuleCatalogSaveAndNew']) ) {
            $this->callCatalogEdit_savePost_saveAndNew();
        }
    }
    
    private function callCatalogEdit_savePost_save() {
        global $handler;
        
        $catalog_id = $this->callCatalogEdit_savePost_update();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=catalog_edit&id=".$catalog_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #002",false,"save");
        }
        
    }
    
    private function callCatalogEdit_savePost_saveCopy() {
        global $handler;
        
        $catalog_id = $this->callCatalogCreate_savePost_asNew();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=catalog_edit&id=".$catalog_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #003",false,"save");
        }
    }
    
    private function callCatalogEdit_savePost_saveAndExit() {
        global $handler;
        
        $catalog_id = $this->callCatalogEdit_savePost_update();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=list");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #004",false,"save");
        }
    }
    
    private function callCatalogEdit_savePost_saveAndNew() {
        global $handler;
        
        $catalog_id = $this->callCatalogEdit_savePost_update();
        $this->callCatalogCreate_savePost_saveFile($catalog_id);
        
        if ( $catalog_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=catalog_create");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB] #005",false,"save");
        }
    }
    
}

return; ?>