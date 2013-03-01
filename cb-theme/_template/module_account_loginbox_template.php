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

$MODULEBODY = "
<div class='accountbox loginbox'>
	<form name='form_loginfields' action='' method='POST'>
		<h3>Belépés</h3>
		<p><input type='text' id='username' name='username' placeholder='".ACCOUNT_TEXT_USERNAME."' /></p>	
		<p><input type='password' id='password' name='password' placeholder='".ACCOUNT_TEXT_PASSWORD."' /></p>
		<p><input type='submit' name='loginbutton' value='Belépés' /></p>
		<p>{#REGISTRATION_LINK}{#FORGOT_PASSWORD_LINK}{#REGISTRATION_MAIL_RESEND_LINK}</p>
	</form>
</div>
";

?>