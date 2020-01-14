<?php
namespace module\mail2;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 17/02/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    private $templatePath = CB_THEME . "/_template/email/";
    
    protected function message_send($data) {
        global $phpmailer, $lang, $theme;
        
        $date = date("Y-m-d H:i:s");
        
        $template = CB_MAIL_SABLON;
        if ( isset($data['template']) && !empty($data['template']) && $this->checkEmailTemplate($data['template']) ) { $template = $data['template']; }
        elseif ( isset($data['template']) && !empty($data['template']) && !$this->checkEmailTemplate($data['template']) ) { cb_error_log('MAIL plugin, Email sending WARNING: no exist template: '.$data['template']); }
        
        if ( !isset($data['target']) ) { cb_error_log('MAIL plugin, Email sending ERROR: no email target!');return FALSE; }
        $targetEmails = $data['target'];
        
        $phpmailer->clearReplyTos(); $phpmailer->clearAddresses(); foreach ( $targetEmails as $tEmail ) { $phpmailer->AddAddress($tEmail); }
        if ( isset($data['reply']) && !empty($data['reply']) ) { foreach ( $data['reply'] as $rEmail ) { $phpmailer->AddReplyTo($rEmail);  } }
        $from_email = CB_MAIL_FROM; $from_name = CB_MAIL_FROM_NAME;
        if ( isset($data['from_email']) && !empty($data['from_email']) ) { $from_email = $data['from_email']; }
        if ( isset($data['from_name']) && !empty($data['from_name']) ) { $from_name = $data['from_name']; }
        $phpmailer->SetFrom( $from_email , $from_name);
        
//        $bodyAlt = $theme->loadTemplate('account_email',$template.'_alt',FALSE,'mail');
        
        $subjectTitle = CB_SITETITLE;
        if ( isset($data['subject']) && !empty($data['subject']) ) { $subjectTitle .= " - ".$data['subject']; }
        if ( isset($data['subject_full']) && !empty($data['subject_full']) ) { $subjectTitle = $data['subject_full']; }
        
        $phpmailer->Subject = $lang->cb_lang_replace_in_text($subjectTitle);
        
        $replace = array();
        $replace['WEBSITE_NAME'] = CB_SITETITLE;
        $replace['WEBSITE_URL'] = CB_HTTPADDRESS;
        $replace['DATE'] = $date;
        $replace['SENDER_EMAIL'] = $from_email;
        $replace['SENDER_NAME'] = $from_name;
        $replace['SUBJECT'] = $subjectTitle;
        $replace['CONTENT'] = $data['body'];
        if ( !isset($data['body_alt']) || empty($data['body_alt']) ) { $data['body_alt'] = strip_tags($data['body']); }
        $replace['CONTENT_ALT'] = $data['body_alt'];
        
        $body = ""; $bodyAlt = "";
        $this->loadEmailTemplate($template,$body,$bodyAlt,$replace);
        
        //$theme->replace($replace,$body);
        //$theme->replace($replace,$bodyAlt);
        
        $replace2 = array();
        
        if ( isset($data['body_replace']) && !empty($data['body_replace']) ) {
            if ( !is_array($data['body_replace']) ) { cb_error_log('MAIL plugin, Email body_replace WARNING: body_replace is not array!'); }
            else {
                foreach ( $data['body_replace'] as $k=>$v ) { $replace2[strtoupper($k)] = $v; }
            }
        }
        
        $theme->mustache($replace2,$body);
        $theme->mustache($replace2,$bodyAlt);
        
        $phpmailer->Body = $lang->cb_lang_replace_in_text($body);
        $phpmailer->AltBody = $lang->cb_lang_replace_in_text($bodyAlt);
                
        if( !$phpmailer->Send() ) {
            global $mail2;
            $mail2->errorInfo = $phpmailer->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
    
    private function checkEmailTemplate($template) {
        $body = $this->templatePath.$template.'.mustache';
        $bodyAlt = $this->templatePath.$template.'_alt.mustache';
        if (!file_exists($body)) { return FALSE; }
        if (!file_exists($bodyAlt)) { return FALSE; }
        return TRUE;
    }
    
    private function loadEmailTemplate($template,&$body,&$bodyAlt,$replace=array()) {
        $templateLower = strtolower($template);
        
        $body = file_get_contents($this->templatePath.$templateLower.'.mustache');
        $bodyAlt = file_get_contents($this->templatePath.$templateLower.'_alt.mustache');
        
        global $theme;
        
        $theme->mustache($replace,$body);
        $theme->mustache($replace,$bodyAlt);
        
        return TRUE;
    }
}

return; ?>
