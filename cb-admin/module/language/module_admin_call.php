<?php
namespace module\admin\language;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 12/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
		
    public function __call_main() {
        global $module;
        $html = $module->loadAdminFunction('admin','adminmodulemenu');
        
        return $html;
    }

    public function __call_list() {
        global $is_ajax;
        if ( $is_ajax ) {
            global $out_html;
            $out_html->printOutContent($this->list_buildHTML(TRUE));
        } else {
            return $this->list_buildHTML();
        }
    }
    
    public function __call_new() {
        global $get, $post, $out_html;
        
        $id = 0;
        
        if ( isset($post['adminLanguageSave']) ) { $ok = $this->saveString($id); if ( $ok ) { $out_html->redirect('?admin=language&funct=edit&id='.$id); } }
        elseif ( isset($post['adminLanguageSaveAndNew']) ) { $ok = $this->saveString($id); if ( $ok ) { $out_html->redirect('?admin=language&funct=new'); } }
        elseif ( isset($post['adminLanguageSaveAndExit']) ) { $ok = $this->saveString($id); if ( $ok ) { $out_html->redirect('?admin=language&funct=list'); } }
        
        return $this->new_buildHTML();
    }
    
    public function __call_edit() {
        global $get, $post, $out_html;
        
        if ( !isset($get['id']) ) { return 'need ID'; }
        
        if ( isset($post['adminLanguageJump']) ) { $ok = $this->jumpToNextString($get['id']); if ( $ok ) { $nextId = $this->getNextTransateId(); if ( $nextId ) { $out_html->redirect('?admin=language&funct=edit&id='.$nextId); } else { $out_html->redirect('?admin=language&funct=list'); } } }
        
        if ( isset($post['adminLanguageSave']) ) { $ok = $this->saveString($get['id']); if ( $ok ) { $out_html->redirect(TRUE); } }
        elseif ( isset($post['adminLanguageSaveAndNew']) ) { $ok = $this->saveString($get['id']); if ( $ok ) { $out_html->redirect('?admin=language&funct=new'); } }
        elseif ( isset($post['adminLanguageSaveAndNext']) ) { $ok = $this->saveString($get['id']); if ( $ok ) { $nextId = $this->getNextTransateId(); if ( $nextId ) { $out_html->redirect('?admin=language&funct=edit&id='.$nextId); } else { $out_html->redirect('?admin=language&funct=list'); } } }
        elseif ( isset($post['adminLanguageSaveAndExit']) ) { $ok = $this->saveString($get['id']); if ( $ok ) { $out_html->redirect('?admin=language&funct=list'); } }
        
        elseif ( isset($post['adminLanguageDelete']) ) { $ok = $this->deleteString($get['id']); if ( $ok ) { $out_html->redirect('?admin=language&funct=list'); } }
        
        return $this->edit_buildHTML($get['id']);
    }
}

return; ?>