<?php
namespace module\admin\article\group;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_group_main() {
        $listData = $this->callGroupMain_databaseGet();
        $html = $this->callGroupMain_themeLoad($listData);
        
        return $html;
    }

    public function __call_group_create() {
        global $theme, $database, $handler, $user, $post;

        $data['name'] = "";$data['text'] = "";$data['state'] = "1";

        $html = $theme->loadAdminTemplate('admin_article','group_create',1,'article');

        $title = 'Bejegyzés kategória létrehozás';

        if ( 
            isset($post['adminModuleArticleGroupSave']) OR
            isset($post['adminModuleArticleGroupSaveAndExit']) OR
            isset($post['adminModuleArticleGroupSaveAndNew'])
            ) {

            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__article_category`");
            $database->order("`id` DESC");
            $database->limit(" 1 ");
            $database->qType("result");
            $id = $database->execute();

            $id = $id+1;

            $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];

            $queryArray = array();
            $queryArray['id'] = $id;
            $queryArray['cat_id'] = $id;
            $queryArray['name'] = $post['name'];
            $queryArray['text'] = $post['text'];
            $queryArray['state'] = $state;

            $database->insertTo("#__article_category",$queryArray);

            $handler->messageSuccess("Sikeres mentés",true,"save");

            if ( isset($post['adminModuleArticleGroupSave']) ) {
                header("Location: ".CB_INDEX."?admin=article&funct=group_edit&id=".$id);
            } else if ( isset($post['adminModuleArticleGroupSaveAndExit']) ) {
                header("Location: ".CB_INDEX."?admin=article&funct=group_main");
            } else if ( isset($post['adminModuleArticleGroupSaveAndNew']) ) {
                header("Location: ".CB_INDEX."?admin=article&funct=group_create");
            }
        }

        $replace['NAME'] = $data['name'];
        $replace['TEXT'] = $data['text'];
        $replace['IFSTATE0'] = ( !isset($data['state']) || empty($data['state']) || $data['state'] == 0 ) ? ' CHECKED ' : '';
        $replace['IFSTATE1'] = ( isset($data['state']) && !empty($data['state']) & $data['state'] == 1 ) ? ' CHECKED ' : '';

        $replace['title'] = $title;

        foreach ( $replace as $key => $value ) {
            $html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
        }

        return $html;
    }

    public function __call_group_edit() {
        global $theme, $database, $handler, $user, $post, $get;

        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            $id = $get['id'];

            $data['name'] = "";$data['text'] = "";$data['state'] = "1";

            $title = 'Bejegyzés kategória szerkesztés';
            $database->newQuery();
            $database->select("*");
            $database->from("`#__article_category`");
            $database->where("`id` = '".$id."'");
            $database->order("");
            $database->limit(" 1 ");
            $database->qType("row");
            $data = $database->execute();


            $html = $theme->loadAdminTemplate('admin_article','group_create',1,'article');

            if (
                isset($post['adminModuleArticleGroupSave']) OR
                isset($post['adminModuleArticleGroupSaveCopy']) OR
                isset($post['adminModuleArticleGroupSaveAndExit']) OR
                isset($post['adminModuleArticleGroupSaveAndNew'])
                ) {

                $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];

                if ( isset($post['adminModuleArticleGroupSaveCopy']) ) {

                    $database->newQuery();
                    $database->select("`id`");
                    $database->from("`#__article_category`");
                    $database->order("`id` DESC");
                    $database->limit(" 1 ");
                    $database->qType("result");
                    $id = $database->execute();

                    $id = $id+1;

                    $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];

                    $queryArray = array();
                    $queryArray['id'] = $id;
                    $queryArray['cat_id'] = $id;
                    $queryArray['name'] = $post['name'];
                    $queryArray['text'] = $post['text'];
                    $queryArray['state'] = $state;

                    $database->insertTo("#__article_category",$queryArray);

                    $handler->messageSuccess("Sikeres mentés",true,"save");

                    header("Location: ".CB_INDEX."?admin=article&funct=group_edit&id=".$id);

                } else {

                    $database->doQuery("UPDATE `#__article_category` SET `name` = '".$post['name']."', `text` = '".$post['text']."', `state` = '".$state."' WHERE `id` = '".$id."' ");


                    $handler->messageSuccess("Sikeres mentés",true,"save");

                    if ( isset($post['adminModuleArticleGroupSave']) ) {
                        header("Location: ".CB_INDEX."?admin=article&funct=group_edit&id=".$id);
                    } else if ( isset($post['adminModuleArticleGroupSaveAndExit']) ) {
                        header("Location: ".CB_INDEX."?admin=article&funct=group_main");
                    } else if ( isset($post['adminModuleArticleGroupSaveAndNew']) ) {
                        header("Location: ".CB_INDEX."?admin=article&funct=group_create");
                    }

                }
            }

            $replace['NAME'] = $data['name'];
            $replace['TEXT'] = $data['text'];
            $replace['IFSTATE0'] = ( !isset($data['state']) || empty($data['state']) || $data['state'] == 0 ) ? ' CHECKED ' : '';
            $replace['IFSTATE1'] = ( isset($data['state']) && !empty($data['state']) & $data['state'] == 1 ) ? ' CHECKED ' : '';

            $replace['title'] = $title;

            foreach ( $replace as $key => $value ) {
                    $html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
            }

            return $html;
        }
    }

    public function __call_group_trash() {
        global $database, $handler, $get;

        if ( !isset($get['id']) OR empty($get['id']) ) { return 'Hibás ID'; }
        $id = $get['id'];

        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__article_category`");
        $database->where("`id` = '".$id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $extid = $database->execute();

        if ( empty($extid) ) { return 'Hibás ID'; }

        $database->doQuery("UPDATE `#__article_category` SET `state` = '-1' WHERE `id` = '".$extid."' ");

        $handler->messageSuccess('A kategória lomtárba helyezése sikeres!',true,'delete');

        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

	
}

return; ?>