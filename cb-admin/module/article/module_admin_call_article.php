<?php
namespace module\admin\article\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_create() {
        $data = array();

        if ( $this->callCreate_checkPost($data) ) { $this->callCreate_savePost(); }
                
        $html = $this->callCreate_themeLoad($data);
        
        return $html;
    }
    
    public function __call_edit() {
        global $handler, $get;

        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            $article_id = $get['id'];
            
            $data = $this->articleGetDatabaseData($article_id);
            
            if ( $this->callCreate_checkPost($data) ) { $this->callEdit_savePost(); }
            
            $html = $this->callCreate_themeLoad($data);
            
            return $html;
            
        } else {
            $handler->messageError('[LANG_ADMIN_ARTICLE_MESSAGE_ERROR_ID_NOT_EXIST]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=main");
        }
    }

}

return; ?>