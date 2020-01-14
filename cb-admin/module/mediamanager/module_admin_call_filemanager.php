<?php
namespace module\admin\mediamanager\filemanager;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 16/11/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_filemanager() {
        $html = $this->filemanager();
        return $html;
    }
}

return; ?>