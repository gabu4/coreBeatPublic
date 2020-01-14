<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 25/09/19
 */
if ( !defined('H-KEI') ) { exit; }

function api_load_corebeat() {
    include_once('api/corebeat/database.php');
    include_once('api/corebeat/function.php');
    include_once('api/corebeat/call.php');
    global $api_corebeat;
    $api_corebeat = new \api\corebeat\call();
}

function api_load_facebook() {
    include_once('api/facebook/database.php');
    include_once('api/facebook/function.php');
    include_once('api/facebook/call.php');
    global $api_facebook;
    $api_facebook = new \api\facebook\call();
}

function api_load_google() {
    include_once('api/google/database.php');
    include_once('api/google/function.php');
    include_once('api/google/call.php');
    global $api_google;
    $api_google = new \api\google\call();
}

return; ?>