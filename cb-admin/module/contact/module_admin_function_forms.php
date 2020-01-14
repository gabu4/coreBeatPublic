<?php
namespace module\admin\contact\forms;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    private $funct_callFormsCreate_makeMainHTML_dataPrefill = Array(
        "id" => "",
        "name" => "",
        "target_email" => "",
        "target_subject" => "",
        "form_class" => "",
        "exist_rows" => "",
        "send_text" => "",
        "state" => 1,
    );
    
    protected function funct_callForms_makeMainList($dataList) {
        global $theme, $admin_function;
        
        $replace = Array();
        $html = $theme->loadAdminTemplate('admin_contact_forms','list',TRUE,'contact');
        
        if ( empty($dataList) ) { 
            $replace['body'] = "<h2 class='text-center'>[ADMIN_TEXT_CONTACT_FORMS_CALL_EMPTY]</h2>";
        } else {
            $tableHead = Array(
                "[ADMIN_TEXT_ARTICLE_CALL_MAIN_ID]",
                "[ADMIN_TEXT_ARTICLE_CALL_MAIN_ARTICLENAME]",
                "[ADMIN_TEXT_ARTICLE_CALL_MAIN_ACTIVE]",
                "&nbsp;",
                "&nbsp;"
            );

            $tableBody = Array();$i = 0;

            foreach ( $dataList as $val ) {

                $tableBody[$i] = Array();

                $tableBody[$i][] = $val['id'];
                $tableBody[$i][] = $val['name'];
                $tableBody[$i][] = ( $val['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');

                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=contact&funct=forms_edit&id=".$val['id']."'>" . $admin_function->getIcon('edit') . "</a>";
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=contact&funct=forms_delete&id=".$val['id']."' onclick=\"javascript:return confirm('[ADMIN_TEXT_ARTICLE_CALL_DELETESURE]')\">" . $admin_function->getIcon('trash') . "</a>";

                $i++;
            }
            $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'article_main');
        }
        
        $theme->replace($replace, $html);
        
        return $html;
    }
    
    protected function funct_callFormsCreate_makeMainHTML($postData = array(),$existRows = array()) {
        global $theme;
        
        $prefillData = $this->funct_callFormsCreate_makeMainHTML_dataPrefill;
        foreach ( $prefillData as $k=>$v ) { $data[$k] = ( isset($postData[$k]) ) ? $postData[$k] : $v; }
        
        $html = $theme->loadAdminTemplate('admin_contact_forms','create',TRUE,'contact');
        
        $form_id = ( isset($data['id']) ) ? $data['id'] : 0;
        
        $replace = array();
        foreach ( $data as $k => $v ) { $replace[strtoupper($k)] = $v; }
        
        $replace['IFSTATE0'] = ( $data['state'] == '0' ) ? ' CHECKED' : '';
        $replace['IFSTATE1'] = ( $data['state'] == '1' ) ? ' CHECKED' : '';
        $replace['FORM_ID'] = $form_id;
        
        $field = "";
        if ( !empty($existRows) ) {
            foreach ( $existRows as $k=>$v ) {
                $field .= $this->funct_callFormsCreate_makeNewRow($v['type'],false,$v);
            }
        }
        $replace['EXIST_ROWS'] = $field;
        
        $theme->replace($replace, $html);
        
        return $html;
    }
    
    protected function funct_callFormsCreate_makeNewRow($type,$json = false,$data = array()) {
        global $theme;
        
        $rowType = "create_newrow_type_".$type;
        
        $html = $theme->loadAdminTemplate('admin_contact_forms',$rowType,TRUE,'contact');
        
        $replace = array();
        
        $i = time() . "_" . cb_generate_code();
        $replace['i'] = $i;
        $replace['FIELD_TITLE'] = ( isset($data['title']) ) ? $data['title'] : '';
        $replace['ID_NAME'] = ( isset($data['name']) ) ? '<div class="label label-default float-right float-right">'.$data['name'].'</div>' : '';
        $replace['FIELD_NAME'] = ( isset($data['name']) ) ? $data['name'] : '';
        $replace['FIELD_INFO'] = ( isset($data['info']) ) ? $data['info'] : '';
        $replace['FIELD_REQUIRED'] = ( isset($data['required']) ) ? ' CHECKED' : '';
        $replace['FIELD_SETUP'] = ( isset($data['setup']) ) ? $data['setup'] : '';
        $replace['FIELD_CLASS'] = ( isset($data['class']) ) ? $data['class'] : '';
        $replace['FIELD_FORMCOPY'] = ( isset($data['formcopy']) ) ? ' CHECKED' : '';
        $replace['FIELD_REPLYEMAIL'] = ( isset($data['replyemail']) ) ? ' CHECKED' : '';
        
        $theme->replace($replace,$html);
        
        if ( $json === true ) {
            $json = array();
            $json['html'] = $html;
            return json_encode($json);
        } else {
            return $html;
        }
    }
    
    /* Save Post (new) */
    protected function funct_callFormsCreate_savePost_init(&$post) {
        $error = $this->funct_callFormsCreate_testSavePost($post);
            
        if ( empty($error) ) {
            $post_id = $this->database_callFormsCreate_savePost($post);
            if ( $post_id ) { //success
                $this->funct_callFormsCreate_message_saveSuccess();
                if ( isset($post['adminModuleFormsSave']) ) {
                    header("Location: ".CB_INDEX."?admin=contact&funct=forms_edit&id=".$post_id);exit;
                } elseif ( isset($post['adminModuleFormsSaveAndExit']) ) {
                    header("Location: ".CB_INDEX."?admin=contact&funct=forms");exit;
                }
            } else {
                $this->funct_callFormsCreate_message_saveErrorInDB();
            }
        } else {
            $this->funct_callFormsCreate_message_saveError($error);
        }
    }

    private function funct_callFormsCreate_testSavePost(&$post) {
        $error = array();
        if ( !isset($post['name']) || empty($post['name']) ) { $error['name'] = '[ADMIN_TEXT_FORM_CREATE_ERROR_NAME_MUST_BE_FILL]'; }
        if ( !isset($post['target_email']) || empty($post['target_email']) ) { $error['target_email'] = '[ADMIN_TEXT_FORM_CREATE_ERROR_TARGET_EMAIL_MUST_BE_FILL]'; }
        if ( !isset($post['send_text']) || empty($post['send_text']) ) { $error['send_text'] = '[ADMIN_TEXT_FORM_CREATE_ERROR_SEND_TEXT_MUST_BE_FILL]'; }
        
        return $error;
    }
    
    private function funct_callFormsCreate_message_saveError($error) {
        global $handler;
        
        $handler->messageError('[ADMIN_TEXT_FORM_CREATE_ERROR_SOME_ERROR_IN_FIELDS]',FALSE,'contactModule');
        
        $handler->textErrorForInput($error,FALSE,'contactModule');
    }
    
    private function funct_callFormsCreate_message_saveErrorInDB() {
        global $handler;
        
        $handler->messageError('[ADMIN_TEXT_FORM_CREATE_ERROR_SOME_ERROR_IN_SAVE_DB] #ERROR-C01',FALSE,'contactModule');
    }
    
    private function funct_callFormsCreate_message_saveSuccess() {
        global $handler;
        
        $handler->messageSuccess('[ADMIN_TEXT_FORM_CREATE_SUCCESS_MESSAGE]',TRUE,'contactModule');
    }
    
    /* Save Post (edit) */
    protected function funct_callFormsEdit_savePost_init(&$post) {
        $error = $this->funct_callFormsCreate_testSavePost($post);
            
        if ( empty($error) ) {
            $post_id = $this->database_callFormsEdit_updatePost($post);
            if ( $post_id ) { //success
                $this->funct_callFormsCreate_message_updateSuccess();
                if ( isset($post['adminModuleFormsSave']) ) {
                    header("Location: ".CB_INDEX."?admin=contact&funct=forms_edit&id=".$post_id);exit;
                } elseif ( isset($post['adminModuleFormsSaveAndExit']) ) {
                    header("Location: ".CB_INDEX."?admin=contact&funct=forms");exit;
                }
            } else {
                $this->funct_callFormsCreate_message_saveErrorInDB();
            }
        } else {
            $this->funct_callFormsCreate_message_saveError($error);
        }
    }
    
    private function funct_callFormsCreate_message_updateSuccess() {
        global $handler;
        
        $handler->messageSuccess('[ADMIN_TEXT_FORM_EDIT_SUCCESS_MESSAGE]',TRUE,'contactModule');
    }
}

return; ?>