<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 10. 13.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

include_once('language/'.LANGTYPE.'.php');

class page {
	
	var $call = Array( "loadpage" );
	
	function page() {
		global $heandler;
		
		$handler->call['page'] = $this->call;
	}
	
	public function __call_loadpage() {
		$id = $_GET['id'];
		return $this->loadPage($id);
	}
	
	public function loadPage($id, $where = 'MAIN' ) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');
		
		$actPage = $database->getSelect("result","`value`","menu"," WHERE `type` = 'PAGE' AND `value` = '$id' AND `state` = '1' ");
		if ( empty($actPage) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$pageData = $database->getSelect("row","*","page"," WHERE `type` = 'PAGE' AND `page_id` = '$actPage' AND `state` = '1' ");
		if ( empty($pageData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$html = $theme->loadModuleTemplate('page_template');
		
		$theme->pageTitle = PAGETITLE . " - ".$pageData['name'];

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
	
	public function loadPost($id, $where = 'MAIN' ) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');
		
		$actPage = $database->getSelect("result","`value`","menu"," WHERE `type` = 'POST' AND `value` = '$id' AND `state` = '1' ");
		if ( empty($actPage) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$pageData = $database->getSelect("row","*","page"," WHERE `type` = 'POST' AND `page_id` = '$actPage' AND `state` = '1' ");
		if ( empty($pageData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return;}
		
		$html = $theme->loadModuleTemplate('page_template');
		
		$theme->pageTitle = PAGETITLE . " - ".$pageData['name'];
		
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
	
	public function loadHtml($id) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');

		$link = $database->getSelect("result","`value`","menu"," WHERE `id` = '$id' AND `state` = '1' ");
		if ( empty($link) ) { $theme->tempREPLACE[$where] = 'Hiba'; return; }
		
		header("Location: ".$link);
	}
	
	public function loadModule($id, $where = 'MAIN' ) {
		global $handler;
		
		$handler->loadFunction($id, $where);
		
	}
	
	public function loadCategory($id, $where = 'MAIN' ) {
		global $database, $theme;
		
		$where = mb_strtoupper($where, 'UTF-8');

		$CatData = $database->getSelect("result","`value`","menu"," WHERE `type` = 'CAT' AND `id` = '$id' AND `state` = '1' ");
		if ( empty($CatData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return; }
		
		$postCat = $database->getSelect("row","*","post_category"," WHERE `id` = '$id' AND `state` = '1' ");
		
		$postCatData = $database->getResultArray("SELECT * FROM `".SQLPREF."page` `page`, `".SQLPREF."post_category_xref` `xref` WHERE `page`.`page_id` = `xref`.`post` AND `page`.`state` = '1' AND `xref`.`id` = '".$id."' AND `page`.`type` = 'POST' ORDER BY `page`.`cdate` DESC ");
		if ( empty($postCatData) ) { $theme->tempREPLACE[$where] = PAGE_NO_PAGE_DATA; return; }
		
		$html = $theme->loadModuleTemplate('cat_template');
		$posthtml = $theme->loadModuleTemplate('cat_post_template');
		
		$theme->pageTitle = PAGETITLE . " - ".$postCat['name'];
		
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
