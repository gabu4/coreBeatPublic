<?php
namespace module\admin\catalog\lists;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 20/11/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callList_databaseGet($current_category_id = 0) {
        global $database, $lang;
        
        $database->newQuery();
        $database->select("ANY_VALUE(`p`.`id`) as `id`, ANY_VALUE(`p`.`catalog_id`) as `catalog_id`, ANY_VALUE(`p`.`sku`) as `sku`, ANY_VALUE(`p`.`state`) as `state`, ANY_VALUE(`p`.`lang`) as `lang`, ANY_VALUE(`p`.`name`) as `name`, ANY_VALUE(`p`.`cre_date`) as `cre_date`, ANY_VALUE(`p`.`mod_date`) as `mod_date`, ANY_VALUE(`p`.`media`) as `media`");
        $database->from("`#__catalog` `p`");
        $end = "";
        if ( $current_category_id != 0 && $current_category_id > 0 ) {
            $database->join("right","`#__catalog_category_xref` `pcx` ON `pcx`.`catalog_id` = `p`.`catalog_id`");
            $end .= " AND `pcx`.`category_id` = '".$current_category_id."'";
        } else if ( $current_category_id == -1 ) {
            $database->join("left","`#__catalog_category_xref` `pcx` ON `p`.`catalog_id` = `pcx`.`catalog_id`");
            $end .= " AND `pcx`.`category_id` IS NULL";
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
        $database->group("`p`.`catalog_id`,`p`.`lang`");
        $database->order("`p`.`catalog_id` ASC");
        $listData = $database->execute();
                
        return $listData;
    }
    
    protected function callTrash_checkID($catalog_id) {
        global $database;
        
        $database->newQuery();
        $database->select("`catalog_id`");
        $database->from("`#__catalog`");
        $database->where("`catalog_id` = '".$catalog_id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $extid = $database->execute();
        
        if ( !empty($extid) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    protected function callTrash_catalogToTrash($extid) {
        global $database;
        
      /*
        $updateQuery = array();
        $updateQuery['article_id'] = $extid;
        $updateQuery['state'] = '-1';
        $result = $database->updateTo('#__article','article_id');
        */
        
        //amíg nem készül el a "szemetes" addig törlésre kerül az amit a felhasználó törölne (nem csak inaktiválódik).. és nem állítható vissza!
        $queryDeleteArray = array();
        $queryDeleteArray['catalog_id'] = $extid;
        $result = $database->deleteFrom('#__catalog',$queryDeleteArray);
        
        if ( $result ) {
            $queryDeleteArray = array();
            $queryDeleteArray['catalog_id'] = $extid;
            $database->deleteFrom("#__catalog_category_xref",$queryDeleteArray);
        }
        
        return $result;
    }
    
    protected function catalogGetDatabaseData($catalog_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__catalog`");
        $database->where("`catalog_id` = '".$catalog_id."'");
        
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
    
    protected function catalogGetDatabaseData2($catalog_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__catalog`");
        $database->where("`catalog_id` = '".$catalog_id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function catalogGetDatabaseDataFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__catalog`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getCatalogMediaValue($catalog_id) {
        global $database;
        $database->newQuery();
        $database->select("`media`");
        $database->from("`#__catalog`");
        $database->where("`catalog_id` = '".$catalog_id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $media = $database->execute();
        
        return json_decode($media, true);
    }
    
    protected function getCatalogMediaValueFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("`media`");
        $database->from("`#__catalog`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $media = $database->execute();
        
        return json_decode($media, true);
    }
}

return; ?>