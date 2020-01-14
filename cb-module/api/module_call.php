<?php
namespace module\api;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    use corebeat\call;
    use facebook\call;
    use google\call;
    
    public function __call_main() { return TRUE; }
}

return; ?>
