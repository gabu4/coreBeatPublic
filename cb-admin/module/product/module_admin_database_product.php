<?php
namespace module\admin\product\product;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function callProductCreate_savePost_getProductID() {
        global $database;
        
        $database->newQuery();
        $database->select("`product_id`");
        $database->from("`#__product_product`");
        $database->order("`product_id` DESC");
        $database->limit(" 1 ");
        $database->qType("result");
        $product_id = $database->execute();
        
        return $product_id+1;
    }
    
    protected function callProductCreate_savePost_getProductLastID() {
        global $database;
        
        $database->newQuery();
        $database->select("`id`");
        $database->from("`#__product_product`");
        $database->order("1");
        $database->limit(" 1 ");
        $database->order("`id` DESC");
        $database->qType("result");
        $id = $database->execute();
        
        return $id;
    }
    
    protected function callProductCreate_categoryListCreate_getDataToCheck($product_id) {
        global $database;
        
        $database->newQuery();
        $database->select("`cat_id`");
        $database->from("`#__product_category_xref`");
        $database->where("`product_id` = '".$product_id."'");
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
    
    protected function callProductCreate_categoryListCreate_getData($language = NULL) {
        global $database, $lang;
        
        if ( $language === NULL ) { $language = $lang->getAdminLanguage(); }
        
        $database->newQuery();
        $database->select("`pcat`.*");
        $database->from("`#__product_category` `pcat`");
        $database->where("`pcat`.`state` > '0' and `pcat`.`lang` = '".$language."' ");
        $database->group("`pcat`.`cat_id`,`pcat`.`lang`");
        $database->order("`pcat`.`cat_id` ASC");
        $categoryListData = $database->execute();
        
        return $categoryListData;
    }
    
    protected function callProductCreate_savePost_asNew() {
        global $post, $database, $lang, $module;
        
        require_once(CB_ADMIN.'/module/menu/menupoint/function_global.php');
        $content_type_id = savePost_getContentTypeId('product','product');
        $product_id = $this->callProductCreate_savePost_getProductID();
        $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
        
        $cre_date = cb_time_to_date();
        
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            $post['shorttext'][$l] = htmlentities($post['shorttext'][$l],ENT_QUOTES);
            $post['text'][$l] = htmlentities($post['text'][$l],ENT_QUOTES);
            
            $queryArray = array();
            $queryArray['product_id'] = $product_id;
            $queryArray['name'] = $post['name'][$l];
            $queryArray['shorttext'] = $post['shorttext'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $queryArray['text'] = $post['text'][$l]; //html_entity_decode($post['text'], ENT_QUOTES | ENT_HTML401, 'UTF-8');
            $queryArray['cre_date'] = $cre_date;
            $queryArray['lang'] = $l;
            $queryArray['meta_keywords'] = $post['meta_keywords'][$l];
            $queryArray['meta_description'] = $post['meta_description'][$l];
            $queryArray['state'] = $state;
            $queryArray['media'] = json_encode(array("thumbnail"=>"","headerimage"=>"","productimage"=>"","youtubevideo"=>""));

            $checkResult = $database->insertTo("#__product_product",$queryArray);
            
            $id = $this->callProductCreate_savePost_getProductLastID();
            
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
                $value = json_encode(array("id"=>$product_id));
                $queryArray2['value'] = $value;
                $checkResult2 = $database->insertOrUpdate("#__content",$queryArray2);
                
                $qUpdate = Array();
                $qUpdate['id'] = $id;
                $qUpdate['content_id'] = $content_id;
                $uCheck = $database->updateTo("#__product_product",'id',$qUpdate);
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
            $uCheck = $database->updateTo("#__product_product",'id',$qUpdate);
        }
        
        if ( $checkResult && isset($post['catList']) ) {
            $queryDeleteArray = array();
            $queryDeleteArray['product_id'] = $product_id;
            $database->deleteFrom("#__product_category_xref",$queryDeleteArray);
            foreach( $post['catList'] as $cat_id ) {
                if ( $cat_id !== '0' ) {
                    $queryArray = array();
                    $queryArray['cat_id'] = $cat_id;
                    $queryArray['product_id'] = $product_id;
                    $database->insertTo("#__product_category_xref",$queryArray);
                }
            }
        }
        
        if ( $checkResult ) {
            return $product_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callProductEdit_savePost_update() {
        global $database, $post, $lang, $module;
        
        require_once(CB_ADMIN.'/module/menu/menupoint/function_global.php');
        $content_type_id = savePost_getContentTypeId('product','product');
        $product_id = $post['product_id'];
        
        $mod_date = cb_time_to_date();
        
            //cbd($post,1);
        foreach ( $lang->getAllowedLanguageTypes() as $l ) {
            gotostart:
            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__product_product`");
            $database->where("`product_id` = '".$product_id."' and `lang` = '$l' ");
            $database->limit(" 1 ");
            $database->qType("result");
            $id = $database->execute();
            
            if ( !$id ) {
                $queryArray = array();
                $queryArray['product_id'] = $product_id;
                $queryArray['lang'] = $l;
                $queryArray['cre_date'] = $mod_date;
                $queryArray['media'] = json_encode(array("thumbnail"=>"","headerimage"=>"","productimage"=>"","youtubevideo"=>""));
                
                $database->insertTo("#__product_product",$queryArray);
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
            $uCheck = $database->updateTo("#__product_product",'id',$qUpdate);
            
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
                $value = json_encode(array("id"=>$product_id));
                $queryArray2['value'] = $value;
                $checkResult2 = $database->insertOrUpdate("#__content",$queryArray2);
                
                $qUpdate = Array();
                $qUpdate['id'] = $id;
                $qUpdate['content_id'] = $content_id;
                $uCheck = $database->updateTo("#__product_product",'id',$qUpdate);
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
            $uCheck = $database->updateTo("#__product_product",'id',$qUpdate);
        }
        
        if ($uCheck) {
            if ( isset($post['catList']) ) {
                $queryDeleteArray = array();
                $queryDeleteArray['product_id'] = $product_id;
                $database->deleteFrom("#__product_category_xref",$queryDeleteArray);
                foreach( $post['catList'] as $cat_id ) {
                    if ( $cat_id !== '0' ) {
                        $queryArray = array();
                        $queryArray['cat_id'] = $cat_id;
                        $queryArray['product_id'] = $product_id;
                        $database->insertTo("#__product_category_xref",$queryArray);
                    }
                }
            }
            
            return $product_id;
        } else {
            return FALSE;
        }
    }
    
    protected function callProductCreate_savePost_saveFile($product_id) {
        global $post, $database, $module;
        
        if ( $module->cb_check_access('product','content_thumbnail_upload_access','admin') ) {
            if ( isset($post['thumbnail_delete'])) { $this->callProductCreate_savePost_saveFile_deletePreviousThumbnail($product_id); }
            if ( cb_file_uploaded("thumbnail_file") ) {
                $check = getimagesize($_FILES["thumbnail_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['thumbnail_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['thumbnail_file']['name'], strrpos($_FILES['thumbnail_file']['name'], '.') + 1));

                    $this->callProductCreate_savePost_saveFile_deletePreviousThumbnail($product_id);
                    $this->callProductCreate_savePost_saveFile_saveNewThumbnail($product_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('product','content_productimage_upload_access','admin') ) {
            if ( isset($post['productimage_delete'])) { $this->callProductCreate_savePost_saveFile_deletePreviousProductimage($product_id); }
            if ( cb_file_uploaded("productimage_file") ) {
                $check = getimagesize($_FILES["productimage_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['productimage_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['productimage_file']['name'], strrpos($_FILES['productimage_file']['name'], '.') + 1));

                    $this->callProductCreate_savePost_saveFile_deletePreviousProductimage($product_id);
                    $this->callProductCreate_savePost_saveFile_saveNewProductimage($product_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('product','content_headerimage_upload_access','admin') ) {
            if ( isset($post['headerimage_delete'])) { $this->callProductCreate_savePost_saveFile_deletePreviousHeaderimage($product_id); }
            if ( cb_file_uploaded("headerimage_file") ) {
                $check = getimagesize($_FILES["headerimage_file"]["tmp_name"]);
                if($check !== false) {

                    $sourcePath = $_FILES['headerimage_file']['tmp_name'];       // Storing source path of the file in a variable
                    $extension = strtolower(substr($_FILES['headerimage_file']['name'], strrpos($_FILES['headerimage_file']['name'], '.') + 1));

                    $this->callProductCreate_savePost_saveFile_deletePreviousHeaderimage($product_id);
                    $this->callProductCreate_savePost_saveFile_saveNewHeaderimage($product_id,$sourcePath,$extension);
                }
            }
        }
        
        if ( $module->cb_check_access('product','content_youtubevideo_upload_access','admin') ) {
            if ( isset($post['youtubevideo']) ) {
                $this->callProductCreate_savePost_saveMedia($product_id,$post['youtubevideo']);
            }
        }
    }
    
    private function callProductCreate_savePost_saveFile_saveNewThumbnail($product_id, $file, $extension = NULL) {
        global $database;
        
        $productData = $this->productGetDatabaseData2($product_id);
        
        $media = json_decode($productData['media'], true);
        
        if ( !empty($file) ) {
            $path = $this->productContentImagePath;
            $pathOut_original = $path . $this->productContentImagePath_original;
            $pathOut_normal = $path . $this->productContentImagePath_normal;
            $pathOut_small = $path . $this->productContentImagePath_small;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $productData['product_id']."_thumbnail_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777, TRUE); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_PRODUCT_THUMBNAIL_SMALL_WIDTH) || CB_PRODUCT_THUMBNAIL_SMALL_WIDTH == '0' ) ? 1000 : CB_PRODUCT_THUMBNAIL_SMALL_WIDTH;
            $height = ( empty(CB_PRODUCT_THUMBNAIL_SMALL_HEIGHT) || CB_PRODUCT_THUMBNAIL_SMALL_HEIGHT == '0' ) ? 1000 : CB_PRODUCT_THUMBNAIL_SMALL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_small.$filename,$width,$height);

            $width = ( empty(CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH) || CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT) || CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['thumbnail'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callProductCreate_savePost_saveFile_saveNewProductimage($product_id, $file, $extension = NULL) {
        global $database;
        
        $productData = $this->productGetDatabaseData2($product_id);
        
        $media = json_decode($productData['media'], true);
        
        if ( !empty($file) ) {
            $path = $this->productContentImagePath;
            $pathOut_original = $path . $this->productContentImagePath_original;
            $pathOut_normal = $path . $this->productContentImagePath_normal;
            $pathOut_small = $path . $this->productContentImagePath_small;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $productData['product_id']."_productimage_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777, TRUE); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_PRODUCT_THUMBNAIL_SMALL_WIDTH) || CB_PRODUCT_THUMBNAIL_SMALL_WIDTH == '0' ) ? 1000 : CB_PRODUCT_THUMBNAIL_SMALL_WIDTH;
            $height = ( empty(CB_PRODUCT_THUMBNAIL_SMALL_HEIGHT) || CB_PRODUCT_THUMBNAIL_SMALL_HEIGHT == '0' ) ? 1000 : CB_PRODUCT_THUMBNAIL_SMALL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_small.$filename,$width,$height);

            $width = ( empty(CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH) || CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT) || CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['productimage'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callProductCreate_savePost_saveFile_saveNewHeaderImage($product_id, $file, $extension = NULL) {
        global $database;
        
        $productData = $this->productGetDatabaseData2($product_id);
        
        $media = json_decode($productData['media'], true);
        
        if ( !empty($file) ) {
            $path = $this->productContentImagePath;
            $pathOut_original = $path . $this->productContentImagePath_original;
            $pathOut_normal = $path . $this->productContentImagePath_normal;
            
            if ( $extension === NULL ) {
                $extension = strtolower(substr($file, strrpos($file, '.') + 1));
            }
            $timestamp = time();
            $filename = $productData['product_id']."_headerimage_".$timestamp;
            $crc32 = crc32($filename);
            $filename .= "_".$crc32.".".$extension;
            
            if ( !is_dir($pathOut_original) ) { mkdir($pathOut_original, 0777); }
            cb_move_uploaded_file($file,$pathOut_original.$filename);

            $width = ( empty(CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH) || CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH == '0' ) ? 5000 : CB_PRODUCT_THUMBNAIL_NORMAL_WIDTH;
            $height = ( empty(CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT) || CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT == '0' ) ? 5000 : CB_PRODUCT_THUMBNAIL_NORMAL_HEIGHT;
            cb_img_resize($pathOut_original.$filename,$pathOut_normal.$filename,$width,$height);
            
            $media['headerimage'] = $filename;
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callProductCreate_savePost_saveMedia($product_id, $youtubevideo) {
        global $database;
        
        $productData = $this->productGetDatabaseData2($product_id);
        
        $media = json_decode($productData['media'], true);
        
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
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callProductCreate_savePost_saveFile_deletePreviousThumbnail($product_id) {
        global $database;
        
        $media = $this->getProductMediaValue($product_id);
        
        if ( isset($media['thumbnail']) && !empty($media['thumbnail']) ) {
            $path = $this->productContentImagePath;
            $pathOut_original = $path . $this->productContentImagePath_original;
            $pathOut_normal = $path . $this->productContentImagePath_normal;
            $pathOut_small = $path . $this->productContentImagePath_small;
            unlink($pathOut_original.$media['thumbnail']);
            unlink($pathOut_normal.$media['thumbnail']);
            unlink($pathOut_small.$media['thumbnail']);
            
            $media['thumbnail'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callProductCreate_savePost_saveFile_deletePreviousProductimage($product_id) {
        global $database;
        
        $media = $this->getProductMediaValue($product_id);
        
        if ( isset($media['productimage']) && !empty($media['productimage']) ) {
            $path = $this->productContentImagePath;
            $pathOut_original = $path . $this->productContentImagePath_original;
            $pathOut_normal = $path . $this->productContentImagePath_normal;
            $pathOut_small = $path . $this->productContentImagePath_small;
            unlink($pathOut_original.$media['productimage']);
            unlink($pathOut_normal.$media['productimage']);
            unlink($pathOut_small.$media['productimage']);
            
            $media['productimage'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
    
    private function callProductCreate_savePost_saveFile_deletePreviousHeaderimage($product_id) {
        global $database;
        
        $media = $this->getProductMediaValue($product_id);
        
        if ( isset($media['headerimage']) && !empty($media['headerimage']) ) {
            $path = $this->productContentImagePath;
            $pathOut_original = $path . $this->productContentImagePath_original;
            $pathOut_normal = $path . $this->productContentImagePath_normal;
            unlink($pathOut_original.$media['headerimage']);
            unlink($pathOut_normal.$media['headerimage']);
            
            $media['headerimage'] = "";
            $qUpdate = Array();
            $qUpdate['media'] = json_encode($media);
            $qUpdate['product_id'] = $product_id;
            $uCheck = $database->updateTo("#__product_product",'product_id',$qUpdate);
            
            if ( $uCheck ) { return true; }
        }
        return false;
    }
}

return; ?>