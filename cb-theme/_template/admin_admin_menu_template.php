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

	<h1 class='title'>".ADMIN_TEXT_MENU_TITLE."</h1>
	<hr class='title' />
	<div class='pageContent'>
	
	<ul class='admin mainMenu'>
	
	<li><a href='".RUNNER."?admin=accountmain'>Felhasználó kezelő</a></li>
	
	<li><a href='".RUNNER."?admin=filemain'>Fájl kezelő</a></li>
	
	<li><a href='".RUNNER."?admin=menulist'>Menü kezelő</a></li>
	
	<li><a href='".RUNNER."?admin=pagelist'>Statikus oldal kezelő</a></li>
	
	<li><a href='".RUNNER."?admin=postlist'>Bejegyzés kezelő</a></li>
	
	<li><a href='".RUNNER."?admin=usermessage'>Üzenetek</a></li>
	
	<li><a href='".RUNNER."?admin=statistic'>Statisztika</a></li>
	
	</ul>

	
	</div>
";

?>