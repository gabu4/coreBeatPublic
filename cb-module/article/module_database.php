<?php
namespace module\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 23/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    
    protected function callArticle_databaseGet($contentData,$language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article`");
        $database->where("`article_id` = '".$contentData['id']."' AND `lang` = '".$language."' ");
        $database->qType("row");
        $articleData = $database->execute();
        
        return $articleData;
    }
    
    protected function callArticleCategory_dbCategoryArticleData($id, $language, int $limit = 20, $order = 'desc', int $page = 1) {
        global $database;
        
        $parentId = $this->getGroupData($id);

        $parentD = "";
        if ( !empty($parentId) ) {
            foreach ( $parentId as $p ) {
                $parentD .= " OR `acx`.`cat_id` = '".$p['cat_id']."' ";
            }
        }
                
        $end = "";
        $end .= " AND ( `acx`.`cat_id` = '".$id."' $parentD )";
        
        $database->newQuery();
        $database->select("`a`.*");
        $database->from("`#__article_category_xref` `acx`");
        $database->join("left","`#__article_category` `ac` ON `acx`.`cat_id` = `ac`.`cat_id`");
        $database->join("right","`#__article` `a` ON `acx`.`article_id` = `a`.`article_id` AND `a`.`lang` = `ac`.`lang`");
        $database->where("`ac`.`lang` = '".$language."' AND `ac`.`state` = '1' AND `a`.`state` = '1' $end");
        if ( strtolower($order) === 'desc' ) {
            $database->order("`a`.`cre_date` DESC ");
        } elseif ( strtolower($order) === 'asc') {
            $database->order("`a`.`cre_date` ASC ");
        } elseif (strtolower($order) === 'random'||strtolower($order) === 'rand') {
            $database->order("rand()");
            $database->limit($limit);
        }
        if ( !strtolower($order) === 'random' && !strtolower($order) === 'rand') {
            $limit_start = ( $page === 1 || $page === 0 ) ? 0 : ($page-1)*$limit;
            $database->limit($limit_start.",".$limit);
        }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getGroupData($currentCatId) {
        global $database;
        
        $database->newQuery();
        $database->select("`cat_id`");
        $database->from("`#__article_category`");
        $database->where("`parent` = '".$currentCatId."'");
        $database->group("`cat_id`");
        $database->qType("array");
        $extid = $database->execute();
                
        if ( !empty($extid) ) {
            return $extid;
        } else {
            return FALSE;
        }
    }
    
    protected function callArticleCategory_dbCategoryDatas($id, $language, $limit = NULL) {
        global $database;
        
        $parentId = $this->getGroupData($id);

        $parentD = "";
        if ( !empty($parentId) ) {
            foreach ( $parentId as $p ) {
                $parentD .= " OR `acx`.`cat_id` = '".$p['cat_id']."' ";
            }
        }
        
        $end = "";
        $end .= " AND ( `acx`.`cat_id` = '".$id."' $parentD )";
        
        $database->newQuery();
        $database->select("`a`.*");
        $database->from("`#__article_category_xref` `acx`");
        $database->join("left","`#__article_category` `ac` ON `acx`.`cat_id` = `ac`.`cat_id`");
        $database->where("`ac`.`lang` = '".$language."' AND `ac`.`state` = '1' $end");
        if ( $limit !== NULL ) {$database->limit($limit); }
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function callArticleCategory_dbCategoryData($id, $language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article_category` `ac`");
        $database->where("`ac`.`cat_id` = '".$id."' AND `ac`.`lang` = '".$language."' AND `ac`.`state` = '1' ");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getArticleCategories($article_id, $language) {
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
    
    protected function getArticleCategories_getBigest($article_id, $language) {
        global $database;
        
        $database->newQuery();
        $database->select("`ac`.*");
        $database->from("`#__article_category_xref` `acx`");
        $database->join("right","`#__article_category` `ac` ON `acx`.`cat_id` = `ac`.`cat_id`");
        $database->where("`acx`.`article_id` = '".$article_id."' AND `ac`.`lang` = '".$language."' AND `ac`.`state` = '1' AND `ac`.`parent` != '0' ");
        $database->order("`ac`.`order` ASC ");
        $database->limit("1");
        $database->qType("row");
        $data = $database->execute();
        
        if ( !empty($data) ) {
            return $data;
        } else {

            $database->newQuery();
            $database->select("`ac`.*");
            $database->from("`#__article_category_xref` `acx`");
            $database->join("right","`#__article_category` `ac` ON `acx`.`cat_id` = `ac`.`cat_id`");
            $database->where("`acx`.`article_id` = '".$article_id."' AND `ac`.`lang` = '".$language."' AND `ac`.`state` = '1' ");
            $database->order("`ac`.`order` ASC ");
            $database->limit("1");
            $database->qType("row");
            $data = $database->execute();
            
            if ( !empty($data) ) {
                return $data;
            }
        }
        return FALSE;
    }
		
}

return; ?>
