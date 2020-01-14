<?php
namespace module\admin\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 08/06/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('article',TRUE);

$subModuleFile = Array("group","article","article_preview");

abstract class module {
    var $articleContentImagePath = CB_ROOTDIR.'/'.CB_FILE."/article/content_image/";
    var $articleContentImagePathHTML = CB_URI.CB_FILE."/article/content_image/";
    var $articleContentImagePath_original = "original/";
    var $articleContentImagePath_normal = "normal/";
    var $articleContentImagePath_small = "small/";
}

return; ?>
