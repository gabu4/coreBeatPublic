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

include_once('language/'.CB_LANGTYPE.'.php');

class module_menu {
	
	protected $menuData = Array();
	protected $actMenuId = 0;
	
	function module_menu() {
		global $database, $handler;
		
		if ( isset($_GET['m']) AND !empty($_GET['m']) ) {
			$this->actMenuId = $_GET['m'];
		}
		
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

	}
	
	public function __call_menu($id) {
		$ret = "";
			
		if ( isset($this->menuData[$id]) ) {
			$ret = $this->getMenu($id, $this->menuData[$id]);
		}
			
		return $ret;
	}

	private function getMenu($group, $menu, $level = 0) {
		$module_menu;
		
		$html = "<ul class='menu menu_".$group." menulevel_".$level."'>";
		foreach ($menu[$level] as $val) {
			$a = "";
			if ( $this->actMenuId == $val['id'] ) {
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
		$blank = "";
		if ( CB_IS_SEO == '1' ) {
			$href = " href='".$val['seo_name']."' ";
		} elseif ( $val['type'] == 'PAGE' ) {
			$href = " href='".CB_INDEX."?page=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'POST' ) {
			$href = " href='".CB_INDEX."?post=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'CATEGORY' ) {
			$href = " href='".CB_INDEX."?category=".$val['value']."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'MODULE' ) {
			$m = explode("|",$val['value']);
			$href = " href='".CB_INDEX."?mod=".$m[0]."&f=".$m[1]."&m=".$val['id']."' ";
		} elseif ( $val['type'] == 'HTML' ) {
			$href = " href='".$val['value']."' ";
		}
		if ( $val['html_blank'] == 1 ) $blank = " target='_blank' ";
		$html = "<a class='link_".$group.$a."' $href $blank >";
		if ( !empty($val['image']) ) {
			$html .= "<img src='".CB_FILE."/menu_img/".$val['image']."' /> ";
		}
		$html .= $val['name'];
		$html .= "</a>";
		
		return $html;
	}
}

?>
