<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 15/11/18
 */
if ( !defined('H-KEI') ) { exit; }

$database->newQuery();
$database->select('`key`, `value`');
$database->from('#__settings');
$database->where(' `auto_load` = "1" ');
$database->queryType('array');
$settings = $database->execute();

foreach ( $settings as $val ) {
	define('CB_'.strtoupper($val['key']),$val['value']);
}

unset($settings);

/**
 * Load specificed settings from a database settings table
 * @param string $settingsName key what is need
 * @param boolean $getArray return multiple value, if TRUE then $settingsName using<br>in mysql LIKE version allowed, etc. <i>key%</i><br>(default: FALSE)
 * @return array
 */
function cb_load_settings($settingsName = '', $getArray = FALSE) {
    global $database;
    
    if ( empty($settingsName) ) { return FALSE; }
    $key = mb_substr(trim(mb_strtolower($settingsName,'UTF8')), 0, 32,'UTF8');
    
    $array = array();
    
    $database->newQuery();
    $database->select('`key`, `value`');
    $database->from('#__settings');
    if ( $getArray ) {
        $database->where(' `key` LIKE "' . $key . '%" ');
        $database->queryType('array');
    } else {
        $database->where(' `key` LIKE "' . $key . '" ');
        $database->queryType('row');
    }
    $database->queryType('array');
    $result = $database->execute();
    
    if ( !empty($result) ) {
        if ( $getArray ) {
            foreach ($result as $value) {
                $array[$value['key']] = $array[$value['value']];
            }
        } else {
            $array = $result['value'];
        }
    }
    return $array;
}

/**
 * Load specificed app only settings from a database settings table
 * @param string $settingsName key what is need
 * @param boolean $getArray return multiple value, if TRUE then $settingsName using<br>in mysql LIKE version allowed, etc. <i>key%</i><br>(default: FALSE)
 * @return array
 */
function cb_load_settings_cache($settingsName = '', $getArray = FALSE) {
    global $database;
    
    if ( empty($settingsName) ) { return FALSE; }
    $key = mb_substr(trim(mb_strtolower($settingsName,'UTF8')), 0, 32,'UTF8');
    
    $array = [];
    
    $database->newQuery();
    $database->select('`key`, `value`');
    $database->from('#__settings_cache');
    if ( $getArray ) {
        $database->where(' `key` LIKE "' . $key . '%" ');
        $database->queryType('array');
    } else {
        $database->where(' `key` LIKE "' . $key . '" ');
        $database->queryType('row');
    }
    $result = $database->execute();
    
    if ( !empty($result) ) {
        if ( $getArray ) {
            foreach ($result as $value) {
                $array[$value['key']] = $array[$value['value']];
            }
        } else {
            $array = $result['value'];
        }
    }
    return $array;
}

/**
 * Save specificed app only settings from a database settings table
 * @param string $settingsName settings keyname
 * @param string $settingsValue settings value
 * @return boolean TRUE or FALSE
 */
function cb_save_settings_cache($settingsName = '', $settingsValue = '') {
    global $database;
    
    if ( empty($settingsName) ) { return FALSE; }
    $key = mb_substr(trim(mb_strtolower($settingsName,'UTF8')), 0, 32,'UTF8');
    
    $queryArray = [];
    $queryArray['key'] = $key;
    $queryArray['value'] = $settingsValue;
        
    return $database->insertOrUpdate("#__settings_cache",$queryArray);
}

return; ?>
