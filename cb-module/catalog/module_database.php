<?php
namespace module\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 20/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    
    protected function callMain_databaseGet($catalog_id,$language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__catalog`");
        $database->wAndIsEqual('catalog_id',$catalog_id);
        $database->wAndIsEqual('lang',$language);
        $database->qType("row");
        $articleData = $database->execute();
        
        return $articleData;
    }
    
    protected function callCatalogCategory_dbCategoryData($category_id, $language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__catalog_category` `cc`");
        if ($category_id !== 0) {$database->wAndIsEqual('category_id',$category_id,'cc');}
        $database->wAndIsEqual('lang',$language,'cc');
        $database->wAndIsEqual('state','1','cc');
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getCatalogCategories($catalog_id, $language) {
        global $database;
        
        $database->newQuery();
        $database->select("`cc`.*");
        $database->from("`#__catalog_category_xref` `ccx`");
        $database->join("right","`#__catalog_category` `cc` ON `ccx`.`category_id` = `cc`.`category_id`");
        $database->wAndIsEqual('catalog_id',$catalog_id,'ccx');
        $database->wAndIsEqual('lang',$language,'cc');
        $database->wAndIsEqual('state','1','cc');
        $database->order("`cc`.`order` ASC ");
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function callCatalogCategory_dbCategoryCatalogData($category_id, $language, $limit = NULL, $random = FALSE, $hiddedId = NULL, $proposer = NULL) {
        global $database;
        
        $database->newQuery();
        $database->select("`c`.*");
        $database->from("`#__catalog_category_xref` `ccx`");
        $database->join("left","`#__catalog_category` `cc` ON `ccx`.`category_id` = `cc`.`category_id`");
        $database->join("right","`#__catalog` `c` ON `ccx`.`catalog_id` = `c`.`catalog_id` AND `c`.`lang` = `cc`.`lang`");
        if ($category_id !== 0) {$database->wAndIsEqual('category_id',$category_id,'ccx');}
        $database->wAndIsEqual('lang',$language,'cc');
        $database->wAndIsEqual('state','1','cc');
        $database->wAndIsEqual('state','1','c');
        if($hiddedId!==NULL&&$hiddedId!=0&&is_numeric($hiddedId)){$database->wAndIsEqual('catalog_id',$hiddedId,'c');}
        if(!empty($proposer)&&is_array($proposer)){$database->wAndBracketStart();foreach($proposer as $proposer_id){$database->wAndIsEqual('catalog_id',$proposer_id,'c');}$database->bracketEnd();}
        elseif($proposer!==NULL&&$proposer!=0&&is_numeric($proposer)) {$database->wAndIsEqual('catalog_id',$proposer,'c');}
        $database->order("`c`.`short_order` ASC,`c`.`cre_date` ASC");
        $database->group("`c`.`catalog_id`");
        if($random===TRUE){$database->order("rand()");}
        if($limit!==NULL){$database->limit($limit);}
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    /*
    protected function callCatalogCategory_dbCategoryCatalogData_random($id, $language, $limit = NULL, $notShowId = NULL, $rec = NULL) {
        global $database;
        
        $and = "";
        if ( $notShowId != 0 && is_numeric($notShowId) ) {
            $and .= " AND `p`.`catalog_id` != '".$notShowId."' ";
        }
        
        $database->newQuery();
        $database->select("`p`.*");
        $database->from("`#__catalog_category_xref` `pcx`");
        $database->join("left","`#__catalog_category` `pc` ON `pcx`.`catategory_id` = `pc`.`catategory_id`");
        $database->join("right","`#__catalog` `p` ON `pcx`.`catalog_id` = `p`.`catalog_id` AND `p`.`lang` = `pc`.`lang`");
        $database->where("`pcx`.`catategory_id` = '".$id."' AND `pc`.`lang` = '".$language."' AND `pc`.`state` = '1' AND `p`.`state` = '1' ".$and);
        $database->order(" rand() ");
        if ( $limit !== NULL ) {$database->limit($limit); }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function callCatalogCategory_dbCategoryCatalogData_random_rec($id, $language, $limit, $notShowId, $rec) {
        global $database;
        
        $and = "";
        if ( $notShowId != 0 && is_numeric($notShowId) ) {
            $and .= " AND `p`.`catalog_id` != '".$notShowId."' ";
        }
        if ( !empty($rec) && is_array($rec) ) {
            $and .= " AND ( "; $ra = '';
            foreach ( $rec as $r ) {
                if ( !empty($ra) ) { $ra .= " OR "; }
                $ra .= " `p`.`catalog_id` = '$r' ";
            }
            $and .= $ra . " ) ";
        }
        
        $database->newQuery();
        $database->select("`p`.*");
        $database->from("`#__catalog_category_xref` `pcx`");
        $database->join("left","`#__catalog_category` `pc` ON `pcx`.`catategory_id` = `pc`.`catategory_id`");
        $database->join("right","`#__catalog` `p` ON `pcx`.`catalog_id` = `p`.`catalog_id` AND `p`.`lang` = `pc`.`lang`");
        $database->where("`pcx`.`catategory_id` = '".$id."' AND `pc`.`lang` = '".$language."' AND `pc`.`state` = '1' AND `p`.`state` = '1' ".$and);
        $database->order(" rand() ");
        if ( $limit !== NULL ) {$database->limit($limit); }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    */
}

return; ?>
