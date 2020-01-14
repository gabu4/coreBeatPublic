<?php
namespace module\admin\admin;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v024
 * @date 11/10/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    use settings\funct;
    use support\funct;
    use pagemenu\funct;
    use sidemenu\funct;
    use update\funct;
    
    var $admin = 0;
    var $submenu = [];
    
    protected function stayAlive() {
        global $out_html, $user;
        
        $state = ( $user->cb_is_admin_access_and_territory() === true ? 'success' : 'fail' );
        
        $array = [
            'state'=>$state,
            'message'=>'OK',
            'date'=>cb_time_to_date()
        ];
        
        $out_html->printOutAjaxContent($array);
    }
    
    protected function createSEOName($name) {
        $name = mb_strtolower($name,'utf8');
        $nc0 = cb_remove_accent($name);
        $nc1 = substr($nc0." ", 0, 63);
        $sp = strrpos($nc1, ' ', -1);

        $nc2 = substr($nc1, 0, $sp);

        return str_replace(Array(' ','/','\\'), Array('-','-','-'), $nc2);
    }
    
    protected function checkSEOName($name, $language, $id = NULL, $prefix = NULL) {
        global $database;
        
        $database->newQuery();
        $database->select("`s`.`id`");
        $database->from("`#__content_seo` `s`");
        $and = "";
        if ( $prefix !== NULL ) {
            $and .= " AND `s`.`name_prefix` = '".$prefix."' ";
        }
        $database->where(" `s`.`seo_name` = '".$name."' ".$and);
        $database->queryType('result');
        $fixedSeoID = $database->execute();
        if ( $fixedSeoID ) { return FALSE; }
        
        $database->newQuery();
        $database->select("`c`.`id`");
        $database->from("`#__content` `c`");
        $and = "";
        if ( $id !== NULL ) {
            $and .= " AND `c`.`id` != '".$id."' ";
        }
        if ( $prefix !== NULL ) {
            $and .= " AND `c`.`name_prefix` = '".$prefix."' ";
        }
        $database->where(" `c`.`seo_name` = '".$name."' AND `c`.`language` = '".$language."' ".$and);
        $database->queryType('result');
        $seoID = $database->execute();
        
        if ( !empty($seoID) ) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    protected function makeSEOName($name,$language,$id,$i = 1,$prefix) {
        if ( $i === NULL ) { $i = 1; }
        $name2 = $name."-".$i++;
        if ( $this->checkSEOName($name2,$language,$id,$prefix) ) {
            return $name2;
        } else {
            return $this->makeSEOName($name,$language,$id,$i,$prefix);
        }
    }
    
    protected function getSEOName($id) {
        global $database;
        
        $database->newQuery();
        $database->select("`s`.`seo_name`");
        $database->from("`#__content` `s`");
        $database->where(" `s`.`id` = '".$id."'");
        $database->queryType('result');
        $result = $database->execute();
        
        if ( !empty($result) ) {
            return $result;
        } else {
            return FALSE;
        }
    }
    
    protected function loadAdminSubmenu($mod, $funct) {
        $filename = "submenu.php";
        //@todo Submenü útvonal alternatíva megvalósítás
        $path = CB_ADMIN.'/module/'.$mod.'-self';
        if ( !file_exists($path) ) { $path = CB_ADMIN.'/module/'.$mod; }
        $dataSourceRoot = $path."/";
        $dataSource = $dataSourceRoot.$filename;

        if ( file_exists($dataSource) ) {
            $SUBMENU = [];
            include($dataSource);

            $funct = strtolower($funct);
            if ( isset($SUBMENU[$funct]) && is_array($SUBMENU[$funct]) ) { $this->submenu = $SUBMENU[$funct]; return TRUE; }
        }

        return FALSE;
    }
    
    protected function genAdminSubMenu($funct) {
        global $get;
        $mod = $get['admin'];

        $result = $this->loadAdminSubmenu($mod, $funct);
        $html = "";
        if ( !empty($this->submenu) ) {
            
            $this->haveSideMenu = TRUE;
            $html .= "<ul class='sidebar-menu moduleSubMenu'>";

            if ( !empty($this->submenu) ) { foreach ( $this->submenu as $link ) { $html .= $this->buildAdminSubMenuPoint($link); } }

            $html .= "</ul>";
        }

        return $html;
    }
    
    private function buildAdminSubMenuPoint($link) {
        $html = "";
        if ( !isset($link['type']) || empty($link['type']) ) { $link['type'] = 'link'; }
        $link['type'] = strtolower($link['type']);
        $class = ( isset($link['class']) || !empty($link['class']) ) ? " ".$link['class'] : "";
        $target = ( isset($link['target']) || !empty($link['target']) ) ? " target='".$link['target']."' " : "";
        $icon = ( isset($link['icon']) ) ? '<i class="'.$link['icon'].'"></i>' : "";
        if ( $link['type'] == 'link' ) {
            $html .= "<li class='subMenuElement link".$class."'><a class='' href='".$link['link']."' ".$target.">".$icon." <span>".$link['name']."</span></a></li>";
        } else if ( $link['type'] == 'space' ) {
            $html .= "<li class='header subMenuElement space".$class."'></li>";
        } else if ( $link['type'] == 'button' ) {
            $html .= "<li class='subMenuElement button".$class."'><button class='' type='submit' name='".$link['button']."'>".$icon." <span>".$link['name']."</span></button></li>";
            //$html .= "<li class='subMenuElement button".$class."'><a class='' href='#' role='submit' name='".$link['button']."'>".$icon."<span>".$link['name']."</span></a></li>";
        }
        return $html;
    }
    
    protected function callBreadcrumb_makeHtml() {
        global $get, $theme;
        
        $inner = [];
        $data = $this->getBreadcrumb_parents($get['admin'],$get['funct']);
        
        if ( !empty($data) ) {
            $data[0]['active'] = true;
            krsort($data);
            $i = 0;
            foreach($data as $v) {
                $p = strtoupper($v['module_name']);
                $f = strtoupper($v['function']);
                $text = "[LANG_ADMIN_".$p."_".$f."_TNAME]";
                $inner[$i]['text'] = $text;
                $inner[$i]['path'] = '?admin='.$v['module_name'].'&funct='.$v['function'];
                $inner[$i]['icon'] = ( !empty($v['fa-icon']) ? "<i class='".$v['fa-icon']."'></i>" : "");
                $inner[$i]['active'] = ( isset($v['active']) ? true : false );
                $i++;
            }
        }
        
        /*
        $breadcrumb_inner = '<li class="active">'.$admintitle.'</li>';
        if ( !empty($adminsubtitle) ) {
            $breadcrumb_inner = '<li><a href="?admin='.$get['admin'].'&funct=main"> '.$admintitle.'</a></li>';
            $breadcrumb_inner .= '<li class="active">'.$adminsubtitle.'</li>';
        }
        
        $html = <<<HTML
        <ol class="breadcrumb">
            <li><a href="?admin=admin&funct=main"><i class="fa fa-dashboard"></i> [LANG_ADMIN_SYS_MAINPAGE_TNAME]</a></li>
            $breadcrumb_inner
        </ol>
HTML;
*/
        $html = $theme->loadAdminTemplate2('admin_breadcrumb',FALSE,'admin');
        
        $replace = [];
        $replace['inner'] = $inner;
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    protected function menuSubmenu($parentId) {
        global $database, $module, $get;
        
        $database->newQuery();
        $database->select("`id`, `module_name`, `function`, `fa-icon`");
        $database->from("`#__module`");
        $where = "`type` = 'ADMIN' AND `mainmenuparent` = '".$parentId."' ";
//        if ( $user->cb_get_user_level() > 200 ) {
            $where .= " AND `mainmenu` >= '1' ";
//        } else {
//            $where .= " AND `mainmenu` >= '2' ";
//        }
        $database->where($where);
        $database->order("`order` ASC, `module_name` ASC");
        $database->cache(TRUE);
        $result = $database->execute();
        
        $html = "";
        
        if ( empty($result) ) {
            return $html;
        }
        
        $html .= "<ul class='treeview-menu'>";
        
        foreach ( $result as $val ) {
            $vname = strtolower($val['module_name']);
            $vfunct = strtolower($val['function']);
            
            if ( !$module->cb_check_access($vname,$vfunct,'admin') ) { continue; }
            
            $nameFunction = $vname."_".$vfunct;
            
            $cname = strtoupper('[LANG_ADMIN_'.$nameFunction.'_MNAME]');
            
            $active = '';
            if ( $vname !== 'admin' && $get['admin'] === $vname && $get['funct'] === $vfunct ) {
                $active = 'active';
            }
            
            $faIcon = ( !empty($val['fa-icon']) ) ? $val['fa-icon'] : 'far fa-circle';
            $html .= "<li class='$active'><a class='' href='?admin=".$vname."&funct=".$vfunct."'><i class='$faIcon'></i> ".$cname."</a></li>";
        }

        $html .= "</ul>";

        return $html;
    }
}

return; ?>