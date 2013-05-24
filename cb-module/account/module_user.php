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

include_once('language/'.CB_LANGTYPE.'.php');

class module_account {
	
	function module_account() {
		global $theme, $module;
		
		$this->adminMenu();
	}
	
	public function __call_account_box() {
		global $user, $handler, $post, $admin_admin;
		$html = "";
		
		if ( isset($post['loginbutton']) ) { 
			$login = $this->getLoginPost();
			if ( $login == 1 ) { 
				$handler->messageSuccess[] = ACCOUNT_LOGIN_SUCCESS;
				$this->adminMenu();
			}
		}
		if ( isset($post['logoutbutton']) ) {
			$this->getLogoutPost();
			$handler->messageSuccess[] = ACCOUNT_LOGOUT_SUCCESS;
			$this->adminMenu();
		}

		if ( $user->userID == '0' ) {
			$html .= $this->loginBox();
		} else {
			$html .= $this->logoutBox();
		}
		
		return $html;
	}
	
	private function loginBox() {
		
		global $theme;
		
		$html = $theme->loadModuleTemplate('module_account_loginbox_template');
		
		$theme->tempStaticREPLACE['ACCOUNT']['REGISTRATION_LINK'] = '';
		$theme->tempStaticREPLACE['ACCOUNT']['FORGOT_PASSWORD_LINK'] = '';
		$theme->tempStaticREPLACE['ACCOUNT']['REGISTRATION_MAIL_RESEND_LINK'] = '';
		
		$reglink = ' <a class="loginElement registration" href="?c=registration">Regisztráció</a> ';
		$froglink = ' <a class="loginElement frogott_password" href="?c=frogott_password">Elfelejtett jelszó</a> ';
		$resendlink = ' <a class="loginElement regmailresend" href="?c=regmailresend">Regisztrációs e-mail újraküldés</a> ';
		
		if ( CB_REGMODE == 'normal' ) {
			$theme->tempStaticREPLACE['ACCOUNT']['REGISTRATION_LINK'] = $reglink;
			$theme->tempStaticREPLACE['ACCOUNT']['FORGOT_PASSWORD_LINK'] = $froglink;
		} elseif ( CB_REGMODE == 'admin_invitation' ) {
			$theme->tempStaticREPLACE['ACCOUNT']['REGISTRATION_LINK'] = $reglink;
			$theme->tempStaticREPLACE['ACCOUNT']['FORGOT_PASSWORD_LINK'] = $froglink;
		}
		
		return $html;
	}
	
	private function logoutBox() {
	
		global $theme, $user;
		
		$html = $theme->loadModuleTemplate('module_account_logoutbox_template');
		
		$theme->tempStaticREPLACE['ACCOUNT']['USERNAME'] = $user->username;
		
		$html = str_replace($replaceFrom, $replaceTo, $html);
		
		return $html;
		
	}
	
	private function getLoginPost() {
		
		global $user, $post, $handler;
		
		$checkError = $this->postErrorCheck();
		
		if ( !empty($checkError) ) { return 0; }
		
		$login = $user->logIn( $post['username'], $post['password']);
		
		if ( $login != 1 ) {
			$handler->messageError[] = ACCOUNT_VALID_ERROR;
			return 0;
		}
		
		return 1;
	}
	
	private function getLogoutPost() {
		global $user;
		
		$user->logOut();
	}
	
	private function postErrorCheck() {
		global $handler, $post;
		$error = Array();
	
		if ( empty($post['username']) ) {
			$error['username'] = 1;
			$handler->messageError['username'] = ACCOUNT_USERNAME_ERROR;
			return $error;
		}
		if ( empty($post['password']) ) {
			$error['password'] = 1;
			$handler->messageError['password'] = ACCOUNT_USERPASSW_ERROR;
			return $error;
		}
		
		return $error;
	}
	
