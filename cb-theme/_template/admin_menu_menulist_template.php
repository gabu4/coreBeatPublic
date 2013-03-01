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
	"".RUNNER."?admin=menucreate"=>"Új menüpont létrehozása",
);

$MODULEBODY = "

	<h1 class='title'>Menü kezelő</h1>
	<div class='pageContent tabTableList'>
		
		<div id='tabs'><ul>{#TAB_LI}</ul>{#TAB_BODY}</div>
	
	</div>
";

?>