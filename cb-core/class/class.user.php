<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 12. 04.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

class user {

	public $userID = 0; //belépett felhasználó ID-ja
	public $userLevel = 0; //belépett felhasználó szintje
	public $userName = ''; //belépett felhasználó neve
		
	public function user() {
		$this->setUserData(); //Felhasználói adatok beállítása
	}	
	
	/* felhasználó beléptetése ha érvényes a felhasználónév és a jelszó */
	public function logIn( $userName, $password ) {
		global $session, $database;
		
		$password = passwordCrypt($password);
		$result = $database->getSelect("row","`id`,`level`","user"," WHERE (`username` = '".$userName."' OR  `email` = '".$userName."') AND `password` = '".$password."' ");
		
		if ( empty($result) ) { return 0; }
		
		$session->sessionSave( $result['id'], $result['level'] );
		
		$this->setUserData(); //Felhasználói adatok beállítása
		
		return 1;
	}
	
	/* felhasználó kiléptetése és session alaphelyzetbe állítása */
	public function logOut() {
		global $session;
		
		$session->sessionSave( 0, 0 );
		
		$this->setUserData(); //Felhasználói adatok beállítása
		
		return 1;
	}
	
	
		/* Felhasználói adatok beállítása, hozzáférési szint lekérdezés */
	private function setUserData() {
		global $database;
		
		$level = $database->getSelect("row","`uid`,`grouplevel`","session"," WHERE `session` = '".$_SESSION['SID']."' ");

		$this->userLevel = ( !empty($level['grouplevel']) ) ? $level['grouplevel'] : 0;
		$this->userID = ( !empty($level['uid']) ) ? $level['uid'] : 0;
		
		$userName = $database->getSelect("result","`username`","user"," WHERE `id` = '".$this->userID."' ");
		
		$this->userName = ( !empty($userName) ) ? $userName : "" ;
		
	//	$this->levelAccess($this->userLevel);
	}
	
	/* Felhasználó készítése átadott paraméterek alapján */
	public function createUser($userName, $password, $email, $level = 1, $state = 0, $regDate = NULL, $regCode = NULL) {
		global $database;
		
		$password = passwordCrypt($password);
		
		$regDate = ( $regDate ) ? $regDate : time();
		$regCode = ( $regCode) ? $regCode : generateCode(50);
		$res = $database->doQuery("INSERT INTO `".SQLPREF."user` ( `username`, `password`, `email`, `level`, `state`, `reg_code`, `reg_date` ) VALUES ('".$userName."','".$password."','".$email."','".$level."','".$state."','".$regCode."','".$regDate."') ");
		
		return $res;
	}
	
	public function checkEmailExist($email) {
		global $database;
		$id = $database->getSelect("result","`id`","user"," WHERE `email` = '".$email."' ");
		
		if ( !empty($id) ) return 1;
		
		return 0;
	}
	
	public function deleteUser() {
		
	}
	
	public function listUser() {
		
	}
	
	public function newPassword($id, $password) {
		global $database;
		
		$password = passwordCrypt($password);
		$database->doQuery("UPDATE `".SQLPREF."user` SET `password` = '".$password."' WHERE `id` = '".$id."' ");
		
		return 1;
	}
	
	public function checkPassword($id, $password) {
		global $database;
		
		$password = passwordCrypt($password);
		$ret = $database->getSelect("result","`id`","user"," WHERE `id` = '".$id."' AND `password` = '".$password."' ");
		
		$ret = ( !empty($ret) ) ? 1 : 0;
		
		return $ret;
	}

}

?>
