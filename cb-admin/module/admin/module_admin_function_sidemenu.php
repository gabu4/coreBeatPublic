<?php
namespace module\admin\admin\sidemenu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 10/10/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function createSideMenu() {
        global $theme, $module, $get;
        
        $menuData = $this->createSideMenu_getData();
        
        $currentMenuId = $this->createSideMenu_getCurrentMenuId($get['admin'],$get['funct']);
        $activeMenuArray = $this->createSideMenu_getCurrentMenuParentsId($currentMenuId);

        $html = $theme->loadAdminTemplate2('admin_sidemenu',FALSE,'admin');
        
        $replace = [];
        
        $i = 0;
        foreach ( $menuData as $val ) {
            $replace['main'][$i]['vname'] = $vname = strtolower($val['module_name']);
            $replace['main'][$i]['vfunct'] = $vfunct = strtolower($val['function']);
            
            if ( !$module->cb_check_access($vname,$vfunct,'admin') ) { continue; }
            
            $nameFunction = $vname."_".$vfunct;

            $replace['main'][$i]['name'] = $cname = strtoupper('[LANG_ADMIN_'.$nameFunction.'_MNAME]');
            
            $replace['main'][$i]['active'] = FALSE;
            $replace['main'][$i]['sub'] = FALSE;
            
            if ( in_array($val['id'],$activeMenuArray) ) {
                $replace['main'][$i]['active'] = TRUE;
                $replace['main'][$i]['sub'] = $this->createSideMenu_submenu($val['id'],$activeMenuArray);
            }
            
            $replace['main'][$i]['icon'] = ( !empty($val['fa-icon']) ) ? $val['fa-icon'] : 'fa-circle-o';
        
            $i++;
        }

        $theme->mustache($replace,$html);

        return $html;
    }
    
    private function createSideMenu_submenu($parentId,$activeMenuArray) {
        global $module;
        
        $menuData = $this->createSideMenu_submenu_getData($parentId);
        
        if ( empty($menuData) ) {
            return FALSE;
        }
        
        $return = [];
        
        $i = 0;
        foreach ( $menuData as $val ) {
            $return[$i]['vname'] = $vname = strtolower($val['module_name']);
            $return[$i]['vfunct'] = $vfunct = strtolower($val['function']);
            
            if ( !$module->cb_check_access($vname,$vfunct,'admin') ) { continue; }
            
            $nameFunction = $vname."_".$vfunct;
            
            $return[$i]['name'] = $cname = strtoupper('[LANG_ADMIN_'.$nameFunction.'_MNAME]');
            
            $return[$i]['active'] = FALSE;
            
            if ( in_array($val['id'],$activeMenuArray) ) {
                $return[$i]['active'] = TRUE;
//                $submenu = $this->createSideMenu_submenu($val['id']);
                
            }
            
            $return[$i]['icon'] = ( !empty($val['fa-icon']) ) ? $val['fa-icon'] : 'fa-circle-o';
            
            $i++;
        }

        return $return;
    }
}

return; ?>