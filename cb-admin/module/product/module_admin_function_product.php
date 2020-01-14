<?php
namespace module\admin\product\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callProductCreate_checkPost(&$data) {
        global $post;
        if ( 
            isset($post['adminModuleProductSave']) OR
            isset($post['adminModuleProductSaveCopy']) OR
            isset($post['adminModuleProductSaveAndExit']) OR
            isset($post['adminModuleProductSaveAndNew'])
            ) {
            return true;
        }
        return false;
    }
    
    protected function callProductCreate_savePost() {
        global $post;
        
        if ( isset($post['adminModuleProductSave']) ) {
            $this->callProductCreate_savePost_save();
        } else if ( isset($post['adminModuleProductSaveAndExit']) ) {
            $this->callProductCreate_savePost_saveAndExit();
        } else if ( isset($post['adminModuleProductSaveAndNew']) ) {
            $this->callProductCreate_savePost_saveAndNew();
        }
    }
    
    private function callProductCreate_savePost_save() {
        global $handler;
        
        $product_id = $this->callProductCreate_savePost_asNew();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=product_edit&id=".$product_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #006",false,"save");
        }
    }
    
    private function callProductCreate_savePost_saveAndExit() {
        global $handler;
        
        $product_id = $this->callProductCreate_savePost_asNew();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=list");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #007",false,"save");
        }
    }
    
    private function callProductCreate_savePost_saveAndNew() {
        global $handler;
        
        $product_id = $this->callProductCreate_savePost_asNew();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=product_create");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #001",false,"save");
        }
    }
    
    protected function callProductCreate_categoryListCreate($article_id = 0) {
        $data = $this->callProductCreate_categoryListCreate_getData();
        
        $html = "";
        
        if ( !empty($data) ) {
            
            $dataCheck = array();
            if ( $article_id !== 0 ) {
                $dataCheck = $this->callProductCreate_categoryListCreate_getDataToCheck($article_id);
            }
            $html .= "<select class='selectCatList' name='catList[]' size='10' multiple>";
            
            $selected = ( empty($dataCheck) ) ? ' SELECTED ' : '';
            $html .= "<option value='0' ".$selected.">[ADMIN_TEXT_PRODUCT_NO_CATEGORY_SELECT_TEXT]</option>";
            foreach ( $data as $ldValue ) {
                $selected = ( in_array($ldValue['id'], $dataCheck) ) ? ' SELECTED ' : '';
                $html .= "<option value='".$ldValue['id']."' ".$selected.">".$ldValue['name']."</option>";
            }
            $html .= "</select>";
        }
        
        return $html;
    }
    
    protected function callProductCreate_imageTabCreate($media = "" ) {
        global $module;
        
        $defImage = '';
        $defHeaderImage = '';
        $defProductImage = '';
        $defYoutubeVideo = '';
        $defYoutubeVideoLink = '';
        
        if ( !empty($media) ) {
            $media = json_decode($media,true);
            $defImage = ( !empty($media['thumbnail']) ) ? $this->productContentImagePathHTML.$this->productContentImagePath_original.$media['thumbnail'] : '';
            $defHeaderImage = ( !empty($media['headerimage']) ) ? $this->productContentImagePathHTML.$this->productContentImagePath_original.$media['headerimage'] : '';
            $defProductImage = ( !empty($media['productimage']) ) ? $this->productContentImagePathHTML.$this->productContentImagePath_original.$media['productimage'] : '';
            $defYoutubeVideo = ( !empty($media['youtubevideo']) ) ? $media['youtubevideo'] : '';
        }
        $html = "";
        
        $html .= "<div class='form-group d-inline-block'>";
        
        if ( $module->cb_check_access('product','content_thumbnail_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defImage)) {
                $defImage = CB_ADMIN . "/module/product/img/no-thumbnail.jpg";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_PRODUCT_IMAGE_TAB_THUMBNAIL_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview'>";
            $html .= "<img class='' id='preview_thumb' style='max-width:100%;' src='$defImage' />";
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "[ADMIN_TEXT_PRODUCT_IMAGE_TAB_THUMBNAIL_ERROR]";
            $html .= "<p id='p-thumbnail_file'><input type='file' name='thumbnail_file' id='thumbnail_file' /></p>";
            $html .= "<p id='p-thumbnail_delete'><label><input type='checkbox' name='thumbnail_delete' id='thumbnail_delete' value='1' /> [ADMIN_TEXT_PRODUCT_IMAGE_TAB_THUMBNAIL_DELETE]</label></p>";
            $html .= "</div>";
        }
        
        if ( $module->cb_check_access('product','content_productimage_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defProductImage)) {
                $defProductImage = CB_ADMIN . "/module/product/img/no-thumbnail.jpg";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_PRODUCT_IMAGE_TAB_PRODUCTIMG_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview_product'>";
            $html .= "<img class='' id='preview_productimage' style='max-width:100%;' src='$defProductImage' />";
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "[ADMIN_TEXT_PRODUCT_IMAGE_TAB_PRODUCTIMG_ERROR]";
            $html .= "<p id='p-productimage_file'><input type='file' name='productimage_file' id='productimage_file' /></p>";
            $html .= "<p id='p-productimage_delete'><label><input type='checkbox' name='productimage_delete' id='productimage_delete' value='1' /> [ADMIN_TEXT_PRODUCT_IMAGE_TAB_PRODUCTIMG_DELETE]</label></p>";
            $html .= "</div>";
        }
		
        if ( $module->cb_check_access('product','content_headerimage_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defHeaderImage)) {
                $defHeaderImage = CB_ADMIN . "/module/product/img/no-thumbnail.jpg";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_PRODUCT_IMAGE_TAB_HEADERIMG_TITLE]</h3>";
            $html .= "<div class='col-md-4 image_preview_header'>";
            $html .= "<img class='' id='preview_headerimage' style='max-width:100%;' src='$defHeaderImage' />";
            $html .= "</div>";
            $html .= "<div class='col-md-8'>";
            $html .= "[ADMIN_TEXT_PRODUCT_IMAGE_TAB_HEADERIMG_ERROR]";
            $html .= "<p id='p-headerimage_file'><input type='file' name='headerimage_file' id='headerimage_file' /></p>";
            $html .= "<p id='p-headerimage_delete'><label><input type='checkbox' name='headerimage_delete' id='headerimage_delete' value='1' /> [ADMIN_TEXT_PRODUCT_IMAGE_TAB_HEADERIMG_DELETE]</label></p>";
            $html .= "</div>";
        }
		
        if ( $module->cb_check_access('product','content_youtubevideo_upload_access','admin') ) {
            $html .= "<hr class='float-left' style='width:100%' />";

            if ( empty($defYoutubeVideo)) {
                $defYoutubeVideoImg = CB_ADMIN . "/module/product/img/no-thumbnail.jpg";
            } else {
                $defYoutubeVideoImg = "https://img.youtube.com/vi/".$defYoutubeVideo."/mqdefault.jpg";
                $defYoutubeVideoLink = "<br /><a href='https://youtube.com/watch?v=".$defYoutubeVideo."' target='ytVideo'>Link</a>";
            }
            $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_PRODUCT_IMAGE_TAB_YOUTUBE_TITLE]</h3>";
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
    
    protected function callProductCreate_themeLoad($data) {
        global $lang, $theme;
        
        $html = $theme->loadAdminTemplate('admin_product','create',TRUE,'product');
        
        $dl = $lang->getAllowedLanguageTypes()[0];
        
        $product_id = ( isset($data['product_id'][$dl]) ) ? $data['product_id'][$dl] : 0;
        $media = ( isset($data['media'][$dl]) ) ? $data['media'][$dl] : "";
        
        $replace['category_list'] = $this->callProductCreate_categoryListCreate($product_id);
        $replace['image_tab'] = $this->callProductCreate_imageTabCreate($media);
        
        $replace['IFSTATE0'] = '';
        $replace['IFSTATE1'] = ' CHECKED ';
        
        $replace['PRODUCT_ID'] = $product_id;
        
        $replace['PRODUCT_FIELD_NAME'] = $this->callProductCreate_themeLoad_articleFieldName($data);
        $replace['CONTENT_TABS'] = $this->callProductCreate_themeLoad_contentTabs($product_id);
        $replace['CONTENT_PANELS'] = $this->callProductCreate_themeLoad_contentPanels($data);
        $replace['META_TABS'] = $this->callProductCreate_themeLoad_metaTabs();
        $replace['META_PANELS'] = $this->callProductCreate_themeLoad_metaPanels($data);
        
        foreach ( $data as $k => $v ) {
            $replace[strtoupper($k)] = $v[$dl];
        }
        
        $theme->replace($replace, $html);
                
        return $html;
    }
    
    protected function callProductCreate_themeLoad_articleFieldName($data) {
        global $lang, $theme, $module, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_product','create_field_name',FALSE,'product');
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
    
    protected function callProductCreate_themeLoad_contentTabs($article_id = 0) {
        global $lang, $theme, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        $first = TRUE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            if ( !empty($article_id) ) {
                $contentCss = 'product_'.$l.'_'.$article_id.'.css';
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
    
    protected function callProductCreate_themeLoad_contentPanels($data) {
        global $lang, $theme;
        
        $html = "";
        $first = TRUE;
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_product','create_content_panels',FALSE,'product');
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
    
    protected function callProductCreate_themeLoad_metaTabs() {
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
    
    protected function callProductCreate_themeLoad_metaPanels($data) {
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
    
    protected function callProductEdit_savePost() {
        global $post;
        
        if ( isset($post['adminModuleProductSave']) ) {
            $this->callProductEdit_savePost_save();
        } else if ( isset($post['adminModuleProductSaveCopy']) ) {
            $this->callProductEdit_savePost_saveCopy();
        } else if ( isset($post['adminModuleProductSaveAndExit']) ) {
            $this->callProductEdit_savePost_saveAndExit();
        } else if ( isset($post['adminModuleProductSaveAndNew']) ) {
            $this->callProductEdit_savePost_saveAndNew();
        }
    }
    
    private function callProductEdit_savePost_save() {
        global $handler;
        
        $product_id = $this->callProductEdit_savePost_update();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=product_edit&id=".$product_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #002",false,"save");
        }
        
    }
    
    private function callProductEdit_savePost_saveCopy() {
        global $handler;
        
        $product_id = $this->callProductCreate_savePost_asNew();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=product_edit&id=".$product_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #003",false,"save");
        }
    }
    
    private function callProductEdit_savePost_saveAndExit() {
        global $handler;
        
        $product_id = $this->callProductEdit_savePost_update();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=list");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #004",false,"save");
        }
    }
    
    private function callProductEdit_savePost_saveAndNew() {
        global $handler;
        
        $product_id = $this->callProductEdit_savePost_update();
        $this->callProductCreate_savePost_saveFile($product_id);
        
        if ( $product_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_PRODUCT_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=product_create");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_PRODUCT_SAVE_ERROR_IN_DB] #005",false,"save");
        }
    }
    
}

return; ?>