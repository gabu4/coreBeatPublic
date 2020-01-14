<?php
namespace menupoint\article\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 19/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function init() {
        global $get;
        
        if ( $get['funct'] === 'edit' && isset($get['id']) && !empty($get['id']) && is_numeric($get['id']) ) {
            return $this->__menupoint_article_edit($get['id']);
        } else {
            return $this->__menupoint_article_new();
        }
    }
    
    private function __menupoint_article_new() {
        global $get, $lang;
        
        $catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
        $catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];
        
        $data = $this->menupointArticle_defaultData();
        
        if ( $this->menupointArticle_checkPost($data) ) { $this->menupointArticle_savePost($catlang, $catid); }
        
        $data['languageselect'] = menuLanguageSelectCreate($catlang);
        $data['groupselect'] = menuGroupSelectCreate($catid);
        $data['parentselect'] = menuParentSelectCreate($catlang,$catid);
        $data['articleselect'] = $this->menupointArticle_menuArticleSelectCreate($catlang);
        
        $html = $this->menupointArticle_themeLoad($data);
        
        return $html;
        
    }
    
    private function __menupoint_article_edit() {
        global $get, $post, $lang;
        
        $catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
        $catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];
        
        $id = ( isset($get['id']) && !empty($get['id']) && is_numeric($get['id']) ) ? $get['id'] : 0;
        if ( $id == 0 ) { return $this->menupointArticle_menuEditError(); }
        
        $dataDef = $this->menupointArticle_defaultData();
        $dataDb = $this->menupointArticle_edit_getData($id);
        $data = array_merge($dataDef,$dataDb);
        $v = json_decode($data['v'],TRUE);
        
        if ( empty($data) ) { return $this->menupointArticle_menuEditError(); }
        
        if ( $this->menupointArticle_checkPost($data) ) { $this->menupointArticle_editPost($catlang, $catid); }
        
        $data['languageselect'] = menuLanguageSelectCreate($catlang);
        $data['groupselect'] = menuGroupSelectCreate($catid);
        $data['parentselect'] = menuParentSelectCreate($catlang,$catid,$data);
        $data['articleselect'] = $this->menupointArticle_menuArticleSelectCreate($catlang,$v['id']);
        
        $data['blank'] = $v['blank'];
        $html = $this->menupointArticle_themeLoad($data,$id);
        
        return $html;
    }
}

return; ?>