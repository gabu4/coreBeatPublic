<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 31/08/19
 */
if (!defined('H-KEI')) { exit; }

class out_api {
    
    private $out = array();
    
    //inicializáció
    public function __construct() {
        global $lang;
        
        $lang->setLanguage(CB_LANGTYPE_USER_DEFAULT);
    }
    
    private function dataSet_byApiModule($method,&$mod,&$funct,&$request) {
        global $module;
        
        $mod = strtolower(trim($mod));
        $funct = strtolower(trim($funct));
        
        $this->contentData['module'] = $mod;
        $this->contentData['type'] = $funct;
        $this->contentData['value'] = $request;
        
        if ($module->cb_check_access($mod, $funct)) {
            return $module->loadFunction_api($this->contentData['module'], $this->contentData['type'], $this->contentData['value']);
        } elseif ($module->cb_check_access($mod, 'main')) {
            return $module->loadFunction_api($this->contentData['module'], 'main', $this->contentData['value']);
        } else {
            $this->responseOut(401,NULL,array(),array('UNAUTHORIZED'));
        }

        return FALSE;
    }

    public function loadStart() {
        // get the HTTP method, path and body of the request
        global $get, $post, $server;
        if ( !isset($server['REQUEST_METHOD']) ) { $this->responseOut(400,'NO_METHOD'); }
        $method = $server['REQUEST_METHOD'];
        $request = explode('/', trim($server['PATH_INFO'],'/'));
        if ( !isset($request[0]) ) { $this->responseOut(400,'NO_DATA'); }
        if ( !isset($request[1]) ) { $request[1] = 'main'; }
        $input = json_decode(file_get_contents('php://input'),true);
        
        if ( isset($server['HTTP_CBPOST']) && !empty($server['HTTP_CBPOST']) ) {
            $p = cb_is_json($server['HTTP_CBPOST'],TRUE);
            if ( is_array($p) ) { $post = $p; }
        }
        
        //$result = file_get_contents('www.othersite.com/salestracker/?clientID=12345&orderValue=19.99');
        
/*        $d = 'SERVER: '; foreach ($_SERVER as $k=>$v) { $d .= "[$k]:$v | "; } cb_error_log($d);
        $d = 'SESSION: '; foreach ($_SESSION as $k=>$v) { $d .= "[$k]:$v | "; } cb_error_log($d); */
        
        //$s = $this->detectRequestBody();
//        $vars = file_get_contents("php://input");
        //$s = http_get_request_body();
//        cbd( $input,0,1);
//        cbd( $s,0,1);
//       cbd( $_SERVER,1,1);
//        cbd( $vars,0,1);
//        cbd( $_POST,0,1);
//        cbd($method,1,1);
        
        if ( isset($get['t']) ) {
            global $post, $env, $server;
            
            cbd( $post,0,1);
            cbd( $env,0,1);
            cbd( $server,0,1);
            cbd( file_get_contents('php://input'),0,1 );
        }
        
        /*if ( $method === 'POST' ) {
            $this->responseOut(500,'ERROR_SERVER_GENERATE_TOKEN');
        } else*/if ( $method ===  'OPTIONS' ) {
            $this->responseOut_options();
        } else { 
            $this->dataSet_byApiModule($method,$request[0],$request[1],$request);
        }
    }
    
    public function responseOut($state,$msg = NULL,array $array_data = array(),array $identity_error = array(),array $viewstate_error = array()) {
        global $user, $session;
        
        http_response_code($state);
        $this->responseOut_headers();
        
        $token = $session->get_token();
        $token_life = $session->get_token_life();
        
        $array = array();
        
        $array['state'] = (int) $state;
        $u = $user->cb_get_user_id();
        if ( !empty($u) ) { $array['user_id'] = $u; }
        
        if ( !empty($msg) && $msg !== NULL ) { $array['cb_msg'] = $msg; }
        if ( !empty($array_data) ) { $array['data'] = $array_data; }
        if ( !empty($identity_error) ) { $array['identity_error'] = $identity_error; }
        if ( !empty($viewstate_error) ) { $array['viewstate_error'] = $viewstate_error; }
        if ( $token ) { $array['token'] = $token; }
        if ( $token_life ) { $array['token_life'] = $token_life; }
        
        $this->printOutAjaxContent($array);
    }
    
    private function responseOut_options() {
        http_response_code(200);
        $this->responseOut_headers();
        
        die();
    }
    
    private function responseOut_headers() {
        global $server;
        // Allow from any origin
        if (isset($server['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$server['HTTP_ORIGIN']}");
            header('Access-Control-Max-Age: -1');    // cache for 1 day (86400)
        }
        if ($server['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($server['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

            if (isset($server['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$server['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
        
        header("Content-Type: application/json; charset=UTF-8");
        header("Accept-Encoding:gzip,deflate,sdch");
    }
    
    
    public function printOutContent($content) {
        global $lang;
        
        echo $lang->cb_lang_replace_in_text($content);exit;
    }
    
    public function printOutAjaxContent($array) {
        global $lang;
        
        if ( !empty($array) && is_array($array) ) {
        
            $lang->cb_lang_start();
            
            $json = $lang->cb_lang_replace_in_text(json_encode($array));
            
            echo $json;exit;
        }
    }
}

return;
?>