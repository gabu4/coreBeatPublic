<?php
namespace menupoint\menu\html;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 18/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    public function init() {
        global $get;
        
        if ( $get['funct'] === 'edit' && isset($get['id']) && !empty($get['id']) && is_numeric($get['id']) ) {
            return $this->__menupoint_html_edit($get['id']);
        } else {
            return $this->__menupoint_html_new();
        }
    }
    
    private function __menupoint_html_new() {
        global $get, $post, $lang;
        
        $catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
        $catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];
        
        $data = $this->menupointHtml_defaultData();
        $data['catid'] = $catid;
        $data['catlang'] = $catlang;
        
        if ( $this->menupointHtml_saveTest($data) ) {
            $error = $this->menupointHtml_saveTest_error();
            if ( $error ) {
                $this->menupoint_html_save_error($error);
            } else {
                $data = $post;
                $data['catid'] = $catid;
                $data['catlang'] = $catlang;
                $error = $this->menupointHtml_savePost($data);
                
                if ( $error !== TRUE ) { 
                    $this->menupointHtml_save_error($error);
                } else {
                    $this->menupointHtml_save_success($data);
                }
            }
        }
        
        $html = $this->menupointHtml_themeLoad($data);
        
        return $html;
        
    }
    
    private function __menupoint_html_edit() {
        global $get, $post, $lang;
        
        $catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
        $catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];
        
        $id = ( isset($get['id']) && !empty($get['id']) && is_numeric($get['id']) ) ? $get['id'] : 0;
        if ( $id == 0 ) { return $this->menupointArticle_menuEditError(); }
        
        $dataDef = $this->menupointHtml_defaultData();
        $dataDb = $this->menupointHtml_edit_getData($id);
        $data = array_merge($dataDef,$dataDb);
        $v = json_decode($data['v'],TRUE);
        $data['catid'] = $catid;
        $data['catlang'] = $catlang;
        
        if ( empty($data) ) { return $this->menupointArticle_menuEditError(); }
        
        if ( $this->menupointHtml_saveTest($data) ) {
            $error = $this->menupointHtml_saveTest_error();
            if ( $error ) {
                $this->menupoint_html_save_error($error);
            } else {
                $data = $post;
                $data['catid'] = $catid;
                $data['catlang'] = $catlang;
                $error = $this->menupointHtml_updatePost($data);
                if ( $error !== TRUE ) { 
                    $this->menupointHtml_save_error($error);
                } else {
                    $this->menupointHtml_save_success($data);
                }
            }
        }
        
        $data['blank'] = $v['blank'];
        $data['html_link'] = $v['html_link'];
        $html = $this->menupointHtml_themeLoad($data,$id);
        
        return $html;
    }
}

return; ?>