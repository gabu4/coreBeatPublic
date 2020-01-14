<?php
namespace module\admin\admin\pagemenu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 11/11/17
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    public function __call_adminmainpage() {
        $data = $this->db_get_adminmainpage_data();
        
        $html = $this->funct_make_adminmainpage_pageHTML($data);
        
        /*
        $html = "<ul class='mainPageMenuAdmin'>";

        foreach ( $data as $val ) {
            
            $vname = strtolower($val['module_name']);
            $vfunct = strtolower($val['function']);
            
            if ( !$module->cb_check_access($vname,$vfunct,'admin') ) { continue; }
            
            $nameFunction = $vname."_".$vfunct;

            $cname = strtoupper('[ADMIN_LTEXT_'.$nameFunction.'_MNAME]');

            $linkImage = $this->mainPageImage($nameFunction, $vname);
            
            $html .= "<li class=''><a class='' href='?admin=".$vname."&funct=".$vfunct."'><span class='menuPageLink' style='background-image: url(".$linkImage.");'>".$cname."</span></a></li>";
        }

        $html .= "</ul>";
*/
        return $html;
    }
    
    public function __call_adminmodulemenu($module_name = NULL,$module_function = NULL) {
        global $get;
        
        if ( $module_name === NULL ) { $module_name = strtolower($get['admin']); }
        if ( $module_function === NULL ) { $module_function = strtolower($get['funct']); }
        
        $data = $this->db_get_adminmodulemenu_data($module_name,$module_function);
        
        $html = $this->funct_make_adminmodulemenu_pageHTML($data,$module_name);
        
        return $html;
    }
    
}

return; ?>