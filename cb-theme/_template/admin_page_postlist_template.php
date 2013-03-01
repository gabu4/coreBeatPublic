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
	"".RUNNER."?admin=postnew"=>"Új bejegyzés",
);

$MODULEBODY = "

	<h1 class='title'>Bejegyzés kezelő</h1>
	<hr class='title' />
	<div class='pageContent'>
		
		<table class='adminList'><thead>
			<tr><th>ID</th><th>Bejegyzés név</th><th>Kategória</th><th>Készítési idő</th><th>Módosítási idő</th><th>Aktív</th><th>&nbsp;</th><th>&nbsp;</th></tr>
		</thead><tbody>
			{#PAGELIST}
		</tbody></table>

	</div>
";

?>