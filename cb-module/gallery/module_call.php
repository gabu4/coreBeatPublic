<?php
namespace module\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 23/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {

    public function __call_main($rawValue) {
        global $get;
        
        if ( !isset($get['admin']) ) {
            return $this->gallery($rawValue);
        } else {
            return "&#123;#MODULE,GALLERY,MAIN,".$rawValue."&#125;";
        }
    }

    public function __call_list($rawValue) {
        global $get;
        
        if ( !isset($get['admin']) ) {
            return $this->gallery_list($rawValue);
        } else {
            return "&#123;#MODULE,GALLERY,LIST,".$rawValue."&#125;";
        }
    }
}

return; ?>
