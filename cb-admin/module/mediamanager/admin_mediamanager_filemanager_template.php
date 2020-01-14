<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 18/11/18
 */
if ( !defined('H-KEI') ) { exit; }


$TEMPLATE['main'] = <<<HTML
<style>
                /* This contains the iframe and sets a new stacking context */
div#contframe {
    top: 80px;
    left: 40px;
    bottom: 25px;
    min-width: 200px;
    background: black; 
        /* DEBUG: If the iframe doesn't cover the whole space,
           it'll show through as black. */
}

    /* Position the iframe inside the new stacking context
       to take up the whole space */
div#contframe iframe {
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
}
    </style>
<div id="contframe">
    <iframe id="frame" src="cb-core/etc/fileman/index.html" frameborder="0" style="height:700px;"></iframe>
</div>
HTML;


return; ?>