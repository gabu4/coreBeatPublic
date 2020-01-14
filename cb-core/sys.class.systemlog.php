<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 30/10/19
 */
if ( !defined('H-KEI') ) { exit; }

if ( !function_exists('array_awr') ) { function array_awr(&$item, $key) {
    $notAllowKeysToSave = ['password'];

    $toDelete = FALSE;
    $keyLower = mb_strtolower($key);
    foreach ($notAllowKeysToSave as $v) {
        $vL = mb_strtolower($v);
        $vC = mb_strlen($vL);
        $keyLowerCutted = mb_substr($keyLower,0,$vC);
        if ( $vL === $keyLowerCutted ) { $toDelete = TRUE; }
    }
    if ( $toDelete ) {
        $item = "";
    } else {
        $item = htmlentities($item,ENT_QUOTES);
    }
} }

class systemlog {
    protected $moduleLog = ['module'=>'','function'=>'','settings'=>'','mpost'=>'','mget'=>''];
    protected $logDisable = FALSE;
    
    public function init() {
        $this->saveLogStatus();
    }
    
    public function saveLogStatus($redirect = NULL) {
        global $user, $lang, $server, $is_ajax, $is_api;
        
        $data = [];
        $data['uid'] = $user->cb_get_user_id();
        $data['grouplevel'] = $user->cb_get_user_level();
        $data['lang'] = $lang->getLanguage();
        $data['ip'] = $server['REMOTE_ADDR'];
        $data['session'] = $_SESSION['SID'];
        $data['page'] = CB_REQUEST_URI;
        $data['module'] = $this->getModuleLog()['module'];
        $data['function'] = $this->getModuleLog()['function'];
        $data['data'] = $this->getModuleLog()['settings'];
        $data['mpost'] = $this->getModuleLog()['mpost'];
        $data['mget'] = $this->getModuleLog()['mget'];
        $data['is_admin'] = ($user->cb_is_admin_territory()) ? 1 : 0;
        $data['is_ajax'] = ($is_ajax) ? 1 : 0;
        $data['is_api'] = ($is_api) ? 1 : 0;
        $data['redirect'] = $redirect;
        
        $r = $this->saveLogRow($data);
        //cb_error_log($database->lastQuery());
        return $r;
    }
    
    public function saveModuleLog($cModule = NULL, $cFunction = NULL, $cSettings = NULL) {
        global $post, $get;
        
        $post2 = $post;
        $get2 = $get;
        
        if (!empty($post2)) { array_walk_recursive($post2,'array_awr'); }
        if (!empty($get2)) { array_walk_recursive($get2,'array_awr'); }
        
        $this->moduleLog['module'] = $cModule;
        $this->moduleLog['function'] = $cFunction;
        $this->moduleLog['settings'] = json_encode($cSettings,JSON_UNESCAPED_UNICODE);
        $this->moduleLog['mpost'] = json_encode($post2,JSON_UNESCAPED_UNICODE);
        $this->moduleLog['mget'] = json_encode($get2,JSON_UNESCAPED_UNICODE);
    }
        
    public function getModuleLog() {
        return $this->moduleLog;
    }
    
    public function setLogDisable($state = TRUE) {
        if ($state === FALSE || $state === 0) { $state = FALSE; } else { $state = TRUE; }
        $this->logDisable = $state;
    }
    
    private function getLogDisableState() {
        return $this->logDisable;
    }
    
    public function saveLogRow($data) {
        global $database, $user, $lang, $server, $is_ajax, $is_api;
        
        $makeLog = FALSE;
        if ( isset($data['uid']) && !empty($data['uid']) && isset($data['module']) && $data['module'] === 'account' && isset($data['function']) && ( $data['function'] === 'login' || $data['function'] === 'logout') && ( CB_SAVELOG === 'detailed' || CB_SAVELOG === 'login' ) ) { $makeLog = TRUE; }
        elseif ($this->getLogDisableState() === FALSE && CB_SAVELOG === 'detailed') { $makeLog = TRUE; }
        if ( $makeLog === FALSE ) { return NULL; }
        
        $date_time = cb_time_to_date();
        
        $queryArray = [];
        $queryArray['uid'] = ( isset($data['uid']) ? $data['uid'] : $user->cb_get_user_id());
        $queryArray['grouplevel'] = ( isset($data['grouplevel']) ? $data['grouplevel'] : $user->cb_get_user_level());
        $queryArray['lang'] = ( isset($data['lang']) ? $data['lang'] : $lang->getLanguage());
        $queryArray['ip'] = ( isset($data['ip']) ? $data['ip'] : $server['REMOTE_ADDR']);
        $queryArray['session'] = ( isset($data['session']) ? $data['session'] : $_SESSION['SID']);
        $queryArray['page'] = ( isset($data['page']) ? $data['page'] : CB_REQUEST_URI);
        $queryArray['module'] = ( isset($data['module']) ? $data['module'] : $this->getModuleLog()['module']);
        $queryArray['function'] = ( isset($data['function']) ? $data['function'] : $this->getModuleLog()['function']);
        $queryArray['data'] = ( isset($data['data']) ? $data['data'] : $this->getModuleLog()['settings']);
        $queryArray['mpost'] = ( isset($data['mpost']) ? $data['mpost'] : $this->getModuleLog()['mpost']);
        $queryArray['mget'] = ( isset($data['mget']) ? $data['mget'] : $this->getModuleLog()['mget']);
        $queryArray['is_admin'] = ( isset($data['is_admin']) ? $data['is_admin'] : ($user->cb_is_admin_territory() ? 1 : 0));
        $queryArray['is_ajax'] = ( isset($data['is_ajax']) ? $data['is_ajax'] : ($is_ajax ? 1 : 0));
        $queryArray['is_api'] = ( isset($data['is_api']) ? $data['is_api'] : ($is_api ? 1 : 0));
        $queryArray['redirect'] = ( isset($data['redirect']) ? $data['redirect'] : "");
        $queryArray['date_time'] = $date_time;
        
        $r = $database->insertTo("#__system_log",$queryArray);
        //cb_error_log($database->lastQuery());
        return $r;
    }
}

return; ?>