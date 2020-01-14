<?php
namespace module\admin\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 12/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
		
    public function __call_main() {

        return $this->galleryCall_buildMainHTML();
    }

    public function __call_list() {
        global $get, $is_ajax, $handler;
    
        $html = "";

        $e = false;
        if ( isset($get['id']) && !empty($get['id']) ) {
            if ( isset($get['fileupload']) && $get['fileupload'] == '1' && $is_ajax) {
                $this->listUploadFile($get['id']);
                exit;
            }
            
            $this->checkListSave($get['id']);

            $html = $this->galleryFileList($get['id']);
        } else { $e = true; }

        if ( $e === true ) {
            $handler->messageWarning2(NULL,'[LANG_ADMIN_GALLERY_LIST_NOT_EXIST_GALLERY]',"error");
            header("Location: ".CB_INDEX."?admin=gallery&funct=main");exit;
        } else {
            return $html;
        }
    }
    
    public function __call_image_edit() {
        global $get, $handler;
        
        $e = false;
        if ( isset($get['id']) && !empty($get['id']) ) {
            $html = $this->galleryImage($get['id']);
        } else { $e = true; }

        if ( $e === true ) {
            $handler->messageWarning2(NULL,'[LANG_ADMIN_GALLERY_IMAGE_EDIT_NOT_EXIST_IMAGE]',"error");
            header("Location: ".CB_INDEX."?admin=gallery&funct=main");exit;
        } else {
            return $html;
        }
    }
}

return; ?>