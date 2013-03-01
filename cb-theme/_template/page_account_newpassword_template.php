<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 10. 05.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

$MODULEBODY = "

	<h1 class='title'>".ACCOUNT_TEXT_TITLE_NEWPASSWORD."</h1>
	<hr class='title' />
	<div class='pageContent newPassword'>
	<form name='form_passwordSettings' action='' method='POST'>
		<p><span class='rowText'>Jelenlegi jelszó: </span><span class='rowData'><input type='password' name='password' value='' /></span></p>
		<p>&nbsp;</p>
		<p><span class='rowText'>Új jelszó: </span><span class='rowData'><input type='password' name='new_password' value='' /></span></p>
		<p><span class='rowText'>Új jelszó ismétlése: </span><span class='rowData'><input type='password' name='repnew_password' value='' /></span></p>
		<input type='submit' name='userPasswordSettingSaveButton' value='Mentés' />
	</form>
	</div>
";

?>