<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 24/02/19
 */
if ( !defined('H-KEI') ) { exit; }

date_default_timezone_set('Europe/Budapest');

$protocol = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

define( "CB_BASEDIR" , @$_SERVER['SCRIPT_NAME'] ); // CB_BASEDIR bázis útvonal, modulban való meghíváshoz
define( "CB_ROOTDIR" , dirname(__FILE__) ); // CB_ROOTDIR útvonal, a gyökérkönyvtáról számítva
define( "CB_WEBPAGEADDRESS" , @$_SERVER['HTTP_HOST'] ); // A weboldal webcíme (előtag nélkül)
define( "CB_HTTPADDRESS" , $protocol.@$_SERVER['HTTP_HOST'] ); // A weboldal webcíme (előtaggal)
define( "CB_HTTPPAGEADDRESS" , $protocol.@$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ); // Az oldal teljes URL webcíme
define( "CB_REQUEST_URI" , substr($_SERVER['REQUEST_URI'],1) ); // A weboldal lekérés paramétere
define( "CB_URI" , substr(@$_SERVER['PHP_SELF'],0,strrpos(@$_SERVER['PHP_SELF'],'/')+1) ); // a rendszer gyökér könyvtára
$is_ajax = ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) ? TRUE : FALSE; // Ajax teszt
$is_api = TRUE;

require_once( CB_CORE . "/sys.version.php" ); // verzió információk

include_once( CB_CORE . "/init.errorlog.php" ); // hibakimentés, hibakeresés, hibakiírás

/* Core functions */

/* Main Including block */
require_once( CB_CORE . "/function.php" ); // általánosan meghívható alap funkciók

require_once( CB_CORE . "/database/" . CB_SQLTYPE . ".php" );
$database = new database();

$database->connect();
$database->start();

require_once( CB_CORE . "/init.settings.php" );

set_time_limit(CB_PHP_SET_TIME_LIMIT);

require_once( CB_CORE . "/sys.class.language.php" ); // nyelvekkel kapcsolatos funkciók

require_once( CB_CORE . "/sys.class.handler.php" );
require_once( CB_CORE . "/sys.class.session.php" );
require_once( CB_CORE . "/sys.class.module.php" );
require_once( CB_CORE . "/sys.class.module.api.php" );
require_once( CB_CORE . "/sys.class.user.php" );
//  require_once( CB_CORE . "/sys.class.theme.php" );
//  require_once( CB_CORE . "/sys.class.content.php" );
require_once( CB_CORE . "/sys.class.out.api.php" );
require_once( CB_CORE . "/sys.class.systemlog.php" );

$handler = new handler();
$session = new session();
$module = new module_api();
$user = new user();
$out_api = new out_api();
$systemlog = new systemlog();

$session->init();
$handler->init();
$user->init();
$module->init_api();


/* Including block */
require_once( CB_CORE . "/vendor/autoload.php" );

include_once( CB_CORE . "/init.mail.php" );

require_once( CB_CORE . "/init.function.php" );

require_once( CB_CORE . "/init.out.api.php" );

return; ?>
