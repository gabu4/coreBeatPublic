<?php
namespace module\admin\admin;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 10/05/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use settings\database;
    use support\database;
    use pagemenu\database;
    use sidemenu\database;
    use update\database;
    
    protected function getBreadcrumb_parents($mod,$funct) {
        global $database;
        
        $dataRow = [];
        $data = $database->newQuery()
                         ->sSelect("id")
                         ->sSelect("module_name")
                         ->sSelect("function")
                         ->sSelect("mainmenuparent")
                         ->sSelect("fa-icon")
                         ->from("`#__module`")
                         ->wAndIsEqual("type","ADMIN")
                         ->wAndIsEqual("module_name",$mod)
                         ->wAndIsEqual("function",$funct)
                         ->qType("row")
                         ->execute();
        
        if ( empty($data) ) { return FALSE; }
        
        $dataRow[] = $data;
        if ( $data['mainmenuparent'] !== '0' ) {
            for ( $i = 0; $i === 0 ; ) {
                $parentId = $data['mainmenuparent'];
                $data = $this->getBreadcrumb_parents_inside($parentId);
                if ( empty($data) ) { $i = 1; break; }
                $dataRow[] = $data;
                if ( $data['mainmenuparent'] === '0' || $parentId === $data['mainmenuparent'] ) { $i = 1; break; }
            }
        }
        
        return $dataRow;
    }
    
    private function getBreadcrumb_parents_inside($id) {
        global $database;
        $data = $database->newQuery()
                         ->sSelect("id")
                         ->sSelect("module_name")
                         ->sSelect("function")
                         ->sSelect("mainmenuparent")
                         ->sSelect("fa-icon")
                         ->from("`#__module`")
                         ->wAndIsEqual("type","ADMIN")
                         ->wAndIsEqual("id",$id)
                         ->qType("row")
                         ->execute();
        return $data;
    }
}

return; ?>
