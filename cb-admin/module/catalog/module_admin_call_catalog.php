<?php
namespace module\admin\catalog\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_catalog_create() {
        $data = array();

        if ( $this->callCatalogCreate_checkPost($data) ) { $this->callCatalogCreate_savePost(); }
                
        $html = $this->callCatalogCreate_themeLoad($data);
        
        return $html;
    }
    
    public function __call_catalog_edit() {
        global $handler, $get;

        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            $catalog_id = $get['id'];
            
            $data = $this->catalogGetDatabaseData($catalog_id);
            
            if ( $this->callCatalogCreate_checkPost($data) ) { $this->callCatalogEdit_savePost(); }
            
            $html = $this->callCatalogCreate_themeLoad($data);
            
            return $html;
            
        } else {
            $handler->messageError('[ADMIN_MESSAGE_CATALOG_ERROR_ID_NOT_EXIST]',true,"save");
            header("Location: ".CB_INDEX."?admin=catalog&funct=list");exit;
        }
    }
    
    public function __call_catalog_delete() {
        global $handler, $get;

        if ( !isset($get['id']) OR empty($get['id']) ) {
            $handler->messageError('[ADMIN_MESSAGE_CATALOG_CATALOG_DELETE_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=catalog&funct=list");exit;
        }
        $id = $get['id'];
        
        $data = $this->callCatalogDelete_checkID($id);
        
        if ( !$data ) { 
            $handler->messageError('[ADMIN_MESSAGE_CATALOG_CATALOG_DELETE_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=catalog&funct=list");exit;
        }
        
        $this->callCatalogDelete_deletingCatalog($data);
        
        $handler->messageSuccess('[ADMIN_MESSAGE_CATALOG_CATALOG_DELETE_SUCCESS_DELETE]',true,'delete');

        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
}

return; ?>