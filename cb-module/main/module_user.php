<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2013. 07. 02.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

include_once('language/'.CB_LANGTYPE.'.php');

class module_main {
	
	var $pageType = 'PAGE';
	var $actPageVal = CB_DEF_PAGE;
	var $menuId = 0;
	
	function module_main() {
		
		
	}
	
	public function __call_main($id) {
		return $this->__call_page($id);
	}
	
	public function __call_page($id, $where = 'MAIN' ) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');
		
		$actPage = $database->getSelect("result","`value`","menu"," WHERE `type` = 'PAGE' AND `value` = '$id' AND `state` = '1' ");
		if ( empty($actPage) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$pageData = $database->getSelect("row","*","page"," WHERE `type` = 'PAGE' AND `page_id` = '$actPage' AND `state` = '1' ");
		if ( empty($pageData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$html = $theme->loadModuleTemplate('page_main_template');
		
		$theme->pageTitle = CB_PAGETITLE . " - ".$pageData['name'];

		$replace['PAGETITLE'] = $pageData['name'];
		$replace['CONTENT'] = nl2br($pageData['text']);
		$replace['CDATE'] = $pageData['cdate'];  //keszitesi ido
		$replace['CID'] = $pageData['cid'];  //keszito id-je
		$replace['MDATE'] = $pageData['mdate'];  //modositasi ido
		$replace['MID'] = $pageData['mid'];  //modosito id-je

		$theme->tempMETAAUTH = $pageData['meta_author'];
		$theme->tempMETAKEY[] = $pageData['meta_keywords'];
		$theme->tempMETADESC[] = $pageData['meta_description'];
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}

		return $html;
	}
	
	public function __call_post($id, $where = 'MAIN' ) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');
		
		$actPage = $database->getSelect("result","`value`","menu"," WHERE `type` = 'POST' AND `value` = '$id' AND `state` = '1' ");
		if ( empty($actPage) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$pageData = $database->getSelect("row","*","page"," WHERE `type` = 'POST' AND `page_id` = '$actPage' AND `state` = '1' ");
		if ( empty($pageData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$html = $theme->loadModuleTemplate('page_main_template');
		
		$theme->pageTitle = CB_PAGETITLE . " - ".$pageData['name'];
		
		$replace['TITLE'] = $pageData['name'];
		$replace['CONTENT'] = nl2br($pageData['text']);
		$replace['CDATE'] = $pageData['cdate'];  //keszitesi ido
		$replace['CID'] = $pageData['cid'];  //keszito id-je
		$replace['MDATE'] = $pageData['mdate'];  //modositasi ido
		$replace['MID'] = $pageData['mid'];  //modosito id-je

		$theme->tempMETAAUTH = $pageData['meta_author'];
		$theme->tempMETAKEY[] = $pageData['meta_keywords'];
		$theme->tempMETADESC[] = $pageData['meta_description'];
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}

		$theme->tempREPLACE[$where] = $html;
	}
		
	public function __call_category($id, $where = 'MAIN' ) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');

		$CatData = $database->getSelect("result","`value`","menu"," WHERE `type` = 'CAT' AND `id` = '$id' AND `state` = '1' ");
		if ( empty($CatData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return; }
		
		$postCat = $database->getSelect("row","*","post_category"," WHERE `id` = '$id' AND `state` = '1' ");
		
		$postCatData = $database->getResultArray("SELECT * FROM `".CB_SQLPREF."page` `page`, `".CB_SQLPREF."post_category_xref` `xref` WHERE `page`.`page_id` = `xref`.`post` AND `page`.`state` = '1' AND `xref`.`id` = '".$id."' AND `page`.`type` = 'POST' ORDER BY `page`.`cdate` DESC ");
		if ( empty($postCatData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return; }
		
		$html = $theme->loadModuleTemplate('cat_template');
		$posthtml = $theme->loadModuleTemplate('cat_post_template');
		
		$theme->pageTitle = CB_PAGETITLE . " - ".$postCat['name'];
		
		$out = "";
		
		foreach ($postCatData as $value) {
			$out .= $posthtml;
			$replace['TITLE'] = $value['name'];
			$replace['CONTENT'] = nl2br($value['text']);
			$replace['CDATE'] = $value['cdate'];  //keszitesi ido
			$replace['CID'] = $value['cid'];  //keszito id-je
			$replace['MDATE'] = $value['mdate'];  //modositasi ido
			$replace['MID'] = $value['mid'];  //modosito id-je
			
			foreach ( $replace as $key => $val ) {
				$out = str_replace( '{#'.strtoupper($key).'}', $val, $out );
			}
			unset($replace);
		}
		
		$replace['TITLE'] = $postCat['name'];
		$replace['CONTENT'] = $out;
		
		foreach ( $replace as $key => $val ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $val, $html );
		}
		$theme->tempREPLACE[$where] = $html;
	}
		
}

?>
