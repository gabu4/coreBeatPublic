<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 14/03/19
 */
//error_reporting(E_ALL);

define('H-KEI','security');

require_once('config-static.php');
require_once('config.php');

require_once('cb-core.php');

print init();
if (CB_DEBUG_MEMORY === 'true') { $text = cb_lang_replace('[LANG_SYS_MEMORY_DEBUG_TEXT]: '. cb_ceil(memory_get_peak_usage()/1024,2) .' Kb');cbdea($text); }
cb_debug_end_build();

$_SESSION['cb_previous_location'] = CB_HTTPPAGEADDRESS;

//print $database->connectCount;
exit;

?>
