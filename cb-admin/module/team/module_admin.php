<?php
namespace module\admin\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('team',TRUE);

$subModuleFile = Array("user");

abstract class module {
    var $teamContentImagePath = CB_ROOTDIR.'/'.CB_FILE."/team/";
    var $teamContentImagePathHTML = CB_URI.CB_FILE."/team/";
    var $teamContentImagePath_original = "original/";
    var $teamContentImagePath_normal = "normal/";
    var $teamContentImagePath_small = "small/";
}

return; ?>
