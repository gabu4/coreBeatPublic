<?php
namespace module\admin\admin\pagemenu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 11/11/17
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function db_get_adminmainpage_data() {
        global $database;
        
        $database->newQuery();
        $database->select("`id`, `module_name`, `function`, `fa-icon`");
        $database->from("`#__module`");
        $database->where("`type` = 'ADMIN' AND `mainpage` = '1' ");
        $database->order("`order` ASC, `module_name` ASC");
        $database->cache(TRUE);
        $data = $database->execute();
        
        return $data;
    }
    
    protected function db_get_adminmodulemenu_data($module_name,$module_function) {
        global $database;
        
        $data = array();
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__module`");
        $database->where("`type` = 'ADMIN' AND `module_name` = '$module_name' AND `function` = '$module_function' ");
        $database->limit("1");
        $database->queryType("result");
        $database->cache(TRUE);
        $parent_id = $database->execute();
        
        if ( !empty($parent_id) ) {
            $database->newQuery();
            $database->select("`id`, `module_name`, `function`, `fa-icon`");
            $database->from("`#__module`");
            $database->where("`type` = 'ADMIN' AND `mainpage` >= '1' AND `mainpageparent` = '$parent_id' ");
            $database->order("`order` ASC, `module_name` ASC");
            $database->cache(TRUE);
            $data = $database->execute();
        }
        
        return $data;
    }
}

return; ?>