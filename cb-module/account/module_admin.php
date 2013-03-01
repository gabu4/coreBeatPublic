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

class account_admin {
	
	var $admin = 0;
	var $call = Array( "accountmain", "accountinvite", "accountcreate", "accountedit", "accountdetails" );
	
	function account_admin() {
		global $user, $theme, $handler;
		
		$handler->callAdmin['account_admin'] = $this->call;
		
		$theme->tempREPLACE['ADMIN_ACCOUNT'] = "";
	}
	
	public function __call_accountmain() {
		global $theme, $database;
		
		$html = $theme->loadModuleTemplate('_admin_account_main_template');
		
		$userList = $database->getSelect("array","*","user"," ORDER BY `id` ASC ");
		
		$out = "<table class='admin pageList'>";
		$out .= "<thead><th>ID</th><th>Név (email)</th><th>&nbsp;</th><th>&nbsp;</th></thead>";
		$out .= "<tbody>";
		foreach ( $userList as $val ) {
			$userData = $database->getSelect("row","*","user_data"," WHERE `id` = '".$val['id']."' ");
			$out .= "<tr><td>#".$val['id']."</td><td>".$userData['name']." (".$val['email'].")</td><td><a href='?admin=accountdetails&id=".$val['id']."'>Megtekintés</a></td><td><a href='?admin=accountedit&id=".$val['id']."'>Szerkesztés</a></td></tr>";
		}
		$out .= "</tbody></table>";
		
		$replace['USERLIST'] = $out;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	public function __call_accountinvite() {
		global $theme, $database, $mail, $user, $handler, $post;
				
		$html = $theme->loadModuleTemplate('_admin_account_invite_template');

		if ( isset($post['adminAccountInviteButton']) ) {
			$regCode = generateCode(50);
			
			$error = $this->test_call_acountinvite();
			
			if ( empty($error) ) {
			
				$user->createUser(NULL,NULL,$post['email'],1,0,NULL,$regCode);
				
				$mail->AddAddress($post['email']);
				$mail->Subject = "Meghívás";
				$regLink = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?c=registration&code=".$regCode;
				$mail->Body = "Meghívást kapott<br />
				Regisztrálhat az alábbi linkre kattintva: <br />
				<a href='".$regLink."'>".$regLink."</a><br /><br />
				".nl2br($post['message']);
				$mail->AltBody = "Meghívást kapott/n
				Regisztrálhat az alábbi linket követve: /n
				".$regLink."/n/n
				".$post['message'];
				
				if(!$mail->Send()) {
					$handler->messageError[] = 'Hiba, e-mail nincs elküldve! ('.$mail->ErrorInfo.')';
			//		echo 'Mailer error: ' . $mail->ErrorInfo;
				} else {
					$handler->messageSuccess[] = 'E-mail elküldve';
				}
				
			} else {
				$handler->messageError = $error;
			}
			
			
		}
		
		return $html;
	}
	
	private function test_call_acountinvite() {
		global $post;
		
		$RET = "";
		
		if ( !isset($post['email']) OR empty($post['email']) OR ( check_email_address($post['email']) === false ) ) {
			$RET['email'] = "Üres vagy érvénytelen e-mail cím!";
			return $RET;
		}
		
		return $RET;
	}
	
	public function __call_accountcreate() {
		global $post, $user, $database;
		
		
		
		
	}
	
	public function __call_accountedit() {
		global $theme, $user, $database, $handler, $post;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) {
			
			$link = "?admin=accountmain";
			header("Location: ".$link);
			
		}
		
		$id = $_GET['id'];
		
		if ( isset($post['userDataSettingSaveButton']) ) {
			
			$error = $this->test_call_accountedit();
			
			if ( !$error ) {
			
				$database->doQuery("UPDATE `".SQLPREF."user_data` SET `name` = '".$post['name']."', `telephone` = '".$post['telephone']."', `address` = '".$post['address']."', `disturb` = '".$post['disturb']."', `comment` = '".$post['comment']."' WHERE `id` = '".$id."' ");
			
				$database->doQuery("UPDATE `".SQLPREF."user` SET `email` = '".$post['email']."' WHERE `id` = '".$id."' ");
				
			} else {
				$handler->messageError = $error;
			}
		}
		
		$html = $theme->loadModuleTemplate('_admin_account_edit_template');
		
		$userData = $database->getSelect("row","*","user"," WHERE `id` = '".$id."' ");
		$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$id."' ");
		
