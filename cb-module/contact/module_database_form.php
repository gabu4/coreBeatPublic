<?php
namespace module\contact\form;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 18/02/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callForm_databaseGet($data) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__contact_forms`");
        $database->where("`id` = '".$data['id']."' AND `state` = '1' ");
        $database->qType("row");
        $formData = $database->execute();
        
        return $formData;
    }
    
    protected function callMain_saveMessage($formData, $post) {
        global $database;
                
        $formsMessage = array(
            'form_id' => $formData['id'],
            'form_field' => $formData['field'],
            'form_target_email' => $formData['target_email'],
            'form_target_subject' => $formData['target_subject'],
            'msgData' => json_encode($post)
        );

        $r = $database->insertTo("#__contact_posts",$formsMessage);
        
        return $r;
    }
}

return; ?>