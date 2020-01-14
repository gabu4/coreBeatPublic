<?php
namespace module\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('gallery');

$subModuleFile = Array();

abstract class module {
    var $galleryPath = CB_FILE.'/gallery/';
    var $galleryThumbPath = CB_TEMP.'/gallery/';
    
    var $imagePerPage = 300;
    var $thumbnailSizeW = 400;
    var $thumbnailSizeH = 400;
}

return; ?>
