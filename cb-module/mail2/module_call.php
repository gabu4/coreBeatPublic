<?php
namespace module\mail2;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 21/01/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    
    public function __call_main($rawValue) {
        return $this->__call_message_send($rawValue);
    }

    /*
     * $rawValue['template'] = 'email_template';
     * $rawValue['subject'] = 'subject';
     * $rawValue['subject_full'] = 'subject' (without site name);
     * $rawValue['from_email'] = 'email_address';
     * $rawValue['from_name'] = 'name';
     * $rawValue['target'] = array('email_address_1','email_address_2',...);
     * $rawValue['body'] = 'email_body_html';
     * $rawValue['body_replace'] = array('key'=>'replace_in_body_html');
     * $rawValue['website_name'] = 'website_name';
     * $rawValue['website_url'] = 'website_url';
     * 
     */
    public function __call_message_send($rawValue) {
        return $this->message_send($rawValue);
    }
}

return; ?>
