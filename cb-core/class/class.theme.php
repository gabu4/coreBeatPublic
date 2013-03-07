<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2013. 03. 07.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

class theme {

	var $template = '';
	
	var $theme = THEMESET;
	var $isAdmin = 0;
	
	var $tempMETADESC = Array();
	var $tempMETAKEY = Array();
	var $tempMETAAUTH = "";
	var $tempMAINCSS = Array();
	var $tempMAINJS = Array();
	
	var $tempModuleREPLACE = Array();
	var $tempStaticREPLACE = Array();
	
	var $tempSUBMENU = Array();
	var $inMAIN = '';
	
	var $tempOut = '';
	
	var $messageBar = "";
	
	var $activeThemePath = "";
	var $themeStyle = "";
	
	
	var $pageTitle = "";
	
	function theme() {
		$this->tempMETAAUTH = META_DEF_AUTH;
		$this->tempMETAKEY[] = META_DEF_KEY;
		$this->tempMETADESC[] = META_DEF_DESC;
	}	
		
	private function loadMETA($type = 'main') {
		global $database;
		
		if ( $type == 'main' ) {
			
		} else {
			
		}
	}
	
	private function themeModuleReplace() {
		global $module;
		$html = $this->tempOut;
		
		preg_match_all("/{#MODULE,(.*),(.*),(.*)?}/", $html, $matchSearch, PREG_SET_ORDER);
//		print_r($matchSearch);
		if ( !empty($matchSearch) ) {
			foreach ($matchSearch as $matchValue) {				
				$funct = $module->loadFunction($matchValue[1], $matchValue[2], $matchValue[3]);
				$html = str_replace( $matchValue[0], $funct, $html );
			}
		}
		
		$this->tempOut = $html;
		
	}
	
	private function themeAdminModuleReplace() {
		global $module;
		$html = $this->tempOut;
		
		preg_match_all("/{#ADMIN,(.*),(.*),?(.*)?}/", $html, $matchSearch, PREG_SET_ORDER);
		
		if ( !empty($matchSearch) ) {
			foreach ($matchSearch as $matchValue) {				
				$funct = $module->loadAdminFunction($matchValue[1], $matchValue[2], $matchValue[3]);
				$html = str_replace( $matchValue[0], $funct, $html );
			}
		}
		
		$this->tempOut = $html;
		
	}
	
	private function themeStaticReplace() {
		
		$html = $this->tempOut;
		
		preg_match_all("/{#STATIC,(.*),(.*)}/", $html, $matchSearch, PREG_SET_ORDER);
		
		if ( !empty($this->tempStaticREPLACE) ) {
			foreach ($matchSearch as $matchValue) {
				if ( isset($this->tempStaticREPLACE[$matchValue[1]][$matchValue[2]]) ) {
					$html = str_replace( $matchValue[0], $this->tempStaticREPLACE[$matchValue[1]][$matchValue[2]], $html );
				} else {
					if ( CMR_DEBUGING != '1' ) {
						$html = str_replace( $matchValue[0], '', $html );
					}
				}
			}
		}
		
		$this->tempOut = $html;
		
	}
	
	
	public function loadPageTheme( $theme = NULL, $themeStyle = 'main' ) {
		if ( $theme == NULL ) $theme = $this->theme;
		$this->themeStyle = strtoupper($themeStyle);
	
		$this->activeThemePath = CB_THEME."/".$theme."/";
		
		$filename = "theme.php";
		if ( ($this->isAdmin == 1) AND file_exists($this->activeThemePath."admin_theme.php") ) {
			$this->theme = $theme;
			$filename = "admin_theme.php";
		}
		
		require_once($this->activeThemePath.$filename);
		
		$this->tempMAIN[strtoupper($themeStyle)] = $THEMEBODY[$themeStyle];
		
		if ( isset($CSS) ) {
			foreach ( $CSS as $val ) {
				$this->tempMAINCSS[] = $this->activeThemePath."css/".$val;
			}
		}
		
		if ( isset($JS) ) {
			foreach ( $JS as $val ) {
				$this->tempMAINJS[] = $this->activeThemePath."js/".$val;
			}
		}
		
	}
	
