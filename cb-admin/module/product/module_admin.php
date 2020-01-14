<?php
namespace module\admin\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 20/04/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('product',TRUE);

$subModuleFile = Array("lists","product");

abstract class module {
    var $pageLimit = 200;
    var $pagePaginationMax = 15;
    
    var $productContentImagePath = CB_ROOTDIR.'/'.CB_FILE."/product/content_image/";
    var $productContentImagePathHTML = CB_URI.CB_FILE."/product/content_image/";
    var $productContentImagePath_original = "original/";
    var $productContentImagePath_normal = "normal/";
    var $productContentImagePath_small = "small/";
}

return; ?>
