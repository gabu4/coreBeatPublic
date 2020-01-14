<?php
namespace module\admin\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    protected function getGalleryGroupsDB() {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery_category');
        $database->where(' `state` >= "0" ');
        $database->qType('array');
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
    
    protected function getGalleryGroupDataDB($cat_id) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery_category');
        $database->where(' `id` = "'.$cat_id.'" AND `state` >= "0" ');
        $database->qType('row');
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
    
    protected function saveGalleryGroupDataFromDir($dirName) {
        global $database;
        
        $insertData = Array(
            "name" => $dirName,
            "dir" => $dirName,
            "class" => "",
            "state" => 1
        );

        $res = $database->insertOrUpdate("#__gallery_category",$insertData);
        
        if ( $res ) {
            $database->newQuery();
            $database->select('*');
            $database->from('#__gallery_category');
            $database->where(' `dir` = "'.$dirName.'" ');
            $database->limit(' 1 ');
            $database->qType('row');
            return $database->execute();
        }
        
        return $res;
    }
    
    protected function getGalleryFileDataDB($cat_id) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery');
        $database->where(' `cat_id` = "'.$cat_id.'" ');
        $database->order(' `order` ASC ');
        $database->qType('array');
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
        
    }

    protected function saveDbData($cat_id,$post) {
        global $database;
        
        $order = 0;
        
        $updateQuery = array();
        $updateQuery['cat_id'] = $cat_id;
        $updateQuery['del'] = '1';
        $result = $database->updateTo('#__gallery','cat_id',$updateQuery);
                
        if ( isset($post['title']) ) {
            foreach ($post['title'] as $md5name => $title) {
                $order++;
                $insertData = Array(
                    "cat_id" => $cat_id,
                    "md5" => $md5name,
                    "filename" => $post['filename'][$md5name],
                    "title" => trim($title),
                    "order" => $order,
                    "del" => 0,
                );

                $res = $database->insertOrUpdate("#__gallery",$insertData);
            }
        }
        
        $this->saveDbData_deletingOld($cat_id);
        
        return TRUE;
    }
    
    private function saveDbData_deletingOld($cat_id) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery');
        $database->where(' `cat_id` = "'.$cat_id.'" AND `del` = "1" ');
        $database->order(' `order` ASC ');
        $database->qType('array');
        $d = $database->execute();
        
        if ( !empty($d) ) {
            foreach ( $d as $f ) {
                $c = $this->getGalleryGroupDataDB($f['cat_id']);
                $this->saveDbData_deleteFile($c['dir'],$f['filename']);
            } 
            
            $queryDeleteArray = array();
            $queryDeleteArray['cat_id'] = $cat_id;
            $queryDeleteArray['del'] = '1';
            $database->deleteFrom("#__gallery",$queryDeleteArray);
        }
    }
    
    private function saveDbData_deleteFile($subdir, $filename) {
        $path1 = $this->galleryPath.$subdir.'/'.$filename;
        $path2 = $this->galleryThumbPath.$subdir.'/thumb/'.$filename;
        
        unlink($path1);
        unlink($path2);
    }
    
    protected function fileUpload_saveDbData($cat_id,$md5name,$filename) {
        global $database;
        
        $order = time();
        
        $insertData = Array(
            "cat_id" => $cat_id,
            "md5" => $md5name,
            "filename" => $filename,
            "title" => "",
            "order" => $order,
            "del" => 0,
        );

        $res = $database->insertOrUpdate("#__gallery",$insertData);
        
        return $res;
    }
    
    protected function getGalleryImageDataDB($image_id) {
        global $database;
        
        $database->newQuery();
        $database->select('*');
        $database->from('#__gallery');
        $database->where(' `id` = "'.$image_id.'" ');
        $database->limit(' 1 ');
        $database->qType('row');
        $d = $database->execute();
        
        if ( $d ) {
            return $d;
        } else {
            return FALSE;
        }
    }
}

return; ?>
