<?php
namespace module\admin\article\article_preview;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 08/06/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_create_preview() {
        global $content, $is_ajax;

        if ( $is_ajax ) {
            $data = $this->articleGetDatabaseData($article_id);
            
            if ( $this->callCreate_checkPost($data) ) { $this->callEdit_savePost(); }
            
            $html = $this->callCreate_themeLoad($data);
            
            $content->printOutContent($html);
            
        } else {
            $content->printOutContent("error");
        }
    }

}

return; ?>