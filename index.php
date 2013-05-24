<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v003
|     Date: 2012. 11. 27.
+------------------------------------------------------------------------------+
*/

//error_reporting(E_ALL);

define('H-KEI','security');

define( "VERSION","0.5.130524" );

require_once('config.php');

require_once('core.php');

print init();

//print $database->connectCount;
exit;

?>
