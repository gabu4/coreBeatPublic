<?php
namespace module\admin\mediamanager;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 13/08/19
 */
class media_admin {
    
    private $media_path = CB_ROOTDIR.'/'.CB_FILE."/media/";
    private $media_thumbnail_path = CB_ROOTDIR.'/'.CB_TEMP."/media/";
    
    /**
    * Media Save
    * @param string $file file path (actual route, or $_FILE temp name)
    * @param string $type upload type: document, image
    * @param array $options this is a option array, possible:<br>["name"=>"","description"=>"","referer_name"=>"","referer_id"=>"0","image_max_width"=>"","image_max_height"=>"","image_thumb_normal_width"=>"","image_thumb_normal_height"=>"","image_thumb_small_width"=>"","image_thumb_small_height"=>""]
    * @return id uploaded media ID
    */
    public function save($file,$type = 'document',array $options = []) {
        if ( !is_file($file) ) { cb_error_log('ERROR: Media Save, file not exist: '.$file); return FALSE; }
        
        $file_dir = date('Y-m');
        $file_original_name = substr($file,strrpos($file,'/')+1);
        $md5 = md5_file($file);
        
        $id = $this->check_is_exist($file_original_name,$md5);
        if ( $id ) { $this->update($id,$type,$options,$file); return $id; }
        
        $file_name = strtolower(cb_urlready_name($file_original_name));
        $name = ( cb_is_not_empty($options['name']) ) ? $options['name'] : $file_original_name;
        $description = ( cb_is_not_empty($options['description']) ) ? $options['description'] : "";
        
        $path2 = $this->media_path.$file_dir;
        if ( !is_dir($path2) ) { mkdir($path2, 0755, TRUE); }
        $copyOk = copy($file, $path2.'/'.$file_name);
        
        if ( !$copyOk ) { cb_error_log('ERROR: Media Save, file copy error: '.$file); return FALSE; }
        
        global $database;
        
        $insertData = [
                "type" => $type,
                "file_dir" => $file_dir,
                "file_name" => $file_name,
                "file_original_name" => $file_original_name,
                "md5" => $md5,
                "name" => $name,
                "description" => $description
            ];
            
        $res = $database->insertOrUpdate("#__media",$insertData);
        if ( !$res ) { cb_error_log('ERROR: Media Save DB, file save to db error: '.$file); return FALSE; }
        
        $id = $database->lqid();
        
        if ( $res && $type === 'image' ) {
            $thumbnail_name = $id.'-'.$md5.'.jpg';
            $path1 = $this->media_path.$file_dir.'/'.$file_name;

            $path2 = $this->media_thumbnail_path.'/'.$file_dir.'/thumb/s-'.$thumbnail_name;
            $ret = cb_img_resize($path1,$path2,CB_MEDIA_THUMBNAIL_SMALL_HEIGHT,CB_MEDIA_THUMBNAIL_SMALL_WIDTH);
            if ( !$res ) { cb_error_log('ERROR: Media Save Thumbnail, file save to thumbnail target: '.$file.' '.$path2); return FALSE; }
            $path2 = $this->media_thumbnail_path.'/'.$file_dir.'/thumb/n-'.$thumbnail_name;
            $ret = cb_img_resize($path1,$path2,CB_MEDIA_THUMBNAIL_NORMAL_HEIGHT,CB_MEDIA_THUMBNAIL_NORMAL_WIDTH);
            if ( !$res ) { cb_error_log('ERROR: Media Save Thumbnail, file save to thumbnail target: '.$file.' '.$path2); return FALSE; }
            $path2 = $this->media_thumbnail_path.'/'.$file_dir.'/thumb/m-'.$thumbnail_name;
            $ret = cb_img_resize($path1,$path2,CB_MEDIA_IMAGE_MAX_HEIGHT,CB_MEDIA_IMAGE_MAX_WIDTH);
            if ( !$res ) { cb_error_log('ERROR: Media Save Thumbnail, file save to thumbnail target: '.$file.' '.$path2); return FALSE; }
        }
        
        if (cb_is_not_empty($options['referer_name']) && cb_is_not_empty($options['referer_id'])) {
            $insertData = [
                    "media_id" => $id,
                    "referer" => $options['referer_name'],
                    "referer_id" => $options['referer_id']
                ];

            $res = $database->insertOrUpdate("#__media_xref",$insertData);
        }
        
        return $id;
    }
    
    public function get() {
        
    }
    
    
    /***************************/
    private function check_is_exist($file_original_name,$md5) {
        global $database;
        
        $database->newQuery();
        $database->select(" `id` ");
        $database->from("`#__media`");
        $database->where(" `file_original_name` = '$file_original_name' AND `md5` = '$md5' ");
        $database->limit(" 1 ");
        $database->qType("result");
        $r = $database->execute();
        
        return $r;
    }
    
    private function update($id,$type,$options,$file) {
        global $database;
        
        $file_original_name = substr($file,strrpos($file,'/')+1);
        $name = ( cb_is_not_empty($options['name']) ) ? $options['name'] : $file_original_name;
        $description = ( cb_is_not_empty($options['description']) ) ? $options['description'] : "";
        
        $insertData = [
                "id" => $id,
                "type" => $type,
                "name" => $name,
                "description" => $description
            ];
            
        
        $res = $database->updateTo("#__media",'id',$insertData);
        if ( !$res ) { cb_error_log('ERROR: Media Update DB, file save to db error: '.$file); return FALSE; }
        
        return TRUE;
    }
    
}

return; ?>
