<?php
namespace module\gallery;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    
    protected function gallery($json) {
        $d = explode('|',$json);
                
        $cat_id = $d[0];
        $template = ( isset($d[1]) && !empty($d[1]) ) ? $d[1] : 'main';
        
        global $theme;
        
        $catData = $this->getDbData_category($cat_id);
        $filelist = $this->getDbData($cat_id);
        
        $subdir = $catData['dir'];
        
        $countMosaic = count($filelist);
        $countPage = ceil($countMosaic/$this->imagePerPage);
        
        
        $html = "";
        
        $pageNumber = 0;
        if ( !empty($filelist) ) {

            $html = $theme->loadTemplate('gallery',$template,FALSE,'gallery');
            
            $replace = array();
            $replace['gallerypage'] = "";
            $replace['gallerypaginator'] = "";
            
            $galleryContent = "";
            
            $pageElement = 0;
            foreach ( $filelist as $f ) {
                $pageElement++;
                
                $file = $f['filename'];
                $galleryContent .= $theme->loadTemplate('gallery','gallerycontent',TRUE,'gallery');
                
                $replace2 = array();
                $replace2['path'] = $this->galleryPath.$subdir.'/'.$file;
                $replace2['paththumb'] = $this->galleryThumbPath.$subdir.'/_thumb/'.$file;
                $replace2['mosaicnumber'] = $pageElement;
                $replace2['mosaicid'] = crc32($file);
                $replace2['title'] = $f['title'];
                $replace2['subdir'] = $subdir;
                
                $theme->replace($replace2,$galleryContent);
                                
                if ( $pageElement >= $this->imagePerPage ) {
                    $htmlGalleryPage = $theme->loadTemplate('gallery','gallerypage',TRUE,'gallery');
                    $replace3 = array();
                    $replace3['pagenumber'] = ++$pageNumber;
                    $replace3['gallerycontent'] = $galleryContent;
                    $theme->replace($replace3,$htmlGalleryPage);
                    $replace['gallerypage'] .= $htmlGalleryPage;
                    $galleryContent = "";
                    $pageElement = 0;
                }
            }
            if ( !empty($galleryContent) ) {
                $htmlGalleryPage = $theme->loadTemplate('gallery','gallerypage',TRUE,'gallery');
                $replace3 = array();
                $replace3['pagenumber'] = ++$pageNumber;
                $replace3['gallerycontent'] = $galleryContent;
                $theme->replace($replace3,$htmlGalleryPage);
                $replace['gallerypage'] .= $htmlGalleryPage;
                $galleryContent = "";
            }
            
            if ( $countPage > 1 ) {
                $replace['gallerypaginator'] = $theme->loadTemplate('gallery','gallerypaginator',TRUE,'gallery');
                $datas = "";
                for ( $i=1;$i<=$countPage;$i++) {
                    $datas .= $theme->loadTemplate('gallery','gallerypaginatorelement',TRUE,'gallery');
                    $replace3 = array();
                    $replace3['pagenumber'] = $i;
                    $theme->replace($replace3,$datas);
                }
                $replace3 = array();
                $replace3['datas'] = $datas;
                $theme->replace($replace3,$replace['gallerypaginator']);
            }
            
            $theme->replace($replace,$html);
            
        }
        return $html;
    }
    
}

return; ?>
