<?php
namespace module\admin\menu\grouplist;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v014
 * @date 10/10/17
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_group_main() {
        $menuGroupListData = $this->callGroupMain_dbGetData();
        
        $html = $this->callGroupMain_createView($menuGroupListData);
        
        return $html;
    }
    
    //TOTO: menücsoport készítést megcsinálni!
    public function __call_group_create() {
        
    }
    
    //TOTO: menücsoport szerkesztést megcsinálni!
    public function __call_group_edit() {
        
    }
    
    //TOTO: menücsoport készítést megcsinálni!
    public function __call_group_trash_main() {
        
    }
    
    public function __call_group_trash() {
        global $get, $handler;
        
        if ( 
            !isset($get['catid']) ||
            empty($get['catid']) ) {
            
            return FALSE;
        } else {
            if ( 
                !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
                ) { 
                    
                print "A funckió ajax lekérése még nem készült el! :-(";
                
            } else {
                    
                $id = $get['catid'];
                $state = $this->group_trash_method($id);
                $handler->messageSuccess('A csoport sikeresen a lomtárba helyezve!',TRUE,'menuGroupDelete');

                header("Location: ".CB_INDEX."?admin=menu&funct=group_main");exit;
            }
                
        }
        
    }
}

return; ?>