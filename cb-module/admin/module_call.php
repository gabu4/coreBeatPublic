<?php
namespace module\admin;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 24/02/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function __call_main() { }
    
    public function __call_headerbar() { return $this->callHeaderbar(); }
    
}

return; ?>
