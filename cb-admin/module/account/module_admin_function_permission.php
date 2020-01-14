<?php
namespace module\admin\account\permission;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v061
 * @date 20/12/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    var $noAdminLevel = Array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88","89","90","91","92","93","94","95","96","97","98","99");
    
    protected function callPermission_themeLoad() {
        global $theme, $user, $module, $admin_function;

        $listData = $this->callPermission_databaseGet();
        
        $html = $theme->loadAdminTemplateTwig('account_permission_main', TRUE, 'account');

        $tableHead = Array(
            '[LANG_ADMIN_ACCOUNT_PERMISSION_MAIN_HEADER_ID]',
            '[LANG_ADMIN_ACCOUNT_PERMISSION_MAIN_HEADER_NAME]',
            '[LANG_ADMIN_ACCOUNT_PERMISSION_MAIN_HEADER_ISADMIN]',
            '&nbsp;'
        );

        $tableBody = Array();
        $i = 0;
        foreach ($listData as $val) {
            $setup = $module->setupHexToAcc($val['setup']);
            
            $tableBody[$i] = Array();

            $tableBody[$i][] = $val['id'];
            $tableBody[$i][] = $val['name'];
            $tableBody[$i][] = ( $setup[1] === 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');

            if ( $val['id'] === 255 && $user->cb_get_user_level() === 255 ) {
                $tableBody[$i][] = "<a href='?admin=account&funct=permission_edit&id=" . $val['id'] . "'>" . $admin_function->getIcon('edit') . "</a>";
            } elseif ( $val['id'] !== 255 ) {
                $tableBody[$i][] = "<a href='?admin=account&funct=permission_edit&id=" . $val['id'] . "'>" . $admin_function->getIcon('edit') . "</a>";
            } else {
                $tableBody[$i][] = '&nbsp;';
            }

            $i++;
        }

        $replace = Array();
        $replace['body'] = $table = $admin_function->listGenerate($tableHead, $tableBody, 'account_main');

        $theme->replaceTwig($replace, $html);

        return $html;
    }

    protected function callPermission_defaultData() {
        $data = Array(
            "name" => ""
        );
        
        return $data;
    }
    
    protected function callPermission_create_themeLoad($data,$permission_id) {
        global $theme, $user;
         
        $html = $theme->loadAdminTemplateTwig('account_permission_edit',TRUE,'account');
        
        $replace = [];
        
        $replace['name'] = $data['name'];
        $replace['tab_user'] = $this->getTabSettings($permission_id, $this->callPermissionModuleList_user(),$data['setup']);
        $replace['tab_admin'] = "";
        $replace['tab_admin_button_hidden'] = TRUE;
        if ( !in_array($permission_id, $this->noAdminLevel) ) {
            $replace['tab_admin_button_hidden'] = FALSE;
            $replace['tab_admin'] = $this->getTabSettings($permission_id, $this->callPermissionModuleList_admin(),$data['setup'],true);
        }
        
        $theme->replaceTwig($replace,$html);
        
        return $html;
    }
    
    private function getTabSettings($permission_id, $data,$setup_hexa,$admin = false) {
        global $module;
        
        $html = "";
                
        if ( !empty($data) ) {
            $dataSorted = $this->sortModuleList($data);
            $setup = $module->setupHexToAcc($setup_hexa);
            
            $header = 'admin';
            $function = 'main';
            if ( !in_array($permission_id, $this->noAdminLevel) ) {
                $html .= "<div class='card mb-3'><div class='card-header'>".$header."</div><div class='card-body'>";
                $html .= $this->getTabSettings_makeRow($setup,$dataSorted,$header,$function,$admin);
            } else {
                unset($dataSorted[$header]);
            }
            if ( isset($dataSorted[$header]) ) foreach ( $dataSorted[$header] as $function=>$v2 ) {
                $html .= $this->getTabSettings_makeRow($setup,$dataSorted,$header,$function,$admin);
            }
            $html .= "</div></div>";
            foreach ( $dataSorted as $header=>$v1 ) {
                $html .= "<div class='card mb-3'><div class='card-header'>".$header."</div><div class='card-body'>";
                $function = 'main';
                $html .= $this->getTabSettings_makeRow($setup,$dataSorted,$header,$function,$admin);
                if ( isset($dataSorted[$header]) ) foreach ( $dataSorted[$header] as $function=>$v2 ) {
                    $html .= $this->getTabSettings_makeRow($setup,$dataSorted,$header,$function,$admin);
                }
                $html .= "</div></div>";
            }
        }
        
        return $html;
    }
    
    private function getTabSettings_makeRow(&$setup,&$dataSorted,&$header,&$function,$admin) {
        $html = '';
        
        $checked = ( isset($dataSorted[$header][$function]) && isset($setup[$dataSorted[$header][$function]['id']]) && $setup[$dataSorted[$header][$function]['id']] === 1 ? 'CHECKED' : '' );
        $class = ( $admin === true ) ? 'admin_' : 'user_';
        $class .= $header;
        $class2 = $class.'_'.$function;
        $html .= "<div class='form-check'><input class='form-check-input $class $class2' value='1' name='level[".$dataSorted[$header][$function]['id']."]' id='level[".$dataSorted[$header][$function]['id']."]' type='checkbox' $checked><label class='form-check-label' for='level[".$dataSorted[$header][$function]['id']."]'>".$function."</label></div>";
        unset($dataSorted[$header][$function]);
        if ( empty($dataSorted[$header]) ) { unset($dataSorted[$header]); }
        
        return $html;
    }
    
    private function sortModuleList($data) {
        $dataSorted = array();
        foreach ( $data as $v ) { $dataSorted[$v['module_name']][$v['function']] = $v; }
        return $dataSorted;
    }
    
    protected function callPermission_checkPost(&$data, $edit = FALSE, $permission_id = 0) {
        global $post, $handler;
        if ( 
            isset($post['adminModulePermissionSave']) OR
            isset($post['adminModulePermissionSaveAndExit'])
            ) {
               $ret = $this->callPermission_checkPost_test($post, $edit, $permission_id);
                if ( !empty($ret) ){foreach ( $data as $k => $v ) {
                    if ( isset($post[$k]) )
                        $data[$k] = $post[$k];
                    }
                    cbd($data);
                    foreach ($ret as $v) {
                        $handler->messageError($v);
                    }
                    return false;
                }
            return true;
        }
        return false;
    }
    
    private function callPermission_checkPost_test($post, $edit, $permission_id) {
        global $user;
        $RET = Array();
        /*
        if (!isset($post['email']) OR empty($post['email']) OR ( cb_check_email_address($post['email']) === false )) {
            $RET['email'] = "Üres vagy érvénytelen e-mail cím!";
        }
        
        $emailCheck = $user->cb_check_email_exist($post['email'],$account_id);
        if ( $emailCheck == TRUE ) {
            $RET['email'] = "Az email cím már használatban van!";
        }
        
        if ( $edit === TRUE && empty($post['pass']) && empty($post['pass_repeat']) ) { return $RET; }
        
        if ( empty($post['pass']) ) {
            $RET['pass'] = "A jelszó nem lehet üres!";
        }
        
        if ( $post['pass'] !== $post['pass_repeat'] ) {
            $RET['pass'] = "A jelszavak nem egyeznek!";
        }
        */
        return $RET;
    }
    
    protected function callPermission_savePost($permission_id = 0) {
        global $post;
        
        if ( isset($post['adminModulePermissionSave']) ) {
            $this->callPermission_savePost_save($permission_id);
        } else if ( isset($post['adminModulePermissionSaveAndExit']) ) {
            $this->callPermission_savePost_saveAndExit($permission_id);
        }
    }
    
    private function callPermission_savePost_save($permission_id = false) {
        global $handler;
        
        if ( $permission_id == false && $permission_id != 0 ) {
            $permission_id = $this->callPermission_savePost_asNew();
        } else {
            $permission_id = $this->callPermission_savePost_update($permission_id);
        }
        
        if ( $permission_id !== false ) {
            $handler->messageSuccess('[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=permission_edit&id=".$permission_id);
        } else {
            $handler->messageError('[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_ERROR_IN_DB]',false,"save");
        }
    }
    
    private function callPermission_savePost_saveAndExit($permission_id = false) {
        global $handler;
        
        if ( $permission_id == false && $permission_id != 0 ) {
            $permission_id = $this->callPermission_savePost_asNew();
        } else {
            $permission_id = $this->callPermission_savePost_update($permission_id);
        }
        
        if ( $permission_id !== false ) {
            $handler->messageSuccess('[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_SUCCESS]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=permission");
        } else {
            $handler->messageError('[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_SAVE_ERROR_IN_DB]',false,"save");
        }
    }
    
    private function callPermission_savePost_asNew() {
        
    }
    
    private function callPermission_savePost_update($permission_id) {
        global $post, $module;
                
        if ( in_array($permission_id, $this->noAdminLevel) ) {
            $adminModuleList = $this->callPermissionModuleList_admin();
            
            foreach ( $adminModuleList as $v ) { if ( isset($post['level'][$v['id']]) ) { unset($post['level'][$v['id']]); } }
        }
        
        foreach ( $post['level'] as $k=>$v ) {
            if ( !empty($v) ) {
                $post['level'][$k] = 1;
            }
        }
        
        $setup = $module->setupAccToHex($post['level']);
        
        $checkResult = $this->updateUserLevelPermission($permission_id,$setup);
        
        if ( $checkResult ) {
            return $permission_id;
        } else {
            return false;
        }
    }
    
}

return; ?>