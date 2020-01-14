<?php
namespace module\account;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v018
 * @date 19/05/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    
    protected function dbSettingsSaveUserdata($data) {
        global $user;
        
        $account_id = $user->cb_get_user_id();
        
        $userDataExtraRaw = $user->cb_get_user_data_extra($user->cb_get_user_id());
        
        $userDataExtra = array();
        foreach( $userDataExtraRaw as $key=>$v ) {
            if ( isset($data[$key]) ) { $userDataExtra[$key] = $data[$key]; }
        }
        
        $return = $user->cb_update_user($account_id,NULL,NULL,$userDataExtra);
        
        return $return;
    }
    
    protected function dbSettingsSavePassword($account_id, $data) {
        global $user;
        
        $return = $user->cb_new_password($account_id,$data['new_password']);
        
        return $return;
    }
    
    protected function recoveryValidationWrite($account_id,$date,$code) {
        global $database, $user;
        
        if ( !empty($user->cb_get_user_id()) ) { return FALSE; }
        
        $updateData = Array(
                "id" => $account_id,
                "pass_reset_date" => $date,
                "pass_reset_code" => $code
        );
        
        $return = $database->updateTo("#__user","id",$updateData);
        
        return $return;
    }
    
    
    /* SOCIAL LOGINS */
    protected function saveCorebeatApiLogin($save) {
        global $database, $user;
                
        $database->newQuery();
        $database->select("*");
        $database->from("`#__user_sdk`");
        $database->where("`provider` = 'corebeat_api' AND `uid` = '".$save['uid']."'");
        $database->qType("row");
        $data = $database->execute();
        
        if ( !empty($data) ) {
            $updateData = Array(
                "uid" => $save['uid'],
                "provider" => $save['provider'],
                "token" => $save['token'],
                "first_name" => $save['first_name'],
                "last_name" => $save['last_name'],
                "email" => $save['email'],
                "picture" => $save['picture'],
                "link" => $save['link'],
                "data" => $save['data'],
                "modified" => date('Y-m-d H:i:s'),
            );
            
            $r = $database->updateTo("#__user_sdk","uid",$updateData);
            if ( $r ) {
                return $data['user_id'];
            } else {
                return FALSE;
            }
        }
        
        $user_id = $user->cb_get_user_id_from_email($save['email']);
        $level = json_decode($save['data'],TRUE)['level'];
        $dataExtra = array(
            'first_name' => $save['first_name'],
            'last_name' => $save['last_name'],
            'display_name' => $save['display_name']
        );
        if ( !$user_id ) {
            $user_id = $user->cb_create_user($save['email'],NULL,'corebeat_api',$dataExtra,1,$level);
            $user->cb_update_user($user_id);
        } else {
            $user->cb_update_user($user_id,$save['email'],NULL,$dataExtra,1,$level);
        }
        
        $insertData = Array(
            "uid" => $save['uid'],
            "provider" => $save['provider'],
            "token" => $save['token'],
            "first_name" => $save['first_name'],
            "last_name" => $save['last_name'],
            "email" => $save['email'],
            "picture" => $save['picture'],
            "link" => $save['link'],
            "created" => date('Y-m-d H:i:s'),
            "modified" => date('Y-m-d H:i:s'),
            "data" => $save['data'],
            "user_id" => $user_id,
        );
        
        $r = $database->insertTo("#__user_sdk",$insertData);
        if ( $r ) { 
            return $user_id;
        } else {
            return FALSE;
        }
    }
    
    protected function saveFacebookLogin($save) {
        global $database, $user;
                
        $database->newQuery();
        $database->select("*");
        $database->from("`#__user_sdk`");
        $database->where("`provider` = 'facebook' AND `uid` = '".$save['oauth_uid']."'");
        $database->qType("row");
        $data = $database->execute();
        
        if ( !empty($data) ) {
            $updateData = Array(
                "uid" => $save['oau_uid'],
                "provider" => $save['oauth_provider'],
                "token" => $save['oauth_token'],
                "first_name" => $save['first_name'],
                "last_name" => $save['last_name'],
                "email" => $save['email'],
                "picture" => $save['picture'],
                "link" => $save['link'],
                "modified" => date('Y-m-d H:i:s'),
            );
            
            $r = $database->updateTo("#__user_sdk","oauth_uid",$updateData);
            
            if ( $r ) {
                return $data['user_id'];
            } else {
                return FALSE;
            }
        }
        
        $user_id = $user->cb_get_user_id_from_email($save['email']);
        
        if ( !$user_id ) {
            $dataExtra = array(
                'first_name' => $save['first_name'],
                'last_name' => $save['last_name'],
                'display_name' => $save['display_name']
            );

            $user_id = $user->cb_create_user($save['email'],NULL,'facebook',$dataExtra,1);
        }
        
        $insertData = Array(
            "uid" => $save['oauth_uid'],
            "provider" => $save['oauth_provider'],
            "token" => $save['oauth_token'],
            "first_name" => $save['first_name'],
            "last_name" => $save['last_name'],
            "email" => $save['email'],
            "picture" => $save['picture'],
            "link" => $save['link'],
            "created" => date('Y-m-d H:i:s'),
            "modified" => date('Y-m-d H:i:s'),
            "user_id" => $user_id,
        );
        
        $r = $database->insertTo("#__user_sdk",$insertData);
        
        if ( $r ) { 
            return $user_id;
        } else {
            return FALSE;
        }
    }
    
    protected function saveGoogleLogin($save) {
        global $database, $user;
                
        $database->newQuery();
        $database->select("*");
        $database->from("`#__user_sdk`");
        $database->where("`provider` = 'google' AND `uid` = '".$save['oauth_uid']."'");
        $database->qType("row");
        $data = $database->execute();
        
        if ( !empty($data) ) {
            $updateData = Array(
                "uid" => $save['oauth_uid'],
                "provider" => $save['oauth_provider'],
                "token" => $save['oauth_token'],
                "first_name" => $save['first_name'],
                "last_name" => $save['last_name'],
                "email" => $save['email'],
                "picture" => $save['picture'],
                "link" => $save['link'],
                "modified" => date('Y-m-d H:i:s'),
            );
            
            $r = $database->updateTo("#__user_sdk","oauth_uid",$updateData);
            
            if ( $r ) {
                return $data['user_id'];
            } else {
                return FALSE;
            }
        }
        
        $user_id = $user->cb_get_user_id_from_email($save['email']);
        
        if ( !$user_id ) {
            $dataExtra = array(
                'first_name' => $save['first_name'],
                'last_name' => $save['last_name'],
                'display_name' => $save['display_name']
            );

            $user_id = $user->cb_create_user($save['email'],NULL,'google',$dataExtra,1);
        }
        
        $insertData = Array(
            "uid" => $save['oauth_uid'],
            "provider" => $save['oauth_provider'],
            "token" => $save['oauth_token'],
            "first_name" => $save['first_name'],
            "last_name" => $save['last_name'],
            "email" => $save['email'],
            "picture" => $save['picture'],
            "link" => $save['link'],
            "created" => date('Y-m-d H:i:s'),
            "modified" => date('Y-m-d H:i:s'),
            "user_id" => $user_id,
        );
        
        $r = $database->insertTo("#__user_sdk",$insertData);
        
        if ( $r ) { 
            return $user_id;
        } else {
            return FALSE;
        }
    }
    
}

return; ?>
