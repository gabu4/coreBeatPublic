<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2013. 07. 02.
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

function removeInputHTML($html) {
	$mit = array ("'<script[^<]*?>.*?</script>'si", // javascript eltüntetése
              "'<[\/\!]*?[^<>]*?>'si",  // HTML elemek eltüntetése
              "'([\r\n])[\s]+'",  // térközök
              "'&(quot|#34);'i",  // HTML entitások
              "'&(amp|#38);'i",
              "'&(lt|#60);'i",
              "'&(gt|#62);'i",
              "'&(nbsp|#160);'i",
              "'&(iexcl|#161);'i",
              "'&(cent|#162);'i",
              "'&(pound|#163);'i",
              "'&(copy|#169);'i",
              "'&#(\d+);'e");  // PHP kódként értelmezze

	$mire = array ("",
				   "",
				   "\\1",
				   "\"",
				   "&",
				   "<",
				   ">",
				   " ",
				   chr(161),
				   chr(162),
				   chr(163),
				   chr(169),
				   "chr(\\1)");

	return preg_replace($mit, $mire, $html);
}

?>
