<?php
namespace module\admin\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v020
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use group\database;
    use article\database;
    use article_preview\database;
    
    protected function callMain_databaseGet($currentCatId = 0) {
        global $database, $lang;
        
        $parentId = $this->getGroupData($currentCatId);

        $parentD = "";
        if ( !empty($parentId) ) {
            foreach ( $parentId as $p ) {
                $parentD .= " OR `acx`.`cat_id` = '".$p['cat_id']."' ";
            }
        }
        
        $database->newQuery();
        $database->select("ANY_VALUE(`a`.`id`) as `id`, ANY_VALUE(`a`.`article_id`) as `article_id`, ANY_VALUE(`a`.`state`) as `state`, ANY_VALUE(`a`.`lang`) as `lang`, ANY_VALUE(`a`.`name`) as `name`, ANY_VALUE(`a`.`version`) as `version`, ANY_VALUE(`a`.`date_create`) as `date_create`, ANY_VALUE(`a`.`date_mod`) as `date_mod`");
        $database->from("`#__article` `a`");
        $end = "";
        if ( $currentCatId != 0 && $currentCatId > 0 ) {
            
            $database->join("right","`#__article_category_xref` `acx` ON `acx`.`article_id` = `a`.`article_id`");
            $end .= " AND ( `acx`.`cat_id` = '".$currentCatId."' $parentD )";
            
        } else if ( $currentCatId == -1 ) {
            $database->join("left","`#__article_category_xref` `acx` ON `a`.`article_id` = `acx`.`article_id`");
            $end .= " AND `acx`.`cat_id` IS NULL";
        }
        $languageFirst = TRUE;
        $end .= " AND ( "; 
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            if ( $languageFirst === TRUE ) {
                $languageFirst = FALSE;
            } else {
                $end .= " OR ";
            }
            $end .= " `a`.`lang` = '".$l."' ";
        }
        $end .= " ) ";
        
        $database->where(" `a`.`state` != '-1' ".$end);
        $database->group("`a`.`article_id`,`a`.`lang`");
        $database->order("`a`.`article_id` ASC");
        $listData = $database->execute();
                
        return $listData;
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
    
    protected function callTrash_articleToTrash($extid,$toDelete=FALSE) {
        global $database;
        
        $result = FALSE;
        if ( $toDelete === FALSE ) {
            $updateQuery = array();
            $updateQuery['article_id'] = $extid;
            $updateQuery['state'] = '-1';
            $result = $database->updateTo('#__article','article_id',$updateQuery);
        } else if ( $toDelete === TRUE ) {
            $queryDeleteArray = array();
            $queryDeleteArray['article_id'] = $extid;
            $result = $database->deleteFrom('#__article',$queryDeleteArray);
            
            if ( $result ) {
                $queryDeleteArray = array();
                $queryDeleteArray['article_id'] = $extid;
                $database->deleteFrom("#__article_category_xref",$queryDeleteArray);
            }
        }
        
        return $result;
    }
    
    protected function articleGetDatabaseData($article_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article`");
        $database->where("`article_id` = '".$article_id."'");
        
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
    
    protected function articleGetDatabaseDataFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getArticleMediaValueFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("`media`");
        $database->from("`#__article`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $media = $database->execute();
        
        return json_decode($media, true);
    }
}

return; ?>
