<?php
namespace module\admin\admin\sidemenu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 21/10/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function createSideMenu_getCurrentMenuId($name,$funct) {
        global $database;
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__module`");
        $database->wAndIsEqual('type','ADMIN');
        $database->wAndIsEqual('module_name',$name);
        $database->wAndIsEqual('function',$funct);
        $database->qtype("result");
        $database->cache(TRUE);
        
        $result = $database->execute();
        
        if ( !$result ) {
            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__module`");
            $database->wAndIsEqual('type','ADMIN');
            $database->wAndIsEqual('module_name',$name);
            $database->wAndIsEqual('function','main');
            $database->qtype("result");
            $database->cache(TRUE);
            
            $result = $database->execute();
        }
        
        return $result;
    }
    
    protected function createSideMenu_getCurrentMenuParentsId($parentId) {
        $array = [];
        $array[] = $parentId;
        
        $pid = $parentId;
        for ( ;; ) {
            $r = $this->createSideMenu_getCurrentMenuParentId($pid);
            if ( $r !== 0 && $r !== FALSE ) { $array[] = $r;$pid = $r; }
            else { break; }
        }
        
        return $array;
    }
    
    protected function createSideMenu_getCurrentMenuParentId($parentId) {
        global $database;
        
        $database->newQuery();
        $database->select("`mainmenuparent`");
        $database->from("`#__module`");
        $where = "`type` = 'ADMIN' AND `id` = '".$parentId."' ";
        $database->where($where);
        $database->qtype("int");
        $database->cache(TRUE);
        
        $result = $database->execute();
        
        return $result;
    }
    
    protected function createSideMenu_getData() {
        global $database;
        
        $database->newQuery();
        $database->select("`id`, `module_name`, `function`, `fa-icon`");
        $database->from("`#__module`");
        $where = "`type` = 'ADMIN' AND `mainmenuparent` = '0' ";
        $where .= " AND `mainmenu` >= '1' ";
        $database->where($where);
        $database->order("`order` ASC, `module_name` ASC");
        $database->cache(TRUE);
        
        $result = $database->execute();
        
        return $result;
    }
    
    protected function createSideMenu_submenu_getData($parentId) {
        global $database;
        
        $database->newQuery();
        $database->select("`id`, `module_name`, `function`, `fa-icon`");
        $database->from("`#__module`");
        $where = "`type` = 'ADMIN' AND `mainmenuparent` = '".$parentId."' ";
        $where .= " AND `mainmenu` >= '1' ";
        $database->where($where);
        $database->order("`order` ASC, `module_name` ASC");
        $database->cache(TRUE);
        
        $result = $database->execute();
        
        //cbd($database->lastQuery,1);
        //cbd($result);
        
        return $result;
    }
}

return; ?>