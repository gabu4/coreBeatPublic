<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 16/01/19
 */
if ( !defined('H-KEI') ) { exit; }

class seo_ext extends seo {
    
    protected function clean_name($name) {
        $name2 = mb_strtolower($name,'utf8');
        $nc0 = cb_remove_accent($name2);
        $nc1 = substr($nc0." ", 0, 63);
        $sp = strrpos($nc1, ' ', -1);

        $nc2 = substr($nc1, 0, $sp);

        return str_replace(Array(' ','/','\\'), Array('-','-','-'), $nc2);
    }
    
    protected function make_name($name,$language,$id,$prefix,$i = 0) {
        $name2 = $name;
        if ( $i !== 0 ) { $i++; $name2 = $name."-".$i++; }
        if ( $this->check_name($name2,$language,$id,$prefix) ) {
            return $name2;
        } else {
            return $this->make_name($name,$language,$id,$prefix,$i);
        }
    }
    
    protected function check_name($name, $language, $id = 0, $prefix = NULL) {
        global $database;
        
        $database->newQuery();
        $database->select("`s`.`id`");
        $database->from("`#__content_seo` `s`");
        $and = "";
        if ( $prefix !== NULL ) {
            $and .= " AND `s`.`name_prefix` = '".$prefix."' ";
        }
        $database->where(" `s`.`seo_name` = '".$name."' ".$and);
        $database->queryType('result');
        $fixedSeoID = $database->execute();
        if ( $fixedSeoID ) { return FALSE; }
        
        $database->newQuery();
        $database->select("`c`.`id`");
        $database->from("`#__content` `c`");
        $and = "";
        if ( $id !== 0 ) {
            $and .= " AND `c`.`id` != '".$id."' ";
        }
        if ( $prefix !== NULL ) {
            $and .= " AND `c`.`name_prefix` = '".$prefix."' ";
        }
        $database->where(" `c`.`seo_name` = '".$name."' AND `c`.`language` = '".$language."' ".$and);
        $database->queryType('result');
        $seoID = $database->execute();
        
        if ( !empty($seoID) ) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    protected function save($language,$name,$seoname,$prefix,$type,$value) {
        global $database;
        
        $valueJSON = json_encode($value);
        
        $queryArray = array();
        $queryArray['lang'] = $language;
        $queryArray['name'] = $name;
        $queryArray['seo_name'] = $seoname;
        $queryArray['name_prefix'] = $prefix;
        $queryArray['type'] = $type;
        $queryArray['value'] = $valueJSON;

        $t = $database->insertTo("#__content",$queryArray);
        if ( $t ) { return $database->lastQueryId(); }
        else { return FALSE; }
    }
    
    protected function update($id,$language,$name,$seoname,$prefix,$type,$value) {
        global $database;
        
        $valueJSON = json_encode($value);
        
        $queryArray = array();
        $queryArray['id'] = $id;
        $queryArray['lang'] = $language;
        $queryArray['name'] = $name;
        $queryArray['seo_name'] = $seoname;
        $queryArray['name_prefix'] = $prefix;
        $queryArray['type'] = $type;
        $queryArray['value'] = $valueJSON;

        $t = $database->updateTo("#__content",'id',$queryArray);
        if ( $t ) { return $id; }
        else { return FALSE; }
    }
    
    protected function get_from_id($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`s`.`seo_name`");
        $database->from("`#__content` `s`");
        $database->where(" `s`.`id` = '".$id."'");
        $database->queryType('result');
        $result = $database->execute();
        
        if ( !empty($result) ) {
            return $result;
        } else {
            return FALSE;
        }
    }
}

return; ?>