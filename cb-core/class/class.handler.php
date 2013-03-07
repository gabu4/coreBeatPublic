<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v002
|     Date: 2012. 11. 27.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

class handler {
		
	var $messageError = Array();
	var $messageSuccess = Array();
	var $messageWarning = Array();
	
	function handler() {
	
		$this->postCheck();
		$this->savedMessage();
		
	}
	
	private function savedMessage() {
		
		if ( isset($_SESSION['messageSuccess']) AND !empty($_SESSION['messageSuccess']) ) {
			$this->$messageSuccess = $_SESSION['messageSuccess'];
			unset($_SESSION['messageSuccess']);
		}
		
		if ( isset($_SESSION['messageWarning']) AND !empty($_SESSION['messageWarning']) ) {
			$this->$messageWarning = $_SESSION['messageWarning'];
			unset($_SESSION['messageWarning']);
		}
		
		if ( isset($_SESSION['messageError']) AND !empty($_SESSION['messageError']) ) {
			$this->$messageError = $_SESSION['messageError'];
			unset($_SESSION['messageError']);
		}
		
	}
	
	
	private function postCheck() {
		global $post;
		
		$post = $_POST;
	}
	
}

return; ?>
