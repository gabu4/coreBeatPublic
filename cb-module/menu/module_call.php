<?php
namespace module\menu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v012
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {

    function __construct() {
        if ( empty($this->menuCategory) ) { $this->getMenuCategory_fromDb(); }
    }

    public function __call_menu($value) {
        global $lang;
        
        $id = 0;$class = '';$template = '';
        if ( !is_array($value) ) { $id = $value; } else { foreach ($value as $k=>$v) { if (!empty($v)) { $$k = $v; } } }

        $language = $lang->getLanguage();

        if ( !isset($this->menuCategory[$id]) ) { return ""; }
        if ( !empty($this->menuCategory[$id]['class']) ) { $class .= " " . $this->menuCategory[$id]['class']; }
        if ( empty($this->activeMenu) ) { $this->menu_activeMenuCheck(); }
        $menuData = $this->getMenuData_fromDb($id, $language);

        $html = "";

        if ( !empty($menuData) ) {
            $html = $this->menuHTMLBuild_function($id, $menuData, $class, 0, 0, FALSE, $template);
        }

        return $html;
    }

    public function __call_html($value) {

        if ( isset( $value['html_link'] ) ) {
            global $out_html;
            if (
                substr($value['html_link'],0,7) === 'http://' ||
                substr($value['html_link'],0,8) === 'https://'
            ) {
                $out_html->redirect($value['html_link']);
            }else if (
                $value['html_link'] === "#" ||
                $value['html_link'] === ""
            ) {
                $out_html->redirect();
            } else {
                $out_html->redirect(CB_HTTPADDRESS."/".$value['html_link']);
            }
        } else {
            $out_html->loadErrorPage404_mainpage();
        }
    }
}

return; ?>
