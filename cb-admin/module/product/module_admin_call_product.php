<?php
namespace module\admin\product\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 22/04/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_product_create() {
        $data = array();

        if ( $this->callProductCreate_checkPost($data) ) { $this->callProductCreate_savePost(); }
                
        $html = $this->callProductCreate_themeLoad($data);
        
        return $html;
    }
    
    public function __call_product_edit() {
        global $handler, $get;

        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            $product_id = $get['id'];
            
            $data = $this->productGetDatabaseData($product_id);
            
            if ( $this->callProductCreate_checkPost($data) ) { $this->callProductEdit_savePost(); }
            
            $html = $this->callProductCreate_themeLoad($data);
            
            return $html;
            
        } else {
            $handler->messageError('[ADMIN_MESSAGE_PRODUCT_ERROR_ID_NOT_EXIST]',true,"save");
            header("Location: ".CB_INDEX."?admin=product&funct=list");exit;
        }
    }
    
    public function __call_product_delete() {
        global $handler, $get;

        if ( !isset($get['id']) OR empty($get['id']) ) { 
            $handler->messageError('[ADMIN_MESSAGE_PRODUCT_PRODUCT_DELETE_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=product&funct=list");exit;
        }
        $id = $get['id'];
        
        $data = $this->callProductDelete_checkID($id);
        
        if ( !$data ) { 
            $handler->messageError('[ADMIN_MESSAGE_PRODUCT_PRODUCT_DELETE_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=product&funct=list");exit;
        }
        
        $this->callProductDelete_deletingProduct($data);
        
        $handler->messageSuccess('[ADMIN_MESSAGE_PRODUCT_PRODUCT_DELETE_SUCCESS_DELETE]',true,'delete');

        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
}

return; ?>