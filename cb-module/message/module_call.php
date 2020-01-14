<?php
namespace module\message;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 25/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    function init() {
        $this->exMessages();
        $this->loadInit();
    }
    
    public function __call_main($value) {
        
    }

    public function __call_message($value) {
        $allowedType = ['success','info','warning','danger'];
        if ( !isset($value['message'])||empty($value['message']) ) { return FALSE; }
        $message = $value['message'];
        $title = (isset($value['title'])&&$value['time']!==NULL ? $value['title'] : '');
        $type = (isset($value['type'])&&in_array($value['type'],$allowedType) ? $value['type'] : 'info');
        $style = (isset($value['style'])&&$value['style']!==NULL ? $value['style'] : '');
        $show_time = (isset($value['time'])&&$value['time']!==NULL ? $value['time'] : CB_MESSAGE_SHOW_TIME);
        $valid = (isset($value['valid'])&&$value['valid']!==NULL ? $value['valid'] : '+1 minute');
        $multi_show = (isset($value['multi'])&&$value['multi']===TRUE ? 1 : 0);
        
        return $this->saveMessage($message,$title,$type,$style,$show_time,$valid,$multi_show);
    }
}

return; ?>
