<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2012. 10. 16.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

$settings = $database->getSelect("array","*","settings"," ");

foreach ( $settings as $val ) {
	define(strtoupper($val['key']),$val['value']);
}

unset($settings);

?>
