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

class page_admin {
	
	var $admin = 0;
	var $call = Array( "pagelist", "pageedit", "pagenew", "pagetrash", "postlist", "postedit", "postnew", "posttrash" );
	
	function page_admin() {
		global $user, $theme, $handler;
		
		$handler->callAdmin['page_admin'] = $this->call;
		
	}
	
	public function __call_pagelist() {
		global $theme, $database;
		
		$html = $theme->loadModuleTemplate('_admin_page_pagelist_template');
		$html2 = $theme->loadModuleTemplate('_admin_page_pagelist_row_template');
		
		$pageList = $database->getSelect("array","*","page"," WHERE `type` = 'PAGE' AND `state` != '-1' ORDER BY `page_id` ASC ");
			
		$in = "";
		foreach ( $pageList as $val ) {
			$in2 = $html2;
			
			$replace['ID'] = $val['page_id'];
			$replace['NAME'] = $val['name'];
			$replace['CDATE'] = date("Y-m-d H:i:s", $val['cdate']);
			$replace['MDATE'] = ( $val['mdate'] != '0' ) ? date("Y-m-d H:i:s", $val['mdate']) : " ----- ";
			$active = "<img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/active.png' alt='Aktív' title='Aktív' />";
			$inactive = "<img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/inactive.png' alt='Inaktív' title='Inaktív' />";
			$replace['ACTIVE'] = ( $val['state'] == 1 ) ? $active : $inactive;
			$replace['SETTINGS'] = "<a href='".RUNNER."?admin=pageedit&id=".$val['page_id']."'><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/settings.png' alt='Beállítás' title='Beállítás' /></a>";
			$replace['DELETE'] = "<a href='".RUNNER."?admin=pagetrash&id=".$val['page_id']."' onclick=\"javascript:return confirm('Biztos, hogy törölni akarod a kiválasztott oldalt? (nem fogod tudni visszaállítani)')\"><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/delete.png' alt='Törlés' title='Törlés' /></a>";
			
			foreach ( $replace as $key => $value ) {
				$in2 = str_replace( '{#'.strtoupper($key).'}', $value, $in2 );
			}
			
			unset($replace);
			$in .= $in2;
		}
		
		$replace['PAGELIST'] = $in;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_pageedit() {
		global $theme, $database, $handler, $user, $post;
				
		$html = $theme->loadModuleTemplate('_admin_page_pageedit_template');
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) return 0;
		
		if ( isset($post['adminPageEditSave']) ) {
			$mdate = time();
			
			$state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
			
			$database->doQuery("UPDATE `".SQLPREF."page` SET `name` = '".$post['name']."', `text` = '".$post['text']."', `mid` = '".$user->userID."', `mdate` = '".$mdate."', `meta_keywords` = '".$post['meta_key']."', `meta_description` = '".$post['meta_desc']."', `state` = '".$state."' WHERE `page_id` = '".$_GET['id']."' ");
			$handler->messageSuccess[] = "Sikeres mentés!";
		}
		
		$pageData = $database->getSelect("row","*","page"," WHERE `type` = 'PAGE' AND `page_id` = '".$_GET['id']."' ");
		
		if ( empty($pageData) ) return 0;
		
		$replace['NAME'] = $pageData['name'];
		$replace['TEXT'] = $pageData['text'];
		$replace['META_KEY'] = $pageData['meta_keywords'];
		$replace['META_DESC'] = $pageData['meta_description'];
		$replace['IFSTATE0'] = ( $pageData['state'] == '0' ) ? ' CHECKED ' : '' ;
		$replace['IFSTATE1'] = ( $pageData['state'] == '1' ) ? ' CHECKED ' : '' ;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_pagenew() {
		global $theme, $database, $handler, $user, $post;
				
		$html = $theme->loadModuleTemplate('_admin_page_pageedit_template');
		
		if ( isset($post['adminPageEditSave']) ) {
			$cdate = time();
			
			$page_id = $database->getSelect("result","`page_id`","page"," WHERE `type` = 'PAGE' ORDER BY `page_id` DESC ");
			$page_id = $page_id+1;
			
			$state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
			
			$database->doQuery("INSERT INTO `".SQLPREF."page` (`name`, `text`, `cid`, `cdate`, `meta_keywords`, `meta_description`, `page_id`, `type`, `state`) VALUES ('".$post['name']."', '".$post['text']."', '".$user->userID."', '".$cdate."', '".$post['meta_key']."', '".$post['meta_desc']."', '".$page_id."', 'PAGE', '$state') ");
			
			$_SESSION['messageSuccess']['save'] = "Sikeres mentés!";
			
			header("Location: ".RUNNER."?admin=pagelist");
		}
				
		$replace['NAME'] = '';
		$replace['TEXT'] = '';
		$replace['META_KEY'] = '';
		$replace['META_DESC'] = '';
		$replace['IFSTATE0'] = '';
		$replace['IFSTATE1'] = ' CHECKED ';
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_postlist() {
		global $theme, $database;
		
		$html = $theme->loadModuleTemplate('_admin_page_postlist_template');
		$html2 = $theme->loadModuleTemplate('_admin_page_postlist_row_template');
		
		$pageList = $database->getSelect("array","*","page"," WHERE `type` = 'POST' AND `state` != '-1' ORDER BY `page_id` ASC ");
		$g = $database->getSelect("array","*","post_category"," ORDER BY `id` ASC ");
		$groups = Array();
		foreach ( $g as $val ) {
			$groups[$val['id']] = $val['name'];
		}
		$ag = $database->getSelect("array","*","post_category_xref"," ORDER BY `post` ASC ");
		$actgroups = Array();
		foreach ( $ag as $val ) {
			$actgroups[$val['post']][$val['id']] = $val['id'];
		}
		
		$in = "";
		foreach ( $pageList as $val ) {
			$in2 = $html2;
			
			$replace['ID'] = $val['page_id'];
			$replace['NAME'] = $val['name'];
			
			$group = "";
			if ( isset($actgroups[$val['page_id']]) ) {
				foreach ( $actgroups[$val['page_id']] as $val2 ) {
					if ( !empty($group) ) $group .= ", ";
					$group .= $groups[$val2];
				}
			}
			
			$replace['GROUP'] = $group;
			$replace['CDATE'] = date("Y-m-d H:i:s", $val['cdate']);
			$replace['MDATE'] = ( $val['mdate'] != '0' ) ? date("Y-m-d H:i:s", $val['mdate']) : " ----- ";
			$active = "<img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/active.png' alt='Aktív' title='Aktív' />";
			$inactive = "<img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/inactive.png' alt='Inaktív' title='Inaktív' />";
			$replace['ACTIVE'] = ( $val['state'] == 1 ) ? $active : $inactive;
			$replace['SETTINGS'] = "<a href='".RUNNER."?admin=postedit&id=".$val['page_id']."'><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/settings.png' alt='Beállítás' title='Beállítás' /></a>";
			$replace['DELETE'] = "<a href='".RUNNER."?admin=posttrash&id=".$val['page_id']."' onclick=\"javascript:return confirm('Biztos, hogy törölni akarod a kiválasztott bejegyzést? (nem fogod tudni visszaállítani)')\"><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/delete.png' alt='Törlés' title='Törlés' /></a>";
			
			foreach ( $replace as $key => $value ) {
				$in2 = str_replace( '{#'.strtoupper($key).'}', $value, $in2 );
			}
			
			unset($replace);
			$in .= $in2;
		}
		
		$replace['PAGELIST'] = $in;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_postedit() {
		global $theme, $database, $handler, $user, $post;
				
		$html = $theme->loadModuleTemplate('_admin_page_postedit_template');
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) return 0;
		
		if ( isset($post['adminPageEditSave']) ) {
			$mdate = time();
			
			$state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
			
			$database->doQuery("UPDATE `".SQLPREF."page` SET `name` = '".$post['name']."', `text` = '".$post['text']."', `mid` = '".$user->userID."', `mdate` = '".$mdate."', `meta_keywords` = '".$post['meta_key']."', `meta_description` = '".$post['meta_desc']."', `state` = '".$state."' WHERE `page_id` = '".$_GET['id']."' ");
			$handler->messageSuccess[] = "Sikeres mentés!";
		}
		
		$database->doQuery("DELETE INTO `".SQLPREF."post_category_xref` WHERE `post` = '".$_GET['id']."' ");
		
		if ( isset($post['category']) ) {
			foreach ($post['category'] as $key => $val )  {
				$database->doQuery("INSERT INTO `".SQLPREF."post_category_xref` (`id`, `post`) VALUES ('".$key."', '".$_GET['id']."') ");
			}
		}
		
		if ( !empty($post['new_category']) ) {
			$cat_id = $database->getSelect("result","`id`","post_category"," ORDER BY `id` DESC LIMIT 1");
			$cat_id = $cat_id+1;
			
			$database->doQuery("INSERT INTO `".SQLPREF."post_category` (`id`, `name`, `state`) VALUES ('".$cat_id."', '".$post['new_category']."', '1') ");
			
			$database->doQuery("INSERT INTO `".SQLPREF."post_category_xref` (`id`, `post`) VALUES ('".$cat_id."', '".$_GET['id']."') ");
		}
		
		$pageData = $database->getSelect("row","*","page"," WHERE `type` = 'POST' AND `page_id` = '".$_GET['id']."' ");
		
		if ( empty($pageData) ) return 0;
		
		$replace['NAME'] = $pageData['name'];
		$replace['TEXT'] = $pageData['text'];
		$replace['META_KEY'] = $pageData['meta_keywords'];
		$replace['META_DESC'] = $pageData['meta_description'];
		$replace['CATEGORYLIST'] = $this->categoryGen($_GET['id']);
		$replace['IFSTATE0'] = ( $pageData['state'] == '0' ) ? ' CHECKED ' : '' ;
		$replace['IFSTATE1'] = ( $pageData['state'] == '1' ) ? ' CHECKED ' : '' ;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_postnew() {
		global $theme, $database, $handler, $user, $post;
				
		$html = $theme->loadModuleTemplate('_admin_page_postedit_template');
		
		if ( isset($post['adminPageEditSave']) ) {
			$cdate = time();
			
			$page_id = $database->getSelect("result","`page_id`","page"," WHERE `type` = 'POST' ORDER BY `page_id` DESC LIMIT 1 ");
			$page_id = $page_id+1;
			
			$state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
			
			$database->doQuery("INSERT INTO `".SQLPREF."page` (`name`, `text`, `cid`, `cdate`, `meta_keywords`, `meta_description`, `page_id`, `type`, `state`) VALUES ('".$post['name']."', '".$post['text']."', '".$user->userID."', '".$cdate."', '".$post['meta_key']."', '".$post['meta_desc']."', '".$page_id."', 'POST', '$state') ");
			
			$database->doQuery("DELETE INTO `".SQLPREF."post_category_xref` WHERE `post` = '".$page_id."' ");
			
			if ( isset($post['category']) ) {
				foreach ($post['category'] as $key => $val )  {
					$database->doQuery("INSERT INTO `".SQLPREF."post_category_xref` (`id`, `post`) VALUES ('".$key."', '".$page_id."') ");
				}
			}
			
			if ( !empty($post['new_category']) ) {
				$cat_id = $database->getSelect("result","`id`","post_category"," ORDER BY `id` DESC LIMIT 1");
				$cat_id = $cat_id+1;
				
				$database->doQuery("INSERT INTO `".SQLPREF."post_category` (`id`, `name`, `state`) VALUES ('".$cat_id."', '".$post['new_category']."', '1') ");
				
				$database->doQuery("INSERT INTO `".SQLPREF."post_category_xref` (`id`, `post`) VALUES ('".$cat_id."', '".$page_id."') ");
			}
			
			$_SESSION['messageSuccess']['save'] = "Sikeres mentés!";
			
			header("Location: ".RUNNER."?admin=postlist");
		}
				
		$replace['NAME'] = '';
		$replace['TEXT'] = '';
		$replace['META_KEY'] = '';
		$replace['META_DESC'] = '';
		$replace['CATEGORYLIST'] = $this->categoryGen();
		$replace['IFSTATE0'] = '';
		$replace['IFSTATE1'] = ' CHECKED ';
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	private function categoryGen($id = 0) {
		global $database;
		
		$RET = "";
		
		$oldCat = Array();
		if ( $id != '0' ) {
			$cat = $database->getSelect("array","*","post_category_xref"," WHERE `post` = '".$id."' ");
			
			if ( !empty($cat) ) {
				foreach ( $cat as $val ) {
					$oldCat[$val['id']] = 1;
				}
			}
		}
		
		$catList = $database->getSelect("array","*","post_category"," ORDER BY `name` ASC ");
		
		$RET .= "<span class='categorySel'>";
		if ( !empty($catList) ) {
			$RET .= "<span class='categorySelBox'>";
			foreach ( $catList as $val ) {
				$SELECT = "";
				if ( isset($oldCat[$val['id']]) ) $SELECT = " CHECKED";
				$RET .= "<input type='checkbox' id='catId_".$val['id']."' value='1' name='category[".$val['id']."]' $SELECT /><label for='catId_".$val['id']."'> ".$val['name']."</label>";
			}
			$RET .= "</span>";
		}
		$RET .= "<span class='categorySelNew'><span class='rowText'>Új kategória neve: </span><input type='text' class='new_category' name='new_category' /></span>";
		$RET .= "</span>";
		
		return $RET;
		
	}
	
	public function __call_pagetrash() {
		global $database;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) { return 'Hibás ID'; }
		$id = $_GET['id'];
		
		$extid = $database->getSelect("result","`id`","page"," WHERE `page_id` = '".$id."' AND `type` = 'PAGE' ");
		if ( empty($extid) ) { return 'Hibás ID'; }
		
		$database->doQuery("UPDATE `".SQLPREF."page` SET `state` = '-1' WHERE `id` = '".$extid."' ");
		
		$_SESSION['messageSuccess']['delete'] = 'Sikeres oldal törlés';
		
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
	
	public function __call_posttrash() {
		global $database;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) { return 'Hibás ID'; }
		$id = $_GET['id'];
		
		$extid = $database->getSelect("result","`id`","page"," WHERE `page_id` = '".$id."' AND `type` = 'POST' ");
		if ( empty($extid) ) { return 'Hibás ID'; }
		
		$database->doQuery("UPDATE `".SQLPREF."page` SET `state` = '-1' WHERE `id` = '".$extid."' ");
		
		$_SESSION['messageSuccess']['delete'] = 'Sikeres bejegyzés törlés';
		
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
}

?>