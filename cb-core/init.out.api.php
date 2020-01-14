<?php

/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 07/11/18
 */
if (!defined('H-KEI')) {
    exit;
}

function init() {
    global $out_api, $systemlog;

    $systemlog->init();
    
    $out_api->loadStart();
    
    //return $out_api->responseOut();
}

return;
?>
