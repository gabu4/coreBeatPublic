<?php
namespace module\message;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 02/11/19
 */
if ( !defined('H-KEI') ) { exit; }

cb_load_lang('message');

$subModuleFile = [];
$allowedRights = ['main'=>['message_success','message_info','message_warning','message_danger','message','ajax_load']];

abstract class module {
    
}

return; ?>
