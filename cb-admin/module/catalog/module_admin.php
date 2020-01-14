<?php
namespace module\admin\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 16/11/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('catalog',TRUE);

$subModuleFile = Array("lists","catalog","importexport");

abstract class module {
    var $pageLimit = 200;
    var $pagePaginationMax = 15;
    
    var $catalogContentImagePathCSV = CB_ROOTDIR.'/'.CB_FILE."/catalogimg/";
    
    
    
    var $catalogContentImagePath = CB_ROOTDIR.'/'.CB_FILE."/catalog/content_image/";
    var $catalogContentImagePathHTML = CB_URI.CB_FILE."/catalog/content_image/";
    var $catalogContentImagePath_original = "original/";
    var $catalogContentImagePath_normal = "normal/";
    var $catalogContentImagePath_small = "small/";
}

return; ?>
