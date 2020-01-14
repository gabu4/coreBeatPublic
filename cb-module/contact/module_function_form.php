<?php
namespace module\contact\form;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 30/03/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    private $defaultTemplate = 'contact_form';
    private $reChapcha3_score = 0;
    
    protected function callForm_createForm($formData, $data) {
        global $theme;
        
        $template = $this->defaultTemplate.$data['template'];
        
        //cbd($data['template'],1);
        $html = $theme->loadTemplate2($template,TRUE,'contact');
        
        $fieldArray = json_decode($formData['field'],true);
        
        $field = $this->callForm_createForm_genField($fieldArray,$template);
        $replace = array();
        
        $replace['id'] = $formData['id'];
        $replace['form_id'] = $formData['id'];
        $replace['form_name'] = 'form_'.$formData['id'];
        $replace['name'] = $formData['name'];
        $replace['field'] = $field;
        $replace['class'] = $formData['form_class'] . ' ' .$data['class'];
        $replace['uri'] = CB_URI;
        $replace['msg'] = ( isset($data['msg']) ) ? $data['msg'] : "";
        $replace['button'] = "<input type='hidden' name='sendContactForm__" . $formData['id'] . "' value='1' /><button class='btn btn-default sendButton' type='submit' name='sendContactFormButton__" . $formData['id'] . "' value='" . $formData['id'] . "'>" . $formData['send_text'] . "</button>";
        $replace['recapcha'] = $this->callFrom_genRecapcha();
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
    
    private function callForm_createForm_genField($fieldArray,$template) {
        global $theme;
        
        $html = "";
        if ( empty($fieldArray) ) { return $html; }
        
        foreach ( $fieldArray as $v ) {
            
            $t = $template.'_type_'.$v['type'];
            if ( !$theme->checkTemplate2($t) ) { $t = $this->defaultTemplate.'_type_'.$v['type']; }
            $html2 = $theme->loadTemplate2($t,FALSE,'contact');
            $replace = array();
            $replace['name'] = ( isset($v['name']) ) ? $v['name'] : '';
            $replace['title'] = ( isset($v['title']) ) ? $v['title'] : '';
            $replace['info'] = ( isset($v['info']) ) ? $v['info'] : '';
            $replace['required'] = ( isset($v['required']) ) ? ' *' : '';
            $replace['class'] = ( isset($v['class']) ) ? $v['class'] : '';
            $replace['default_value'] = ( isset($v['default_value']) ) ? $v['default_value'] : '';
            
            $theme->mustache($replace,$html2);
            $html .= $html2;
        }
        
        return $html;
    }
    
    private function checkRecapcha3() {
        if ( ( defined('CB_GOOGLE_RECAPCHA3_KEY') && !empty(CB_GOOGLE_RECAPCHA3_KEY) ) && ( defined('CB_GOOGLE_RECAPCHA3_SECRET') && !empty(CB_GOOGLE_RECAPCHA3_SECRET) ) ) { return TRUE; } else { return FALSE; }
    }
    
    private function callFrom_genRecapcha() {
        $html = "";
        
        if ( !$this->checkRecapcha3() ) { return $html; }
        
        global $theme;
        
        $key = CB_GOOGLE_RECAPCHA3_KEY;
        $theme->addContentJs("https://www.google.com/recaptcha/api.js?render=$key");
        
        $js1 = <<<HTML
var formName = jQuery('form[name=form_connect]');
formName.submit(function() { 
    // we stoped it
    event.preventDefault();
    // needs for recaptacha ready
    grecaptcha.ready(function() {
        // do request for recaptcha token
        // response is promise with passed token
        grecaptcha.execute('$key', {action: 'contact_form'}).then(function(token) {
            // add token to form
            formName.prepend('<input type="hidden" name="token" value="' + token + '">');
            formName.prepend('<input type="hidden" name="action" value="create_comment">');
            // submit form now
            formName.unbind('submit').submit();
        });;
    });
});
HTML;
        $theme->addTextEndJs($js1);
        
        $html .= <<<HTML
<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
HTML;
        
        return $html;
    }
    
    private function validate_reCapcha() {
        if ( !$this->checkRecapcha3() ) { return TRUE; }
        
        global $post;
        
        $token = $post['token'];
        $action = $post['action'];
        $secret = CB_GOOGLE_RECAPCHA3_SECRET;

        if(isset($token) && !empty($token)){
            $verifyURL = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret) .  '&response=' . urlencode($token);
            //get verify response data
            $verifyResponse = file_get_contents($verifyURL);
            $responseData = json_decode($verifyResponse);

            if($responseData && $responseData->success && $responseData->action === $action) {
                $this->reChapcha3_score = $responseData->score;
                return TRUE;
            }

            // maybe check error codes in responseData here and return them.
        } else {
            return FALSE;
        }
    }
    
    protected function callMain_contactFormTest($formData,$data) {
        $returnArray = Array();
        
        $fieldArray = json_decode($formData['field'],true);
        foreach ( $fieldArray as $val ) {
            if ( isset($val['required']) && $val['required'] === '1' ) {
                if ( !isset($data[$val['name']]) || empty($data[$val['name']]) ) {
                    $returnArray[$val['name']] = '[LANG_CONTACT_FORM_ERROR_REQUIRED_PRE] '.$val['title'].' [LANG_CONTACT_FORM_ERROR_REQUIRED_AFTER]';
                }
            }
            if ( $val['type'] === '2' && ( cb_check_email_address($data[$val['name']]) !== true )) {
                $returnArray[$val['name']] = '[LANG_CONTACT_FORM_ERROR_REQUIRED_PRE] '.$val['title'].' [LANG_CONTACT_FORM_ERROR_EMAIL_NOT_VALID]';
            }
        }
        
        return $returnArray;
    }
    
    protected function callMain_sendMail($formData, $data) {
        global $mail2, $handler;
        $mail2->clean();
        $mail2->target($formData['target_email']);
        
        $fieldArray = json_decode($formData['field'],true);
        foreach ( $fieldArray as $val ) {
            if ( $val['type'] === '2' && isset($val['formcopy']) && $val['formcopy'] === '1' ) {
                $mail2->reply($data[$val['name']]);
            }
            if ( $val['type'] === '2' && isset($val['replyemail']) && $val['replyemail'] === '1' ) {
                $mail2->reply($data[$val['name']]);
            }
        }
        
        $subjectText = "";$subjectTextAlt = "";$subjectTitle = "";
        if ( !empty($formData['target_subject']) ) { 
            $subjectTitle .= $formData['target_subject'];
            $subjectText = "[LANG_CONTACT_FORM_ROW_SUBJECT]: ".$formData['target_subject']."<br />";
            $subjectTextAlt = "[LANG_CONTACT_FORM_ROW_SUBJECT]: ".$formData['target_subject']."\n";
        }
        
        $bodyText = "";$bodyTextAlt = "";
        foreach ( $fieldArray as $val ) {
            $bodyText .= $val['title'].': '.$data[$val['name']]."<br />";
            $bodyTextAlt .= $val['title'].': '.$data[$val['name']]."\n";
        }
                
        $mail2->body($subjectText.$bodyText);
        $mail2->body_alt($subjectTextAlt.$bodyTextAlt);
        
        //$mail2->body_replace($body_replace_array);
        $mail2->subject($subjectTitle);
        
        $mailSendingProcess = $mail2->send(TRUE);
        
        if( !$mailSendingProcess ) {
            return FALSE;
        }
        else {
            return TRUE;
        }
        
    }

}

return; ?>