<?php
namespace module\admin\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v023
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: form ellenörzés és js elemek nincsenek még megírva!
class call extends funct {
    use group\call;
    use article\call;
//    use article_preview\call;
    
    function module_admin_article_call() { }

    public function __call_main() {
        global $get;
        
        $currentCatId = ( isset($get['cat']) && is_numeric($get['cat']) ) ? $get['cat'] : 0;
        
        $listDataRaw = $this->callMain_databaseGet($currentCatId);
        
        $listData = $this->listDataLanguageFilter($listDataRaw);
        
        $html = $this->callMain_themeLoad($listData,$currentCatId);
        
        return $html;
    }
    
    public function __call_trash() {
        global $handler, $get;

        if ( !isset($get['id']) OR empty($get['id']) ) {
            $handler->messageError2(NULL,'[LANG_ADMIN_ARTICLE_MESSAGE_TRASH_ERROR_ID_NOT_EXIST]',"delete");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=main");
        }
        $id = $get['id'];
        
        $extid = $this->callTrash_checkID($id);
        
        if ( !$extid ) { 
            $handler->messageError2(NULL,'[LANG_ADMIN_ARTICLE_MESSAGE_TRASH_ERROR_ID_NOT_EXIST]',"delete");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=main");
        }
        
        $this->callTrash_articleToTrash($id);
        
        $handler->messageSuccess2(NULL,'[LANG_ADMIN_ARTICLE_MESSAGE_SUCCESS_MOVE_TO_TRASH]','delete');
        global $out_html;$out_html->redirect(CB_INDEX."?admin=article&funct=main");
    }

    
}

return; ?>