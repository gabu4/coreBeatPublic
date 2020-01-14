<?php
namespace menupoint\article\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v021
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends menupoint {
    
    
    protected function menupointArticle_savePost_asNew(&$catlang, &$catid) {
        global $post, $database, $module;
        
        $content_type_id = savePost_getContentTypeId('article','article');
        $menu_id = savePost_getNextMenuId();
        $content_id = savePost_getNextContentId();
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        $is_blank = ( !isset($post['is_blank']) OR empty($post['is_blank']) ) ? 0 : $post['is_blank'];
        
        $queryArray1 = array();
        $queryArray1['id'] = $menu_id;
        $queryArray1['content_id'] = $content_id;
        $catid = $queryArray1['category'] = $post['category'];
        $queryArray1['lang'] = $post['language'];
        $queryArray1['parent'] = $post['parent'][$post['language']][$post['category']];
        $queryArray1['order'] = ( !empty($post['order']) && is_numeric($post['order']) ) ? $post['order'] : savePost_getPostOrderNext($queryArray1['parent']);
        $queryArray1['state'] = $state;
        $queryArray1['text'] = htmlentities($post['text'],ENT_QUOTES);

        $checkResult1 = $database->insertTo("#__menu",$queryArray1);
        
        $jsonContentRaw['id'] =  $post['article_id'][$post['language']];
        $jsonContentRaw['blank'] =  $is_blank;

        $jsonContent = json_encode($jsonContentRaw);
        
        $seo_data = array('name'=>$post['name'],'seoname'=>$post['seo_name'],'language'=>$post['language']);
        $seo_name = $module->loadAdminFunction('admin','seonamegenerate',$seo_data);
        
        $queryArray2 = array();
        $queryArray2['id'] = $content_id;
        $queryArray2['name'] = $post['name'];
        $queryArray2['seo_name'] = $seo_name['seoname'];
        $queryArray2['type'] = $content_type_id;
        $catlang = $queryArray2['lang'] = $post['language'];
        $queryArray2['value'] = $jsonContent;

        $checkResult2 = $database->insertTo("#__content",$queryArray2);
        cbd($database->lastQuery,1);
        if ( !$checkResult1 ) { cb_error_log('Menupoint save is not good! ERROR CODE: #150320x001'); }
        if ( !$checkResult2 ) { cb_error_log('Menupoint save is not good! ERROR CODE: #150320x002'); }
        
        if ( $checkResult1 && $checkResult2 ) {
            return $menu_id;
        } else {
            return FALSE;
        }
    }
    
    
    protected function menupointArticle_edit_getData($id) {
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
    
    protected function menupointArticle_editPost_update(&$catlang, &$catid) {
        global $post, $database, $module;
        
        $content_type_id = savePost_getContentTypeId('article','article');
        $menu_id = $post['id'];
        $content_id = $post['content_id'];
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        $is_blank = ( !isset($post['is_blank']) OR empty($post['is_blank']) ) ? 0 : $post['is_blank'];
        
        $queryArray1 = array();
        $queryArray1['id'] = $menu_id;
        $queryArray1['content_id'] = $content_id;
        $catid = $queryArray1['category'] = $post['category'];
        $queryArray1['lang'] = $post['language'];
        $queryArray1['parent'] = $post['parent'][$post['language']][$post['category']];
        $queryArray1['order'] = ( !empty($post['order']) && is_numeric($post['order']) ) ? $post['order'] : savePost_getPostOrderNext($queryArray1['parent'][$post['category']]);
        $queryArray1['state'] = $state;
        $queryArray1['text'] = htmlentities($post['text'],ENT_QUOTES);

        $checkResult1 = $database->updateTo("#__menu",'id',$queryArray1);
        
        $jsonContentRaw['id'] =  $post['article_id'][$post['language']];
        $jsonContentRaw['blank'] =  $is_blank;

        $jsonContent = json_encode($jsonContentRaw);

        $seo_data = array('name'=>$post['name'],'seoname'=>$post['seo_name'],'id'=>$content_id,'language'=>$post['language']);
        $seo_name = $module->loadAdminFunction('admin','seonamegenerate',$seo_data);
        
        $queryArray2 = array();
        $queryArray2['id'] = $content_id;
        $queryArray2['name'] = $post['name'];
        $queryArray2['seo_name'] = $seo_name['seoname'];
        $queryArray2['type'] = $content_type_id;
        $catlang = $queryArray2['lang'] = $post['language'];
        $queryArray2['value'] = $jsonContent;

        $checkResult2 = $database->updateTo("#__content",'id',$queryArray2);
        
        if ( !$checkResult1 ) { cb_error_log('Menupoint save is not good! ERROR CODE: #150321x001'); }
        if ( !$checkResult2 ) { cb_error_log('Menupoint save is not good! ERROR CODE: #150321x002'); }
        
        if ( $checkResult1 && $checkResult2 ) {
            return $menu_id;
        } else {
            return FALSE;
        }
    }
    
}

return; ?>