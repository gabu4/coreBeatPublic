<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v002
|     Date: 2012. 10. 16.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

include_once('language/'.LANGTYPE.'.php');

class module_menu {
	
	protected $menuData = Array();
	
	public $actPage = 1;
	public $actPageType = "PAGE";
	public $actPageId = 0;
	public $actPageVal = 0;
	
	function module_menu() {
		global $database, $handler;
						
		if ( ( IS_SEO == '1' ) AND isset($_GET['seo']) and !empty($_GET['seo']) ) { 
			$val = $database->getSelect("row"," * ","menu"," WHERE `state` = '1' AND `seo_name` = '".$_GET['seo']."' ");
			if ( !empty($val) ) {
				$this->actPage = $val['id'];
				$_GET['m'] = $val['id'];
				if ( $val['type'] == 'PAGE' ) {
					$_GET['page'] = $val['value'];
				} elseif ( $val['type'] == 'POST' ) {
					$_GET['post'] = $val['value'];
				} elseif ( $val['type'] == 'CAT' ) {
					$_GET['cat'] = $val['value'];
				} elseif ( $val['type'] == 'HTML' ) {
					$_GET['html'] = $val['value'];
				} elseif ( $val['type'] == 'MODULE' ) {
					$_GET['c'] = $val['value'];
				}
			}
		}
		if ( (!isset($val) OR empty($val)) AND isset($_GET['m']) and !empty($_GET['m']) ) {
			$this->actPage = $_GET['m'];
			$val = $database->getSelect("row"," `type`,`id`,`value` ","menu"," WHERE `state` = '1' AND `id` = '".$this->actPage."' ");
		}
		if ( !isset($val) OR empty($val) ) {
			$this->actPage = DEF_PAGE;
			$val = $database->getSelect("row"," `type`,`id`,`value` ","menu"," WHERE `state` = '1' AND `id` = '".$this->actPage."' ");
		}
		
		$this->actPageType = $val['type'];
		$this->actPageId = $val['id'];
		$this->actPageVal = $val['value'];

		$activeMenu = $this->actPage;
		
		$this->menuSet();
	}

	private function menuSet() {
		global $database, $theme;
		
		$menus = $database->getSelect("array","*","menu"," WHERE `state` = '1' ORDER BY `group` ASC, `parent` ASC, `order` ASC ");
		if ( empty($menus) ) return '';

		$menu = Array();
		foreach ( $menus as $value ) {
			$menu[$value['group']][$value['parent']][$value['id']] = $value;
		}
		
		$this->menuData = $menu;
		
		foreach ( $menu as $key => $value ) {
			$theme->tempREPLACE['MENU_'.$key] = $this->getMenu($key, $value);
		}

	}

	private function getMenu($group, $menu, $level = 0) {
		
		$html = "<ul class='menu menu_".$group." menulevel_".$level."'>";
		foreach ($menu[$level] as $val) {
			$a = "";
			if ( $this->actPageId == $val['id'] ) {
				$a = " active ";
			}
			$html .= "<li class='menu menu_".$group." ".$a."'>";
			$html .= $this->getMenuLink($group, $val, $a);
			
			if ( isset($menu[$val['id']]) ) {
				$html .= $this->getMenu($group, $menu, $val['id']);
			}
			
			$html .= "</li>";
			}
			
		$html .= "</ul>";
		
		return $html;
		
	}
	
	private function getMenuLink($group, $val, $a) {
		$href = "";
		if ( IS_SEO == '1' ) {
			$href = " href='".$val['seo_name']."' ";
		} elseif ( $val['type'] == 'PAGE' ) {
			$href = " href='".RUNNER."?page=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'POST' ) {
			$href = " href='".RUNNER."?post=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'CAT' ) {
			$href = " href='".RUNNER."?cat=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'MODULE' ) {
			$href = " href='".RUNNER."?c=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'HTML' ) {
			$href = " href='".RUNNER."".$val['value']."&m=".$val['id']."' ";
		}
		$html = "<a class='link_".$group.$a."' $href >";
		if ( !empty($val['image']) ) {
			$html .= "<img src='".CB_FILE."/menu_img/".$val['image']."' /> ";
		}
		$html .= $val['name'];
		$html .= "</a>";
		
		return $html;
	}
}

?>
