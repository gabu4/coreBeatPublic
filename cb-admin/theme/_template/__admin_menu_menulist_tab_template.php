<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v000
 * @date 05/10/12
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

return; ?>