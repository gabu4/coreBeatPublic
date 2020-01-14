<?php
namespace module\admin\account\user;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v065
 * @date 22/12/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    var $userLevelName = array();
    
    protected function callMain_themeLoad() {
        global $theme, $user, $module, $admin_function, $get;
        
        $state = '';$allowedState = ['active','inactive','inactivated'];
        $filter_text = '';
        if ( isset($get['st']) && in_array($get['st'],$allowedState) ) { $state = $get['st']; }
        if ( isset($get['ft']) && !empty($get['ft']) ) { $filter_text = $get['ft']; }
        
        $listData = $this->callMain_databaseGet($state,$filter_text);
        $page = ( isset($get['page']) && is_numeric($get['page']) ? (int) $get['page'] : 1 );
        
        $html = $theme->loadAdminTemplateTwig('account_main', TRUE, 'account');
        $this->userLevelName = $this->getUserLevel_allData();
                
        $tableHead = Array(
            'nid'=>'[LANG_ADMIN_ACCOUNT_USER_HEADER_ID]',
            "&nbsp;",
            'email'=>'[LANG_ADMIN_ACCOUNT_USER_HEADER_NAME_EMAIL]',
            'state'=>'[LANG_ADMIN_ACCOUNT_USER_HEADER_STATE]',
            '[LANG_ADMIN_ACCOUNT_USER_HEADER_LEVEL]',
            "&nbsp;",
            "&nbsp;"
        );

        $tableBody = Array();
        $i = 0;
        foreach ($listData as $val) {
            //    $userData = $database->getSelect("row","*","user_data"," WHERE `id` = '".$val['id']."' ");

            $tableBody[$i] = Array();

            $tableBody[$i][] = $val['id'];
            $tableBody[$i][] = "<img src='".$user->cb_get_user_avatar($val['email'],32)."' alt='' />";
            
            $emailRow = "";
            $emailRow .= "<a data-sort='". cb_urlready_name($val['email'])."' href='?admin=account&funct=edit&id=" . $val['id'] . "'>".$val['email'].'</a>';
            $emailRow .= ( $user->cb_get_user_is_active_last_time($val['id']) ? " <span class='badge badge-success'>[LANG_ADMIN_ACCOUNT_CURRENTLY_LOGGED_IN]</span>" : '' );
            $tableBody[$i][] = $emailRow;
            $tableBody[$i][] = ( $val['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
            //$tableBody[$i][] = "<a href='?admin=account&funct=details&id=" . $val['id'] . "'>" . $admin_function->getIcon('view') . "</a>";
            $tableBody[$i][] = $this->userLevelName[$val['level']]['name'];
            
            $r = "";
            if ( (int)$val['level'] <= $user->cb_get_user_level() ) {
                $r .= " <a href='?admin=account&funct=edit&id=" . $val['id'] . "'>" . $admin_function->getIcon('edit') . "</a>";
            }
            if ( $module->cb_check_access('account','details','admin') ) {
                $r .= " <a href='?admin=account&funct=details&id=" . $val['id'] . "'>" . $admin_function->getIcon('about') . "</a>";
            }
            
            $tableBody[$i][] = ( empty($r) ) ? '&nbsp;' : $r;
            if (    (int)$val['level'] <= $user->cb_get_user_level() && 
                    (int)$val['id'] !== $user->cb_get_user_id() && (int)$val['id'] !== 1 &&
                    $module->cb_check_access('account','delete','admin')
                    ) {
                $tableBody[$i][] = "<a href='?admin=account&funct=delete&id=" . $val['id'] . "' onclick=\"javascript:return confirm('Biztos, hogy törli a felhasználót?\\nNem tudja majd visszaállítani!')\">" . $admin_function->getIcon('trash') . "</a>";
            } else {
                $tableBody[$i][] = '&nbsp;';
            }

            $i++;
        }

        $replace = Array();
        $replace['body'] = $table = $admin_function->listGenerate2($tableHead, $tableBody, 'account_main', NULL, 25, $page);
        $replace['state'] = $state;
        $replace['filter_text'] = $filter_text;

        $theme->replaceTwig($replace, $html);

        return $html;
    }
    
/* User Create&Edit */
    
    protected function callCreate_checkPost($edit = FALSE, $account_id = 0) {
        global $post, $handler;
        if ( 
            isset($post['adminModuleAccountSave']) OR
            isset($post['adminModuleAccountSaveAndExit'])
            ) {
               $ret = $this->callCreate_checkPost_test($post, $edit, $account_id);
                if ( !empty($ret) ){
                    foreach ($ret as $v) {
                        $handler->messageError2('',$v);
                    }
                    return false;
                }
            return true;
        }
        return false;
    }
    
    private function callCreate_checkPost_test($post, $edit, $account_id) {
        global $user;
        $RET = Array();

        if (!isset($post['email']) OR empty($post['email']) OR ( cb_check_email_address($post['email']) === false )) {
            $RET['email'] = "[LANG_ADMIN_ACCOUNT_USER_EMPTY_OR_INVAILD_EMAIL]";
        }
        
        $emailCheck = $user->cb_check_email_exist($post['email'],$account_id);
        if ( $emailCheck == TRUE ) {
            $RET['email'] = "[LANG_ADMIN_ACCOUNT_USER_EMAIL_IS_ALREADY_USED]";
        }
        
        if ( $edit === TRUE && empty($post['pass']) ) { return $RET; }
        
        if ( $edit === FALSE && empty($post['pass']) ) {
            $RET['pass'] = "[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_MUST_FILLED]";
        } elseif ( !empty($post['pass']) && !cb_password_strength($post['pass']) ) {
            $RET['pass'] = "[LANG_ADMIN_ACCOUNT_USER_THE_PASSWORD_TO_WEAK]";
        }
        
        return $RET;
    }
    
    protected function callCreate_savePost($account_id = 0) {
        global $post;
        
        if ( isset($post['adminModuleAccountSave']) ) {
            $this->callCreate_savePost_save($account_id);
        } else if ( isset($post['adminModuleAccountSaveAndExit']) ) {
            $this->callCreate_savePost_saveAndExit($account_id);
        }
    }
    
    private function callCreate_savePost_save($account_id = 0) {
        global $handler;
        
        if ( $account_id === 0 ) {
        $account_id = $this->callCreate_savePost_asNew();
        } else {
            $account_id = $this->callCreate_savePost_update($account_id);
        }
        
        if ( $account_id ) {
            $handler->messageSuccess2('','[LANG_ADMIN_ACCOUNT_SAVE_SUCCESS]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=edit&id=".$account_id);
        } else {
            $handler->messageError2('','[LANG_ADMIN_ACCOUNT_SAVE_ERROR_IN_DB]',false,"save");
        }
    }
    
    private function callCreate_savePost_saveAndExit($account_id = 0) {
        global $handler;
        
        if ( $account_id === 0 ) {
            $account_id = $this->callCreate_savePost_asNew();
        } else {
            $account_id = $this->callCreate_savePost_update($account_id);
        }
        
        if ( $account_id ) {
            $handler->messageSuccess2('','[LANG_ADMIN_ACCOUNT_SAVE_SUCCESS]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
        } else {
            $handler->messageError2('','[LANG_ADMIN_ACCOUNT_SAVE_ERROR_IN_DB]',false,"save");
        }
    }
    
    private function callCreate_savePost_asNew() {
        global $post, $user;
        
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        
        $dataFields = $user->cb_get_data_extra_fields();
        $user_data = [];
        foreach ( $dataFields as $k=>$v ) {
            if ( (int) $v['acm'] !== 1 ) { continue; }
            if ( !isset($post[$k]) ) { continue; }
            $user_data[$k] = $post[$k];
        }
        
        $checkResult = $user->cb_create_user($post['email'],$post['pass'],'local',$user_data,$state,$post['userlevel']);
        
        if ( $checkResult ) {
            $account_id = $user->cb_get_user_id_from_email($post['email']);
            $user->cb_update_user_image_type($account_id,$post['image']);
            return $account_id;
        } else {
            return FALSE;
        }
    }
    
    private function callCreate_savePost_update($account_id) {
        global $post, $user;
        
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        
        $dataFields = $user->cb_get_data_extra_fields();
        $user_data = [];
        foreach ( $dataFields as $k=>$v ) {
            if ( (int) $v['acm'] !== 1 ) { continue; }
            if ( !isset($post[$k]) ) { continue; }
            $user_data[$k] = $post[$k];
        }
        
        if ( empty($post['pass']) ) { $post['pass'] = NULL; }
        
        $checkResult = $user->cb_update_user($account_id,$post['email'],$post['pass'],$user_data,$state,$post['userlevel']);
        
        if ( $checkResult ) {
            $user->cb_update_user_image_type($account_id,$post['image']);
            return $account_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callCreate_themeLoad($account_id=0) {
        global $theme, $user, $post;
        
        $replace = [];
        $dataFields = $user->cb_get_data_extra_fields();
        $data = ['state'=>1,'level'=>1,'image'=>'gravatar','email'=>''];$dataExtra = [];
        $replace['admin_color'] = FALSE;
        
        if ( $account_id !== 0 ) { $data = $user->cb_get_user_data_from_id($account_id); }
        $dataExtra = $user->cb_get_user_data_extra($account_id);
        
        $html = $theme->loadAdminTemplateTwig('account_edit',TRUE,'account');
        
        if ( $account_id === 0 ) {
            $replace['image_url'] = $user->cb_get_user_avatar(FALSE);
        } else {
            $replace['image_url'] = $user->cb_get_user_avatar($account_id);
        }
        foreach ( $data as $name=>$value  ) { $replace['data_'.$name] = ( isset($post[$name]) ? $post[$name] : $value ); }
        $i = 0;
        foreach ( $dataExtra as $name=>$value ) {
            if ( $name === 'admin_theme_style' ) { $replace['admin_color']=TRUE;$replace['admin_theme_style'] = $value;continue; }
            $replace['data_extra'][$i]['name_big'] = strtoupper($name);
            $replace['data_extra'][$i]['name'] = $name;
            $replace['data_extra'][$i]['value'] = ( isset($post[$name]) ? $post[$name] : $value );
            $replace['data_extra'][$i]['admin'] = ( (int)$dataFields[$name]['acm'] === 1 ? TRUE : FALSE );
            $replace['data_extra'][$i]['useredit_or_usersee'] = ( (int)$dataFields[$name]['ucm'] === 1 || (int)$dataFields[$name]['ucs'] === 1 ? true : FALSE );
            $replace['data_extra'][$i]['useredit'] = ( (int)$dataFields[$name]['ucm'] === 1 ? TRUE : FALSE );
            $replace['data_extra'][$i]['usersee'] = ( (int)$dataFields[$name]['ucs'] === 1 ? TRUE : FALSE );
            $i++;
        }
        
        $userleveldata = $this->getUserLevel_data($user->cb_get_user_level());
        foreach ( $userleveldata as $k=>$value ) {
            $replace['userlevel'][$k]['id'] = $value['id'];
            $replace['userlevel'][$k]['name'] = $value['name'];
            $replace['userlevel'][$k]['selected'] = ( isset($post['level']) ? ( (int)$value['id'] === (int)$post['level'] ? TRUE : FALSE ) : ( (int)$value['id'] === (int)$data['level'] ? TRUE : FALSE ) );
        }
        
        $replace['state'] = ( isset($post['state']) ? $post['state'] : ( isset($data['state']) ? $data['state'] : 1 ));
        
        if ( isset($post['image']) ) {
            $replace['image'] = $post['image'];
        } else {
            $replace['image'] = $data['image'];
        }
        
        $theme->replaceTwig($replace,$html);
        
        return $html;
    }
    
    protected function callDetails_themeLoad($account_id) {
        global $theme, $user, $post;
        
        $replace = [];
        $dataFields = $user->cb_get_data_extra_fields();
        
        $data = $user->cb_get_user_data_from_id($account_id);
        $dataExtra = $user->cb_get_user_data_extra($account_id);
        
        $html = $theme->loadAdminTemplateTwig('account_details',TRUE,'account');
        
        if ( $account_id === 0 ) {
            $replace['image_url'] = $user->cb_get_user_avatar(FALSE);
        } else {
            $replace['image_url'] = $user->cb_get_user_avatar($account_id);
        }
        foreach ( $data as $name=>$value  ) { $replace['data_'.$name] = ( isset($post[$name]) ? $post[$name] : $value ); }
        $i = 0;
        foreach ( $dataExtra as $name=>$value ) {
            if ( $name === 'admin_theme_style' ) { continue; }
            $replace['data_extra'][$i]['name_big'] = strtoupper($name);
            $replace['data_extra'][$i]['name'] = $name;
            $replace['data_extra'][$i]['value'] = ( isset($post[$name]) ? $post[$name] : $value );
            $replace['data_extra'][$i]['admin'] = ( (int)$dataFields[$name]['acm'] === 1 ? TRUE : FALSE );
            $replace['data_extra'][$i]['useredit'] = ( (int)$dataFields[$name]['ucm'] === 1 ? TRUE : FALSE );
            $replace['data_extra'][$i]['usersee'] = ( (int)$dataFields[$name]['ucs'] === 1 ? TRUE : FALSE );
            $i++;
        }
        
        $replace['data_level_text'] = $this->getUserLevel_text($data['level']);
        
        $replace['data_state_text'] = "";
        
        if ( (int)$data['state'] === 0 ) { $replace['data_state_text'] = "<span class='badge badge-danger'>[LANG_ADMIN_ACCOUNT_EDIT_STATE_INACTIVE]</span>"; }
        elseif ( (int)$data['state'] === 1 ) { $replace['data_state_text'] = "<span class='badge badge-success'>[LANG_ADMIN_ACCOUNT_EDIT_STATE_ACTIVE]</span>"; }
        elseif ( (int)$data['state'] === 2 ) { $replace['data_state_text'] = "<span class='badge badge-primary'>[LANG_ADMIN_ACCOUNT_EDIT_STATE_NOT_ACTIVED]</span>"; }
        
        $replace['registration_date'] = $user->cb_get_user_registration_date($account_id);
        $last_login = $user->cb_get_user_login_last($account_id);
        $replace['login_last'] = ( $last_login === FALSE ? '[LANG_ADMIN_ACCOUNT_USER_NEVER_LOGED_IN]' : $last_login );
        $replace['login_count'] = $user->cb_get_user_login_count($account_id);
        $replace['login_now'] = ( $user->cb_get_user_is_active_last_time($account_id) ? " <span class='badge badge-success'>[LANG_ADMIN_ACCOUNT_CURRENTLY_LOGGED_IN]</span>" : '' );
        
        $theme->replaceTwig($replace,$html);
        
        return $html;
    }
}

return; ?>