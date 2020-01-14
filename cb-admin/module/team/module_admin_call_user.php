<?php
namespace module\admin\team\user;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_create() {
        $data = array();

        if ( $this->callCreate_checkPost($data) ) { $this->callCreate_savePost(); }
                
        $html = $this->callCreate_themeLoad($data);
        
        return $html;
    }
    
    public function __call_edit() {
        global $handler, $get;

        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            $team_id = $get['id'];
            
            $data = $this->teamGetDatabaseData($team_id);
            
            if ( $this->callCreate_checkPost($data) ) { $this->callEdit_savePost(); }
            
            $html = $this->callCreate_themeLoad($data);
            
            return $html;
            
        } else {
            $handler->messageError('[ADMIN_MESSAGE_TEAM_ERROR_ID_NOT_EXIST]',true,"save");
            header("Location: ".CB_INDEX."?admin=team&funct=main");exit;
        }
    }

}

return; ?>