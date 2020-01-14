<?php
namespace module\admin\article\group;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function callGroupMain_databaseGet() {
        global $database, $lang;
        
        $l = $lang->getLanguage();
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article_category`");
        $database->wAndIsNotEqual('state','-1');
        $database->wAndIsEqual('lang',$l);
        $database->orderASC("id");
        $listData = $database->execute();
        
        return $listData;
    }
    
    protected function callGroupMain_count($id) {
        global $database;
        
        $database->newQuery();
        $database->select("count(`id`)");
        $database->from("`#__article_category_xref`");
        $database->where(" `cat_id` = '".$id."' ");
        $database->qType("result");
        $c = $database->execute();
        
        if ( !$c ) { return 0; }
        
        return (int) $c;
    }
}

return; ?>