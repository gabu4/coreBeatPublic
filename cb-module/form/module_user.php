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

class module_form {
	
	var $call = Array( "form" );
	
	function module_form() {
		
		global $theme, $handler;
		$handler->call['form'] = $this->call;
		
		$theme->tempREPLACE['FORM'] = $this->__call_form('form_inside_template');
	}

	public function __call_form($template = 'form_main_template' ) {
		global $theme, $user, $database, $handler, $post, $mail;
		
		if ( $user->userID == '0' ) {
			$def['name'] = '';
			$def['email'] = '';
			$def['telephone'] = '';
		} else {
			$def = $database->getRow("SELECT `name`, `email`, `telephone` FROM `".SQLPREF."user` `u`, `".SQLPREF."user_data` `d`  WHERE `u`.`id` = `d`.`id` AND `u`.`id` = '".$user->userID."' ");
		}
		
		if ( isset($post['sendConnectForm']) ) {
			$error = $this->test_call_form();
			if ( empty($error) ) {
				
				$mail->AddAddress(MAIL_FROM);
				$mail->AddAddress($post['email']);
				$mail->SetFrom($post['email'],$post['name']);
				$mail->Subject = "Üzenet a weboldalról";
				$mail->Body = nl2br($post['message'])."<br />Telefonszám: ".$post['telephone'];
				$mail->AltBody = $post['message']."\nTelefonszám: ".$post['telephone'];
				
				if(!$mail->Send()) {
					$handler->messageError[] = 'Hiba, e-mail nincs elküldve! ('.$mail->ErrorInfo.')';
			//		echo 'Mailer error: ' . $mail->ErrorInfo;
				} else {
					$handler->messageSuccess[] = 'Üzenet elküldve!';
				}
			} else {
				$handler->messageError = $error;
			}
		}
		
		$html = $theme->loadModuleTemplate($template);
		
		$replace['DEFNAME'] = $def['name'];
		$replace['DEFEMAIL'] = $def['email'];
		$replace['DEFTELEPHONE'] = $def['telephone'];
				
		foreach ( $replace as $key => $value ) {
			$html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
		}
		
		return $html;
	}
	
	private function test_call_form() {
		global $database, $post;
		
		$RET = Array();
		
		if ( !isset($post['name']) OR empty($post['name']) ) {
			$RET['name'] = "A név nem lehet üres!";
			return $RET;
		}
		
		if ( !isset($post['email']) OR empty($post['email']) OR ( check_email_address($post['email']) === false ) ) {
			$RET['email'] = "Üres vagy érvénytelen e-mail cím!";
			return $RET;
		}
		
		if ( !isset($post['message']) OR empty($post['message']) ) {
			$RET['message'] = "Üzenet írása kötelező!";
			return $RET;
		}
		
		return $RET;
	}
	
}

?>
