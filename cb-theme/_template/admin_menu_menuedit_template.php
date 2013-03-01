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

	<h1 class='title'>Menüpont létrehozás/szerkeszés</h1>
	<div class='pageContent menuEdit'>
		<span style='display:none;' class='defTab'>{#DEFTAB}</span>
		<div id='tabs'>
			<ul>
				<li><a href='#tabs-page'>Statikus oldal</a></li>
				<li><a href='#tabs-post'>Bejegyzés oldal</a></li>
				<li><a href='#tabs-cat'>Bejegyzés kategória</a></li>
				<li><a href='#tabs-module'>Modul tartalom</a></li>
				<li><a href='#tabs-html'>Külső link</a></li>
			</ul>
			<div id='tabs-page'>
				{#MENU_TYPE_PAGE}
			</div>
			<div id='tabs-post'>
				{#MENU_TYPE_POST}
			</div>
			<div id='tabs-cat'>
				{#MENU_TYPE_CAT}
			</div>
			<div id='tabs-module'>
				{#MENU_TYPE_MODULE}
			</div>
			<div id='tabs-html'>
				{#MENU_TYPE_HTML}
			</div>
			
		</div>
	
	</div>
";

?>