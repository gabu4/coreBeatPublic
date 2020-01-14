<?php
namespace module\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v013
 * @date 30/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function __call_team($value) {
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
        $teamData = $this->callMain_databaseGet($contentData,$language);
        if ( empty($teamData) ) { return $content->loadErrorPage404(); }
        
        $template_extra = ( isset($contentData['template']) && !empty($contentData['template']) ) ? '_'.$contentData['template'] : $template_extra;
        $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $contentData['class'] : '';
        
        $html = $this->callTeam_createPage($teamData, $template_extra, $class, true);
        
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
        
        $language = $lang->getLanguage();
        
        $listData = $this->callTeamList_dbData($language);
        
        $team = "";
        
        if ( empty($listData) ) {
            $team .= "<div class='teamCategoryPageDIV emptyCategory'>[TEXT_ARTICLE_CATEGORY_EMPTY]</div>";
        } else {
            foreach ( $listData as $contentData ) {
                $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $contentData['class'] : '';
                $a = $this->callTeam_createPage($contentData, '_category', $class);
                $team .= $a['body'];
            }
        }

        $html = $this->callTeamCategory_createCategoryPage($team);
        
        return $html;
    }
    
    public function __call_works($value) {
        global $content, $get, $is_ajax, $lang;
        
        if ( isset($get['admin']) ) {
            return "&#123;#MODULE,PRODUCT,PRODUCT,".$value."&#125;";
        }
        
        if ( !empty($value) && is_numeric($value) ) {
            $contentData['id'] = $value;
        } else if ( !empty($value) ) {
            $contentData = (array) json_decode($value,true);
        } else if ( !empty($content->contentData['value']) ) {
            $contentData = (array) json_decode($content->contentData['value'],true);
        } else if (
            $content->contentData['module'] == 'team' &&
            $content->contentData['type'] == 'works' &&
            isset($get['id']) &&
            is_numeric($get['id']) 
            ) {
            $contentData['id'] = $get['id'];
        } else {
            return $content->loadErrorPage404();
        }
        
        $language = ( isset($contentData['language']) ) ? $contentData['language'] : $lang->getLanguage();
        $teamData = $this->callMain_databaseGet($contentData['id'],$language);
        
        if ( empty($teamData) ) { return $content->loadErrorPage404(); }
        
        $template_extra = "_works";
        $template_extra = ( isset($contentData['template']) && !empty($contentData['template']) ) ? '_'.$contentData['template'] : $template_extra;
        
        $class = ( isset($contentData['class']) && !empty($contentData['class']) ) ? $contentData['class'] : '';
        $html = $this->callTeam_createPage($teamData, $template_extra, $class, true);
        
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
    
}

return; ?>
