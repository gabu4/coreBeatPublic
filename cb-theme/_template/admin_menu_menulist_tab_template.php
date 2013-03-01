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

	
	<div id='tab-{#GROUP}'>
		<table class='adminList'><thead>
			<tr><th>ID</th><th>Menüpont neve</th><th>Seo név</th><th>Aktív</th><th>Sorrend</th><th>&nbsp;</th><th>&nbsp;</th></tr>
		</thead><tbody>
			{#MENULIST}
		</tbody></table>
	</div>
";

?>