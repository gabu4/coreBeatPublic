<?php
namespace module\admin\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v018
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use user\database;
    
    protected function callMain_databaseGet() {
        global $database, $lang;
        
        $database->newQuery();
        $database->select("`t`.`id`, `t`.`team_id`, `t`.`name`, `t`.`lang`, `t`.`state`, `t`.`media`");
        $database->from("`#__team` `t`");
        $end = "";
        $languageFirst = TRUE;
        $end .= " AND ( "; 
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            if ( $languageFirst === TRUE ) {
                $languageFirst = FALSE;
            } else {
                $end .= " OR ";
            }
            $end .= " `t`.`lang` = '".$l."' ";
        }
        $end .= " ) ";
        
        $database->where(" `t`.`state` != '-1' ".$end);
        $database->group("`t`.`team_id`,`t`.`lang`");
        $database->order("`t`.`short_order` ASC,`t`.`team_id` ASC");
        $listData = $database->execute();
                
        return $listData;
    }
    
    
    protected function callTrash_checkID($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`team_id`");
        $database->from("`#__team`");
        $database->where("`team_id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $extid = $database->execute();
        
        if ( !empty($extid) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    protected function callTrash_teamToTrash($extid) {
        global $database;
        
        $queryDeleteArray = array();
        $queryDeleteArray['team_id'] = $extid;
        $result = $database->deleteFrom('#__team',$queryDeleteArray);
                
        return $result;
    }
    
    protected function teamGetDatabaseData($team_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__team`");
        $database->where("`team_id` = '".$team_id."'");        
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
    
    protected function teamGetDatabaseDataFromTeamId($team_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__team`");
        $database->where("`team_id` = '".$team_id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function teamGetDatabaseDataFromId($id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__team`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
    
    protected function getTeamMediaValueFromTeamId($team_id) {
        global $database;
        $database->newQuery();
        $database->select("`media`");
        $database->from("`#__team`");
        $database->where("`team_id` = '".$team_id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $media = $database->execute();
        
        return json_decode($media, true);
    }
}

return; ?>
