<?php
namespace module\slide;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 10/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
	
    function __construct() {
        $this->path = CB_FILE . '/slide/';
    }

    public function __call_main() {
        global $get;
        
        if ( !isset($get['admin']) ) {
            return $this->slide();
        } else {
            return "&#123;#MODULE,SLIDE,MAIN&#125;";
        }
    }

}

return; ?>
