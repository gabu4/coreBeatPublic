<?php
namespace module\menu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 16/05/19
 */
if (!defined('H-KEI')) { exit; }

class funct extends database {

    protected function menuHTMLBuild_function($cid, $menu, $class = '', $menuid = 0, $level = 0, $subName = FALSE, $template = '') {
        global $theme;

        $level2 = $level+1;
        $havesubReferer = FALSE;
        $menuItemNumber = 1;

        $template2_a1 = 'menu_';
        $template2_a2 = ( !empty($template) ? 'menu_'.$template.'_' : $template2_a1 );
        if ( $subName !== FALSE ) { $template2_b = "ulsub";
        } else { $template2_b = "ul"; }
        $template2 = $template2_a2.$template2_b;
        if ( !$theme->checkTemplate2($template2,'menu') ) { $template2 = $template2_a1.$template2_b; }
        $html_ul = $theme->loadTemplate2($template2,FALSE,'menu');
        
        $body = "";

        foreach ($menu[$menuid] as $data) {
            $body .= $this->menuHTMLBuild_function_menuInside_li($data, $menu, $cid, $class, $level, $level2, $menuItemNumber, $havesubReferer, $template);
        }

        $replace = Array();
        $replace['cid'] = $cid;
        $replace['level'] = $level;
        $replace['class'] = $class;
        $replace['body'] = $body;
        $replace['havesub'] = ( $havesubReferer !== FALSE ) ? " havesub " : "";
        $replace['subattr'] = ( $subName !== FALSE ) ? " aria-labelledby='$subName' " : "";
        $theme->mustache($replace, $html_ul);
        unset($replace);

        return $html_ul;
    }

    private function menuHTMLBuild_function_menuInside_li($data, $menu, $cid, $class, $level, $level2, &$menuItemNumber, &$havesubReferer, $template) {
        global $theme, $user;
        $active = ""; $haveSub = ""; $submenu = "";

        $template2_a1 = 'menu_';
        $template2_a2 = ( !empty($template) ? 'menu_'.$template.'_' : $template2_a1 );
        $template2_b = "li";
        $template2 = $template2_a2.$template2_b;
        if ( !$theme->checkTemplate2($template2,'menu') ) { $template2 = $template2_a1.$template2_b; }
        $html_li = $theme->loadTemplate2($template2,FALSE,'menu');

        if ( $data['level'] !== '' ) {
            $allowed_levels = explode('|',$data['level']);
            if ( !in_array($user->cb_get_user_level(),$allowed_levels) ) { return NULL; }
        }
        
        if ( !empty($data['value']) ) { $data['value'] = (array) json_decode($data['value']); }

        if ( in_array( $data['id'], $this->activeMenu ) ) {
            $active .= " active active2 ";
        }
        if ( isset( $menu[$data['id']] ) ) {
            $haveSub = " dropdown havesub ";
            $havesubReferer = "menunbr-".$data['id'];
            foreach ( $menu[$data['id']] as $m ) {
                if ( in_array( $m['id'], $this->activeMenu ) ) {
                    $active .= " active2 ";
                    break;
                }
            }
        }

        $link = $this->menuHTMLBuild_function_menuInside_a($data, $class, $active, $havesubReferer, $template);

        if ( isset($menu[$data['id']]) ) {
            $submenu = $this->menuHTMLBuild_function($cid, $menu, $class, $data['id'], $level2, $havesubReferer, $template);
        }

        $replace = Array();
        $replace['active'] = $active;
        $replace['id'] = $data['id'];
        $replace['cid'] = $cid;
        $replace['level'] = $level;
        $replace['level2'] = $level2;
        $replace['menuitemnumber'] = $menuItemNumber++;
        $replace['class'] = $data['class'];
        $replace['havesub'] = $haveSub;
        $replace['link'] = $link;
        $replace['submenu'] = $submenu;

        $theme->mustache($replace, $html_li);
        unset($replace);

        return $html_li;
    }

    protected function menuHTMLBuild_function_menuInside_a($data, $class, $active, $havesubReferer, $template) {
        global $theme, $lang;

        $href = "";$blank = "";$sub_attribute = "";

        $template2_a1 = 'menu_';
        $template2_a2 = ( !empty($template) ? 'menu_'.$template.'_' : $template2_a1 );
        $template2_b = "a";
        $template2 = $template2_a2.$template2_b;
        if ( !$theme->checkTemplate2($template2,'menu') ) { $template2 = $template2_a1.$template2_b; }
        $html = $theme->loadTemplate2($template2,FALSE,'menu');

        if ( CB_IS_SEO == 'true' ) {
            $la = "";
            $c = $lang->getAllowedLanguageTypes();
            if ( $c > 1 ) {
                $l = $lang->getLanguage();
                if ( $l !== $c[0] ) {
                    $la = $l."/";
                }
            }
            $href = " href='".CB_URI.$la.$data['seo_name']."' ";
        } else {
            $la = "";
            $c = $lang->getAllowedLanguageTypes();
            if ( $c > 1 ) {
                $l = $lang->getLanguage();
                if ( $l !== $c[0] ) {
                    $la = "&lang=".$l;
                }
            }
            $href = " href='".CB_URI.CB_INDEX."?c=".$data['content_id'].$la."' ";
        }

        if ( isset($data['value']['blank']) && $data['value']['blank'] == 1 ) { $blank = " target='_blank' "; }
        if ( isset($data['value']['html_link']) && !empty($data['value']['html_link'])  ) { $href = " href='".$data['value']['html_link']."' "; }

        $preimage = "";
        if ( !empty($data['image']) ) {
            $preimage = "<span class='img'><img src='".CB_URI.CB_FILE."/menu_img/".$data['image']."' /></span>";
        }
        if ( $havesubReferer ) {
            $sub_attribute = " id='$havesubReferer' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' ";
        }

        $replace = Array();
        $replace['href'] = $href;
        $replace['blank'] = $blank;
        $replace['active'] = $active;
        $replace['havesub'] = ( $havesubReferer ) ? " dropdown-toggle " : "";
        $replace['class'] = $data['class'];
        $replace['text'] = $data['text'];
        $replace['id'] = $data['id'];
        $replace['name'] = $data['name'];
        $replace['preimage'] = $preimage;
        $replace['subattr'] = $sub_attribute;

        $theme->mustache($replace, $html);
        unset($replace);

        return $html;
    }
}

return;
?>
