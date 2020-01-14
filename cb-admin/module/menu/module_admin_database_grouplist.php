<?php
namespace module\admin\menu\grouplist;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v014
 * @date 10/10/17
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callGroupMain_dbGetData() {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__menu_category` `mcat`");
        $database->where("`mcat`.`state` != '-1' ");
        $database->group("`mcat`.`id`");
        $database->order("`mcat`.`id` ASC");
        return $database->execute();
    }
}

return; ?>