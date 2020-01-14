<?php
namespace module\admin\catalog\importexport;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait database {
    
    protected function get_catalogDatabaseCount() {
        global $database;
        
        $database->newQuery();
        $database->select("count(*)");
        $database->from("`#__catalog`");
        $database->where(" `state` != '-1' ");
        $database->qType("result");
        $listData = $database->execute();
        
        return $listData;
    }
    
    protected function nextCatalogId() {
        global $database;
        
        $database->newQuery();
        $database->select(" `catalog_id` ");
        $database->from("`#__catalog`");
        $database->where(" 1 ");
        $database->order(" `catalog_id` DESC ");
        $database->limit(" 1 ");
        $database->qType("result");
        $r = $database->execute();
        
        if ( $r ) {
            return $r+1;
        } else {
            return 1;
        }
    }
    
    protected function putCsvToDB($data, $isReplace = FALSE) {
        global $database;
        
        if ( $isReplace === TRUE ) {
            $this->putCsvToDB_removeOld();
        }
        
        foreach ( $data as $row ) {
            //print_r($row);exit;
            
            $catalog_id = ( isset($row['id']) && !empty($row['id']) && is_numeric($row['id']) ) ? $row['id'] : NULL;
            $sku = trim($row['sku']);
            $name = ( isset($row['name']) && !empty($row['name']) ) ? trim($row['name']) : $sku;
            $shorttext = ( isset($row['shorttext']) ) ? nl2br($row['shorttext']) : "";
            $text = ( isset($row['text']) ) ? nl2br($row['text']) : "";
            $lang = ( isset($row['lang']) ) ? trim($row['lang']) : "hu";
            $state = ( isset($row['state']) ) ? trim($row['state']) : 1;
            $template = ( isset($row['template']) ) ? trim($row['template']) : "";
            $class = ( isset($row['class']) ) ? trim($row['class']) : "";
            
            $category = [];
            $image = [];
            $thumb = [];
            $youtube = [];
            $headerimage = [];
            if ( isset($row['category']) && !empty($row['category']) ) { $category = explode(",",$row['category']); }
            if ( isset($row['image']) && !empty($row['image']) ) { $image = explode(",",$row['image']); }
            if ( isset($row['thumb']) && !empty($row['thumb']) ) { $thumb = explode(",",$row['thumb']); } else { if (isset($image[0])) { $thumb[0] = $image[0]; } if (isset($image[1])) { $thumb[1] = $image[1]; } }
            if ( isset($row['youtube']) && !empty($row['youtube']) ) { $youtube = explode(",",$row['youtube']); }
            if ( isset($row['headerimage']) && !empty($row['headerimage']) ) { $headerimage = explode(",",$row['headerimage']); }
            if ( $catalog_id === NULL ) { $catalog_id = $this->nextCatalogId(); }
            
            $media = [
                "thumbnail"=>[],
                "headerimage"=>[],
                "catalogimage"=>[],
                "youtubevideo"=>[],
            ];
            
            $insertData = [
                "catalog_id" => $catalog_id,
                "sku" => $sku,
                "name" => $name,
                "shorttext" => $shorttext,
                "text" => $text,
                "lang" => $lang,
                "state" => $state,
                "template" => $template,
                "class" => $class,
                "media" => json_encode($media)
            ];
            
            $res = $database->insertOrUpdate("#__catalog",$insertData);
            
            if ( $res ) {
                $id = $database->lqid();
                
                $this->putCsvToDB_removeOldCategoryData($catalog_id);
                if ( !empty($category) ) { $this->putCsvToDB_saveCategoryData($catalog_id, $category); }
                
                $this->putCsvToDB_removeOldMediaData($catalog_id, 'catalogimage');
                if ( !empty($image) ) { $this->putCsvToDB_saveMediaData($catalog_id, $image, 'catalogimage'); }
                
                $this->putCsvToDB_removeOldMediaData($catalog_id, 'thumbnail');
                if ( !empty($thumb) ) { $this->putCsvToDB_saveMediaData($catalog_id, $thumb, 'thumbnail'); }
                
                $this->putCsvToDB_removeOldMediaData($catalog_id, 'headerimage');
                if ( !empty($headerimage) ) { $this->putCsvToDB_saveMediaData($catalog_id, $headerimage, 'headerimage'); }
            }
        }
        
    }
    
    private function putCsvToDB_removeOld() {
        global $database;
        
        $ret = $database->doQuery(" TRUNCATE `".CB_SQLPREF."catalog`");
        if ( $ret ) {$database->doQuery(" TRUNCATE `".CB_SQLPREF."catalog_category_xref`");}
        return $ret;
    }
    
    private function putCsvToDB_removeOldCategoryData($catalog_id) {
        global $database;
        
        $queryDeleteArray = array();
        $queryDeleteArray['catalog_id'] = $catalog_id;
        $result = $database->deleteFrom('#__catalog_category_xref',$queryDeleteArray);
        
        if ( !$result ) { cb_error_log('Catalog CSV import, oldCategoryData remove error! '.$catalog_id); return FALSE; }
        
        return $result;
    }
    
    private function putCsvToDB_saveCategoryData($catalog_id, $category) {
        global $database;
        
        foreach( $category as $category_id ) {
            if ( $category_id !== '0' ) {
                $queryArray = array();
                $queryArray['category_id'] = $category_id;
                $queryArray['catalog_id'] = $catalog_id;
                $database->insertTo("#__catalog_category_xref",$queryArray);
            }
        }
    }
    
    private function putCsvToDB_removeOldMediaData($catalog_id,$type) {
        global $database;
        
        $targetArray = ['catalog_id'=>$catalog_id];
        $database->setJSONIn('#__catalog',$targetArray,'media',$type,"");
        //$database->deleteJSONIn('#__catalog',$targetArray,'media',$type);
    }
    
    private function putCsvToDB_saveMediaData($catalog_id, $image, $type) {
        global $media_admin, $database;
        
        $media_ids = [];
        
        $i = 0;
        foreach( $image as $image_name ) {
            $pos = strrpos($image_name,'.');
            if ( $pos === FALSE ) { 
                $extension = 'jpg'; 
                $image_name .= '.'.$extension;
            } else {
                $extension = strtolower(substr($image_name,$pos+1));
            }
            
            $file = $this->catalogContentImagePathCSV.$image_name;
            if ( !is_file($file) ) { cb_error_log('ERROR: Catalog CSV upload, file not exist: '.$file); return FALSE; }
            
            $options = [
                "name"=>"",
                "description"=>"",
                "referer_name"=>"catalog",
                "referer_id"=>$catalog_id
            ];
            
            $media_id = $media_admin->save($file,'image',$options);
            
            if ( $media_id ) { 
                $media_ids[] = (int) $media_id;
            }
        }
        
        $targetArray = ['catalog_id'=>$catalog_id];
        $database->setJSONIn('#__catalog',$targetArray,'media',$type, json_encode($media_ids));
        
        return TRUE;
    }
    
    /*
    private function catalog_media_mod($type,$catalog_id,$media_ids) {
        if ( empty($media_ids) ) { return NULL; }
        
        global $database;
        
        $i = 0;
        foreach ( $media_ids as $id ) {
            $targetArray = [
                'catalog_id' => $catalog_id
            ];
                    
            $database->setJSONIn('#__catalog',$targetArray, $type, $i++,$id);
        }
    } */
}

return; ?>