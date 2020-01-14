<?php
namespace module\admin\account\permission;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v054
 * @date 11/10/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    /* Felhasználókezelő főoldal */
    public function __call_permission() {
        $html = $this->callPermission_themeLoad();
        return $html;
    }
    
    public function __call_permission_edit() {
        global $get, $handler;
        
        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] >= 0) ) {
            $permission_id = $get['id'];
            
            $dataDef = $this->callPermission_defaultData();
            $dataPerms = $this->callPermission_edit_getData($permission_id);
            $data = \array_merge($dataDef, $dataPerms);
            
            if ( $this->callPermission_checkPost($data, TRUE, $permission_id) ) { $this->callPermission_savePost($permission_id); }

            $html = $this->callPermission_create_themeLoad($data,$permission_id);

            return $html;
        
        
        } else {
            $handler->messageError2(NULL,'[LANG_ADMIN_ACCOUNT_PERMISSION_MESSAGE_ERROR_ID_NOT_EXIST]',"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=permission");
        }
        
        return $html;
    }
}

return; ?>