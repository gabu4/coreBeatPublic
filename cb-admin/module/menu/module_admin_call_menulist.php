<?php
namespace module\admin\menu\menulist;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v016
 * @date 16/04/18
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    public function __call_list() {
        global $get, $lang;
        $catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
        $catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];
        $menuListDataRow = $this->callList_getMenuData($catid,$catlang);
        $html = $this->callList_themeLoad($menuListDataRow,$catid,$catlang);
        return $html;
    }
}

return; ?>