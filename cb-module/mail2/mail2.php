<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 18/02/19
 */


class mail2 {
    private $temp = array();
    
    public function clean() { $this->temp = array(); return TRUE; }
    public function clean_target() { unset($this->temp['target']); return TRUE; }
    
    public function template($template) { $this->temp['template'] = trim($template); return TRUE; }
    public function subject($subject) { $this->temp['subject'] = trim($subject); return TRUE; }
    public function subject_full($subject) { $this->temp['full_subject'] = trim($subject); return TRUE; }
    public function from_email($from_email) { $this->temp['from_email'] = $from_email; return TRUE; }
    public function from_name($from_name) { $this->temp['from_name'] = $from_name; return TRUE; }
    public function target($target) {
        if(empty(trim($target))) { return FALSE; }
        if(!isset($this->temp['target'])){$this->temp['target']=array();}
        if(!is_array($target)) { 
            $this->temp['target'][] = trim($target); return TRUE; 
        } else {
            foreach($target as $t) { $this->temp['target'][] = trim($t); } return TRUE;
        }
    }
    public function reply($target) {
        if(empty(trim($target))) { return FALSE; }
        if(!isset($this->temp['reply'])){$this->temp['reply']=array();}
        if(!is_array($target)) { 
            $this->temp['reply'][] = trim($target); return TRUE; 
        } else {
            foreach($target as $t) { $this->temp['reply'][] = trim($t); } return TRUE;
        }
    }
    public function body($body) { $this->temp['body'] = $body; }
    public function body_alt($body_alt) { $this->temp['body_alt'] = $body_alt; }
    public function body_replace(array $body_replace) { $this->temp['body_replace'] = $body_replace; return TRUE; }
    public function website_name($website_name) { $this->temp['website_name'] = trim($website_name); return TRUE; }
    public function website_url($website_url) { $this->temp['website_url'] = trim($website_url); return TRUE; }
    
    
    public function send($reset = FALSE) {
        global $module;
        
        $r = $module->loadFunction('mail2','message_send',$this->temp);
        
        if ( $r ) {
            if ( $reset === TRUE ) { $this->temp = array(); }
        }
        return $r;
    }
    
    public $errorInfo;
}

global $mail2;
$mail2 = new mail2();

return; ?>
