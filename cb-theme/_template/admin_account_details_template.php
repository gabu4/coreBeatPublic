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

	<h1 class='title'>Felhasználói adatok: {#DEFNAME}</h1>
	<hr class='title' />
	<div class='pageContent'>
	
		<input type='hidden' name='id' value='{#DEFID}' />
		<p><span class='rowText'>Név: </span><span class='rowData'>{#DEFNAME}</span></p>
		<p><span class='rowText'>E-mail: </span><span class='rowData'>{#DEFEMAIL}</span></p>
		<p><span class='rowText'>Telefon: </span><span class='rowData'>{#DEFTEL}</span></p>
		<p><span class='rowText'>Cím: </span><span class='rowData'>{#DEFADDR}</span></p>
		<p><span class='rowText'>Zavarható: </span><span class='rowData'>{#DEFDIST}</span></p>
		<p><span class='rowText'>Megjegyzés: </span><span class='rowData'>{#DEFCOMM}</span></p>
		
		<span class='rowText'>Feltöltött fájlok: </span><span class='rowData'>{#FILE_LIST}</span>
		
	
	</div>
";

?>