<?php
namespace module\admin\account\permission;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v051
 * @date 22/02/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callPermission_databaseGet() {
        global $database;

        $database->newQuery();
        $database->select("*");
        $database->from("`#__user_level`");
        $database->order("`id` ASC");
        $listData = $database->execute();

        return $listData;
    }
    
    protected function callPermission_edit_getData($id) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("#__user_level");
        $database->where("`id` = '".$id."'");
        $database->queryType("row");
        $data = $database->execute();
        
        if ( empty($data) ) { $data = Array(); }
        
        return $data;
    }
    
    protected function callPermissionModuleList_user() {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("#__module");
        $database->where("`type` = 'USER'");
        $database->order("`module_name` ASC, `function` ASC");
        $database->queryType("array");
        $result = $database->execute();
        
        return $result;
    }
    
    protected function callPermissionModuleList_admin() {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("#__module");
        $database->where("`type` = 'ADMIN'");
        $database->order("`module_name` ASC, `function` ASC");
        $database->queryType("array");
        $result = $database->execute();
        
        return $result;
    }
    
    protected function updateUserLevelPermission($permission_id, $setup) {
        global $database;
        
        $updateData = Array(
            "id" => $permission_id,
            "setup" => $setup
        );

        $res = $database->updateTo("#__user_level",'id',$updateData);

        return $res;
    }
}

return; ?>