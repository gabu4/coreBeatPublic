<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 16/01/19
 */
if ( !defined('H-KEI') ) { exit; }

require_once('init.seo.ext.php');

class seo {
    public function clean($name) {
        return $this->clean_name($name);
    }
    
    public function make($name, $language, $seoname = NULL, $id = 0, $prefix = NULL, $type = 0, array $value = array()) {
        $result = FALSE;
        
        if ( !empty($seoname) && !$this->check_name($seoname,$language,$id,$prefix) ) { $seoname = NULL; }
        if ( empty($seoname) ) { $seoname = $this->make_name($name,$language,$id,$prefix); }
        
        if ( $id === 0 ) { $result = $this->save($language,$name,$seoname,$prefix,$type,$value); }
        else if ( $id !== 0 ) { $result = $this->update($id,$language,$name,$seoname,$prefix,$type,$value); }
        
        return $result;
    }
    
    public function delete($id = 0) {
        if ( empty($id) ) { return FALSE; }
        
        return $this->delete_with_id($id);
    }

    function cb_seo_name_make() {
        global $cb_init_system_function;

        return $cb_init_system_function->seo_check_name($name, $language, $id, $prefix);
    }

}

global $seo;
$seo = new seo_ext();

return; ?>