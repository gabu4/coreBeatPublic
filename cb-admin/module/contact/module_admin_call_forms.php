<?php
namespace module\admin\contact\forms;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 25/01/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_forms() {
        $dataList = $this->database_callForms_getList();
        
        $html = $this->funct_callForms_makeMainList($dataList);
        
        return $html;
    }
    
    public function __call_forms_create() {
        global $post, $get, $is_ajax;
        
        if ( $is_ajax && isset($get['ajax']) && $get['ajax'] == 'newrow' && isset($get['type']) ) { print $this->funct_callFormsCreate_makeNewRow($get['type'],true);exit; }
        
        $defData = array();
        $existRows = array();
        if ( isset($post['adminModuleFormsSave']) || isset($post['adminModuleFormsSaveAndExit']) ) {
            $this->funct_callFormsCreate_savePost_init($post);
            $defData = $post;
            $existRows = $post['field'];
        }
        
        $html = $this->funct_callFormsCreate_makeMainHTML($defData,$existRows);
        
        return $html;
    }
    
    public function __call_forms_edit() {
        global $post, $get, $is_ajax;
        
        if ( $is_ajax && isset($get['ajax']) && $get['ajax'] == 'newrow' && isset($get['type']) ) { print $this->funct_callFormsCreate_makeNewRow($get['type'],true);exit; }
        
        if ( !isset($get['id']) || !is_numeric($get['id']) || $get['id'] <= 0 ) { 
            global $handler;
            $handler->messageError('[ADMIN_MESSAGE_CONTACT_ERROR_ID_NOT_EXIST]',true,"save");
            header("Location: ".CB_INDEX."?admin=contact&funct=forms");exit;
        }
        
        $defData = $this->database_callFormsEdit_getData($get['id']);
        $existRows = json_decode($defData['field'],true);
        if ( isset($post['adminModuleFormsSave']) || isset($post['adminModuleFormsSaveAndExit']) ) {
            $this->funct_callFormsEdit_savePost_init($post);
            $defData = $post;
            $existRows = $post['field'];
        }
        
        $html = $this->funct_callFormsCreate_makeMainHTML($defData,$existRows);
        
        return $html;
    }
    
    public function __call_forms_delete() {
        global $handler, $get;

        if ( !isset($get['id']) OR empty($get['id']) ) { 
            $handler->messageError('[ADMIN_MESSAGE_CONTACT_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=contact&funct=forms");exit;
        }
        $id = $get['id'];
        
        $extid = $this->database_callFormsEdit_getData($id);
        
        if ( !$extid ) { 
            $handler->messageError('[ADMIN_MESSAGE_CONTACT_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=contact&funct=forms");exit;
        }
        
        $this->database_deleteForm($id);
        
        $handler->messageSuccess('A form sikeresen törölve!',true,'delete');

        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
}

return; ?>