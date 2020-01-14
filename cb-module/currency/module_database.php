<?php
namespace module\currency;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 24/02/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    protected function convert_getDB($base, $vto, $oldIsGood = FALSE) {
        global $database;
        
        $time = time()-$this->refreshTime;
        $date = cb_time_to_date($time);
        
        $database->newQuery();
        $database->select(" `value` ");
        $database->from("`#__currency_value`");
        if ( $oldIsGood ) {
            $database->where(" `base` = '$base' AND `vto` = '$vto' ");
        } else {
            $database->where(" `base` = '$base' AND `vto` = '$vto' AND `refresh_date` > '$date' ");
        }
        $database->qtype("result");
        $data = $database->execute();
        
        if ( $data ) {
            return $data;
        } else {
            return FALSE;
        }
    }
    
    protected function convert_saveDB($base, $vto, $value) {
        global $database;
        
        $queryArray = array();
        $queryArray['base'] = $base;
        $queryArray['vto'] = $vto;
        $queryArray['value'] = $value;

        $r = $database->insertOrUpdate("#__currency_value",$queryArray);

        return $r;
    }
    
    protected function refreshCurrencyList_saveDB($data) {
        
        if ( empty($data) ) { $this->refreshCurrencyList_saveDb_truncate(); }
        
        global $database;
        
        foreach ( $data as $k=>$v ) {
            $queryArray = array();
            $queryArray['id'] = strtolower($v['id']);
            $queryArray['symbol'] = (isset($v['currencySymbol'])) ? $v['currencySymbol'] : "";
            $queryArray['name'] = $v['currencyName'];

            $r = $database->insertOrUpdate("#__currency_list",$queryArray);
            if ( !$r ) { cbd($v);return FALSE; }
        }
        
        return TRUE;
    }
    
    private function refreshCurrencyList_saveDb_truncate() {
        global $database;
        
        $database->doQuery("TRUNCATE `".CB_SQLPREF."currency_list` ");
    }
    
    protected function getCurrencyList_DB() {
        global $database;
        
        $database->newQuery();
        $database->select(" * ");
        $database->from("`#__currency_list`");
        $database->where(" 1 ");
        $database->qtype("array");
        $data = $database->execute();
        
        return $data;
    }
}

return; ?>
