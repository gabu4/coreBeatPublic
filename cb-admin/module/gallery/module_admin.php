<?php
namespace module\admin\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 10/10/17
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('gallery',TRUE);

$subModuleFile = Array();

abstract class module {
    var $galleryPath = CB_FILE.'/gallery/';
    var $galleryThumbPath = CB_TEMP.'/gallery/';
}

return; ?>
