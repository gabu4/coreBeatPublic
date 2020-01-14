<?php
namespace module\admin\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v019
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: form ellenörzés és js elemek nincsenek még megírva!
class call extends funct {
    use user\call;
    
    function module_admin_article_call() { }

    public function __call_main() {        
        $listDataRaw = $this->callMain_databaseGet();
        
        $listData = $this->listDataLanguageFilter($listDataRaw);
        
        $html = $this->callMain_themeLoad($listData);
        
        return $html;
    }
    
    public function __call_trash() {
        global $handler, $get;

        if ( !isset($get['id']) OR empty($get['id']) ) { 
            $handler->messageError('[ADMIN_MESSAGE_TEAM_TRASH_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=team&funct=main");exit;
        }
        $id = $get['id'];
        
        $extid = $this->callTrash_checkID($id);
        
        if ( !$extid ) { 
            $handler->messageError('[ADMIN_MESSAGE_TEAM_TRASH_ERROR_ID_NOT_EXIST]',true,"delete");
            header("Location: ".CB_INDEX."?admin=team&funct=main");exit;
        }
        
        $this->callTrash_teamToTrash($id);
        
        $handler->messageSuccess('[ADMIN_MESSATE_TEAM_TRASH_SUCCESS]',true,'delete');

        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

    
}

return; ?>