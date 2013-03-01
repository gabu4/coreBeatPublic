<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 06. 12.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

function generateCode($length = '8') {
    $chars = "abcdefghijkmnpqrstuvwxyz23456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i < $length) {
        $num = rand() % 31;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

function passwordCrypt($a) {
	$a = hash('sha512',$a);
	return $a;
}

function check_email_address($email) {
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return false;
	}
	return true;
}

?>
