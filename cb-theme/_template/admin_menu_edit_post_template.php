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
<div class='inlineBlock'>
	<form action='' method='POST'>
		<input type='hidden' name='type' value='POST' />
		<p><span class='inpText'>Menüpont neve</span><input type='text' name='name' value='{#NAME}' /><span class='comm'></span></p>
		<p><span class='inpText'>Seo név</span><input type='text' class='seo_name' name='seo_name' value='{#SEO_NAME}' /><span class='comm'></span></p>
		<p><span class='inpText'>Csoport</span>{#GROUPSELECT}<span class='comm'></span></p>
		<p><span class='inpText'>Menü szülő</span>{#PARENTSELECT}<span class='comm'></span></p>
		<p><span class='inpText'>Tartalom</span>{#POST_VALUE}<span class='comm'></span></p>
		<p><span class='inpText'>Sorrend</span><input type='text' name='order' value='{#ORDER}' /><span class='comm'></span></p>
		<p><span class='inpText'>Menüpont leírás</span><textarea class='menuText' name='text' />{#TEXT}</textarea><span class='comm'></span></p>
		<p><span class='inpText'>Állapot</span><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} /><label for='state0'>Inaktív</label> <input type='radio' id='state1' name='state' value='1' {#IFSTATE1} /><label for='state1'>Aktív</label><span class='comm'></span></p>
		<p><input type='submit' name='adminMenuEditSave' value='Mentés' /></p>
	</form>
</div>
";

?>