<?php
namespace module\admin\admin\settings;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 11/11/17
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function callSettings_dbSettings() {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__settings`");
        //$database->where("`show_in_admin` > 0");
        $database->where("1");
        $settingsData = $database->execute();
        
        return $settingsData;
    }
    
    protected function callSettings_saveDataToDB($saveData) {
        global $database;
        
        if ( empty($saveData) ) { return NULL; }
        $noError = TRUE;
        
        foreach ( $saveData as $k=>$v ) {
            $queryArray1 = array();
            $queryArray1['key'] = $k;
            $queryArray1['value'] = $v;
            
            $checkResult1 = $database->updateTo("#__settings",'key',$queryArray1);
            if ( !$checkResult1 ) { $noError = FALSE; }
        }
        
        return $noError;
    }
}

return; ?>