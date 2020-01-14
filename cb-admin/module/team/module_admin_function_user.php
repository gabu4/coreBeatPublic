<?php
namespace module\admin\team\user;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callCreate_checkPost(&$data) {
        global $post;
        if ( 
            isset($post['adminModuleTeamMateSave']) OR
            isset($post['adminModuleTeamMateAndExit'])
            ) {
            return true;
        }
        return false;
    }
    
    protected function callCreate_savePost() {
        global $post;
        
        if ( isset($post['adminModuleTeamMateSave']) ) {
            $this->callCreate_savePost_save();
        } else if ( isset($post['adminModuleTeamMateAndExit']) ) {
            $this->callCreate_savePost_saveAndExit();
        }
    }
    
    private function callCreate_savePost_save() {
        global $handler;
        
        $team_id = $this->callCreate_savePost_asNew();
        $this->callCreate_savePost_saveFile($team_id);
        
        if ( $team_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_TEAM_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=team&funct=edit&id=".$team_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_TEAM_SAVE_ERROR_IN_DB] #106",false,"save");
        }
    }
    
    private function callCreate_savePost_saveAndExit() {
        global $handler;
        
        $team_id = $this->callCreate_savePost_asNew();
        $this->callCreate_savePost_saveFile($team_id);
        
        if ( $team_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_TEAM_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=team&funct=main");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_TEAM_SAVE_ERROR_IN_DB] #107",false,"save");
        }
    }
    
    
    protected function callCreate_imageTabCreate($media = "" ) {
        global $module;
        
        $teamMate_image = CB_ADMIN . "/module/team/img/default-user-image.png";
        if ( !empty($media) ) {
            $media = json_decode($media,true);
            if ( isset($media['image']) && !empty($media['image'])  ) {
                $teamMate_image = $this->teamContentImagePathHTML.$this->teamContentImagePath_small.$media['image'];
            }
        }
        $html = "";
        
        $html .= "<div class='form-group d-inline-block'>";
        
        $html .= "<hr class='float-left' style='width:100%' />";

        $html .= "<h3 class='col-md-12 float-left' style='width:100%'>[ADMIN_TEXT_TEAM_IMAGE_TAB_IMAGE_TITLE]</h3>";
        $html .= "<div class='col-md-4 image_preview'>";
        $html .= "<img class='' id='preview_image' style='max-width:100%;' src='$teamMate_image' />";
        $html .= "</div>";
        $html .= "<div class='col-md-8'>";
        $html .= "[ADMIN_TEXT_TEAM_IMAGE_TAB_IMAGE_ERROR]";
        $html .= "<p id='p-image_file'><input type='file' name='image_file' id='image_file' /></p>";
        $html .= "<p id='p-image_delete'><label><input type='checkbox' name='image_delete' id='image_delete' value='1' /> [ADMIN_TEXT_TEAM_IMAGE_TAB_IMAGE_DELETE]</label></p>";
        $html .= "</div>";
        
        
        $html .= "</div>";
            
        return $html;
    }
    
    protected function callCreate_themeLoad($data) {
        global $lang, $theme;
        
        $html = $theme->loadAdminTemplate('admin_team','create',TRUE,'team');
        
        $dl = $lang->getAllowedLanguageTypes()[0];
        
        $team_id = ( isset($data['team_id'][$dl]) ) ? $data['team_id'][$dl] : 0;
        $media = ( isset($data['media'][$dl]) ) ? $data['media'][$dl] : "";
        $short_order = ( isset($data['short_order'][$dl]) ) ? $data['short_order'][$dl] : "";
        
        $replace['image_tab'] = $this->callCreate_imageTabCreate($media);
        
        $replace['IFSTATE0'] = '';
        $replace['IFSTATE1'] = ' CHECKED ';
        
        $replace['TEAM_FIELD_NAME'] = $this->callCreate_themeLoad_teamFieldName($data);
        $replace['CONTENT_TABS'] = $this->callCreate_themeLoad_contentTabs($team_id);
        $replace['CONTENT_PANELS'] = $this->callCreate_themeLoad_contentPanels($data);
        $replace['SHORT_ORDER'] = $short_order;
        
        foreach ( $data as $k => $v ) {
            $replace[strtoupper($k)] = $v[$dl];
        }
        
        $theme->replace($replace, $html);
                
        return $html;
    }
    
    protected function callCreate_themeLoad_teamFieldName($data) {
        global $lang, $theme, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_team','create_field_name',FALSE,'team');
            $replace = array();
            $replace['LANG'] = $l;
            $replace['LANGUAGE_FLAG'] = ( $showFlag === TRUE ) ? $admin_function->getLanguageFlag($l) : "";
            $replace['NAME'] = ( isset($data['name'][$l]) ) ? $data['name'][$l] : "";
            $replace['TITULUS'] = ( isset($data['titulus'][$l]) ) ? $data['titulus'][$l] : "";
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    protected function callCreate_themeLoad_contentTabs($team_id = 0) {
        global $lang, $theme, $admin_function;
        
        $html = "";
        $showFlag = FALSE;
        $first = TRUE;
        if ( $lang->getAllowedLanguageCount() > 1 ) { $showFlag = TRUE; }
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_team','create_content_tabs',FALSE,'team');
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
    
    protected function callCreate_themeLoad_contentPanels($data) {
        global $lang, $theme;
        
        $html = "";
        $first = TRUE;
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $h = $theme->loadAdminTemplate('admin_team','create_content_panels',FALSE,'team');
            $replace = array();
            $replace['ACTIVE'] = "";
            $replace['LANG'] = $l;
            $replace['TEXT'] = ( isset($data['text'][$l]) ) ? $data['text'][$l] : "";
            $replace['MUNKAI'] = ( isset($data['munkai'][$l]) ) ? $data['munkai'][$l] : "";
            $replace['FOGLALAS'] = ( isset($data['foglalas'][$l]) ) ? $data['foglalas'][$l] : "";
            if ( $first === TRUE ) {
                $replace['ACTIVE'] = "active";
                $first = FALSE;
            }
            $theme->replace($replace, $h);
            $html .= $h;
        }
        
        return $html;
    }
    
    
    protected function callEdit_savePost() {
        global $post;
        
        if ( isset($post['adminModuleTeamMateSave']) ) {
            $this->callEdit_savePost_save();
        } else if ( isset($post['adminModuleTeamMateAndExit']) ) {
            $this->callEdit_savePost_saveAndExit();
        }
    }
    
    private function callEdit_savePost_save() {
        global $handler;
        
        $team_id = $this->callEdit_savePost_update();
        $this->callCreate_savePost_saveFile($team_id);
        
        if ( $team_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_TEAM_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=team&funct=edit&id=".$team_id);exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_TEAM_SAVE_ERROR_IN_DB] #102",false,"save");
        }
        
    }
        
    private function callEdit_savePost_saveAndExit() {
        global $handler;
        
        $team_id = $this->callEdit_savePost_update();
        $this->callCreate_savePost_saveFile($team_id);
        
        if ( $team_id ) {
            $handler->messageSuccess("[ADMIN_MESSAGE_TEAM_SAVE_SUCCESS]",true,"save");
            header("Location: ".CB_INDEX."?admin=team&funct=main");exit;
        } else {
            $handler->messageError("[ADMIN_MESSAGE_TEAM_SAVE_ERROR_IN_DB] #104",false,"save");
        }
    }
    
}

return; ?>