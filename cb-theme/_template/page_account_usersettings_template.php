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

	<h1 class='title'>".ACCOUNT_TEXT_TITLE_USERSETUP."</h1>
	<hr class='title' />
	<div class='pageContent userSettings'>
	<form name='form_userDataSettings' action='' method='POST'>
		<p><span class='rowText'>*Név: </span><span class='rowData'><input type='text' name='name' value='{#DEFNAME}' /></span></p>
		<p><span class='rowText'>*E-mail: </span><span class='rowData'><input type='text' name='email' value='{#DEFEMAIL}' /></span></p>
		<p><span class='rowText'>*Telefon: </span><span class='rowData'><input type='text' name='telephone' value='{#DEFTEL}' /></span></p>
		<p><span class='rowText'>*Cím: </span><span class='rowData'><textarea name='address'>{#DEFADDR}</textarea></span></p>
		<p><span class='rowText'>*Zavarható: </span><span class='rowData'><textarea name='disturb'>{#DEFDIST}</textarea></span></p>
		<p><span class='rowText'>Megjegyzés: </span><span class='rowData'><textarea name='comment'>{#DEFCOMM}</textarea></span></p>
		<input type='submit' name='userDataSettingSaveButton' value='Mentés' /> (* Kötelező)
	</form>
	</div>
";

?>