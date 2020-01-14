<?php
namespace module\admin\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v014
 * @date 22/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use lists\database;
    use product\database;
    
    protected function callProductDelete_checkID($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`id`,`product_id`,`content_id`");
        $database->from("`#__product_product`");
        $database->where("`product_id` = '".$id."'");
        $database->qType("array");
        $result = $database->execute();
        
        if ( !empty($result) ) {
            return $result;
        } else {
            return FALSE;
        }
    }
    
    protected function callProductDelete_deletingProduct($data = array()) {
        global $database;
        
        if ( empty($data) ) { return FALSE; }
        foreach ( $data as $k ) {
            $content_id = $k['content_id'];
            $id = $k['id'];
            $product_id = $k['product_id'];
            
            $queryDeleteArray = array();
            $queryDeleteArray['id'] = $id;
            $result = $database->deleteFrom('#__product_product',$queryDeleteArray);
            
            if ( $result ) {
                if ( $content_id != 0 ) {
                    $queryDeleteArray = array();
                    $queryDeleteArray['id'] = $content_id;
                    $result = $database->deleteFrom('#__content',$queryDeleteArray);
                }
                
                $queryDeleteArray = array();
                $queryDeleteArray['product_id'] = $product_id;
                $database->deleteFrom("#__product_category_xref",$queryDeleteArray);
            }
        }
        
        return $result;
    }
}

return; ?>
