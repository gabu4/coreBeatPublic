<?php
namespace module\admin\team\user;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 18/06/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callCreate_savePost_getTeamID() {
        global $database;
        
        $database->newQuery();
        $database->select("`team_id`");
        $database->from("`#__team`");
        $database->order("`team_id` DESC");
        $database->limit(" 1 ");
        $database->qType("result");
        $team_id = $database->execute();
        
        return $team_id+1;
    }
    
    protected function callCreate_categoryListCreate_getDataToCheck($article_id) {
        global $database;
        
        $database->newQuery();
        $database->select("`cat_id`");
        $database->from("`#__article_category_xref`");
        $database->where("`article_id` = '".$article_id."'");
        $database->order("`cat_id` ASC");
        $dataCheckRaw = $database->execute();

        $dataCheck = array();

        if ( !empty($dataCheckRaw) ) {
            foreach ( $dataCheckRaw as $dc ) {
                $dataCheck[] = $dc['cat_id'];
            }
        }
        
        return $dataCheck;
    }
    
    protected function callCreate_categoryListCreate_getData($language = NULL) {
        global $database, $lang;
        
        if ( $language === NULL ) { $language = $lang->getAdminLanguage(); }
        
        $database->newQuery();
        $database->select("`acat`.*");
        $database->from("`#__article_category` `acat`");
        $database->where("`acat`.`state` > '0' and `acat`.`lang` = '".$language."' ");
        $database->group("`acat`.`cat_id`,`acat`.`lang`");
        $database->order("`acat`.`cat_id` ASC");
        $categoryListData = $database->execute();
        
        return $categoryListData;
    }
    
    private function savePost_getPostOrderNext($team_id) {
        global $database;

        $database->newQuery();
        $database->select("`short_order`");
        $database->from("`#__team`");
        $database->where(" `team_id` != '".$team_id."'");
        $database->order("`short_order` DESC");
        $database->limit(" 1 ");
        $database->qType("result");
        $order = $database->execute();

        if ( !$order ) { $order = 100; } else { $order = $order*1 + 100; }

        return $order;
    }
    
    protected function callCreate_savePost_asNew() {
        global $post, $database, $lang;
        
        $team_id = $this->callCreate_savePost_getTeamID();
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        $order = ( !isset($post['short_order']) OR empty($post['short_order']) ) ? $this->savePost_getPostOrderNext($team_id) : $post['short_order'];
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $post['name'][$l] = htmlentities($post['name'][$l],ENT_QUOTES);
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            $post['titulus'][$l] = htmlentities($post['titulus'][$l],ENT_QUOTES);
            $post['munkai'][$l] = htmlentities($post['munkai'][$l],ENT_QUOTES);
            $post['foglalas'][$l] = htmlentities($post['foglalas'][$l],ENT_QUOTES);
            
            $queryArray = array();
            $queryArray['team_id'] = $team_id;
            $queryArray['name'] = $post['name'][$l];
            $queryArray['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $queryArray['titulus'] = $post['titulus'][$l];
            $queryArray['munkai'] = $post['munkai'][$l];
            $queryArray['foglalas'] = $post['foglalas'][$l];
            $queryArray['lang'] = $l;
            $queryArray['state'] = $state;
            $queryArray['media'] = json_encode(array("image"=>""));
            $queryArray['short_order'] = $order;

            $checkResult = $database->insertTo("#__team",$queryArray);
        }
                
        if ( $checkResult ) {
            return $team_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callEdit_savePost_update() {
        global $database, $get, $post, $lang;
        
        $team_id = $get['id'];
        $order = ( !isset($post['short_order']) OR empty($post['short_order']) ) ? $this->savePost_getPostOrderNext($team_id) : $post['short_order'];
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            gotostart:
            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__team`");
            $database->where("`team_id` = '".$team_id."' and `lang` = '$l' ");
            $database->limit(" 1 ");
            $database->qType("result");
            $id = $database->execute();
            
            if ( !$id ) {
                $queryArray = array();
                $queryArray['team_id'] = $team_id;
                $queryArray['lang'] = $l;
                $queryArray['media'] = json_encode(array("image"=>""));
                
                $database->insertTo("#__team",$queryArray);
                goto gotostart;
            }
            $post['name'][$l] = htmlentities($post['name'][$l],ENT_QUOTES);
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            $post['titulus'][$l] = htmlentities($post['titulus'][$l],ENT_QUOTES);
            $post['munkai'][$l] = htmlentities($post['munkai'][$l],ENT_QUOTES);
            $post['foglalas'][$l] = htmlentities($post['foglalas'][$l],ENT_QUOTES);
            
            $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
            $state = ( empty($post['name'][$l]) AND empty($post['text'][$l]) ) ? 0 : $state;
            
            $qUpdate = Array();
            $qUpdate['name'] = $post['name'][$l];
            $qUpdate['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $qUpdate['titulus'] = $post['titulus'][$l];
            $qUpdate['munkai'] = $post['munkai'][$l];
            $qUpdate['foglalas'] = $post['foglalas'][$l];
            //$qUpdate['lang'] = $l;
            $qUpdate['state'] = $state;
            $qUpdate['id'] = $id;
            $qUpdate['short_order'] = $order;
            
            $uCheck = $database->updateTo("#__team",'id',$qUpdate);
        }
        
        if ($uCheck) {
            return $team_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callCreate_savePost_saveFile($team_id) {
        global $post, $database, $module;
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__team`");
        $database->where("`team_id` = '".$team_id."'");
        $database->limit(" 1 ");
        $database->qType("result");
        $id = $database->execute();
        
        if ( isset($post['image_delete'])) { $this->callCreate_savePost_saveFile_deletePreviousImage($team_id); }
        if ( cb_file_uploaded("image_file") ) {
            $check = getimagesize($_FILES["image_file"]["tmp_name"]);
            if($check !== false) {
                $sourcePath = $_FILES['image_file']['tmp_name'];       // Storing source path of the file in a variable
                $extension = strtolower(substr($_FILES['image_file']['name'], strrpos($_FILES['image_file']['name'], '.') + 1));
                
                $this->callCreate_savePost_saveFile_deletePreviousImage($team_id);
                $this->callCreate_savePost_saveFile_saveNewThumbnail($team_id,$sourcePath,$extension);
            }
        }
        
    }
    
    private function callCreate_savePost_saveFile_saveNewThumbnail($team_id, $file, $extension = NULL) {
        global $database;
        
        $teamData = $this->teamGetDatabaseDataFromTeamId($team_id);
        
        $media = json_decode($teamData['media'], true);
        
        if ( isset($media['image']) && empty($media['image']) || !isset($media['image']) ) {
            $path = $this->teamContentImagePath;
            $pathOut_original = $path . $this->teamContentImagePath_original;
            $pathOut_normal = $path . $this->teamContentImagePath_normal;
            $pathOut_small = $path . $this->teamContentImagePath_small;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $team_id."_image_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777, TRUE); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_ARTICLE_THUMBNAIL_SMALL_WIDTH) || CB_ARTICLE_THUMBNAIL_SMALL_WIDTH == '0' ) ? 1000 : CB_ARTICLE_THUMBNAIL_SMALL_WIDTH;
            $height = ( empty(CB_ARTICLE_THUMBNAIL_SMALL_HEIGHT) || CB_ARTICLE_THUMBNAIL_SMALL_HEIGHT == '0' ) ? 1000 : CB_ARTICLE_THUMBNAIL_SMALL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_small.$filename,$width,$height);

            $width = ( empty(CB_ARTICLE_THUMBNAIL_NORMAL_WIDTH) || CB_ARTICLE_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_ARTICLE_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_ARTICLE_THUMBNAIL_NORMAL_HEIGHT) || CB_ARTICLE_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_ARTICLE_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['image'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['team_id'] = $team_id;
            $uCheck = $database->updateTo("#__team",'team_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCreate_savePost_saveFile_deletePreviousImage($team_id) {
        global $database;
        
        $media = $this->getTeamMediaValueFromTeamId($team_id);
        
        if ( isset($media['image']) && !empty($media['image']) ) {
            $path = $this->teamContentImagePath;
            $pathOut_original = $path . $this->teamContentImagePath_original;
            $pathOut_normal = $path . $this->teamContentImagePath_normal;
            $pathOut_small = $path . $this->teamContentImagePath_small;
            unlink($pathOut_original.$media['image']);
            unlink($pathOut_normal.$media['image']);
            unlink($pathOut_small.$media['image']);
            
            $media['image'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['team_id'] = $team_id;
            $uCheck = $database->updateTo("#__team",'team_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
}

return; ?>