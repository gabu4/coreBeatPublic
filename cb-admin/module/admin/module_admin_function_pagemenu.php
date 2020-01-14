<?php
namespace module\admin\admin\pagemenu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 24/02/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function funct_make_adminmainpage_pageHTML($data) {
        global $theme, $module;
        
        if ( empty($data) ) { return ''; }
        
        $html = $theme->loadAdminTemplate2('admin_pagemenu_main',TRUE,'admin');
        
        $replace = array();
        $html_body = "";
        
        foreach ( $data as $val ) {
            $vname = strtolower($val['module_name']);
            $vfunct = strtolower($val['function']);
            
            if ( !$module->cb_check_access($vname,$vfunct,'admin') ) { continue; }
            
            $body = $theme->loadAdminTemplate2('admin_pagemenu_main_icon',FALSE,'admin');
            
            $nameFunction = $vname."_".$vfunct;
            
            $replace2 = array();
            
            $link = "?admin=".$vname."&funct=".$vfunct;
            $replace2['link'] = $link;
            
            $faIcon = ( !empty($val['fa-icon']) ) ? $val['fa-icon'] : 'fa-circle-o';
            $replace2['fa_icon'] = "<i class='fa ".$faIcon." mainFloat'></i>";
            $replace2['oname'] = "icon_".$nameFunction;
            
            $cname = strtoupper('[LANG_ADMIN_'.$nameFunction.'_MNAME]');
            $replace2['link_title'] = $cname;
            
            $theme->mustache($replace2,$body);
        
            $html_body .= $body;
        }
        
        $replace['body'] = $html_body;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
    
    protected function funct_make_adminmodulemenu_pageHTML($data,$module_name) {
        global $theme, $module;
        
        if ( empty($data) ) { return ''; }
        
        $html = $theme->loadAdminTemplate2('admin_pagemenu_main',TRUE,'admin');
        
        $replace = array();
        $html_body = "";
        
        $vname = strtolower($module_name);
        foreach ( $data as $val ) {
            $vfunct = strtolower($val['function']);
            
            if ( !$module->cb_check_access($vname,$vfunct,'admin') ) { continue; }
            
            $body = $theme->loadAdminTemplate2('admin_pagemenu_main_icon',FALSE,'admin');
            
            $nameFunction = $vname."_".$vfunct;

            $link = "?admin=".$vname."&funct=".$vfunct;
            $replace2['link'] = $link;
            
            $faIcon = ( !empty($val['fa-icon']) ) ? $val['fa-icon'] : 'fa-circle-o';
            $replace2['fa_icon'] = "<i class='fa ".$faIcon." mainFloat'></i>";
            $replace2['oname'] = "icon_".$nameFunction;
            
            $cname = strtoupper('[LANG_ADMIN_'.$nameFunction.'_MNAME]');
            $replace2['link_title'] = $cname;
            
            $theme->mustache($replace2,$body);
            
            $html_body .= $body;
        }
        
        $replace['body'] = $html_body;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
        
}

return; ?>