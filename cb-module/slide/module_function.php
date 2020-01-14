<?php
namespace module\slide;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 04/12/17
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    private $width = 0;
    private $height = 0;
    
    protected function slide() {
        global $theme;
        
        $files = $this->readDir();
        
        if ( empty($files) ) { return ""; }
        if ( $files[0] ) { 
            $d = getimagesize($this->path.$files[0]);
            $this->width = $d[0];
            $this->height = $d[1];
        }
        
        $html = $theme->loadTemplate('slide','default',TRUE,'slide');
        
        $replace = array();
        
        $replace['WIDTH'] = $this->width;
        $replace['HEIGHT'] = $this->height;
        
        $images = "";
        /* Slides Container */
        foreach ( $files as $f ) {
            $images2 = $theme->loadTemplate('slide','default_images',TRUE,'slide');
            $replace2 = array();
            $replace2['IMAGE_PATH'] = $this->path.$f;
            
            $theme->replace($replace2,$images2);
            $images .= $images2;
        }
        $replace['IMAGES'] = $images;
        
        $theme->replace($replace,$html);
        
        return $html;
    }
    
    function readDir() {
        
        $dir    = ''.CB_FILE.'/slide/';
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
                    $files2[] = $filename;
                }
            }
        }
        
        return $files2;
    }
}

return; ?>
