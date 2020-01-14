<?php
namespace module\admin\catalog\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v014
 * @date 07/12/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callCatalogDelete_checkID($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`id`,`catalog_id`");
        $database->from("`#__catalog`");
        $database->where("`catalog_id` = '".$id."'");
        $database->qType("array");
        $result = $database->execute();
        
        if ( !empty($result) ) {
            return $result;
        } else {
            return FALSE;
        }
    }
    
    protected function callCatalogDelete_deletingCatalog($data = array()) {
        global $database;
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__content_type`");
        $database->where("`module`='catalog' AND `type` = 'catalog'");
        $database->qType("result");
        $content_type_id = $database->execute();
        
        if ( empty($data) ) { return FALSE; }
        foreach ( $data as $k ) {
            $catalog_id = $k['catalog_id'];
            
            $queryDeleteArray = array();
            $queryDeleteArray['catalog_id'] = $catalog_id;
            $result = $database->deleteFrom('#__catalog',$queryDeleteArray);
            
            if ( $result ) {
                if ( !empty($content_type_id) ) {
                    $queryDeleteArray = array();
                    $queryDeleteArray['type'] = $content_type_id;
                    $queryDeleteArray['value'] = '{"id": "'.$catalog_id.'"}';
                    $result = $database->deleteFrom('#__content',$queryDeleteArray);
                }
                
                $queryDeleteArray = array();
                $queryDeleteArray['catalog_id'] = $catalog_id;
                $database->deleteFrom("#__catalog_category_xref",$queryDeleteArray);
            }
        }
        
        return $result;
    }
    
    protected function callCatalogCreate_savePost_getCatalogID() {
        global $database;
        
        $database->newQuery();
        $database->select("`catalog_id`");
        $database->from("`#__catalog`");
        $database->order("`catalog_id` DESC");
        $database->limit(" 1 ");
        $database->qType("result");
        $catalog_id = $database->execute();
        
        return $catalog_id+1;
    }
    
    protected function callCatalogCreate_savePost_getCatalogLastID() {
        global $database;
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__catalog`");
        $database->order("1");
        $database->limit(" 1 ");
        $database->order("`id` DESC");
        $database->qType("result");
        $id = $database->execute();
        
        return $id;
    }
    
    protected function callCatalogCreate_categoryListCreate_getDataToCheck($catalog_id) {
        global $database;
        
        $database->newQuery();
        $database->select("`category_id`");
        $database->from("`#__catalog_category_xref`");
        $database->where("`catalog_id` = '".$catalog_id."'");
        $database->order("`category_id` ASC");
        $dataCheckRaw = $database->execute();

        $dataCheck = array();

        if ( !empty($dataCheckRaw) ) {
            foreach ( $dataCheckRaw as $dc ) {
                $dataCheck[] = $dc['category_id'];
            }
        }
        
        return $dataCheck;
    }
    
    protected function callCatalogCreate_categoryListCreate_getData($language = NULL) {
        global $database, $lang;
        
        if ( $language === NULL ) { $language = $lang->getAdminLanguage(); }
        
        $database->newQuery();
        $database->select("`pcat`.*");
        $database->from("`#__catalog_category` `pcat`");
        $database->where("`pcat`.`state` > '0' and `pcat`.`lang` = '".$language."' ");
        $database->group("`pcat`.`category_id`,`pcat`.`lang`");
        $database->order("`pcat`.`category_id` ASC");
        $categoryListData = $database->execute();
        
        return $categoryListData;
    }
    
    protected function callCatalogCreate_savePost_asNew() {
        global $post, $database, $lang, $module;
        
        require_once(CB_ADMIN.'/module/menu/menupoint/function_global.php');
        $content_type_id = savePost_getContentTypeId('catalog','catalog');
        $catalog_id = $this->callCatalogCreate_savePost_getCatalogID();
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        
        $cre_date = cb_time_to_date();
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $post['shorttext'][$l] = htmlentities($post['shorttext'][$l],ENT_QUOTES);
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            
            $queryArray = array();
            $queryArray['catalog_id'] = $catalog_id;
            $queryArray['name'] = $post['name'][$l];
            $queryArray['shorttext'] = $post['shorttext'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $queryArray['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $queryArray['cre_date'] = $cre_date;
            $queryArray['lang'] = $l;
            $queryArray['meta_keywords'] = $post['meta_keywords'][$l];
            $queryArray['meta_description'] = $post['meta_description'][$l];
            $queryArray['state'] = $state;
            $queryArray['media'] = json_encode(array("thumbnail"=>"","headerimage"=>"","catalogimage"=>"","youtubevideo"=>""));

            $checkResult = $database->insertTo("#__catalog",$queryArray);
            
            $id = $this->callCatalogCreate_savePost_getCatalogLastID();
            
            $seo_data = array('name'=>$post['name'][$l],'seoname'=>$post['seo_name'][$l],'language'=>$l);
            $seo_name = $module->loadAdminFunction('admin','seonamegenerate',$seo_data);
            
            $content_id = 0;
            if ( !empty($post['name'][$l]) ) {
                $content_id = ( isset($post['content_id'][$l]) && $post['content_id'][$l] != 0 ) ? $post['content_id'][$l] : savePost_getNextContentId();
                
                $queryArray2 = array();
                $queryArray2['id'] = $content_id;
                $queryArray2['name'] = $post['name'][$l];
                $queryArray2['seo_name'] = $seo_name['seoname'];
                $queryArray2['type'] = $content_type_id;
                $queryArray2['lang'] = $l;
                $value = json_encode(array("id"=>$catalog_id));
                $queryArray2['value'] = $value;
                $checkResult2 = $database->insertOrUpdate("#__content",$queryArray2);
                
                $qUpdate = Array();
                $qUpdate['id'] = $id;
                $qUpdate['content_id'] = $content_id;
                $uCheck = $database->updateTo("#__catalog",'id',$qUpdate);
            } elseif ( isset($post['content_id'][$l]) && $post['content_id'][$l] != 0 ) {
                $queryDeleteArray = array();
                $queryDeleteArray['lang'] = $l;
                $queryDeleteArray['id'] = $content_id;
                $queryDeleteArray['type'] = $content_type_id;
                $checkResult2 = $database->deleteFrom("#__content",$queryDeleteArray);
            }
            
            $qUpdate = Array();
            $qUpdate['id'] = $id;
            $qUpdate['content_id'] = $content_id;
            $uCheck = $database->updateTo("#__catalog",'id',$qUpdate);
        }
        
        if ( $checkResult && isset($post['catList']) ) {
            $queryDeleteArray = array();
            $queryDeleteArray['catalog_id'] = $catalog_id;
            $database->deleteFrom("#__catalog_category_xref",$queryDeleteArray);
            foreach( $post['catList'] as $category_id ) {
                if ( $category_id !== '0' ) {
                    $queryArray = array();
                    $queryArray['category_id'] = $category_id;
                    $queryArray['catalog_id'] = $catalog_id;
                    $database->insertTo("#__catalog_category_xref",$queryArray);
                }
            }
        }
        
        if ( $checkResult ) {
            return $catalog_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callCatalogEdit_savePost_update() {
        global $database, $post, $lang, $module;
        
        require_once(CB_ADMIN.'/module/menu/menupoint/function_global.php');
        $content_type_id = savePost_getContentTypeId('catalog','catalog');
        $catalog_id = $post['catalog_id'];
        
        $mod_date = cb_time_to_date();
        
            //cbd($post,1);
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            gotostart:
            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__catalog`");
            $database->where("`catalog_id` = '".$catalog_id."' and `lang` = '$l' ");
            $database->limit(" 1 ");
            $database->qType("result");
            $id = $database->execute();
            
            if ( !$id ) {
                $queryArray = array();
                $queryArray['catalog_id'] = $catalog_id;
                $queryArray['lang'] = $l;
                $queryArray['cre_date'] = $mod_date;
                $queryArray['media'] = json_encode(array("thumbnail"=>"","headerimage"=>"","catalogimage"=>"","youtubevideo"=>""));
                
                $database->insertTo("#__catalog",$queryArray);
                goto gotostart;
            }
            $post['shorttext'][$l] = htmlentities($post['shorttext'][$l],ENT_QUOTES);
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            
            $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
            $state = ( empty($post['name'][$l]) AND empty($post['text'][$l]) ) ? 0 : $state;
            
            $qUpdate = Array();
            $qUpdate['name'] = $post['name'][$l];
            $qUpdate['shorttext'] = $post['shorttext'][$l];
            $qUpdate['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $qUpdate['mod_date'] = $mod_date;
            $qUpdate['meta_keywords'] = $post['meta_keywords'][$l];
            $qUpdate['meta_description'] = $post['meta_description'][$l];
            //$qUpdate['lang'] = $l;
            $qUpdate['state'] = $state;
            $qUpdate['id'] = $id;
            $uCheck = $database->updateTo("#__catalog",'id',$qUpdate);
            
            $content_id = ( isset($post['content_id'][$l]) && $post['content_id'][$l] != 0 ) ? $post['content_id'][$l] : savePost_getNextContentId();
            $seo_data = array('name'=>$post['name'][$l],'seoname'=>$post['seo_name'][$l],'id'=>$content_id,'language'=>$l);
            $seo_name = $module->loadAdminFunction('admin','seonamegenerate',$seo_data);
            
            if ( !empty($post['name'][$l]) ) {
                $queryArray2 = array();
                $queryArray2['id'] = $content_id;
                $queryArray2['name'] = $post['name'][$l];
                $queryArray2['seo_name'] = $seo_name['seoname'];
                $queryArray2['type'] = $content_type_id;
                $queryArray2['lang'] = $l;
                $value = json_encode(array("id"=>$catalog_id));
                $queryArray2['value'] = $value;
                $checkResult2 = $database->insertOrUpdate("#__content",$queryArray2);
                
                $qUpdate = Array();
                $qUpdate['id'] = $id;
                $qUpdate['content_id'] = $content_id;
                $uCheck = $database->updateTo("#__catalog",'id',$qUpdate);
            } elseif ( isset($post['content_id'][$l]) && $post['content_id'][$l] != 0 ) {
                $queryDeleteArray = array();
                $queryDeleteArray['lang'] = $l;
                $queryDeleteArray['id'] = $content_id;
                $queryDeleteArray['type'] = $content_type_id;
                $checkResult2 = $database->deleteFrom("#__content",$queryDeleteArray);
                $content_id = 0;
            } else {
                $content_id = 0;
            }
            
            $qUpdate = Array();
            $qUpdate['id'] = $id;
            $qUpdate['content_id'] = $content_id;
            $uCheck = $database->updateTo("#__catalog",'id',$qUpdate);
        }
        
        if ($uCheck) {
            if ( isset($post['catList']) ) {
                $queryDeleteArray = array();
                $queryDeleteArray['catalog_id'] = $catalog_id;
                $database->deleteFrom("#__catalog_category_xref",$queryDeleteArray);
                foreach( $post['catList'] as $category_id ) {
                    if ( $category_id !== '0' ) {
                        $queryArray = array();
                        $queryArray['category_id'] = $category_id;
                        $queryArray['catalog_id'] = $catalog_id;
                        $database->insertTo("#__catalog_category_xref",$queryArray);
                    }
                }
            }
            
            return $catalog_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callCatalogCreate_savePost_saveFile($catalog_id) {
        global $post, $database, $module;
        
        if ( $module->cb_check_access('catalog','content_thumbnail_upload_access','admin') ) {
            if ( isset($post['thumbnail_delete'])) { $this->callCatalogCreate_savePost_saveFile_deletePreviousThumbnail($catalog_id); }
            if ( cb_file_uploaded("thumbnail_file") ) {
                $check = getimagesize($_FILES["thumbnail_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['thumbnail_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['thumbnail_file']['name'], strrpos($_FILES['thumbnail_file']['name'], '.') + 1));

                    $this->callCatalogCreate_savePost_saveFile_deletePreviousThumbnail($catalog_id);
                    $this->callCatalogCreate_savePost_saveFile_saveNewThumbnail($catalog_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('catalog','content_catalogimage_upload_access','admin') ) {
            if ( isset($post['catalogimage_delete'])) { $this->callCatalogCreate_savePost_saveFile_deletePreviousCatalogimage($catalog_id); }
            if ( cb_file_uploaded("catalogimage_file") ) {
                $check = getimagesize($_FILES["catalogimage_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['catalogimage_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['catalogimage_file']['name'], strrpos($_FILES['catalogimage_file']['name'], '.') + 1));

                    $this->callCatalogCreate_savePost_saveFile_deletePreviousCatalogimage($catalog_id);
                    $this->callCatalogCreate_savePost_saveFile_saveNewCatalogimage($catalog_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('catalog','content_headerimage_upload_access','admin') ) {
            if ( isset($post['headerimage_delete'])) { $this->callCatalogCreate_savePost_saveFile_deletePreviousHeaderimage($catalog_id); }
            if ( cb_file_uploaded("headerimage_file") ) {
                $check = getimagesize($_FILES["headerimage_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['headerimage_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['headerimage_file']['name'], strrpos($_FILES['headerimage_file']['name'], '.') + 1));

                    $this->callCatalogCreate_savePost_saveFile_deletePreviousHeaderimage($catalog_id);
                    $this->callCatalogCreate_savePost_saveFile_saveNewHeaderimage($catalog_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('catalog','content_youtubevideo_upload_access','admin') ) {
            if ( isset($post['youtubevideo']) ) {
                $this->callCatalogCreate_savePost_saveMedia($catalog_id,$post['youtubevideo']);
            }
        }
    }
    
    private function callCatalogCreate_savePost_saveFile_saveNewThumbnail($catalog_id, $file, $extension = NULL) {
        global $database;
        
        $catalogData = $this->catalogGetDatabaseData2($catalog_id);
        
        $media = json_decode($catalogData['media'], true);
        
        if ( !empty($file) ) {
            $path = $this->catalogContentImagePath;
            $pathOut_original = $path . $this->catalogContentImagePath_original;
            $pathOut_normal = $path . $this->catalogContentImagePath_normal;
            $pathOut_small = $path . $this->catalogContentImagePath_small;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $catalogData['catalog_id']."_thumbnail_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777, TRUE); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_CATALOG_THUMBNAIL_SMALL_WIDTH) || CB_CATALOG_THUMBNAIL_SMALL_WIDTH == '0' ) ? 1000 : CB_CATALOG_THUMBNAIL_SMALL_WIDTH;
            $height = ( empty(CB_CATALOG_THUMBNAIL_SMALL_HEIGHT) || CB_CATALOG_THUMBNAIL_SMALL_HEIGHT == '0' ) ? 1000 : CB_CATALOG_THUMBNAIL_SMALL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_small.$filename,$width,$height);

            $width = ( empty(CB_CATALOG_THUMBNAIL_NORMAL_WIDTH) || CB_CATALOG_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_CATALOG_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT) || CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['thumbnail'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCatalogCreate_savePost_saveFile_saveNewCatalogimage($catalog_id, $file, $extension = NULL) {
        global $database;
        
        $catalogData = $this->catalogGetDatabaseData2($catalog_id);
        
        $media = json_decode($catalogData['media'], true);
        
        if ( !empty($file) ) {
            $path = $this->catalogContentImagePath;
            $pathOut_original = $path . $this->catalogContentImagePath_original;
            $pathOut_normal = $path . $this->catalogContentImagePath_normal;
            $pathOut_small = $path . $this->catalogContentImagePath_small;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $catalogData['catalog_id']."_catalogimage_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777, TRUE); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_CATALOG_THUMBNAIL_SMALL_WIDTH) || CB_CATALOG_THUMBNAIL_SMALL_WIDTH == '0' ) ? 1000 : CB_CATALOG_THUMBNAIL_SMALL_WIDTH;
            $height = ( empty(CB_CATALOG_THUMBNAIL_SMALL_HEIGHT) || CB_CATALOG_THUMBNAIL_SMALL_HEIGHT == '0' ) ? 1000 : CB_CATALOG_THUMBNAIL_SMALL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_small.$filename,$width,$height);

            $width = ( empty(CB_CATALOG_THUMBNAIL_NORMAL_WIDTH) || CB_CATALOG_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_CATALOG_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT) || CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['catalogimage'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCatalogCreate_savePost_saveFile_saveNewHeaderImage($catalog_id, $file, $extension = NULL) {
        global $database;
        
        $catalogData = $this->catalogGetDatabaseData2($catalog_id);
        
        $media = json_decode($catalogData['media'], true);
        
        if ( !empty($file) ) {
            $path = $this->catalogContentImagePath;
            $pathOut_original = $path . $this->catalogContentImagePath_original;
            $pathOut_normal = $path . $this->catalogContentImagePath_normal;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $catalogData['catalog_id']."_headerimage_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_CATALOG_THUMBNAIL_NORMAL_WIDTH) || CB_CATALOG_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_CATALOG_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT) || CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_CATALOG_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['headerimage'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCatalogCreate_savePost_saveMedia($catalog_id, $youtubevideo) {
        global $database;
        
        $catalogData = $this->catalogGetDatabaseData2($catalog_id);
        
        $media = json_decode($catalogData['media'], true);
        
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
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCatalogCreate_savePost_saveFile_deletePreviousThumbnail($catalog_id) {
        global $database;
        
        $media = $this->getCatalogMediaValue($catalog_id);
        
        if ( isset($media['thumbnail']) && !empty($media['thumbnail']) ) {
            $path = $this->catalogContentImagePath;
            $pathOut_original = $path . $this->catalogContentImagePath_original;
            $pathOut_normal = $path . $this->catalogContentImagePath_normal;
            $pathOut_small = $path . $this->catalogContentImagePath_small;
            unlink($pathOut_original.$media['thumbnail']);
            unlink($pathOut_normal.$media['thumbnail']);
            unlink($pathOut_small.$media['thumbnail']);
            
            $media['thumbnail'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCatalogCreate_savePost_saveFile_deletePreviousCatalogimage($catalog_id) {
        global $database;
        
        $media = $this->getCatalogMediaValue($catalog_id);
        
        if ( isset($media['catalogimage']) && !empty($media['catalogimage']) ) {
            $path = $this->catalogContentImagePath;
            $pathOut_original = $path . $this->catalogContentImagePath_original;
            $pathOut_normal = $path . $this->catalogContentImagePath_normal;
            $pathOut_small = $path . $this->catalogContentImagePath_small;
            unlink($pathOut_original.$media['catalogimage']);
            unlink($pathOut_normal.$media['catalogimage']);
            unlink($pathOut_small.$media['catalogimage']);
            
            $media['catalogimage'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callCatalogCreate_savePost_saveFile_deletePreviousHeaderimage($catalog_id) {
        global $database;
        
        $media = $this->getCatalogMediaValue($catalog_id);
        
        if ( isset($media['headerimage']) && !empty($media['headerimage']) ) {
            $path = $this->catalogContentImagePath;
            $pathOut_original = $path . $this->catalogContentImagePath_original;
            $pathOut_normal = $path . $this->catalogContentImagePath_normal;
            unlink($pathOut_original.$media['headerimage']);
            unlink($pathOut_normal.$media['headerimage']);
            
            $media['headerimage'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['catalog_id'] = $catalog_id;
            $uCheck = $database->updateTo("#__catalog",'catalog_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
}

return; ?>