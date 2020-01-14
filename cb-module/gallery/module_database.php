<?php
namespace module\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 27/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    
    protected function getDbData_category($cat_id) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery_category');
        $database->where(' `id` = "'.$cat_id.'" AND `state` > "0" ');
        $database->qType('row');
        $d = $database->execute();
        
        if ( !empty($d) ) {
            return $d;
        } else {
            return Array();
        }
    }
    
    protected function getDbData($cat_id) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery');
        $database->where(' `cat_id` = "'.$cat_id.'" ');
        $database->order(' `order` ASC ');
        $database->qType('array');
        $d = $database->execute();
        
        if ( !empty($d) ) {
            return $d;
        } else {
            return Array();
        }
    }
    
    protected function getGaleriaRandomImg($cat_id, $limit) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery');
        $database->where(' `cat_id` = "'.$cat_id.'" ');
        $database->order(' rand() ');
        $database->limit($limit);
        $database->qType('array');
        $d = $database->execute();
        
        if ( !empty($d) ) {
            return $d;
        } else {
            return Array();
        }
    }
}

return; ?>
