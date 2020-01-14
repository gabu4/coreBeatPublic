<?php
namespace module\admin\language;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 12/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    protected function getListDatabase() {
        global $database, $get;
        
        $database->newQuery()
                ->select('*')
                ->from('#__language')
                ->orderDESC('id')
                ->qType('array');
        
        if ( isset($get['ft']) && !empty($get['ft']) ) {
            $database->wAndBracketStart();
            $database->wOrIsLikeP('constant',$get['ft']);
            $database->wOrIsLikeP('text',$get['ft']);
            $database->bracketEnd();
        }
        
        if ( isset($get['fl']) && !empty($get['fl']) ) { $database->wAndIsEqual('lang',$get['fl']); }
        if ( isset($get['fm']) && !empty($get['fm']) ) { $database->wAndIsEqual('module',$get['fm']); }
        if ( isset($get['fa']) && !empty($get['fa']) && ( $get['fa'] === '0' || $get['fa'] === '1' ) ) { $database->wAndIsEqual('is_admin',$get['fa']); }
        if ( isset($get['fd']) && !empty($get['fd']) && ( $get['fd'] === '0' || $get['fd'] === '1' ) ) { $database->wAndIsEqual('debugger_predicted',$get['fd']); }
        if ( isset($get['fn']) && !empty($get['fn']) && ( $get['fn'] === '0' || $get['fn'] === '1' ) ) { $database->wAndIsEqualOrBigger('translate_need',1); }
        
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
    
    protected function getData($id) {
        global $database;
        
        $database->newQuery()
                ->select('*')
                ->from('#__language')
                ->qType('row')
                ->wAndIsEqual('id',$id);
        
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
    
    protected function getDataLanguageVersions($is_admin,$module,$constant) {
        global $database;
        
        $database->newQuery()
                ->select('*')
                ->from('#__language')
                ->qType('array')
                ->wAndIsEqual('is_admin',$is_admin)
                ->wAndIsEqual('module',$module)
                ->wAndIsEqual('constant',$constant);
        
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
    
    protected function getNextTransateId() {
        global $database;
        
        $database->newQuery()
                ->sSelect('id')
                ->from('#__language')
                ->qType('result')
                ->wAndIsEqualOrBigger('translate_need',1)
                ->orderASC('translate_need')
                ->orderASC('id');
        
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
        
    protected function saveString_new(&$id,$data) {
        global $database;
        
        $text = str_replace(array("\r", "\n"), '', $data['text']);
        
        $insertData = Array(
            "lang" => $data['lang'],
            "is_admin" => $data['is_admin'],
            "module" => $data['module'],
            "constant" => $data['constant'],
            "text" => $text,
//            "tag" => $data['tag'],
            "debugger_predicted" => $data['debugger'],
            "translate_need" => $data['translate'],
//            "deprecated" => $data['deprecated'],
        );

        $res = $database->insertOrUpdate("#__language",$insertData);
        
        $id = $database->lqid();
        
        return $res;
    }
    
    protected function saveString_update($id, $data) {
        global $database;
        
        $text = str_replace(array("\r", "\n"), '', $data['text']);
        
        $insertData = Array(
            "id" => $id,
            "lang" => $data['lang'],
            "is_admin" => $data['is_admin'],
            "module" => $data['module'],
            "constant" => $data['constant'],
            "text" => $text,
//            "tag" => $data['tag'],
            "debugger_predicted" => $data['debugger'],
            "translate_need" => $data['translate'],
//            "deprecated" => $data['deprecated'],
        );

        $res = $database->insertOrUpdate("#__language",$insertData);
        
        return $res;
    }
    
    protected function deleteString_db($id) {
        global $database;
        
        $queryDeleteArray = array();
        $queryDeleteArray['id'] = $id;
        $res = $database->deleteFrom("#__language",$queryDeleteArray);
        
        return $res;
    }
    
    protected function jumpToNextString($id) {
        global $database;
        
        $data = $this->getData($id);
        $tn = (int) $data['translate_need'];
        if ( $tn === 0 ) { return TRUE; }
        $tn++;
        if ( $tn >= 10 ) { $tn = 9; }
        
        $insertData = Array(
            "id" => $id,
            "translate_need" => $tn
        );

        $res = $database->insertOrUpdate("#__language",$insertData);
        
        return $res;
    }
    
    
    
}

return; ?>
