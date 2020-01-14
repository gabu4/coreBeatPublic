<?php
namespace module\admin\admin\update;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 25/03/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_update() {
        global $post, $get;
        
        $this->__construct_update();
        
        if ( isset($get['version']) ) {
            $html = $this->call_update_to($get['version']);
        } else {
            $html = $this->call_update_page();
        }
        
        return $html;
    }
    
    public function __call_update_check() {
        
    }
}

return; ?>