		if ( empty($userData2) ) {
			$database->doQuery("INSERT INTO `".SQLPREF."user_data` (`id`) VALUES ('".$id."') ");
			$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$id."' ");
		}
		if ( isset($post['userDataSettingSaveButton']) ) {
			foreach ( $userData2 as $key => $val) {
				$userData2[$key] = ( isset($post[$key]) ) ? $post[$key] : $userData2[$key] ;
			}
			$userData['email'] = ( isset($post['email']) ) ? $post['email'] : $userData['email'] ;
		}
		$replace['DEFNAME'] = $userData2['name'];
		$replace['DEFEMAIL'] = $userData['email'];
		$replace['DEFTEL'] = $userData2['telephone'];
		$replace['DEFADDR'] = $userData2['address'];
		$replace['DEFDIST'] = $userData2['disturb'];
		$replace['DEFCOMM'] = $userData2['comment'];
		$replace['DEFID'] = $id;
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	private function test_call_accountedit() {
		global $handler, $database, $user, $post;
		$RET = Array();
		
		if ( !isset($post['name']) OR empty($post['name']) ) {
			$RET['name'] = "A név nem lehet üres!";
		}
		
		if ( !isset($post['email']) OR empty($post['email']) OR ( check_email_address($post['email']) === false ) ) {
			$RET['email'] = "Üres vagy érvénytelen e-mail cím!";
		}
		
		$emailCheck = $database->getSelect("result","`id`","user"," WHERE `id` != '".$post['id']."' AND `email` = '".$post['email']."' ");
		if ( !empty($emailCheck) ) {
			$RET['email'] = "Az email cím már használatban van!";
		}
		
		if ( !isset($post['telephone']) OR empty($post['telephone']) ) {
			$RET['telephone'] = "Telefonszám megadás kötelező!";
		}
		
		if ( !isset($post['address']) OR empty($post['address']) ) {
			$RET['address'] = "Cím megadás kötelező!";
		}
		
		if ( !isset($post['disturb']) OR empty($post['disturb']) ) {
			$RET['disturb'] = "Hívhatóság megadása közelező!";
		}
			
		return $RET;
	}
	
	public function __call_accountdetails() {
		global $theme, $user, $database, $handler, $post;
		
		if ( !isset($_GET['id']) OR empty($_GET['id']) ) {
			
			$link = "?admin=accountmain";
			header("Location: ".$link);
			
		}
		
		$id = $_GET['id'];
		
		$html = $theme->loadModuleTemplate('_admin_account_details_template');
		
		$userData = $database->getSelect("row","*","user"," WHERE `id` = '".$id."' ");
		$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$id."' ");
		
		if ( empty($userData2) ) {
			$database->doQuery("INSERT INTO `".SQLPREF."user_data` (`id`) VALUES ('".$id."') ");
			$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$id."' ");
		}
		
		
		$replace['DEFNAME'] = $userData2['name'];
		$replace['DEFEMAIL'] = $userData['email'];
		$replace['DEFTEL'] = $userData2['telephone'];
		$replace['DEFADDR'] = $userData2['address'];
		$replace['DEFDIST'] = $userData2['disturb'];
		$replace['DEFCOMM'] = $userData2['comment'];
		$replace['DEFID'] = $id;
		
		$replace['FILE_LIST'] = "<a href='?admin=files&id=".$id."'>Felhasználói fájlok</a>";
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	
}

?>