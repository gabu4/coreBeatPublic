<?php
namespace module\admin\mediamanager\media;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function callMediaList_databaseGet($moduleName,$moduleID) {
        global $database;
        
        $database->newQuery();
        $database->select("`m`.*");
        $database->from("`#__media` `m`");
        
        if ( $moduleName !== NULL || $moduleID !== 0 && $moduleID > 0 || $moduleID === -1 ) {
            $database->join("right","`#__media_xref` `mx` ON `mx`.`media_id` = `m`.`id`");
//            $end .= " AND ( `acx`.`cat_id` = '".$currentCatId."' $parentD )";
//            $end .= " AND `acx`.`cat_id` IS NULL";
        }
        $database->wAndIsNotEqual("del","1","m");
        if ( $moduleName !== NULL ) { $database->wAndIsEqual("referer",$moduleName,"mx"); }
        if ( $moduleID !== 0 && $moduleID > 0 ) { $database->wAndIsEqual("referer_id",$moduleID,"mx"); }
        if ( $moduleID === -1 ) { $database->wAndIsNull("referer","mx"); }
        
        $database->orderDESC("id","m");
        $listData = $database->execute();
        
        return $listData;
    }
}

return; ?>