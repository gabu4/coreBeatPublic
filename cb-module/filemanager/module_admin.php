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

class filemanager_admin {
	
	var $admin = 0;
	var $call = Array( "filemain", "files", "fileupload", "filedelete" );
	
	function filemanager_admin( ) {
		global $user, $theme, $handler;
		
		$handler->callAdmin['filemanager_admin'] = $this->call;
		
	}
	
	public function __call_filemain() {
		global $theme, $database;
		
		$html = $theme->loadModuleTemplate('_admin_filemanager_main_template');
		
		$userList = $database->getSelect("array","*","user"," ORDER BY `id` ASC ");
		
		$out = "<table class='admin fileList'>";
		$out .= "<thead><th>ID</th><th>Név (email)</th><th>&nbsp;</th><th>&nbsp;</th></thead>";
		$out .= "<tbody>";
		foreach ( $userList as $val ) {
			$userData = $database->getSelect("row","*","user_data"," WHERE `id` = '".$val['id']."' ");
			$out .= "<tr><td>#".$val['id']."</td><td>".$userData['name']." (".$val['email'].")</td><td><a href='".RUNNER."?admin=files&id=".$val['id']."'>Megtekintés</a></td><td><a href='".RUNNER."?admin=fileupload&id=".$val['id']."'>Fájl feltöltés</a></td></tr>";
		}
		$out .= "</tbody></table>";
		
		$replace['FILELIST'] = $out;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_files() {
		global $theme, $database;
		$tempmain = $theme->loadModuleTemplate('_admin_filemanager_filemain_template');
		$tempfile = $theme->loadModuleTemplate('_admin_filemanager_file_template');
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) { return 'Hibás felhasználó ID'; }
		$id = $_GET['id'];
		
		$filehtml = '';
		
		$filelist = $database->getSelect("array","*","file"," WHERE `user_id` = '".$id."' ");
		
		if ( empty($filelist) ) { return 'Nincs még feltöltött fájl...'; }
		
		foreach ( $filelist as $val ) {
			
			$dir = CB_UPLOADDIR.'/'.$id;
			
			if ( !file_exists($dir.'/'.$val['date'].$val['file_ext']) ) {
				$database->doQuery("DELETE `".SQLPREF."file` WHERE `id` = '".$val['id']."' ");
			} else {
				$filehtml .= $tempfile;
				
				$replace['FILEID'] = $val['id'];
				$replace['FILENAME'] = $val['file_name'];
				$replace['FILESIZE'] = $val['file_size'];
				$replace['FILETYPE'] = $val['file_type'];
				$replace['FILEDESC'] = $val['comment'];
				$replace['FILEDATE'] = date('Y m d H:i:s', $val['date']);
				$replace['FILEDELETE'] = "<a href='".RUNNER."?admin=filedelete&id=".$val['id']."' onclick=\"javascript:return confirm('Biztos, hogy törölni akarod a fájlt? (nem fogod tudni visszaállítani)')\"><img src='" . CB_THEME ."/". ADMIN_THEMESET ."/images/icon/delete.png' alt='Törlés' title='Törlés' /></a>";
				
				foreach ( $replace as $key => $value ) {
					$filehtml = str_replace( '{#'.strtoupper($key).'}', $value, $filehtml );
				}
			}
		}
		
		$repl['USERNAME'] = $database->getSelect("result","`email`","user"," WHERE `id` = '".$id."' ");
		$repl['FILELIST'] = $filehtml;
		
		$html = $tempmain;
		foreach ( $repl as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_fileupload() {
		global $theme, $user, $database, $handler, $post;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) { return 'Hibás felhasználó ID'; }
		$id = $_GET['id'];
		
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
				$dir = CB_UPLOADDIR.'/'.$id;
				
				if( !file_exists($dir) OR !is_dir($dir) ) {
					mkdir($dir, 0777, true);
				}
				
				copy($tmp_name,$dir.'/'.$date.$file_ext);
				$database->doQuery("INSERT INTO `".SQLPREF."file` (`user_id`,`file_name`,`file_size`,`file_type`,`date`,`file_ext`,`comment`) VALUES ('".$id."','".$file_name."','".$file_size."','".$file_type."','".$date."','".$file_ext."','".$comment."') ");
				
				$handler->messageSuccess[] = 'Sikeres fájlfeltöltés';
			} else {
				$handler->messageError[] = 'Hiba a fájlfeltöltés során!';
			}
		}
		
		$html = $theme->loadModuleTemplate('filemanager_fileupload_template');
		
		return $html;
	}
	
	public function __call_filedelete() {
		global $database, $handler;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) { return 'Hibás fájl ID'; }
		$id = $_GET['id'];
		
		$file = $database->getSelect("row","*","file"," WHERE `id` = '".$id."' ");
		
		$database->doQuery("DELETE FROM `".SQLPREF."file` WHERE `id` = '".$id."' ");
		
		$_SESSION['messageSuccess']['delete'] = 'Sikeres fájltörtlés';

		$dir = CB_UPLOADDIR.'/'.$file['user_id'].'/';
		unlink($dir.$file['date'].$file['file_ext']);
		
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
}

?>