<?php
namespace module\admin\catalog\importexport;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 21/11/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    public function __call_import() {
        global $post;
        
        $typ = "";
        if ( isset($post['csv_import_file']) ) {
            $isReplace = FALSE;
            if (isset($post['list_replace']) && $post['list_replace'] == '1'){$isReplace = TRUE;}
            $ok = $this->csvImport_saveFile($isReplace);
            if ( $ok ) { $typ = $post['typ']; }
        }
        
        $html = $this->import_html($typ);
        
        return $html;
    }
    
}

return; ?>