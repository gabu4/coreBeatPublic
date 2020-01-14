<?php
namespace module\admin\admin\update;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    public function __construct_update() {
        require_once CB_CORE."/sys.class.update.php";
    }
    
    protected function call_update_page() {
        global $theme, $module, $out_html, $cbupdate;
        
        $html = $theme->loadAdminTemplate2('admin_update_page',TRUE,'admin');
        
        $replace = [];
        $replace['current_version'] = $cbupdate->get_version();
        $uv = $cbupdate->server_check_version();
        
        $replace['have_system_update'] = FALSE;
        $replace['updated_version_minor'] = $uv['minor']['version'];
        if ( $cbupdate->get_version() !== $uv['minor']['version'] ) {
            $link = '?admin=admin&funct=update&version='. $uv['minor']['version'];
            $replace['updated_version_minor_update'] = $link;
            $replace['have_system_update'] = TRUE;
        }
        $replace['updated_version_major'] = $uv['major']['version'];
        if ( $cbupdate->get_version() !== $uv['major']['version'] && $cbupdate->get_version_sub() !== (int) $uv['major']['v_1'] ) {
            $link = '?admin=admin&funct=update&version='. $uv['major']['version'];
            $replace['updated_version_major_update'] = $link;
            $replace['have_system_update'] = TRUE;
        }
        $replace['updated_version_develop'] = $uv['all']['version'];
        if ( $cbupdate->get_version() !== $uv['all']['version'] ) {
            $replace['updated_version_develop_update'] = TRUE;
        }
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    
    protected function call_update_to($version_target) {
        global $cbupdate, $theme, $module, $out_html;
        
        $html = $theme->loadAdminTemplate2('admin_update_to',TRUE,'admin');
        
        $version_e = explode('.',$version_target);
        
        if ( $cbupdate->get_version_main() !== (int) $version_e[0] ) { return $theme->loadAdminTemplate2('admin_update_badversion_main',TRUE,'admin'); }
        if ( $cbupdate->get_version_sub() > (int) $version_e[1] || $cbupdate->get_version_sub() == (int) $version_e[1] && (int) $cbupdate->get_version_day().$cbupdate->get_version_day_sub() >= (int) $version_e[2] ) { return $theme->loadAdminTemplate2('admin_update_badversion_lower',TRUE,'admin'); }
        
        
        $sidemenu = [ "type" => "link", "link" => CB_BASEDIR."?admin=admin&funct=update", "name" => "[LANG_SYS_BACK_BUTTON]", "class" => "red", "icon" => "fa-chevron-left" ];
        $module->loadAdminFunction('admin','submenu',$sidemenu);
        
        $replace = [];
        $replace['current_version'] = $cbupdate->get_version();
        $replace['version'] = $version_target;
        $replace['changelog'] = $cbupdate->get_changes($version_target);
        
        /*
        $new = FALSE;
        $replace['current_version'] = $this->version_current;
        $uv = $this->get_version();
        
        $replace['have_system_update'] = FALSE;
        $replace['updated_version_minor'] = $uv['minor']['version'];
        if ( $this->version_current !== $uv['minor']['version'] ) {
            $link = '?admin=admin&funct=update&version='. $uv['minor']['version'];
            
            $replace['have_system_update'] = TRUE;
        }
        $replace['updated_version_major'] = $uv['major']['version'];
        if ( $this->version_current !== $uv['major']['version'] && $this->version_sub !== (int) $uv['major']['v_1'] ) {
            $link = '?admin=admin&funct=update&version='. $uv['major']['version'];
            $replace['updated_version_major_update'] = $link;
            $replace['have_system_update'] = TRUE;
        }
        $replace['updated_version_develop'] = $uv['all']['version'];
        if ( $this->version_current !== $uv['all']['version'] ) {
            $replace['updated_version_develop_update'] = TRUE;
        }
        
        */
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    

    


}

return; ?>