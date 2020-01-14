<?php
namespace module\admin\mediamanager\media;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_media_list() {
        $html = $this->callMediaList_themeLoad();
        return $html;
    }
    
    public function __call_media_details() {
        $html = $this->filemanager();
        return $html;
    }
    
    public function __call_media_ajaxview() {
        $html = $this->filemanager();
        return $html;
    }
    
    public function __call_media_add() {}
    public function __call_media_modify() {}
    public function __call_media_remove() {}
}

return; ?>