<?php
namespace module\admin\account\user;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v053
 * @date 28/10/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callMain_databaseGet($state,$filter_text) {
        global $database;

        $database->newQuery()
                        ->sSelectAll()
                        ->from("`#__user`")
                        ->orderASC("id")
                        ->qType("array");
        if ( $state === 'active' ) {
            $database->wAndIsEqual('state',1);
        } elseif ( $state === 'inactive' ) { 
            $database->wAndIsEqual('state',0);
        } elseif ( $state === 'inactivated' ) { 
            $database->wAndIsEqual('state',2);
        }
        if ( !empty($filter_text) ) {
            $database->wAndIsLikeP('email',$filter_text);
        }
        $listData = $database->execute();
        
        return $listData;
    }
    
    protected function getUserLevel_allData() {
        global $database;
        
        $result = $database->newQuery()
                        ->sSelectAll()
                        ->from("`#__user_level`")
                        ->qType("array")
                        ->execute();
        
        $r = array();
        foreach ( $result as $v ) {
            $r[$v['id']] = $v;
        }
        
        return $r;
    }
    
    protected function getUserLevel_data($level) {
        global $database;
        
        $result = $database->newQuery()
                        ->sSelect("id")
                        ->sSelect("name")
                        ->from("`#__user_level`")
                        ->wAndIsBigger("id","0")
                        ->wAndIsEqualOrSmaller("id",$level)
                        ->qType("array")
                        ->execute();
        
        return $result;
    }
    
    protected function getUserLevel_text($level) {
        global $database;
        
        
        $result = $database->newQuery()
                        ->sSelect("name")
                        ->from("`#__user_level`")
                        ->wAndIsEqual("id",$level)
                        ->qType("result")
                        ->execute();
        
        return $result;
    }
    
}

return; ?>