	public function __call_settings() {
		global $theme, $user, $database, $handler, $post;
		
		if ( $user->userID == '0' ) { return 0; }
		
		if ( isset($post['userDataSettingSaveButton']) ) {
			
			$error = $this->test_call_settings();
			
			if ( !$error ) {
			
				$database->doQuery("UPDATE `".CB_SQLPREF."user_data` SET `name` = '".$post['name']."', `telephone` = '".$post['telephone']."', `address` = '".$post['address']."', `disturb` = '".$post['disturb']."', `comment` = '".$post['comment']."' WHERE `id` = '".$user->userID."' ");
			
				$database->doQuery("UPDATE `".CB_SQLPREF."user` SET `email` = '".$post['email']."' WHERE `id` = '".$user->userID."' ");
				
			} else {
				$handler->messageError = $error;
			}
		}
		
		$html = $theme->loadModuleTemplate('account_usersettings_template');
		
		$userData = $database->getSelect("row","*","user"," WHERE `id` = '".$user->userID."' ");
		$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$user->userID."' ");
		
		if ( empty($userData2) ) {
			$database->doQuery("INSERT INTO `".CB_SQLPREF."user_data` (`id`) VALUES ('".$user->userID."') ");
			$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$user->userID."' ");
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
		
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	private function test_call_settings() {
		global $handler, $database, $user, $post;
		$RET = Array();
		
		if ( !isset($post['name']) OR empty($post['name']) ) {
			$RET['name'] = "A név nem lehet üres!";
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
			
		return $RET;
	}
	
	public function __call_password_change() {
		global $theme, $user, $database, $handler;
		
		if ( $user->userID == '0' ) { return 0; }
		
		if ( isset($_POST['userPasswordSettingSaveButton']) ) {
			
			$error = $this->test_call_password_change();
			
			if ( !$error ) {
				
				$user->newPassword($user->userID, $_POST['new_password'] );
				
				$handler->messageSuccess[] = 'Sikeres jelszó módosítás!';
				
			} else {
				$handler->messageError = $error;
			}
		}
		
		$html = $theme->loadModuleTemplate('account_newpassword_template');
		
		return $html;
	}

	private function test_call_password_change() {
		global $user, $post;
		$RET = Array();
		
		if ( !isset($post['password']) OR empty($post['password']) OR ( $user->checkPassword($user->userID, $post['password']) != 1 ) ) {
			$RET['password'] = "Hibás régi jelszó!";
			return $RET;
		}
		
		if ( !isset($post['new_password']) OR empty($post['new_password']) ) {
			$RET['new_password'] = "Az új jelszó nem lehet üres!";
			return $RET;
		}
		
		if ( !isset($post['repnew_password']) OR empty($post['repnew_password']) ) {
			$RET['repnew_password'] = "Az új jelszó ismételt megadása kötelező!";
			return $RET;
		}
		
		if ( $post['new_password'] != $post['repnew_password'] ) {
			$RET['notSame'] = "A két jelszó nem egyezik!";
			return $RET;
		}
		
		if ( $post['password'] == $post['new_password'] ) {
			$RET['notTheSame'] = "A régi és új jelszó nem lehet ugyan az!";
			return $RET;
		}
			
		return $RET;
	}
	
	public function __call_registration() {
		
		if ( REGMODE == 'normal' ) { //normál regisztráció
			return $this->regmode_normal();
		} elseif ( REGMODE == 'admin_invitation' ) {  //admin általi meghívás
			return $this->regmode_admin_invitation();
		}
		
	}
	
	private function regmode_normal() {
		global $theme, $user, $database, $handler, $post;
		
		if ( $user->userID != '0' ) { return 0; }
		
		$html = $theme->loadModuleTemplate('account_registration_admin_invitation_step2_template');
		
		if ( isset($post['userRegistrationSaveButton']) ) {
		
			$error = $this->test_regmode_normal();
				
				if ( !$error ) {
					
				$database->doQuery("UPDATE `".CB_SQLPREF."user_data` SET `name` = '".$post['name']."', `telephone` = '".$post['telephone']."' WHERE `id` = '".$id."' ");
			
				$database->doQuery("UPDATE `".CB_SQLPREF."user` SET `email` = '".$post['email']."', `username` = '".$post['username']."', `state` = '1', `reg_code` = '' WHERE `id` = '".$id."' ");
					
				$user->newPassword($id, $post['password'] );
					
			} else {
				$handler->messageError = $error;
			}				
			
		}
			
		$replace['DEFNAME'] = '';
		$replace['DEFUNAME'] = '';
		$replace['DEFEMAIL'] = '';
		$replace['DEFTEL'] = '';
			
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
			
		return $html;
		
	}
	
	private function regmode_admin_invitation() {
		global $theme, $user, $database, $handler, $post;
		
		if ( $user->userID != '0' ) { return 0; }
		
		if ( !isset($_GET['code']) OR empty($_GET['code']) ) {
			$html = $theme->loadModuleTemplate('account_registration_admin_invitation_step1_template');
			
			return $html;
		} else {
			
			$userData = $database->getSelect("row","*","user"," WHERE `reg_code` = '".$_GET['code']."' AND `state` = '0' ");
			
			$id = $userData['id'];
			
			if ( empty($userData) ) {
				return "Hibás ellenörzőkód!<br /><a href='".CB_INDEX."?c=registration'><-- Vissza</a>";
			}
		
			$html = $theme->loadModuleTemplate('account_registration_admin_invitation_step2_template');
			
			$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$userData['id']."' ");
			
			if ( empty($userData2) ) {
				$database->doQuery("INSERT INTO `".CB_SQLPREF."user_data` (`id`) VALUES ('".$userData['id']."') ");
				$userData2 = $database->getSelect("row","*","user_data"," WHERE `id` = '".$userData['id']."' ");
			}
			
			if ( isset($post['userRegistrationSaveButton']) ) {
			
				$error = $this->test_regmode_normal();
				
				if ( !$error ) {
					
					$database->doQuery("UPDATE `".CB_SQLPREF."user_data` SET `name` = '".$post['name']."', `telephone` = '".$post['telephone']."' WHERE `id` = '".$id."' ");
			
					$database->doQuery("UPDATE `".CB_SQLPREF."user` SET `email` = '".$post['email']."', `username` = '".$post['username']."', `state` = '1', `reg_code` = '' WHERE `id` = '".$id."' ");
					
					$user->newPassword($id, $post['password'] );
					
				} else {
					$handler->messageError = $error;
				}
				
				foreach ( $userData2 as $key => $val) {
					$userData2[$key] = ( isset($post[$key]) ) ? $post[$key] : $userData2[$key] ;
				}
				$userData['email'] = ( isset($post['email']) ) ? $post['email'] : $userData['email'] ;
				$userData['username'] = ( isset($post['username']) ) ? $post['username'] : $userData['username'] ;
			}
			
			$replace['DEFNAME'] = $userData2['name'];
			$replace['DEFUNAME'] = $userData['username'];
			$replace['DEFEMAIL'] = $userData['email'];
			$replace['DEFTEL'] = $userData2['telephone'];
			
			foreach ( $replace as $key => $value ) {
				$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
			}
			
			return $html;
			
			
		}
		
	}
	
	private function test_regmode_normal() {
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
	
	public function adminMenu() {
		global $module, $user, $theme;
		
	//	if ( $module->moduleAdminAcc['admin'] == 1 ) {
		if ( $user->userLevel == 255 ) {
			$html = "<ul><li><a href='".CB_INDEX."?admin=admin_menu' target='admin_page'>Admin</a></li></ul>";
			
			$theme->tempStaticREPLACE['ADMINMENU'] = $html;
		} else {
		
			$theme->tempStaticREPLACE['ADMINMENU'] = "";
			
		}
	}

}

return; ?>
