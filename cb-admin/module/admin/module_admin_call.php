<?php
namespace module\admin\admin;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v030
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    use settings\call;
    use support\call;
    use pagemenu\call;
    use sidemenu\call;
    use update\call;
    
    protected $preAdminSubMenu = Array();
    protected $haveSideMenu = FALSE;
    
    function __construct() {
        global $get,$user;
        
        if ( $user->cb_is_admin_access_and_territory() ) {
            $funct = ( isset($get['funct']) ) ? $get['funct'] : NULL;
            $this->preAdminSubMenu[$funct] = $this->genAdminSubMenu($funct);
        }
    }

    public function __call_main() {
        global $module, $get, $is_ajax;
        
        if ( $is_ajax && isset($get['stayalive']) ) { $this->stayAlive(); }
        
        $html = $module->loadAdminFunction('admin', 'adminmainpage');

        return $html;
    }
    
    
    public function __call_havesidemenu() {
        return $this->haveSideMenu;
    }
    
    
    public function __call_submenu($funct) {
        global $get, $module;
        
        $funct = ( isset($get['funct']) ) ? $get['funct'] : NULL;
        
        if ( !$module->loadAdminFunction('admin','havesidemenu') ) { return ""; }
        
        if ( !isset($this->preAdminSubMenu[$funct]) ) {
            return $this->genAdminSubMenu($funct);
        } else {
            return $this->preAdminSubMenu[$funct];
        }
    }

    public function __call_formmenu($type) {

        $type = strtoupper($type);

        $html = "";
        if ( $type == 'START' ) {
            $html = "<form action='' enctype='multipart/form-data' class='adminForm' method='post'>";
        } else if ( $type == 'END' ) {
            $html = "</form>";
        }

        return $html;
    }
    
    /** SEO név legenerálás
     * Visszatérés "print" értékkel ha ajax, egyébként return
     */
    public function __call_seonamegenerate($data = array()) {
        global $get, $is_ajax, $lang;
        
        $isAjax = FALSE;
        $name = ''; $seoname = ''; $id = NULL; $renew = NULL; $prefix = NULL; $language = $lang->getLanguage();
        
        if ( empty($data) ) {
            $jsonArray = Array();

            $isAjax = ( $is_ajax && isset($get['seoname_gen']) ) ? TRUE : FALSE;

            if ( !isset($get['id']) ||
                empty($get['id'])) {
                $get['id'] = NULL;
            }
            if ( $isAjax && isset($get['name']) ) {
                $name = trim($get['name']);
            } elseif ( empty($name) ) {
                $jsonArray['seoname'] = '';
                $jsonArray['state'] = 'empty';
                if ( $isAjax ) {
                    print json_encode($jsonArray);exit;
                } else {
                    return $jsonArray;
                }
            }
            if ( $isAjax && isset($get['seoname']) ) { $seoname = trim($get['seoname']); }
            if ( $isAjax && isset($get['id']) ) { $id = trim($get['id']); }
            if ( $isAjax && isset($get['renew']) ) { $renew = trim($get['renew']); }
            if ( $isAjax && isset($get['prefix']) ) { $prefix = trim($get['prefix']); }
            if ( $isAjax && isset($data['language']) ) { $language = trim($data['language']); }
        } else {
            if ( isset($data['name']) ) { $name = trim($data['name']); }
            if ( isset($data['seoname']) ) { $seoname = trim($data['seoname']); }
            if ( isset($data['id']) ) { $id = trim($data['id']); }
            if ( isset($data['renew']) ) { $renew = trim($data['renew']); }
            if ( isset($data['prefix']) ) { $prefix = trim($data['prefix']); }
            if ( isset($data['language']) ) { $language = trim($data['language']); }
        }
        
        if ( !empty($name) && !empty($seoname) && $id !== '0') {
            $nameCleaned = $this->createSEOName($seoname);
            if ( $this->checkSEOName($nameCleaned, $language, $id, $prefix) ) {
                $jsonArray['seoname'] = $nameCleaned;
                $jsonArray['state'] = 'ok';
            } else {
                $seonameOK = $this->makeSEOName($nameCleaned, $language, $id, NULL, $prefix);
                $jsonArray['seoname'] = $seonameOK;
                $jsonArray['state'] = 'ok';
            }
        } elseif ( !empty($name) && !empty($seoname) ) {
            if ( $this->checkSEOName($seoname, $language, $id, $prefix) ) {
                $jsonArray['seoname'] = $seoname;
                $jsonArray['state'] = 'ok';
            } else {
                $seonameOK = $this->makeSEOName($nameCleaned, $language, $id, NULL, $prefix);
                $jsonArray['seoname'] = $seonameOK;
                $jsonArray['state'] = 'ok';
            }
        } elseif ( !empty($name) ) {
            
            $nameCleaned = $this->createSEOName($name);
            
            if ( !($this->checkSEOName($nameCleaned, $language, NULL, $prefix)) ) {
                $nameCleaned = $this->makeSEOName($nameCleaned, $language, NULL, NULL, $prefix);
            }
            
            $jsonArray['seoname'] = $nameCleaned;
            $jsonArray['state'] = 'ok';
            
        } else {
            $jsonArray['seoname'] = '';
            $jsonArray['state'] = 'empty';
        }
        
        if ( $isAjax ) {
            print json_encode($jsonArray);exit;
        } else {
            return $jsonArray;
        }
    }
    
    public function __call_getSeonameFromID($id = 0) {
        if ( $id == 0 ) { return FALSE; }
        
        return $this->getSEOName($id);
    }
    
    public function __call_breadcrumb() {
        $html = $this->callBreadcrumb_makeHtml();
        
        return $html;
    }
    
}

return; ?>