<?php

/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 08/05/19
 */
if (!defined('H-KEI')) {
    exit;
}

function init() {
    global $theme, $out_html, $lang, $systemlog;

    $out_html->loadStart();
    
    $systemlog->init();
    
    $theme->loadPageTheme();
    
    $theme->buildPage();

    cb_load_lang('sys');
    $lang->cb_lang_start();
    
    $out = $theme->tempOut;
    
    return $out;
}

return;
?>
