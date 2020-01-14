<?php
namespace module\admin\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v013
 * @date 12/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {

    protected function galleryCall_buildMainHTML() {
        global $theme, $admin_function;
        
        $html = $theme->loadAdminTemplate2('gallery_main',TRUE,'gallery');
        
        $replace = array();
        
        $gallery_a = $this->getGalleryGroupsDB();
        $gallery_b = $this->getGalleryDirList();
        
        foreach ( $gallery_b as $k=>$v ) {
            $notHave = TRUE;
            foreach ($gallery_a as $k2=>$v2 ) {
                if ( $v2['dir'] === $v ) {
                    $notHave = FALSE;
                    unset($gallery_b[$k]);break;
                }
            }
            if ( $notHave === TRUE ) {
                //$gallery_a[] = array('id'=>'4','name'=>$v,'dir'=>$v,'class'=>'','state'=>'1');
                $gallery_a[] = $this->saveGalleryGroupDataFromDir($v);unset($gallery_b[$k]);
            }
        }
        
        $galleryGroupListData = $gallery_a;
        
        $replace['body'] = $this->getGalleryDirList();
        $replace['usageinfo'] = "[LANG_ADMIN_GALLERY_USAGEINFO]";
        
        if ( empty($galleryGroupListData) ) {
            $replace['body'] = '[LANG_ADMIN_GALLERY_CALL_EMPTY]';
        } else {
            $tableHead = Array(
                '[LANG_ADMIN_GALLERY_MAIN_ID]',
                '[LANG_ADMIN_GALLERY_MAIN_MENUNAME]',
                '[LANG_ADMIN_GALLERY_MAIN_MENUDIR]',
                '[LANG_ADMIN_GALLERY_MAIN_STATE]',
                "&nbsp;"
                );

            $tableBody = Array();$i = 0;
            foreach ( $galleryGroupListData as $val ) {

                $tableBody[$i] = Array();

                $tableBody[$i][] = $val['id'];
                $tableBody[$i][] = $val['name'];
                $tableBody[$i][] = $val['dir'];
                $tableBody[$i][] = ( $val['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                $tableBody[$i][] = "<a href='?admin=gallery&funct=list&id=".$val['id']."'>" . $admin_function->getIcon('view') . "</a>";

                $i++;
            }
            $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'menu_group_main');
        }
        $theme->mustache($replace,$html);
        
        return $html;
    }


    public function galleryFileList($cat_id) {
        global $theme;
        
        $groupData = $this->getGalleryGroupDataDB($cat_id);
        $filelistDB = $this->getGalleryFileDataDB($cat_id);
        $subdir = $groupData['dir'];
        $filelist = $this->readDir($subdir);
        
        $html = $theme->loadAdminTemplate2('gallery_list',TRUE,'gallery');
        
        $replace = array();
        $replace['subdir'] = $groupData['dir'];
        $replace['id'] = $cat_id;
        $replace['name'] = $groupData['name'];
        
        $body = "";
        
        $fileListArray = [];
        $i = 0;
        if ( !empty($filelistDB) ) {
            foreach ( $filelistDB as $d ) {
                $path = $this->galleryPath.$subdir.'/'.$d['filename'];
                
                if ( !is_file($path) ) { continue; }
                
                $fileListArray[$i] = [];
                $fileListArray[$i]['path'] = $path;
                $fileListArray[$i]['subdir'] = $subdir;
                $fileListArray[$i]['paththumb'] = $this->galleryThumbPath.$subdir.'/thumb/'.$d['filename'];
                $fileListArray[$i]['md5name'] = $d['md5'];
                $fileListArray[$i]['filename'] = $d['filename'];
                $fileListArray[$i]['title'] = $d['title'];
                $fileListArray[$i]['img_edit_link'] = '?admin=gallery&funct=image_edit&id='.$d['id'];
                
                if ( isset($filelist[$d['md5']]) ) { unset($filelist[$d['md5']]); }
                $i++;
            }
        }
        
        if ( !empty($filelist) ) {
            foreach ( $filelist as $file ) {
                $path = $this->galleryPath.$subdir.'/'.$file;
                $md5name = md5($file);

                $fileListArray[$i] = [];
                $fileListArray[$i]['path'] = $path;
                $fileListArray[$i]['subdir'] = $subdir;
                $fileListArray[$i]['paththumb'] = $this->galleryThumbPath.$subdir.'/thumb/'.$file;
                $fileListArray[$i]['md5name'] = $md5name;
                $fileListArray[$i]['filename'] = $file;
                $fileListArray[$i]['title'] = '';
                $fileListArray[$i]['img_edit_link'] = '';

                $i++;
            }
        }
        
        if ( !empty($fileListArray) ) {
            foreach ( $fileListArray as $replace2 ) {
                $body2 = $theme->loadAdminTemplate2('gallery_list_file',FALSE,'gallery');
                
                $theme->mustache($replace2,$body2);
                
                $body .= $body2;
            }
        }
        
        $replace['body'] = $body;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }

    private function readDir($subdir) {
        
        $dir    = $this->galleryPath.$subdir.'/';
        if ( !is_dir($dir) ) { mkdir($dir, 0777, TRUE); }
        $files1 = scandir($dir);
        $files2 = Array();
        
        $allowExt = Array('jpg','jpeg','gif','png');
        
        foreach ( $files1 as $filename ) {
            if ( $filename !== '.' &&
                    $filename !== '..' ) 
                {
                
                $e = explode(".",$filename);
                $end = array_pop($e);
                $fileExt = strtolower( $end );
                
                if ( in_array($fileExt, $allowExt) ) {
                    $md5name = md5($filename);
                    $files2[$md5name] = $filename;
                    $this->checkThumbnail($subdir,$filename);
                }
            }
        }
        
        return $files2;
    }
    
    private function getGalleryDirList() {
        $dir    = $this->galleryPath;
        if ( !is_dir($dir) ) { mkdir($dir, 0777, TRUE); }
        $files1 = scandir($dir);
        $files2 = Array();
        
        foreach ( $files1 as $filename ) {
            if ( $filename !== '.' &&
                    $filename !== '..' &&
                    is_dir($dir.$filename) ) {
                
                $files2[] = $filename;
                
            }
        }
        
        return $files2;
    }
    
    private function checkThumbnail($subdir,$filename) {
        $path1 = $this->galleryPath.$subdir.'/'.$filename;
        $path2 = $this->galleryThumbPath.$subdir.'/thumb/'.$filename;
        
        $ret = cb_img_resize($path1,$path2,CB_GALLERY_THUMBNAIL_HEIGHT,CB_GALLERY_THUMBNAIL_WIDTH);
        
        return $ret;
    }
    
    protected function checkListSave($cat_id) {
        global $post,$handler;
        if ( isset($post['adminModuleGallerySave']) ) {
            $chk = $this->saveDbData($cat_id, $post);
            if ( $chk === TRUE ) {
                $handler->messageSuccess2(NULL,'[LANG_ADMIN_GALLERY_SAVE_SUCCESS]',"save");
                header("Location: ".CB_INDEX."?admin=gallery&funct=list&id=".$cat_id);exit;
            }
        } elseif ( isset($post['adminModuleGallerySaveAndExit']) ) {
            $chk = $this->saveDbData($cat_id, $post);
            if ( $chk === TRUE ) {
                $handler->messageSuccess2(NULL,'[LANG_ADMIN_GALLERY_SAVE_SUCCESS]',"save");
                header("Location: ".CB_INDEX."?admin=gallery&funct=main");exit;
            }
        }
        return FALSE;
    }
    
    protected function listUploadFile($cat_id) {
        global $theme, $lang, $out_html, $handler;
                
        $allowedFileTypes = array('jpg','jpeg','png');
        
        $return = array();
        
        if ( isset($_FILES['galleryFile']) && !empty($_FILES['galleryFile']) ) {
            $return['html'] = "";
            foreach ( $_FILES['galleryFile']['tmp_name'] as $k=>$f ) {
                $name = $_FILES['galleryFile']['name'][$k];
                $tmpname = $_FILES['galleryFile']['tmp_name'][$k];
                $groupData = $this->getGalleryGroupDataDB($cat_id);
                $subdir = $groupData['dir'];
                $dir    = $this->galleryPath.$subdir.'/';
                
                $fn = strtolower($name);
                
                $extension = strtolower(substr($fn, strrpos($fn, '.') + 1));
                if ( !in_array($extension, $allowedFileTypes) ) { continue; }
                $timestamp = time();
                $crc32 = md5($fn);
                $filename = $crc32."_".$timestamp.'.'.$extension;
                
                $path1 = $dir.''.$filename;
                if ( !is_dir($dir) ) { mkdir($dir, 0777, TRUE); }
                cb_move_uploaded_file($tmpname,$path1);
                
                $path2 = $this->galleryThumbPath.$subdir.'/thumb/'.$filename;
                
                cb_img_resize($path1,$path2,CB_GALLERY_THUMBNAIL_HEIGHT,CB_GALLERY_THUMBNAIL_WIDTH,NULL,TRUE);
                
                $body2 = $lang->cb_lang_replace_in_text($theme->loadAdminTemplate2('gallery_list_file',FALSE,'gallery'));

                $md5name = md5($filename);
                $title = "";
                
                $replace2 = array();
                $replace2['path'] = $path1;
                $replace2['subdir'] = $subdir;
                $replace2['paththumb'] = $path2;
                $replace2['md5name'] = $md5name;
                $replace2['filename'] = $filename;
                $replace2['title'] = $title;

                $theme->mustache($replace2,$body2);
                
                $this->fileUpload_saveDbData($cat_id,$md5name,$filename);
                
                $return['html'] .= $body2;
            }
            $return['state'] = '1';
            $return['type'] = 'success';
            $return['state_text'] = '[LANG_ADMIN_GALLERY_FILE_UPLOADED]';
            $handler->messageSuccess2(NULL,'[LANG_ADMIN_GALLERY_FILE_UPLOADED]',"save");
        } else {
            $return['state'] = '0';
            $return['type'] = 'error';
            $return['state_text'] = '[LANG_ADMIN_GALLERY_NO_UPLOADED_FILE]';
            $handler->messageInfo2(NULL,'[LANG_ADMIN_GALLERY_NO_UPLOADED_FILE]',"save");
        }
        
        $out_html->printOutAjaxContent($return);
    }
    
    
    public function galleryImage($image_id) {
        global $theme,$handler;
        
        $fileData = $this->getGalleryImageDataDB($image_id);
        
        if ( !$fileData ) {
            $handler->messageWarning2(NULL,'[LANG_ADMIN_GALLERY_IMAGE_EDIT_NOT_EXIST_IMAGE]',"error");
            header("Location: ".CB_INDEX."?admin=gallery&funct=main");exit;
        }
        
        $cat_id = $fileData['cat_id'];
        $groupData = $this->getGalleryGroupDataDB($cat_id);
        $subdir = $groupData['dir'];
        
            
        $html = $theme->loadAdminTemplate2('gallery_list_edit',TRUE,'gallery');
        
        $replace = array();
        $replace['subdir'] = $groupData['dir'];
        $replace['cat_id'] = $cat_id;
        $replace['id'] = $image_id;
        $replace['image_title'] = $fileData['title'];
        $replace['img_src'] = $this->galleryPath.$subdir.'/'.$fileData['filename'];
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
	
}

return; ?>