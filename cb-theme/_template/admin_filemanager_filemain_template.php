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

	<h1 class='title'>Fájlok listája: {#USERNAME}</h1>
	<hr class='title' />
	<div class='pageContent'>
		
		<table class='adminList'><thead>
			<tr><th>ID</th><th>Fájlnév</th><th>Kiterjesztés</th><th>Méret</th><th>Leírás</th><th>Feltötési dátum</th><th>&nbsp;</th></tr>
		</thead><tbody>
			{#FILELIST}
		</tbody></table>
		
	</div>
";

?>