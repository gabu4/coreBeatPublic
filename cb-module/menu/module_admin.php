<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2012. 10. 06.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

include_once('language/'.LANGTYPE.'.php');

class module_admin_menu {
	
	var $admin = 0;
	var $call = Array( "menulist", "menuedit", "menunew", "menutrash", "menudelete", "menugroup", "menugroupdelete" );
	
	var $modules = Array( "form", "account" );
	
	function module_admin_menu() {
		global $user, $theme, $handler;
		
		$handler->callAdmin['menu_admin'] = $this->call;
		
	}
	
	public function __call_menulist() {
		global $theme, $database;
		
		$html = $theme->loadModuleTemplate('_admin_menu_menulist_template');
		$html2 = $theme->loadModuleTemplate('_admin_menu_menulist_tab_template');
		$html3 = $theme->loadModuleTemplate('_admin_menu_menulist_row_template');
		
		$menuList = $database->getSelect("array","*","menu"," WHERE `state` != '-1' ORDER BY `group` ASC, `parent` ASC, `order` ASC ");
		
		$menuList2 = array();
		$groups = array();
		foreach ( $menuList as $val ) {
			$menuList2[$val['group']][$val['parent']][$val['id']] = $val;
			$groups[$val['group']] = $val['group'];
		}
		
		$tab_body = "";
		$grouptab = "";
		foreach ($groups as $g) {
			$grouptab .= "<li><a href='#tab-".$g."'>".$g."</a></li>";
		}
		
		foreach ( $menuList2 as $group => $menuVal ) {
			$tab_body .= $html2;
			
			$menu_list = "";
			foreach ( $menuVal[0] as $val ) {
				
				$menu_list .= $this->menuListRowConstruct($html3, $val, $menuVal, 0);
				
			}
			
			$replace['GROUP'] = $group;
			$replace['MENULIST'] = $menu_list;
	
			foreach ( $replace as $key => $value ) {
				$tab_body = str_replace( '{#'.strtoupper($key).'}', $value, $tab_body );
			}
			
			unset($replace);
		
		}
		
		$replace['TAB_LI'] = $grouptab;
		$replace['TAB_BODY'] = $tab_body;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	private function menuListRowConstruct($sablon, $menu, $menuData, $level) {
		$html = $sablon;
		
		$active = "<img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/active.png' alt='Aktív' title='Aktív' />";
		$inactive = "<img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/inactive.png' alt='Inaktív' title='Inaktív' />";
		$replace['ID'] = $menu['id'];
		$replace['NAME'] = $menu['name'];
		$replace['SEO_NAME'] = $menu['seo_name'];
		$replace['ACTIVE'] = ( $menu['state'] == 1 ) ? $active : $inactive;
		$replace['ORDER'] = $menu['order'];
		
		$levelChar = "";
		for ( $i = 1; $i <= $level; $i++ ) {
			$levelChar .= "&nbsp;&nbsp;";
		}
		if ( $level > 0 ) {
			$levelChar .= "-&nbsp;";
		}
		$replace['LEVEL'] = $levelChar;
		
		$replace['SETTINGS'] = "<a href='".RUNNER."?admin=menuedit&id=".$menu['id']."'><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/settings.png' alt='Beállítás' title='Beállítás' /></a>";
		$replace['DELETE'] = "<a href='".RUNNER."?admin=menutrash&id=".$menu['id']."' onclick=\"javascript:return confirm('Biztos, hogy törölni akarod a kiválasztott menüpontot? (nem fogod tudni visszaállítani)')\"><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/delete.png' alt='Törlés' title='Törlés' /></a>";
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		if ( isset($menuData[$menu['id']]) and !empty($menuData[$menu['id']]) ) {
			$level++;
			foreach ( $menuData[$menu['id']] as $val ) {
				$html .= $this->menuListRowConstruct($sablon, $val, $menuData, $level);
			}
		}
		
		return $html;
		
	}
	
	public function __call_menuedit() {
		global $theme, $database, $handler, $post;
				
		$html = $theme->loadModuleTemplate('_admin_menu_menuedit_template');
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) return 0;
		
		$menuData = $database->getSelect("row","*","menu"," WHERE `state` != '-1' AND `id` = '".$_GET['id']."' ");
		
		if ( empty($menuData) ) return 0;
		
		if ( isset($post['adminMenuEditSave']) ) {
			$database->doQuery("UPDATE `".SQLPREF."menu` SET `name` = '".$post['name']."', `text` = '".$post['text']."', `type` = '".$post['type']."', `value` = '".$post['value']."', `seo_name` = '".$post['seo_name']."', `group` = '".$post['group']."', `order` = '".$post['order']."', `parent` = '".$post['parent']."', `state` = '".$post['state']."' WHERE `id` = '".$_GET['id']."' ");
			$handler->messageSuccess[] = "Sikeres mentés!";
			
			$menuData = $database->getSelect("row","*","menu"," WHERE `id` = '".$_GET['id']."' ");
		}
		
		$replace['DEFTAB'] = 'tabs-'.strtolower($menuData['type']);
		
		$replace['MENU_TYPE_PAGE'] = $theme->loadModuleTemplate('_admin_menu_edit_page_template');
		$replace['MENU_TYPE_POST'] = $theme->loadModuleTemplate('_admin_menu_edit_post_template');
		$replace['MENU_TYPE_CAT'] = $theme->loadModuleTemplate('_admin_menu_edit_cat_template');
		$replace['MENU_TYPE_MODULE'] = $theme->loadModuleTemplate('_admin_menu_edit_module_template');
		$replace['MENU_TYPE_HTML'] = $theme->loadModuleTemplate('_admin_menu_edit_html_template');
		
		$replace['NAME'] = $menuData['name'];
		$replace['SEO_NAME'] = $menuData['seo_name'];
		$replace['TYPE'] = $menuData['type'];
		$replace['TEXT'] = $menuData['text'];
		
		$replace['PAGE_VALUE'] = ( $menuData['type'] == 'PAGE' ) ? $this->pageValSelect($menuData['value']) : $this->pageValSelect();
		$replace['POST_VALUE'] = ( $menuData['type'] == 'POST' ) ? $this->postValSelect($menuData['value']) : $this->postValSelect();
		$replace['HTML_VALUE'] = ( $menuData['type'] == 'HTML' ) ? $menuData['value'] : "";
		$replace['MODULE_VALUE'] = ( $menuData['type'] == 'MODULE' ) ? $this->moduleValSelect($menuData['value']) : $this->moduleValSelect();
		$replace['CAT_VALUE'] = ( $menuData['type'] == 'CAT' ) ? $this->catValSelect($menuData['value']) : $this->catValSelect();
		
		$replace['ORDER'] = $menuData['order'];
		$replace['GROUPSELECT'] = $this->menuGroupSelect($menuData['group']);
		$replace['PARENTSELECT'] = $this->menuParSelect($menuData);
		$replace['IFSTATE0'] = ( $menuData['state'] == '0' ) ? ' CHECKED ' : '' ;
		$replace['IFSTATE1'] = ( $menuData['state'] == '1' ) ? ' CHECKED ' : '' ;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_menunew() {
		global $theme, $database, $handler, $post;
				
		$html = $theme->loadModuleTemplate('_admin_menu_menuedit_template');
		
		if ( isset($post['adminMenuEditSave']) ) {
			
			$state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
			
			$database->doQuery("INSERT INTO `".SQLPREF."menu` (`group`, `lang`, 
			`name`, `text`, `type`, `value`, `seo_name`, `order`, `parent`, `state`
			) VALUES ('".$post['group']."', 'hu',
			'".$post['name']."', '".$post['text']."', '".$post['type']."', '".$post['value']."', '".$post['seo_name']."', '".$post['order']."', '".$post['parent']."', '$state') ");
			
			
			$_SESSION['messageSuccess']['save'] = "Sikeres mentés!";
			
			header("Location: ".RUNNER."?admin=menulist");
		}
		
		$replace['DEFTAB'] = '';
		
		$replace['MENU_TYPE_PAGE'] = $theme->loadModuleTemplate('_admin_menu_edit_page_template');
		$replace['MENU_TYPE_POST'] = $theme->loadModuleTemplate('_admin_menu_edit_post_template');
		$replace['MENU_TYPE_CAT'] = $theme->loadModuleTemplate('_admin_menu_edit_cat_template');
		$replace['MENU_TYPE_MODULE'] = $theme->loadModuleTemplate('_admin_menu_edit_module_template');
		$replace['MENU_TYPE_HTML'] = $theme->loadModuleTemplate('_admin_menu_edit_html_template');
		
		$replace['NAME'] = '';
		$replace['SEO_NAME'] = '';
		$replace['TYPE'] = '';
		$replace['TEXT'] = '';
		
		$replace['PAGE_VALUE'] = $this->pageValSelect();
		$replace['POST_VALUE'] = $this->postValSelect();
		$replace['HTML_VALUE'] = "";
		$replace['MODULE_VALUE'] = $this->moduleValSelect();
		$replace['CAT_VALUE'] = $this->catValSelect();
		
		$replace['ORDER'] = '';
		$replace['GROUPSELECT'] = $this->menuGroupSelect();
		$replace['PARENTSELECT'] = $this->menuParSelect();
		$replace['IFSTATE0'] = '';
		$replace['IFSTATE1'] = ' CHECKED ';
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	private function pageValSelect( $id = 0 ) {
		global $database;
		
		$cont = $database->getSelect("array","*","page"," WHERE `type` = 'PAGE' AND `state` != '-1' ORDER BY `name` ASC ");
		if ( empty($cont) ) return '';
				
		$RET = "";
		
		$RET .= "<select name='value' size='10'>";
		
		foreach ( $cont as $val ) {
			$sel = ( $val['page_id'] == $id ) ? ' SELECTED ' : '';
			$RET .= "<option value='".$val['page_id']."' $sel >".$val['name']." (#".$val['page_id'].")</option>";
		}
		
		$RET .= "</select>";
		
		return $RET;
	}
	
	private function postValSelect( $id = 0 ) {
		global $database;
		
		$cont = $database->getSelect("array","*","page"," WHERE `type` = 'POST' AND `state` != '-1' ORDER BY `name` ASC ");
		if ( empty($cont) ) return '';
				
		$RET = "";
		
		$RET .= "<select name='value' size='10'>";
		
		foreach ( $cont as $val ) {
			$sel = ( $val['page_id'] == $id ) ? ' SELECTED ' : '';
			$RET .= "<option value='".$val['page_id']."' $sel >".$val['name']." (#".$val['page_id'].")</option>";
		}
		
		$RET .= "</select>";
		
		return $RET;
	}
	
	private function catValSelect( $id = 0 ) {
		global $database;
		
		$cont = $database->getSelect("array","*","post_category"," WHERE `state` != '-1' ORDER BY `name` ASC ");
		if ( empty($cont) ) return '';
				
		$RET = "";
		
		$RET .= "<select name='value' size='10'>";
		
		foreach ( $cont as $val ) {
			$sel = ( $val['id'] == $id ) ? ' SELECTED ' : '';
			$RET .= "<option value='".$val['id']."' $sel >".$val['name']." (#".$val['id'].")</option>";
		}
		
		$RET .= "</select>";
		
		return $RET;
	}
	
	private function moduleValSelect( $id = 0 ) {
		
		$cont = $this->modules;
				
		$RET = "";
		
		$RET .= "<select name='value' size='10'>";
		
		foreach ( $cont as $val ) {
			$sel = ( $val == $id ) ? ' SELECTED ' : '';
			$RET .= "<option value='".$val."' $sel >".$val."</option>";
		}
		
		$RET .= "</select>";
		
		return $RET;
	}
	
	private function menuGroupSelect( $id = 1 ) {
		
		$menuGroup = array("1","2");
				
		$RET = "";
		
		$RET .= "<select name='group' size='2'>";
		
		foreach ( $menuGroup as $val ) {
			$sel = ( $val == $id ) ? ' SELECTED ' : '';
			$RET .= "<option value='".$val."' $sel >".$val."</option>";
		}
		
		$RET .= "</select>";
		
		return $RET;
	}
	
	private function menuParSelect($menuData = NULL) {
		global $database;
		
		if ($menuData === NULL) {
			$menuData['id'] = 0;
			$menuData['parent'] = 0;
		}
		
		$menus = $database->getSelect("array","*","menu"," WHERE `id` != '".$menuData['id']."' AND `state` != '-1' ORDER BY `group` ASC, `parent` ASC, `order` ASC ");
		if ( empty($menus) ) return '';
		
		
		$menu = Array();
		foreach ( $menus as $value ) {
			$menu[$value['group']][$value['parent']][$value['id']] = $value;
		}
		
		$curParent = $menuData['parent'];
		
		$RET = "";
		
		$RET .= "<select name='parent' size='10'>";
		
		$selFirst = ( $curParent == '0' ) ? ' SELECTED ' : '';
		$RET .= "<option class='group_0' value='0' $selFirst >FŐMENÜ</option>";
		
		$a = "";
		foreach ( $menu as $key => $val ) {
			$RET .= $this->optionReply( $menu[$key], $curParent, 0, $a);
		}
		
		$RET .= "</select>";
		
		return $RET;
	}
	
	private function optionReply( $menu, $curParent, $id, $a) {
		$a .= "&nbsp;&nbsp;";
		$RET = "";
		
		foreach ( $menu[$id] as $key => $val ) {
			$sel = ( $curParent == $val['id'] ) ? ' SELECTED ' : '';
			$RET .= "<option class='group_".$val['group']."' value='".$val['id']."' $sel >".$a.$val['name']."</option>";
			if ( isset($menu[$val['id']]) AND !empty($menu[$val['id']]) ) {
				$RET .= $this->optionReply( $menu, $curParent, $val['id'], $a);
			}
		}
		
		return $RET;
	}
	
	public function __call_menutrash() {
		global $database;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) { return 'Hibás ID'; }
		$id = $_GET['id'];
		
		$extid = $database->getSelect("result","`id`","menu"," WHERE `id` = '".$id."' ");
		if ( empty($extid) ) { return 'Hibás ID'; }
		
		$database->doQuery("UPDATE `".SQLPREF."menu` SET `state` = '-1' WHERE `id` = '".$extid."' ");
		
		$_SESSION['messageSuccess']['delete'] = 'Sikeres bejegyzés törlés';
		
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
}

?>