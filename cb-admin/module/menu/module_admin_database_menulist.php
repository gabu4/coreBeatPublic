<?php
namespace module\admin\menu\menulist;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v016
 * @date 17/04/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function callList_getMenuData($catid,$catlang) {
        global $database;
        
        $database->newQuery();
        $database->select("*,`m`.`id` as `m_id`,`c`.`id` as `c_id`,`ct`.`module` as `ct_module`,`ct`.`type` as `ct_type`");
        $database->from("`#__menu` `m`, `#__content` `c`, `#__content_type` `ct`");
        $database->where("`m`.`state` != '-1' AND `m`.`category` = '".$catid."' AND `m`.`content_id` = `c`.`id` AND `ct`.`id` = `c`.`type` AND `c`.`lang` = '".$catlang."' ");
        $database->order("`m`.`order` ASC, `m`.`id` ASC");
        return $database->execute();
    }
    
    protected function getPossibleContentTypeFromDB() {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__content_type` `ct`");
        $database->where("`ct`.`in_menu` = 1");
        $database->order("`ct`.`id` ASC");
        
        return $database->execute();
    }
    
    protected function callList_categoryListCreate_getData() {
        global $database;
        
        $database->newQuery();
        $database->select("`acat`.*");
        $database->from("`#__menu_category` `acat`");
        $database->where("`acat`.`state` > '0' ");
        $database->order("`acat`.`id` ASC");
        $categoryListData = $database->execute();
                
        return $categoryListData;
    }
}

return; ?>