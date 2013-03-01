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

$SUBMENU = array(
	"".RUNNER."?a=accountinvite"=>"Új felhasználó meghívása",
);

$MODULEBODY = "

	<h1 class='title'>".ADMIN_TEXT_ACCOUNT_MAIN_TITLE."</h1>
	<hr class='title' />
	<div class='pageContent'>

		{#USERLIST}
	
	</div>
";

?>