<?php
namespace menupoint\_default\_default;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 18/03/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends menupoint {
        
/* MENUPOINT HTML SAVE FUNCION */
    protected function menupointHtml_savePost(&$data,$type) {
        global $database;
        
        $state = ( !isset($data['state']) OR empty($data['state']) ) ? 0 : $data['state'];
        $is_blank = ( !isset($data['is_blank']) OR empty($data['is_blank']) ) ? 0 : $data['is_blank'];
        
        $t = explode('_',$type,2);
        
        $content_type_id = savePost_getContentTypeId($t[0],$t[1]);
        $data['id'] = $id = savePost_getNextMenuId();
        $data['content_id'] = $content_id = savePost_getNextContentId();
        
        $queryArray = array();
        $queryArray['id'] = $id;
        $queryArray['content_id'] = $content_id;
        $data['catid'] = $queryArray['category'] = $data['category'];
        $queryArray['parent'] = ( isset($data['parent'][$data['language']][$data['category']]) && !empty($data['parent'][$data['language']][$data['category']]) ) ? $data['parent'][$data['language']][$data['category']]: 0;
        $queryArray['lang'] = $data['language'];
        $queryArray['order'] = ( !empty($data['order']) && is_numeric($data['order']) ) ? $data['order'] : savePost_getPostOrderNext($queryArray['parent'][$data['category']]);
        $queryArray['state'] = $state;
        $queryArray['text'] = htmlentities($data['text'],ENT_QUOTES);

        $succ1 = $database->insertTo("#__menu",$queryArray);

        $jsonContentRaw['blank'] =  $is_blank;

        $jsonContent = json_encode($jsonContentRaw);

        $queryArray = array();
        $queryArray['id'] = $content_id;
        $queryArray['name'] = $data['name'];
        $queryArray['seo_name'] = ( !empty($data['seo_name']) ) ? $data['seo_name'] : round(microtime(true) * 1000);
        $queryArray['type'] = $content_type_id;
        $data['catlang'] = $queryArray['lang'] = $data['language'];
        $queryArray['value'] = $jsonContent;

        $succ2 = $database->insertTo("#__content",$queryArray);
        
        if ( $succ1 && $succ2 ) {
            return TRUE;
        } else {
            $error = Array();
            if ( !$succ1 ) {
                $error[] = "[ADMIN_MESSAGE_MENUPOINT_SAVE_ERROR_IN_MENUTABLE]";
            }
            if ( !$succ2 ) {
                $error[] = "[ADMIN_MESSAGE_MENUPOINT_SAVE_ERROR_IN_CONTENTTABLE]";
            }
            return $error;
        }
    }
    
    protected function menupointHtml_edit_getData($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`m`.`id` as `id`, `c`.`id` as `content_id`, `c`.`name` as `name`, `c`.`seo_name` as `seo_name`, `c`.`value` as `v`, `m`.`category` as `category`, `m`.`parent` as `parent`, `m`.`image` as `image`, `m`.`order` as `order`, `m`.`state` as `state`, `m`.`text` as `text`");
        $database->from("`#__menu` `m`, `#__content` `c`");
        $database->where("`m`.`content_id` = `c`.`id` and `m`.`id` = '".$id."' ");
        $database->limit("1");
        $database->qType("row");
        $data = $database->execute();

        return $data;
    }
    
    protected function menupointHtml_updatePost(&$data,$type) {
        global $database;
        
        
        $state = ( !isset($data['state']) OR empty($data['state']) ) ? 0 : $data['state'];
        $is_blank = ( !isset($data['is_blank']) OR empty($data['is_blank']) ) ? 0 : $data['is_blank'];
        
        $t = explode('_',$type,2);
        $content_type_id = savePost_getContentTypeId($t[0],$t[1]);
        
        cbd($data);
        cbd($data['parent'][$data['language']][$data['category']]);
        
        $queryArray = array();
        $queryArray['id'] = $data['id'];
        $queryArray['content_id'] = $data['content_id'];
        $data['catid'] = $queryArray['category'] = $data['category'];
        $queryArray['parent'] = ( isset($data['parent'][$data['language']][$data['category']]) && !empty($data['parent'][$data['language']][$data['category']]) ) ? $data['parent'][$data['language']][$data['category']]: 0;
        $queryArray['lang'] = $data['language'];
        $queryArray['order'] = ( !empty($data['order']) && is_numeric($data['order']) ) ? $data['order'] : savePost_getPostOrderNext($queryArray['parent'][$data['category']]);
        $queryArray['state'] = $state;
        $queryArray['text'] = htmlentities($data['text'],ENT_QUOTES);

        $succ1 = $database->updateTo("#__menu",'id',$queryArray);
cbdlq();
        $jsonContentRaw['blank'] =  $is_blank;

        $jsonContent = json_encode($jsonContentRaw);

        $queryArray = array();
        $queryArray['id'] = $data['content_id'];
        $queryArray['name'] = $data['name'];
        $queryArray['seo_name'] = ( !empty($data['seo_name']) ) ? $data['seo_name'] : round(microtime(true) * 1000);
        $queryArray['type'] = $content_type_id;
        $data['catlang'] = $queryArray['lang'] = $data['language'];
        $queryArray['value'] = $jsonContent;

        $succ2 = $database->updateTo("#__content",'id',$queryArray);
        
        if ( $succ1 && $succ2 ) {
            return TRUE;
        } else {
            $error = Array();
            if ( !$succ1 ) {
                $error[] = "[ADMIN_MESSAGE_MENUPOINT_SAVE_ERROR_IN_MENUTABLE]";
            }
            if ( !$succ2 ) {
                $error[] = "[ADMIN_MESSAGE_MENUPOINT_SAVE_ERROR_IN_CONTENTTABLE]";
            }
            return $error;
        }
    }
}

return; ?>