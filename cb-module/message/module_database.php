<?php
namespace module\message;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 25/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    protected function saveMessageDB($user_id,$session_id,$title,$message,$type,$style,$show_time,$valid_time,$multishow) {
        global $database;
        
        $queryArray1 = array();
        $queryArray1['user_id'] = $user_id;
        $queryArray1['session_id'] = $session_id;
        $queryArray1['title'] = $title;
        $queryArray1['message'] = $message;
        $queryArray1['type'] = $type;
        $queryArray1['style'] = $style;
        $queryArray1['time'] = $show_time;
        $queryArray1['valid_time'] = $valid_time;
        $queryArray1['multishow'] = $multishow;
        
        $checkResult1 = $database->insertTo("#__message",$queryArray1);
        
        if ( !$checkResult1 ) { return FALSE; }
        return TRUE;
    }
    
    protected function searchMessageDB($user_id,$session_id) {
        global $database;
        
        $this->searchMessageDB_archiveOld();
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__message`");
        $database->wAndBracketStart();
        if ( $user_id > 0 ) { $database->wOrIsEqual('user_id',$user_id); }
        $database->wOrIsEqual('session_id',$session_id);
        $database->bracketEnd();
        $database->wAndIsEqual('delivered','0');
        $database->wAndIsEqual('archive','0');
        $database->orderDesc("id");
        $database->qType('array');
        
        $tickets = $database->execute();
        
        foreach ( $tickets as $t ) {
            if ( $t['multishow'] !== '0' ) { continue; }
            $queryArray1['id'] = $t['id'];
            $queryArray1['delivered'] = '1';

            $checkResult1 = $database->updateTo("#__message",'id',$queryArray1);
            if ( !$checkResult1 ) { return FALSE; }
        }
        
        return $tickets;
    }
    
    protected function searchMessageDB_archiveOld() {
        global $database;
        
        $date = cb_time_to_date();
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__message`");
        $database->wAndIsSmaller('valid_time',$date);
        $database->wAndIsEqual('archive','0');
        $database->orderAsc("id");
        $database->qType('array');
        
        $tickets = $database->execute();
        
        if ( empty($tickets) ) { return TRUE; }
        
        foreach ( $tickets as $t ) {
            $queryArray1['id'] = $t['id'];
            $queryArray1['archive'] = '1';

            $checkResult1 = $database->updateTo("#__message",'id',$queryArray1);
            if ( !$checkResult1 ) { return FALSE; }
        }
        return TRUE;
    }
    
    protected function setMessageDelivered($id,$user_id,$session_id) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__message`");
        $database->wAndIsEqual('id',$id);
        $database->wAndBracketStart();
        $database->wOrIsEqual('user_id',$user_id);
        $database->wOrIsEqual('session_id',$session_id);
        $database->bracketEnd();
        $database->wAndIsEqual('delivered','0');
        $database->orderAsc("id");
        $database->qType('row');
        
        $t = $database->execute();
        
        if ( empty($t) ) { return TRUE; }
        
        $queryArray1['id'] = $t['id'];
        $queryArray1['delivered'] = '1';

        $checkResult1 = $database->updateTo("#__message",'id',$queryArray1);
        if ( !$checkResult1 ) { return FALSE; }
        
        return TRUE;
    }
}

return; ?>
