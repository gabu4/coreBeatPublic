<?php
namespace module\contact\form;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 25/01/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_form($value) {
        global $post, $handler, $get, $lang, $out_html;
        
        if ( isset($get['admin']) ) {
            return "&#123;#MODULE,CONTACT,FORM,".$value."&#125;";
        }
        
        if ( !is_array($value) ) { $id = $value; } else { foreach ($value as $k=>$v) { if (!empty($v)) { $$k = $v; } } }
        
        if (
            isset($get['mod']) && $get['mod'] == 'article' &&
            isset($get['funct']) && $get['funct'] == 'article' &&
            isset($get['id']) && is_numeric($get['id']) 
            ) {
            $id = $get['id'];
            unset($get['mod']);unset($get['funct']);
        }
        
        
        $data['id'] = ( isset($id) ) ? $id : 1;
        $data['language'] = ( isset($language) ) ? $language : $lang->getLanguage();
        $data['class'] = ( isset($class) ) ? $class : '';
        $data['template'] = ( isset($template) && !empty($template) ) ? '_'.$template : '';
        
        $formData = $this->callForm_databaseGet($data);
        if ( empty($formData) ) { return ''; }
        
        if ( isset($_SESSION['cb_module_contact_msg']) ) {
            $data['msg'] = $_SESSION['cb_module_contact_msg'];
            unset($_SESSION['cb_module_contact_msg']);
        }
        
        if ( isset($post['sendContactForm__'.$data['id']]) ) {
            $error = $this->callMain_contactFormTest($formData,$post);
            if ( empty($error) ) {
                $r = $this->callMain_saveMessage($formData, $post);
                if ( !$r ) {
                    $handler->messageError('[LANG_CONTACT_FORM_MAIL_SEND_ERROR]',TRUE,'contactFormMessage');
                    cb_error_log('ERROR: Contact form, mail save error. ### '.implode(' | ',$formData).' ### '.implode(' | '.$post));
                    $out_html->redirect();
                }
                $r2 = $this->callMain_sendMail($formData, $post);
                if ( !$r2 ) {
                    global $mail2;
                    $text = "[LANG_CONTACT_FORM_MAIL_SEND_ERROR]" . ' ('.$mail2->errorInfo.')';
                    $handler->messageError($text,TRUE,'contactFormMessage');
                    $out_html->redirect();
                } else {
                    $_SESSION['cb_module_contact_msg'] = '<div class="alert alert-success" role="alert">[LANG_CONTACT_FORM_MAIL_SEND_SUCCESS]</div>';
                    $handler->messageSuccess('[LANG_CONTACT_FORM_MAIL_SEND_SUCCESS]',TRUE,'contactFormMessage');
                    $out_html->redirect();
                }
            } else {
                $handler->messageError('[LANG_CONTACT_FORM_ERROR_SOME_ERROR_IN_FIELDS]',TRUE,'contactFormMessage');
                $handler->textErrorForInput($error,TRUE,'contactFormMessage');
                $out_html->redirect();
            }
        }
        
        $html = $this->callForm_createForm($formData, $data, true);
        
        return $html;
    }
}

return; ?>