<?php
namespace module\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 04/06/18
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('team');

$subModuleFile = Array();

abstract class module {
    protected $teamContentImagePath = CB_ROOTDIR.'/'.CB_FILE."/team/";
    protected $teamContentImagePathHTML = CB_URI.CB_FILE."/team/";
    protected $teamContentImagePath_original = "original/";
    protected $teamContentImagePath_normal = "normal/";
    protected $teamContentImagePath_small = "small/";
    protected $facebookApi = array(
        "app_id"=>"1823024904423898",
        "app_secret"=>"c560c802a82dffbfe67ff1be72a7e2c6",
        "access_token"=>"",
        );
}

return; ?>
