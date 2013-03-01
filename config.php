<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2012. 11. 27.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

define('SQLHOST','localhost');
define('SQLUSER','root');
define('SQLPASS','x');
define('SQLBASE','cb005a');
define('SQLPREF','cb_');

define('SQLTYPE','mysqli');
define('SQLCHARSET','utf8');

define('CB_ADMIN','cb-admin');
define('CB_CORE','cb-core');
define('CB_FILE','cb-file');
define('CB_LANGUAGE','cb-language');
define('CB_MODULE','cb-module');
define('CB_THEME','cb-theme');
define('CB_TEMP','cb-temp');

define('CB_UPLOADDIR',CB_FILE.'/upload');
define('INDEX','index.php');

return; ?>