	public function loadModuleTemplate( $name, $module = NULL, $title = 1 ) {
		$filename = $name.".php";print_r($name);
		$data = "";
		if ( $module == NULL ) {
			$data = CB_THEME."/".THEMESET."/".$filename;
			if ( !file_exists($data) ) { $data = CB_THEME."/_template/".$filename; }
		} else {
			$data = CB_THEME."/".THEMESET."/".$filename;
			if ( !file_exists($data) ) { $data = CB_MODULE."/".$module."/".$filename; }
		}
		if ( file_exists($data) ) {
	
		include($data);
		
		if ( isset($CSS) ) {
			foreach ( $CSS as $val ) {
				if ( $module == NULL ) {
					$this->tempMAINCSS[] = CB_THEME."/_template/css/".$val;
				} else {
					$this->tempMAINCSS[] = CB_MODULE."/".$module."/css/".$val;
				}
			}
		}
		if ( isset($JS) ) {
			foreach ( $JS as $val ) {
				if ( $module == NULL ) {
					$this->tempMAINJS[] = CB_THEME."/_template/js/".$val;
				} else {
					$this->tempMAINJS[] = CB_MODULE."/".$module."/js/".$val;
				}
			}
		}
		
		if ( isset($SUBMENU) AND !empty($SUBMENU) ) {
			$this->tempSUBMENU = $SUBMENU;
		}
		
		if ( isset($MODULETITLE) AND !empty($MODULETITLE) AND ( $title == 1 ) ) {
			$this->tempREPLACE['PAGETITLE'] = $MODULETITLE;
		}
		
		return $MODULEBODY;
		}
	}
	
	public function buildSubMenu() {
		$out = "";
		if ( !empty($this->tempSUBMENU) ) {
			$out .= "<ul class='subMenu'>";
			foreach( $this->tempSUBMENU as $key => $val ) {
				$out .= "<li><a href='$key'>$val</a></li>";
			}
			$out .= "</ul>";
		}
		
		$this->tempREPLACE['SUBMENU'] = $out;
	}
	
	public function buildPage() {
		$this->loadMessages();
		$this->buildSubMenu();
		
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$html .= "<html>";
		$html .= "<head>";
		$html .= "<title>".$this->pageTitle."</title>";
		$html .= "
			<meta content='text/html; charset=utf-8' http-equiv='content-type' />
		";
		if ( !empty($this->tempMETAAUTH) ) {
			$html .= "<meta name='author' content='".$this->tempMETAAUTH."' />";
		}
		if ( !empty($this->tempMETAKEY) ) {
			$meta = "";
			foreach ( $this->tempMETAKEY as $val ) {
				if ( !empty($meta) ) $meta .= "; ";
				$meta .= $val;
			}
			$html .= "<meta name='keywords' content='".$val."' />";
		}
		if ( !empty($this->tempMETADESC) ) {
			$meta = "";
			foreach ( $this->tempMETADESC as $val ) {
				if ( !empty($meta) ) $meta .= "; ";
				$meta .= $val;
			}
			$html .= "<meta name='description' content='".$val."' />";
		}
		if ( !empty($this->tempMAINCSS) ) {
			foreach ( $this->tempMAINCSS as $val ) {
				$html .= "<link type='text/css' href='".$val."' rel='stylesheet' />";
			}
		}
		
		$html .= "<script type='text/javascript' src='". CB_THEME ."/_template/js/jquery.min.js' language='JavaScript'></script>";
		$html .= "<script type='text/javascript' src='". CB_CORE ."/etc/tiny_mce/tiny_mce.js' language='JavaScript'></script>";
		$html .= "<script type='text/javascript' src='". CB_THEME ."/_template/js/tiny_mce_setup.js' language='JavaScript'></script>";
		
		if ( !empty($this->tempMAINJS) ) {
			foreach ( $this->tempMAINJS as $val ) {
				$html .= "<script type='text/javascript' src='".$val."' language='JavaScript'></script>";
			}
		}
		
		$html .= "</head>";
		$html .= "<body>";
		$html .= $this->messageBar;
		$html .= $this->tempMAIN[$this->themeStyle];
		$html .= "</body>";
		$html .= "</html>";	
				
		$this->tempOut = $html;
		
		$this->themeModuleReplace();
		$this->themeAdminModuleReplace();
		$this->themeStaticReplace();
		
	}
	
	private function loadMessages() {
		global $handler;
		
		$this->tempMAINCSS[] = CB_THEME."/_template/css/messagebar.css";
		$this->tempMAINJS[] = CB_THEME."/_template/js/messagebar.js";
		
		$html = "<div id='messagebar' class='messagebar'>";
		$html .= "<div class='loadmessage'>";
		foreach ( $handler->messageError as $val ) {
			$html .= "<span class='error' style='display:none;'>".$val."</span>";
		}
		foreach ( $handler->messageWarning as $val ) {
			$html .= "<span class='warning' style='display:none;'>".$val."</span>";
		}
		foreach ( $handler->messageSuccess as $val ) {
			$html .= "<span class='success' style='display:none;'>".$val."</span>";
		}
		$html .= "</div>";
		$html .= "<div class='message'></div>";
		$html .= "</div>";
		
		$this->messageBar = $html;
		
	}

}

return; ?>
