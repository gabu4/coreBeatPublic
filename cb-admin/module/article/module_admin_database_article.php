<?php
namespace module\admin\article\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callCreate_savePost_getArticleID() {
        global $database;
        
        $database->newQuery();
        $database->select("`article_id`");
        $database->from("`#__article`");
        $database->order("`article_id` DESC");
        $database->limit(" 1 ");
        $database->qType("result");
        $article_id = $database->execute();
        
        return $article_id+1;
    }
    
    protected function callCreate_categoryListCreate_getDataToCheck($article_id) {
        global $database;
        
        $database->newQuery();
        $database->select("`cat_id`");
        $database->from("`#__article_category_xref`");
        $database->where("`article_id` = '".$article_id."' ");
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
    
    protected function callCreate_savePost_asNew() {
        global $post, $database, $user, $lang;
                
        $article_id = $this->callCreate_savePost_getArticleID();
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        
        $date_create = cb_time_to_date();
        $cre_id = $user->cb_get_user_id();
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            
            $queryArray = array();
            $queryArray['article_id'] = $article_id;
            $queryArray['name'] = $post['name'][$l];
            $queryArray['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $queryArray['date_create'] = $date_create;
            $queryArray['lang'] = $l;
            $queryArray['meta_keywords'] = $post['meta_keywords'][$l];
            $queryArray['meta_description'] = $post['meta_description'][$l];
            $queryArray['state'] = $state;
            $queryArray['version'] = 1;
            $queryArray['template'] = $post['other_template'];
            $queryArray['class'] = $post['other_class'];
            $queryArray['css'] = $post['other_css'];
            $queryArray['js'] = $post['other_js'];
            $queryArray['media'] = json_encode(array("thumbnail"=>"","headerimage"=>"","youtubevideo"=>""));

            $checkResult = $database->insertTo("#__article",$queryArray);
        }
        
        if ( $checkResult && isset($post['catList']) ) {
            $queryDeleteArray = array();
            $queryDeleteArray['article_id'] = $article_id;
            $database->deleteFrom("#__article_category_xref",$queryDeleteArray);
            foreach( $post['catList'] as $cat_id ) {
                if ( $cat_id !== '0' ) {
                    $queryArray = array();
                    $queryArray['cat_id'] = $cat_id;
                    $queryArray['article_id'] = $article_id;
                    $database->insertTo("#__article_category_xref",$queryArray);
                }
            }
        }
        
        if ( $checkResult ) {
            
            $this->saveArticleToArchiveBackup($article_id);
            return $article_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callEdit_savePost_update() {
        global $database, $user, $get, $post, $lang;
        
        $article_id = $get['id'];
        
        $date_mod = cb_time_to_date();
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            gotostart:
            $database->newQuery();
            $database->select("`id`,`version`");
            $database->from("`#__article`");
            $database->where("`article_id` = '".$article_id."' and `lang` = '$l' ");
            $database->limit(" 1 ");
            $database->qType("row");
            $a = $database->execute();
            
            if ( !$a ) {
                $queryArray = array();
                $queryArray['article_id'] = $article_id;
                $queryArray['lang'] = $l;
                $queryArray['date_create'] = $date_mod;
                $queryArray['version'] = 1;
                $queryArray['media'] = json_encode(array("thumbnail"=>"","headerimage"=>"","youtubevideo"=>""));
                
                $database->insertTo("#__article",$queryArray);
                goto gotostart;
            }
            
            $id = $a['id'];
            
            $this->saveArticleToArchive($id);
            
            $version = $a['version'] + 1;
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            
            $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
            $state = ( empty($post['name'][$l]) AND empty($post['text'][$l]) ) ? 0 : $state;
            
            $qUpdate = Array();
            $qUpdate['name'] = $post['name'][$l];
            $qUpdate['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $qUpdate['date_mod'] = $date_mod;
            $qUpdate['meta_keywords'] = $post['meta_keywords'][$l];
            $qUpdate['meta_description'] = $post['meta_description'][$l];
            $qUpdate['version'] = $version;
            $qUpdate['template'] = $post['other_template'];
            $qUpdate['class'] = $post['other_class'];
            $qUpdate['css'] = $post['other_css'];
            $qUpdate['js'] = $post['other_js'];
            //$qUpdate['lang'] = $l;
            $qUpdate['state'] = $state;
            $qUpdate['id'] = $id;
            $uCheck = $database->updateTo("#__article",'id',$qUpdate);
        }
        
        if ($uCheck) {
            if ( isset($post['catList']) ) {
                $queryDeleteArray = array();
                $queryDeleteArray['article_id'] = $article_id;
                $database->deleteFrom("#__article_category_xref",$queryDeleteArray);
                foreach( $post['catList'] as $cat_id ) {
                    if ( $cat_id !== '0' ) {
                        $queryArray = array();
                        $queryArray['cat_id'] = $cat_id;
                        $queryArray['article_id'] = $article_id;
                        $database->insertTo("#__article_category_xref",$queryArray);
                    }
                }
            }
            
            return $article_id;
        } else {
            return FALSE;
        }
    }
    
    private function saveArticleToArchiveBackup($article_id) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article`");
        $database->where("`article_id` = '".$article_id."' ");
        $database->qType("array");
        $data = $database->execute();
        
        foreach ( $data as $a ) {
            $this->saveArticleToArchive($a['id'],0);
        } 
    }
    
    private function saveArticleToArchive($id, $version = NULL) {
        global $database;
        
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article`");
        $database->where("`id` = '".$id."' ");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        if ( $data ) {
            $database->newQuery();
            $database->select("*");
            $database->from("`#__article_category_xref`");
            $database->where("`article_id` = '".$data['article_id']."' ");
            $database->limit(" 1 ");
            $database->qType("array");
            $cdata = $database->execute();
            
            $category_xref = "";
            if ( !empty($cdata) ) {
                foreach ( $cdata as $v ) {
                    if ( !empty($category_xref) ) { $category_xref .= "|";}
                    $category_xref .= $v['cat_id'];
                }
            }
            unset($data['id']);
            $queryArray = array();
            foreach ($data as $k=>$v) { $queryArray[$k] = $v; }
            $queryArray['category_xref'] = $category_xref;
            if ( $version !== NULL ) {
                $queryArray['version'] = $version;
            }
            if ( $queryArray['date_create'] == '' ) { unset($queryArray['date_create']); }
            if ( $queryArray['date_mod'] == '' ) { unset($queryArray['date_mod']); }
            $database->insertTo("#__article_archive",$queryArray);
        }
    }


    protected function callCreate_savePost_saveFile($article_id) {
        global $post, $module;
        
        if ( $module->cb_check_access('article','content_thumbnail_upload_access','admin') ) {
            if ( isset($post['thumbnail_delete'])) { $this->callCreate_savePost_saveFile_deletePreviousThumbnail($article_id); }
            if ( cb_file_uploaded("thumbnail_file") ) {
                $check = getimagesize($_FILES["thumbnail_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['thumbnail_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['thumbnail_file']['name'], strrpos($_FILES['thumbnail_file']['name'], '.') + 1));

                    $this->callCreate_savePost_saveFile_deletePreviousThumbnail($article_id);
                    $this->callCreate_savePost_saveFile_saveNewThumbnail($article_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('article','content_headerimage_upload_access','admin') ) {
            if ( isset($post['headerimage_delete'])) { $this->callCreate_savePost_saveFile_deletePreviousHeaderimage($article_id); }
            if ( cb_file_uploaded("headerimage_file") ) {
                $check = getimagesize($_FILES["headerimage_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['headerimage_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['headerimage_file']['name'], strrpos($_FILES['headerimage_file']['name'], '.') + 1));

                    $this->callCreate_savePost_saveFile_deletePreviousHeaderimage($article_id);
                    $this->callCreate_savePost_saveFile_saveNewHeaderimage($article_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('article','content_youtubevideo_upload_access','admin') ) {
            if ( isset($post['youtubevideo']) ) {
                $this->callArticleCreate_savePost_saveMedia($article_id,$post['youtubevideo']);
            }
        }
    }
    
    private function callCreate_savePost_saveFile_saveNewThumbnail($article_id, $file, $extension = NULL) {
        global $database;
        
        $articleData = $this->articleGetDatabaseData2($article_id);
        
        $media = json_decode($articleData['media'], true);
        
        if ( isset($media['thumbnail']) && empty($media['thumbnail']) ) {
            $path = $this->articleContentImagePath;
            $pathOut_original = $path . $this->articleContentImagePath_original;
            $pathOut_normal = $path . $this->articleContentImagePath_normal;
            $pathOut_small = $path . $this->articleContentImagePath_small;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $articleData['article_id']."_thumbnail_".$timestamp;
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
            
            $media['thumbnail'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['article_id'] = $article_id;
            $uCheck = $database->updateTo("#__article",'article_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCreate_savePost_saveFile_saveNewHeaderImage($article_id, $file, $extension = NULL) {
        global $database;
        
        $articleData = $this->articleGetDatabaseData2($article_id);
        
        $media = json_decode($articleData['media'], true);
        
        if ( isset($media['headerimage']) && empty($media['headerimage']) ) {
            $path = $this->articleContentImagePath;
            $pathOut_original = $path . $this->articleContentImagePath_original;
            $pathOut_normal = $path . $this->articleContentImagePath_normal;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $articleData['article_id']."_headerimage_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_ARTICLE_THUMBNAIL_NORMAL_WIDTH) || CB_ARTICLE_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_ARTICLE_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_ARTICLE_THUMBNAIL_NORMAL_HEIGHT) || CB_ARTICLE_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_ARTICLE_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['headerimage'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['article_id'] = $article_id;
            $uCheck = $database->updateTo("#__article",'article_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callArticleCreate_savePost_saveMedia($article_id, $youtubevideo) {
        global $database;
        
        $articleData = $this->articleGetDatabaseData2($article_id);
        $media = json_decode($articleData['media'], true);
                
        if ( isset($youtubevideo) ) {
            if ( strpos($youtubevideo, 'v=') !== false ) {
                $y = explode("v=",$youtubevideo);
                if ( strpos($y[1], '&') !== false ) {
                    $y = explode("&",$y[1]);
                    $youtubevideo = $y[0];
                } else {
                    $youtubevideo = $y[1];
                }
            }
            
            $media['youtubevideo'] = $youtubevideo;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['article_id'] = $article_id;
            $uCheck = $database->updateTo("#__article",'article_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCreate_savePost_saveFile_deletePreviousThumbnail($article_id) {
        global $database;
        
        $articleData = $this->articleGetDatabaseData2($article_id);
        $media = json_decode($articleData['media'], true);
        
        if ( isset($media['thumbnail']) && !empty($media['thumbnail']) || !isset($media['thumbnail']) ) {
            $path = $this->articleContentImagePath;
            $pathOut_original = $path . $this->articleContentImagePath_original;
            $pathOut_normal = $path . $this->articleContentImagePath_normal;
            $pathOut_small = $path . $this->articleContentImagePath_small;
            unlink($pathOut_original.$media['thumbnail']);
            unlink($pathOut_normal.$media['thumbnail']);
            unlink($pathOut_small.$media['thumbnail']);
            
            $media['thumbnail'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['article_id'] = $article_id;
            $uCheck = $database->updateTo("#__article",'article_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCreate_savePost_saveFile_deletePreviousHeaderimage($article_id) {
        global $database;
        
        $articleData = $this->articleGetDatabaseData2($article_id);
        $media = json_decode($articleData['media'], true);
        
        if ( isset($media['headerimage']) && !empty($media['headerimage']) || !isset($media['headerimage']) ) {
            $path = $this->articleContentImagePath;
            $pathOut_original = $path . $this->articleContentImagePath_original;
            $pathOut_normal = $path . $this->articleContentImagePath_normal;
            unlink($pathOut_original.$media['headerimage']);
            unlink($pathOut_normal.$media['headerimage']);
            
            $media['headerimage'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['article_id'] = $article_id;
            $uCheck = $database->updateTo("#__article",'article_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    protected function articleGetDatabaseData2($article_id) {
        global $database;
        $database->newQuery();
        $database->select("*");
        $database->from("`#__article`");
        $database->where("`article_id` = '".$article_id."'");
        $database->limit(" 1 ");
        $database->qType("row");
        $data = $database->execute();
        
        return $data;
    }
}

return; ?>