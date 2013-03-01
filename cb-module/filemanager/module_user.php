<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 09. 30.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

include_once('language/'.LANGTYPE.'.php');

class filemanager {
	
	var $call = Array( "filemanager", "fileupload", "filedownload" );
	
	function filemanager() {
		global $theme, $handler;
		
		$handler->call['filemanager'] = $this->call;
		
	}

	public function __call_filemanager() {
		global $theme, $user, $database, $handler, $post;
		
		if ( $user->userID == '0' ) { return 0; }
		
		$html = $theme->loadModuleTemplate('filemanager_main_template');
		
		$fileList = $database->getSelect("row","*","file"," WHERE `user_id` = '".$user->userID."' ");
		
		if ( empty($fileList) ) {
			$out = "Nincs feltöltött fájl!";
		} else {
			
			$out = "";
			foreach ( $fileList as $val ) {
				
				$fileSab = $theme->loadModuleTemplate('filemanager_file_template');
				
				$replace['IMAGE'] = "";
				$replace['FILENAME'] = $val['file_name'];
				$replace['FILESIZE'] = $val['file_size'];
				$replace['FILETYPE'] = $val['file_type'];
				$replace['FILEDATE'] = $val['date'];
				$replace['FILECOMMENT'] = $val['comment'];
				
				foreach ( $replace as $key => $value ) {
					$out .= str_replace( '{#'.strtoupper($key).'}', $value, $fileSab );
				}
			}
		}
		return $html;
	}
	
	private function test_call_filemanager() {
		global $database, $post;
		
		$RET = Array();
		
		if ( !isset($post['name']) OR empty($post['name']) ) {
			$RET['name'] = "A név nem lehet üres!";
		}
		
		if ( !isset($post['username']) OR empty($post['username']) ) {
			$RET['username'] = "A felhasználónév megadása közelező!";
		}
		
		if ( !isset($post['email']) OR empty($post['email']) OR ( check_email_address($post['email']) === false ) ) {
			$RET['email'] = "Üres vagy érvénytelen e-mail cím!";
		}
		
		$emailCheck = $database->getSelect("result","`id`","user"," WHERE `id` != '".$user->userID."' AND `email` = '".$post['email']."' ");
		if ( !empty($emailCheck) ) {
			$RET['email'] = "Az email cím már használatban van!";
		}
		
		if ( !isset($post['telephone']) OR empty($post['telephone']) ) {
			$RET['telephone'] = "Kérem adjon meg egy telefonszámot!";
		}
		
		if ( !isset($post['address']) OR empty($post['address']) ) {
			$RET['address'] = "Kérem adjom meg címet!";
		}
		
		if ( !isset($post['disturb']) OR empty($post['disturb']) ) {
			$RET['disturb'] = "Kérem adja meg, hogy mikor hívható!";
		}
		
		if ( !isset($post['password']) OR empty($post['password']) ) {
			$RET['new_password'] = "Az új jelszó nem lehet üres!";
		}
		
		if ( !isset($post['rep_password']) OR empty($post['rep_password']) ) {
			$RET['repnew_password'] = "Az új jelszó ismételt megadása kötelező!";
		}
		
		if ( $post['password'] != $post['rep_password'] ) {
			$RET['notSame'] = "A két jelszó nem egyezik!";
		}
		
		return $RET;
	}
	
	public function __call_fileupload() {
		global $theme, $user, $database, $handler, $post;
		
		if ( $user->userID == '0' ) { return 0; }
		
		if ( isset($post['fileUploadButton']) AND isset($_FILES['file']) AND !empty($_FILES['file']) ) {
			
			if ( $_FILES['file']['error'] == '0' ) {
				$file_name = $_FILES['file']['name'];
				$file_type = $_FILES['file']['type'];
				$file_size = $_FILES['file']['size'];
				$numbr = strrpos($_FILES['file']['name'], '.', -1);
				$file_ext = substr($_FILES['file']['name'], $numbr);
				
				$comment = $post['comment'];
				
				$tmp_name = $_FILES['file']['tmp_name'];
				$date = time();
				$dir = CB_UPLOADDIR.'/'.$user->userID;
				
				if( !file_exists($dir) OR !is_dir($dir) ) {
					mkdir($dir, 0777, true);
				}
				
				copy($tmp_name,$dir.'/'.$date.$file_ext);
				$database->doQuery("INSERT INTO `".SQLPREF."file` (`user_id`,`file_name`,`file_size`,`file_type`,`date`,`file_ext`,`comment`) VALUES ('".$user->userID."','".$file_name."','".$file_size."','".$file_type."','".$date."','".$file_ext."','".$comment."') ");
				
				$handler->messageSuccess[] = 'Sikeres fájlfeltöltés';
			} else {
				$handler->messageError[] = 'Hiba a fájlfeltöltés során!';
			}
		}
		
		$html = $theme->loadModuleTemplate('filemanager_fileupload_template');
		
		return $html;
	}
	
	public function __call_filedownload() {
	
		global $database, $user;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) {
			return 0;
		}
		
		$id = $_GET['id'];
		$file = $database->getSelect("row","*","file"," WHERE `id` = '".$id."' ");
		
		if ( empty($file) ) {
			return 0;
		}
		
		if ( ($file['user_id'] != $user->userID ) OR ($user->userLevel != 255 ) ) {
			return 0;
		}
		
		
		$dir = CB_UPLOADDIR.'/'.$file['user_id'].'/';
		$original_filename = $file['date'].$file['file_ext'];
		$new_filename = $file['file_name'];

		// headers to send your file
		header("Content-Type: ".$file['file_type']);
		header("Content-Length: " . filesize($dir.$original_filename));
		header('Content-Disposition: attachment; filename="' . $new_filename . '"');

		// upload the file to the user and quit
		readfile($dir.$original_filename);
		exit;
		
		
	}
	
}

?>
