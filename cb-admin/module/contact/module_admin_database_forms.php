<?php
namespace module\admin\contact\forms;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 06/03/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    protected function database_callForms_getList() {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__contact_forms`");
        $database->where(" 1 ");
        $data = $database->execute();
        
        //cbd($listData,1);
        
        return $data;
    }
    
    protected function database_callFormsCreate_savePost($post) {
        global $database;
        
        $nextFormId = $this->database_getNextFormId();
        
        $field = "";
        if ( !empty($post['field']) ) {
            $i = 0;
            foreach ( $post['field'] as $k=>$v ) {
                if ( empty($v['name']) ) {
                    $post['field'][$k]['name'] = $nextFormId.'_'.$i++.'_'.$v['type'].'_'.crc32($v['title']).'_'.cb_generate_code();
                }
            }
            $post['field'] = array_values($post['field']);
            $field = cb_json_encode($post['field'], true);
        }
        
        $queryArray = array();
        $queryArray['id'] = $nextFormId;
        $queryArray['name'] = $post['name'];
        $queryArray['field'] = $field; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
        $queryArray['target_email'] = $post['target_email'];
        $queryArray['target_subject'] = $post['target_subject'];
        $queryArray['send_text'] = $post['send_text'];
        $queryArray['form_class'] = $post['form_class'];
        $queryArray['state'] = $post['state'];

        $checkResult = $database->insertTo("#__contact_forms",$queryArray);
        
        if ( $checkResult ) {
            return $nextFormId;
        } else {
            return FALSE;
        }
    }
    
    protected function database_callFormsEdit_updatePost($post) {
        global $database;
        
        $field = "";
        if ( !empty($post['field']) ) {
            $i = 0;
            foreach ( $post['field'] as $k=>$v ) {
                if ( empty($v['name']) ) {
                    $post['field'][$k]['name'] = $post['id'].'_'.$i++.'_'.$v['type'].'_'.crc32($v['title']).'_'.cb_generate_code();
                }
            }
            $post['field'] = array_values($post['field']);
            $field = cb_json_encode($post['field'], true);
        }
        
        $queryArray = array();
        $queryArray['id'] = $post['id'];
        $queryArray['name'] = $post['name'];
        $queryArray['field'] = $field; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
        $queryArray['target_email'] = $post['target_email'];
        $queryArray['target_subject'] = $post['target_subject'];
        $queryArray['send_text'] = $post['send_text'];
        $queryArray['form_class'] = $post['form_class'];
        $queryArray['state'] = $post['state'];
        
        $checkResult = $database->updateTo("#__contact_forms",'id',$queryArray);
        
        if ( $checkResult ) {
            return $post['id'];
        } else {
            return FALSE;
        }
    }
    
    private function database_getNextFormId() {
        global $database;
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__contact_forms`");
        $database->where(" 1 ");
        $database->order(" `id` DESC ");
        $database->limit("1");
        $database->qType("result");
        $data = $database->execute();
        
        if ( !$data ) { $data = 1; } else { $data++; }
        
        return $data;
    }
    
    protected function database_callFormsEdit_getData($id) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__contact_forms`");
        $database->where(" `id` = '".$id."' ");
        $database->limit("1");
        $database->qType("row");
        $data = $database->execute();
        
        if ( !$data ) { $data = 1; } else { $data++; }
        
        return $data;
    }
    
    protected function database_deleteForm($extid) {
        global $database;
        
        $queryDeleteArray = array();
        $queryDeleteArray['id'] = $extid;
        $result = $database->deleteFrom('#__contact_forms',$queryDeleteArray);
        
        if ( $result ) {
            $queryDeleteArray = array();
            $queryDeleteArray['form_id'] = $extid;
            $database->deleteFrom("#__contact_posts",$queryDeleteArray);
        }
        
        return $result;
    }
}

return; ?>