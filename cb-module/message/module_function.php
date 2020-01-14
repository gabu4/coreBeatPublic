<?php
namespace module\message;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 25/08/19
 */
if (!defined('H-KEI')) { exit; }

class funct extends database {
    
    protected function loadInit() {
        global $theme;
        
        $theme->addContentCss(CB_HTTPADDRESS.'/'.CB_CORE.'/etc/toastr/build/toastr.min.css');
        $theme->addContentEndJs(CB_HTTPADDRESS.'/'.CB_CORE.'/etc/toastr/build/toastr.min.js');
        
        $textJs = $theme->loadTemplateJs('message_options','message');
        
        $replace = [];
        $replace['position'] = CB_MESSAGE_POSITION;
        $replace['time'] = CB_MESSAGE_SHOW_TIME;
        $replace['refresh_time'] = CB_MESSAGE_REFRESH_TIME;
        
        $theme->replace($replace,$textJs); // valami "bug" miatt egy vegyes templatet tudtam csak csinálni, "korai oldalstátuszban" valamiért a mustache engine nem elérhető :(
        
        $theme->addTextEndJs($textJs);
        
    }
    
    protected function saveMessage($message,$title,$type,$style,$show_time,$valid,$multi_show) {
        global $user,$session;
        
        $user_id = $user->cb_get_user_id();
        $session_id = $session->getSessionId();
        
        $valid_time = cb_time_to_date(strtotime($valid,time()));
        
        return $this->saveMessageDB($user_id,$session_id,$title,$message,$type,$style,$show_time,$valid_time,$multi_show);
    }

    
    protected function exMessages() {
        global $is_ajax, $get, $user,$session, $out_html;
        
        $user_id = $user->cb_get_user_id();
        $session_id = $session->getSessionId();
        
        $out_array = [];
        
        if ( !$is_ajax ) { return; }
        if ( !isset($get['ticketsystem']) || $get['ticketsystem'] !== '1' ) { return; }
        if ( isset($get['mid']) && !empty($get['mid']) ) { $this->setMessageDelivered($get['mid'],$user_id,$session_id);$out_array['state'] = 'ok';$out_html->printOutAjaxContent($out_array); }
        
        $messages = $this->searchMessageDB($user_id,$session_id);
        
        $out_array['state'] = 'empty';
        if ( empty($messages) ) { $out_html->printOutAjaxContent($out_array); }
        
        $out_array['state'] = 'success';
        $out_array['messages'] = [];
        foreach ( $messages as $m ) {
            $out_array['messages'][] = [
                'mid'=>$m['id'],
                'title'=>( $m['title'] !== NULL ? $m['title'] : ''),
                'text'=>$m['message'],
                'type'=>$m['type'],
                'style'=>(!empty($m['style'])&&$m['style'] !== NULL ? $m['style'] : ''),
                'multi'=>$m['multishow'],
                'time'=>$m['time']
            ];
        }
        
        $out_html->printOutAjaxContent($out_array);
    }
}

return;
?>
