<?php
namespace module\admin;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 04/03/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    public function callHeaderbar() {
        
        global $theme,$user,$out_html,$is_maintenance;
        
        if ( CB_ADMIN_HEADERBAR !== 'true' ) { return ""; }
        if ( $user->cb_is_admin_territory() !== FALSE || $user->cb_is_admin_access() !== TRUE ) { return ""; }
        
        $theme->addBodyClass('is_admin_headerbar');
        //$theme->loadBootstrap4();
        $html = $theme->loadTemplate2("admin_headerbar",FALSE,'admin');
        
        $replace = [];
        $replace['brand_image'] = CB_MODULE.'/admin/images/cb_icon2_26.png';
        $replace['brand_text'] = "CoreBeat's";
        
        $replace['page_name'] = CB_SITETITLE;
        $replace['dashboard_link'] = "?admin";
        $replace['dashboard_text'] = "[LANG_ADMIN_DASHBOARD_TEXT]";
        
        $replace['user_name'] = $user->cb_get_user_name();
        $replace['user_image'] = $user->cb_get_user_avatar();
        $replace['user_profile_text'] = "[LANG_ADMIN_PROFILE_TEXT]";
        $replace['user_profile_link'] = "?admin=account&mod=user_edit&id=".$user->cb_get_user_id();
        
        $replace['user_logout_link'] = $out_html->getModuleFuctionName('account','logout');
        $replace['user_logout_text'] = "[LANG_ADMIN_LOGOUT_TEXT]";
        
        if ( $is_maintenance === TRUE ) {
            $replace['admin_message'] = '<span class="text-warning">[LANG_ADMIN_WEBSITE_MAINTENANCE_TEXT]</span>';
        }
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
}

return; ?>
