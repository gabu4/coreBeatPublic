<?php
namespace module\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 30/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    
    protected function callMain_databaseGet($id,$language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__team`");
        $database->where("`team_id` = '".$id."' AND `lang` = '".$language."' ");
        $database->qType("row");
        $articleData = $database->execute();
        
        return $articleData;
    }
    
    protected function callTeamList_dbData($language) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__team` `t`");
        $database->where("`t`.`lang` = '".$language."' AND `t`.`state` = '1' ");
        $database->order("`t`.`short_order` ASC ");
        $database->qType("array");
        $data = $database->execute();
        
        return $data;
    }
}

return; ?>
