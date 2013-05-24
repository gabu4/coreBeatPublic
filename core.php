<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v006
|     Date: 2013. 05. 22.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

define('CB_BASEDIR',$_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);

/* Core functions */

/* Main Including block */
require_once( CB_CORE .'/function.php');

require_once( CB_CORE .'/database/'.CB_SQLTYPE.'.php');
$database = new database;

$database->connect();
$database->start();

require_once( CB_CORE .'/init.settings.php');

require_once( CB_CORE .'/init.seo.php');

require_once( CB_LANGUAGE .'/'.CB_LANGTYPE.'.php');

require_once( CB_CORE . "/class/class.handler.php" );
$handler = new handler;
require_once( CB_CORE . "/class/class.session.php" );
$session = new session;
require_once( CB_CORE . "/class/class.user.php" );
$user = new user;
require_once( CB_CORE . "/class/class.theme.php" );
$theme = new theme;
require_once( CB_CORE . "/class/class.module.php" );
$module = new module;


/* Including block */
include_once( CB_CORE .'/init.mail.php' );

require_once( CB_CORE.'/init.start.php' );

return; ?>
