<?php
namespace module\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 27/04/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('catalog');

$subModuleFile = Array();

abstract class module {
    var $catalogContentImagePath = CB_ROOTDIR.'/'.CB_FILE."/catalog/content_image/";
    var $catalogContentImagePathHTML = CB_URI.CB_FILE."/catalog/content_image/";
    var $catalogContentImagePath_original = "original/";
    var $catalogContentImagePath_normal = "normal/";
    var $catalogContentImagePath_small = "small/";
}

return; ?>
