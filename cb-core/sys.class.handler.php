<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v025
 * @date 02/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class handler {
		
    var $messageError = Array(); //hiba üzenetek tömbje
    var $messageSuccess = Array(); //sikeres üzenetek tömbje
    var $messageWarning = Array(); //figyelmeztető üzenetek tömbje

    var $messageBar = Array(); //messageBar üzenetek array tömbje
    var $textErrorForInput = Array(); //input mező hibakiírás array tömbje
    var $textForInputPrevText = Array(); //input mező előző üzenet visszatöltés tömb
    var $textForInputPrevTextBanList = Array('passw','password','passwordreply','password_repeat','pwd'); //input mező előző üzenet visszatöltés tömb tiltólista

    var $content404 = "";
    var $content403 = "";

    var $ifAjax = FALSE;

    function __construct() {
        $this->reqCheck();
        $this->clockDataOverSessionCount();
        $this->clockDataOverSessionTimed();
    }

    public function init() {
        $this->checkIfAjax();
        $this->savedMessage();
    }
    
    /** Korábban mentett üzenet visszatöltése $_SESSION-ból */
    private function savedMessage() {
        if ( isset($_SESSION['textErrorForInput']) AND !empty($_SESSION['textErrorForInput']) ) {
            $this->textErrorForInput = $_SESSION['textErrorForInput'];
            unset($_SESSION['textErrorForInput']);
        }
        if ( isset($_SESSION['textForInputPrevText']) AND !empty($_SESSION['textForInputPrevText']) ) {
            $this->textForInputPrevText = $_SESSION['textForInputPrevText'];
            unset($_SESSION['textForInputPrevText']);
        }
    }
	
    /** A felhasználó számára kiirandó sikeres üzenet megjelenítése
     * 
     * @param string $message megjelenítendő üzenet
     * @param boolean $toSession az üzenet megjelenítése (FALSE - a jelenlegi betöltéskor, TRUE - a következő oldalbetöltéskor)
     * @param string $style ki jeleníti meg az üzenetet
     */
    public function messageSuccess($message, $toSession = FALSE, $style = 'success') { $this->messageBar('success',NULL,$message,$style); }
    
    public function messageSuccess2($title=NULL,$message=NULL,$style='success',$time=NULL,$valid=NULL,$multi=FALSE,$device='',$user_id=0) { $this->messageBar('success',$title,$message,$style,$time,$valid,$multi,$device,$user_id); }
    
    public function messageInfo2($title=NULL,$message=NULL,$style='info',$time=NULL,$valid=NULL,$multi=FALSE,$device='',$user_id=0) { $this->messageBar('info',$title,$message,$style,$time,$valid,$multi,$device,$user_id); }
    
    /** A felhasználó számára kiirandó figyelmeztető üzenet megjelenítése
     * 
     * @param string $message megjelenítendő üzenet
     * @param boolean $toSession az üzenet megjelenítése (FALSE - a jelenlegi betöltéskor, TRUE - a következő oldalbetöltéskor)
     * @param string $style ki jeleníti meg az üzenetet
     */
    public function messageWarning($message, $toSession = FALSE, $style = 'warning') { $this->messageBar('warning',NULL,$message,$style); }
    
    public function messageWarning2($title=NULL,$message=NULL,$style='warning',$time=NULL,$valid=NULL,$multi=FALSE,$device='',$user_id=0) { $this->messageBar('warning',$title,$message,$style,$time,$valid,$multi,$device,$user_id); }
	
    /** A felhasználó számára kiirandó hiba üzenet megjelenítése
     * 
     * @param string $message megjelenítendő üzenet
     * @param boolean $toSession az üzenet megjelenítése (FALSE - a jelenlegi betöltéskor, TRUE - a következő oldalbetöltéskor)
     * @param string $style ki jeleníti meg az üzenetet
     */
    public function messageError($message, $toSession = FALSE, $style = 'danger') { $this->messageBar('danger',NULL,$message,$style);  }
    
    public function messageError2($title=NULL,$message=NULL,$style='danger',$time=NULL,$valid=NULL,$multi=FALSE,$device='',$user_id=0) { $this->messageBar('danger',$title,$message,$style,$time,$valid,$multi,$device,$user_id); }
    
    /** A felhasználó számára kiirandó üzenet megjelenítése
     * 
     * @param string $type success, warning, error (alap - success)
     * @param string $message megjelenítendő üzenet
     * @param boolean $toSession az üzenet megjelenítése (FALSE - a jelenlegi betöltéskor, TRUE - a következő oldalbetöltéskor)
     * @param string $class ki jeleníti meg az üzenetet
     */
    private function messageBar($type='success',$title=NULL,$message=NULL,$style=NULL,$time=NULL,$valid=NULL,$multi=FALSE,$device='',$user_id=0) {
        global $module_message;
        
        $v = [
            'type'=>$type,
            'title'=>$title,
            'message'=>$message,
            'style'=>$style,
            'time'=>$time,
            'valid'=>$valid,
            'multi'=>( $multi === TRUE ? TRUE : FALSE ),
            'device'=>$device,
            'user_id'=>$user_id
        ];
        
        return $module_message->__call_message($v);
    }
    
    private function checkIfAjax() {
        global $server;
        if(!empty($server['HTTP_X_REQUESTED_WITH']) && strtolower($server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->isAjax = TRUE;
        }
    }
    
    private function reqCheck() {
        global $server, $cookie, $post, $get, $env;

        $server = filter_input_array(INPUT_SERVER);
        $cookie = filter_input_array(INPUT_COOKIE);
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $env = filter_input_array(INPUT_ENV);
    }
    
    
    /** A felhasználó számára kiirandó üzenet, input mezőhöz hibakiírás
     * 
     * @param array $error a hibát tartalmazó tömb ( $array['kulcs'] = 'megjelenítendő üzenet' )
     * @param boolean $toSession az üzenet megjelenítése (FALSE - a jelenlegi betöltéskor, TRUE - a következő oldalbetöltéskor)
     * @param string $class ki jeleníti meg az üzenetet
     * @param string $oldPostData korábbi post üzenetek
     */
    public function textErrorForInput($error, $toSession = FALSE, $class = "",array $oldPostData = array()) {
        global $theme;
        if ( !empty($error) && is_array($error) ) {
            $theme->loadFontAwesome();
            foreach ( $error as $n=>$message ) {
                if ( $toSession === FALSE ) {
                    $this->textErrorForInput[$n]['message'] =  $message;
                    if ( !empty($class) ) { $this->textErrorForInput[$n]['class'] = $class; }
                } else if ( $toSession === TRUE ) {
                    $_SESSION['textErrorForInput'][$n]['message'] = $message;
                    if ( !empty($class) ) { $_SESSION['textErrorForInput'][$n]['class'] = $class; }
                }
            }
        }
        if ( !empty($oldPostData) && is_array($oldPostData) ) {
            foreach ( $oldPostData as $p=>$postdata ) {
                if ( !in_array($p,$this->textForInputPrevTextBanList) ) {
                    if ( $toSession === FALSE ) {
                        $this->textForInputPrevText[$p] = $postdata;
                    } else if ( $toSession === TRUE ) {
                        $_SESSION['textForInputPrevText'][$p] = $postdata;
                    }
                }
            }
        }
    }

    public function setDataOverSessionCount($module,$name,$data,$count=1){
        $_SESSION['dataOverSessionCount'][$module][$name]['data'] = $data;
        $_SESSION['dataOverSessionCount'][$module][$name]['count'] = (int) $count;
    }
    
    public function getDataOverSessionCount($module,$name) {
        if ( !isset($_SESSION['dataOverSessionCount'][$module][$name]) ) { return FALSE; }
        return $_SESSION['dataOverSessionCount'][$module][$name]['data'];
    }
    
    public function unsetDataOverSessionCount($module,$name) {
        if ( isset($_SESSION['dataOverSessionCount'][$module][$name]) ) { unset($_SESSION['dataOverSessionCount'][$module][$name]);return TRUE; }
        return FALSE;
    }
    
    private function clockDataOverSessionCount() {
        if ( !isset($_SESSION['dataOverSessionCount']) ) { return; }
        foreach ( $_SESSION['dataOverSessionCount'] as $module=>$m ) {
            if ( empty($m) ) { unset($_SESSION['dataOverSessionCount'][$module]);continue; }
            foreach ( $m as $name=>$n ) {
                if ( empty($m) ) { unset($_SESSION['dataOverSessionCount'][$module][$name]);continue; }
                $_SESSION['dataOverSessionCount'][$module][$name]['count']--;
                if ( $_SESSION['dataOverSessionCount'][$module][$name]['count'] < 0 ) {
                    unset($_SESSION['dataOverSessionCount'][$module][$name]);continue;
                }
            }
            if ( count($_SESSION['dataOverSessionCount'][$module]) === 0 ) { unset($_SESSION['dataOverSessionCount'][$module]); }
        }
        if ( count($_SESSION['dataOverSessionCount']) === 0 ) { unset($_SESSION['dataOverSessionCount']); }
        return;
    }

    public function setDataOverSessionTimed($module,$name,$data,$second=1){
        $_SESSION['dataOverSessionTimed'][$module][$name]['data'] = $data;
        $time = time() + $second;
        $_SESSION['dataOverSessionTimed'][$module][$name]['time'] = $time;
    }
    
    public function getDataOverSessionTimed($module,$name) {
        if ( !isset($_SESSION['dataOverSessionTimed'][$module][$name]) ) { return FALSE; }
        $time = time();
        if ( $time >= $_SESSION['dataOverSessionTimed'][$module][$name]['time'] ) { unset($_SESSION['dataOverSessionTimed'][$module][$name]);return FALSE; }
        return $_SESSION['dataOverSessionTimed'][$module][$name]['data'];
    }
    
    public function unsetDataOverSessionTimed($module,$name) {
        if ( isset($_SESSION['dataOverSessionTimed'][$module][$name]) ) { unset($_SESSION['dataOverSessionTimed'][$module][$name]);return TRUE; }
        return FALSE;
    }
    
    private function clockDataOverSessionTimed() {
        if ( !isset($_SESSION['dataOverSessionTimed']) ) { return; }
        foreach ( $_SESSION['dataOverSessionTimed'] as $module=>$m ) {
            if ( empty($m) ) { unset($_SESSION['dataOverSessionTimed'][$module]);continue; }
            foreach ( $m as $name=>$n ) {
                if ( empty($m) ) { unset($_SESSION['dataOverSessionTimed'][$module][$name]);continue; }
                $time = time();
                if ( $time >= $_SESSION['dataOverSessionTimed'][$module][$name]['time'] ) {
                    unset($_SESSION['dataOverSessionTimed'][$module][$name]);continue;
                }
            }
            if ( count($_SESSION['dataOverSessionTimed'][$module]) === 0 ) { unset($_SESSION['dataOverSessionTimed'][$module]); }
        }
        if ( count($_SESSION['dataOverSessionTimed']) === 0 ) { unset($_SESSION['dataOverSessionTimed']); }
        return;
    }
}

return; ?>
