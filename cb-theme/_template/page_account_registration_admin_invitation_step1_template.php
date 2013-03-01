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

	<h1 class='title'>".ACCOUNT_TEXT_TITLE_REGISTRATION_STEP1."</h1>
	<hr class='title' />
	<div class='pageContent registration step1'>
	<form name='form_passwordSettings' action='' method='GET'>
		<p>Az oldalon a regisztráció engedélyhez kötött, kérem adja meg a kapott regiszrációs kódot!</p>
		<p>Amennyiben szeretne regisztrálni, de nem rendelkezik kóddal, akkor kérem vegye fel az oldal tulajdonosával a kapcsolatot a kapcsolat oldalon.</p>
		<input type='hidden' name='c' value='registration' />
		<p><span class='rowText'>Regisztrációhoz kapott kód: </span><span class='rowData'><input type='text' name='code' value='' /></span></p>
		<input type='submit' name='sendCode' value='Ellenőrzés' />
	</form>
	</div>
";

?>