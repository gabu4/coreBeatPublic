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

	<h1 class='title'>".ADMIN_TEXT_ACCOUNT_INVITE_TITLE."</h1>
	<hr class='title' />
	<div class='pageContent'>
	
		<form name='form_accountinvite' action='' method='POST'>
			<p>Felhasználó meghívása e-mail cím alapján</p>
			<p><span class='inpText'>E-mail cím</span><input type='text' name='email' value='' /></p>	
			<p><span class='inpText'>Üzenet</span><textarea name='message' /></textarea></p>
			<p><input type='submit' name='adminAccountInviteButton' value='Meghívó elküldése' /></p>
		</form>
	
	</div>
";

?>