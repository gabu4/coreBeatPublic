<?php
namespace module\admin\product\lists;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 20/04/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callList_databaseGet($currentCatId = 0) {
        global $database, $lang;
        
        $database->newQuery();
        $database->select("ANY_VALUE(`p`.`id`) as `id`, ANY_VALUE(`p`.`product_id`) as `product_id`, ANY_VALUE(`p`.`sku`) as `sku`, ANY_VALUE(`p`.`state`) as `state`, ANY_VALUE(`p`.`lang`) as `lang`, ANY_VALUE(`p`.`name`) as `name`, ANY_VALUE(`p`.`cre_date`) as `cre_date`, ANY_VALUE(`p`.`mod_date`) as `mod_date`, ANY_VALUE(`p`.`media`) as `media`");
        $database->from("`#__product_product` `p`");
        $end = "";
        if ( $currentCatId != 0 && $currentCatId > 0 ) {
            $database->join("right","`#__product_category_xref` `pcx` ON `pcx`.`product_id` = `p`.`product_id`");
            $end .= " AND `pcx`.`cat_id` = '".$currentCatId."'";
        } else if ( $currentCatId == -1 ) {
            $database->join("left","`#__product_category_xref` `pcx` ON `p`.`product_id` = `pcx`.`product_id`");
            $end .= " AND `pcx`.`cat_id` IS NULL";
        }
        $languageFirst = TRUE;
        $end .= " AND ( "; 
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            if ( $languageFirst === TRUE ) {
                $languageFirst = FALSE;
            } else {
                $end .= " OR ";
            }
            $end .= " `p`.`lang` = '".$l."' ";
        }
        $end .= " ) ";
        
        $database->where(" `p`.`state` != '-1' ".$end);
        $database->group("`p`.`product_id`,`p`.`lang`");
        $database->order("`p`.`product_id` ASC");
        $listData = $database->execute();
        
        return $listData;
    }
    
    protected function callTrash_checkID($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`article_id`");
        $database->from("`#__article`");
        $database->where("`article_id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $extid = $database->execute();
        
        if ( !empty($extid) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    protected function callTrash_productToTrash($extid) {
        global $database;
        
      /*
        $updateQuery = array();
        $updateQuery['article_id'] = $extid;
        $updateQuery['state'] = '-1';
        $result = $database->updateTo('#__article','article_id');
        */
        
        //amíg nem készül el a "szemetes" addig törlésre kerül az amit a felhasználó törölne (nem csak inaktiválódik).. és nem állítható vissza!
        $queryDeleteArray = array();
        $queryDeleteArray['product_id'] = $extid;
        $result = $database->deleteFrom('#__product_product',$queryDeleteArray);
        
        if ( $result ) {
            $queryDeleteArray = array();
            $queryDeleteArray['product_id'] = $extid;
            $database->deleteFrom("#__product_category_xref",$queryDeleteArray);
        }
        
        return $result;
    }
    
    protected function productGetDatabaseData($product_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__product_product`");
        $database->where("`product_id` = '".$product_id."'");
        
        $database->qType("array");
        $data = $database->execute();
        
        $returnData = array();
        if ( !empty($data) ) {
            foreach ( $data as $v ) {
                foreach ( $v as $k=>$v2 ) {
                    $returnData[$k][$v['lang']] = $v2;
                }
            }
        }
        
        return $returnData;
    }
    
    protected function productGetDatabaseData2($product_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__product_product`");
        $database->where("`product_id` = '".$product_id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function productGetDatabaseDataFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__product_product`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getProductMediaValue($product_id) {
        global $database;
        $database->newQuery();
        $database->select("`media`");
        $database->from("`#__product_product`");
        $database->where("`product_id` = '".$product_id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $media = $database->execute();
        
        return json_decode($media, true);
    }
    
    protected function getProductMediaValueFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("`media`");
        $database->from("`#__product_product`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $media = $database->execute();
        
        return json_decode($media, true);
    }
}

return; ?>