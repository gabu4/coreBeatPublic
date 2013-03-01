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
	"".RUNNER."?admin=pagenew"=>"Új oldal létrehozása",
);


$MODULEBODY = "

	<h1 class='title'>Statikus oldal kezelő</h1>
	<hr class='title' />
	<div class='pageContent'>
		
		<table class='adminList'><thead>
			<tr><th>ID</th><th>Oldal név</th><th>Készítési idő</th><th>Módosítási idő</th><th>Aktív</th><th>&nbsp;</th><th>&nbsp;</th></tr>
		</thead><tbody>
			{#PAGELIST}
		</tbody></table>
		

	</div>
";

?>