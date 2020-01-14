<?php
namespace module_api\update;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 17/10/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function __call_api_main() {
        $this->api_update();
    }
    
}

return; ?>
