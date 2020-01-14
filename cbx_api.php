<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 14/03/19
 */
error_reporting(E_ALL);

define('H-KEI','security');

require_once('config-static.php');
require_once('config.php');

require_once('cb-core.api.php');

print init();

$_SESSION['cb_previous_location'] = CB_HTTPPAGEADDRESS;

//print $database->connectCount;
exit;

?>
