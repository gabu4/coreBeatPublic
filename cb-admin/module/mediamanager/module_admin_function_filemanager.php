<?php
namespace module\admin\mediamanager\filemanager;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 16/11/18
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    function filemanager() {
        global $theme;

        $html = $theme->loadAdminTemplate('admin_mediamanager_filemanager','main',TRUE,'mediamanager');

        return $html;
    }
}

return; ?>