<?php
namespace module\language;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 27/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {

    public function __call_main($rawValue) {
        
    }
    
    public function __call_selector($rawValue) {
        return $this->callSelector_buildHTML();
    }

}

return; ?>
