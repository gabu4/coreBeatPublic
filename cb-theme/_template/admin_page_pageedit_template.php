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

	<h1 class='title'>Oldal létrehozás/szerkeszés</h1>
	<hr class='title' />
	<div class='pageContent'>
	
		<form name='form_pageedit' action='' method='POST'>
			<p><span class='inpText'>".ADMIN_TEXT_PAGEEDIT_PAGE_TITLE."</span><input type='text' name='name' value='{#NAME}' /></p>	
			<p><span class='inpText'>".ADMIN_TEXT_PAGEEDIT_PAGE_CONTENT."</span><textarea id='editorarea' class='contentEdit' name='text' />{#TEXT}</textarea></p>
			<p><span class='inpText'>Kereső kulcsok:</span><input type='text' class='metaKey' name='meta_key' value='{#META_KEY}' /></p>
			<p><span class='inpText'>Kereső leírás</span><textarea class='metaDesc' name='meta_desc' />{#META_DESC}</textarea></p>
			<p><span class='inpText'>Állapot</span><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} /><label for='state0'>Inaktív</label> <input type='radio' id='state1' name='state' value='1' {#IFSTATE1} /><label for='state1'>Aktív</label> </p>
			<p><input type='submit' class='save' name='adminPageEditSave' value='Mentés' /></p>
		</form>
	
	</div>
";

?>