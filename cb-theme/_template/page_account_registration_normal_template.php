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

	<h1 class='title'>".ACCOUNT_TEXT_TITLE_REGISTRATION_STEP2."</h1>
	<hr class='title' />
	<div class='pageContent registration step2'>
	<form name='form_userDataSettings' action='' method='POST'>
		<p><span class='rowText'>*Név: </span><span class='rowData'><input type='text' name='name' value='{#DEFNAME}' /></span></p>
		<p><span class='rowText'>*Felhasználónév: </span><span class='rowData'><input type='text' name='username' value='{#DEFUNAME}' /></span></p>
		<p><span class='rowText'>*E-mail: </span><span class='rowData'><input type='text' name='email' value='{#DEFEMAIL}' /></span></p>
		
		<p><span class='rowText'>*Jelszó: </span><span class='rowData'><input type='password' name='password' value='' /></span></p>
		<p><span class='rowText'>*Jelszó ismétlése: </span><span class='rowData'><input type='password' name='rep_password' value='' /></span></p>
		
		<p>&nbsp;</p>
		<p><span class='rowText'>Telefon: </span><span class='rowData'><input type='text' name='telephone' value='{#DEFTEL}' /></span></p>
		<input type='submit' name='userRegistrationSaveButton' value='Regisztráció' /> (* Kötelező)
	</form>
	</div>
";

?>