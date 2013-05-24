<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v002
|     Date: 2013. 05. 24.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

define('CB_SQLHOST','localhost');
define('CB_SQLUSER','root');
define('CB_SQLPASS','x');
define('CB_SQLBASE','cb005a');
define('CB_SQLPREF','cb_');

define('CB_SQLTYPE','mysqli');
define('CB_SQLCHARSET','utf8');

define('CB_ADMIN','cb-admin');
define('CB_CORE','cb-core');
define('CB_FILE','cb-file');
define('CB_LANGUAGE','cb-language');
define('CB_MODULE','cb-module');
define('CB_THEME','cb-theme');
define('CB_TEMP','cb-temp');

define('CB_UPLOADDIR',CB_FILE.'/upload');
define('CB_INDEX','index.php');

return; ?>
