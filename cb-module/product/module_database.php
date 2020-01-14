<?php
namespace module\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v016
 * @date 21/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    
    protected function callMain_databaseGet($contentData,$language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__product_product`");
        $database->where("`product_id` = '".$contentData['id']."' AND `lang` = '".$language."' ");
        $database->qType("row");
        $articleData = $database->execute();
        
        return $articleData;
    }
    
    protected function callProductCategory_dbCategoryData($id, $language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__product_category` `pc`");
        $database->where("`pc`.`cat_id` = '".$id."' AND `pc`.`lang` = '".$language."' AND `pc`.`state` = '1' ");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getProductCategories($article_id, $language) {
        global $database;
        
        $database->newQuery();
        $database->select("`ac`.*");
        $database->from("`#__article_category_xref` `acx`");
        $database->join("right","`#__article_category` `ac` ON `acx`.`cat_id` = `ac`.`cat_id`");
        $database->where("`acx`.`article_id` = '".$article_id."' AND `ac`.`lang` = '".$language."' AND `ac`.`state` = '1' ");
        $database->order("`ac`.`order` ASC ");
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function callProductCategory_dbCategoryProductData($id, $language, $limit = NULL) {
        global $database;
        
        $database->newQuery();
        $database->select("`p`.*");
        $database->from("`#__product_category_xref` `pcx`");
        $database->join("left","`#__product_category` `pc` ON `pcx`.`cat_id` = `pc`.`cat_id`");
        $database->join("right","`#__product_product` `p` ON `pcx`.`product_id` = `p`.`product_id` AND `p`.`lang` = `pc`.`lang`");
        $database->where("`pcx`.`cat_id` = '".$id."' AND `pc`.`lang` = '".$language."' AND `pc`.`state` = '1' AND `p`.`state` = '1' ");
        $database->order("`p`.`short_order` ASC,`p`.`cre_date` ASC ");
        if ( $limit !== NULL ) {$database->limit($limit); }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function callProductCategory_dbCategoryProductData_random($id, $language, $limit, $notShowId) {
        global $database;
        
        $and = "";
        if ( $notShowId != 0 && is_numeric($notShowId) ) {
            $and .= " AND `p`.`product_id` != '".$notShowId."' ";
        }
        
        $database->newQuery();
        $database->select("`p`.*");
        $database->from("`#__product_category_xref` `pcx`");
        $database->join("left","`#__product_category` `pc` ON `pcx`.`cat_id` = `pc`.`cat_id`");
        $database->join("right","`#__product_product` `p` ON `pcx`.`product_id` = `p`.`product_id` AND `p`.`lang` = `pc`.`lang`");
        $database->where("`pcx`.`cat_id` = '".$id."' AND `pc`.`lang` = '".$language."' AND `pc`.`state` = '1' AND `p`.`state` = '1' ".$and);
        $database->order(" rand() ");
        if ( $limit !== NULL ) {$database->limit($limit); }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function callProductCategory_dbCategoryProductData_random_rec($id, $language, $limit, $notShowId, $rec) {
        global $database;
        
        $and = "";
        if ( $notShowId != 0 && is_numeric($notShowId) ) {
            $and .= " AND `p`.`product_id` != '".$notShowId."' ";
        }
        if ( !empty($rec) && is_array($rec) ) {
            $and .= " AND ( "; $ra = '';
            foreach ( $rec as $r ) {
                if ( !empty($ra) ) { $ra .= " OR "; }
                $ra .= " `p`.`product_id` = '$r' ";
            }
            $and .= $ra . " ) ";
        }
        
        $database->newQuery();
        $database->select("`p`.*");
        $database->from("`#__product_category_xref` `pcx`");
        $database->join("left","`#__product_category` `pc` ON `pcx`.`cat_id` = `pc`.`cat_id`");
        $database->join("right","`#__product_product` `p` ON `pcx`.`product_id` = `p`.`product_id` AND `p`.`lang` = `pc`.`lang`");
        $database->where("`pcx`.`cat_id` = '".$id."' AND `pc`.`lang` = '".$language."' AND `pc`.`state` = '1' AND `p`.`state` = '1' ".$and);
        $database->order(" rand() ");
        if ( $limit !== NULL ) {$database->limit($limit); }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
}

return; ?>
