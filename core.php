<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v005
|     Date: 2013. 01. 27.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

define('BASEDIR',$_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);

/* Core functions */

function __autoload($class) {
	require( CB_CORE . "/class/class." . $class . ".php" );
}

/* Main Including block */

require_once( CB_CORE .'/function.php');

require_once( CB_CORE .'/database/'.SQLTYPE.'.php');
$database = new database;

$database->connect();
$database->start();

require_once( CB_CORE .'/init.settings.php');

require_once( CB_LANGUAGE .'/'.LANGTYPE.'.php');

$handler = new handler;
$session = new session;
$user = new user;
$theme = new theme;
$module = new module;


/* Including block */
include_once( CB_CORE .'/init.mail.php');

require_once(CB_CORE.'/init.start.php');

return; ?>
