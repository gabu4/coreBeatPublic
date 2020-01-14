<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 03/10/13
 */
if ( !defined('H-KEI') ) { exit; }

$TEMPLATE['loginbox'] = "
<div class='accountbox loginbox'>
	<form name='form_loginfields' action='' method='POST'>
		<h3>Belépés</h3>
		<p><input type='text' id='username' name='username' placeholder='[LANG_ACCOUNT_USERNAME]' /></p>	
		<p><input type='password' id='password' name='password' placeholder='[ACCOUNT_TEXT_PASSWORD]' /></p>
		<p><input type='submit' name='loginbutton' value='Belépés' /></p>
	</form>
</div>
";

$TEMPLATE['logoutbox'] = "
<div class='accountbox logoutbox'>
	<p class='userName'>Belépve: <b>{#MODULE,ACCOUNT,STATIC,USERNAME}</b></p>
	<form name='form_logoutfields' action='' method='POST'>
		{#MODULE,ACCOUNT,STATIC,ADMINMENU}
		<p><input type='submit' name='logoutbutton' value='Kilépés' /></p>
	</form>
</div>
";

return; ?>