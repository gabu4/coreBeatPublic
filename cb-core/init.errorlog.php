<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v010
 * @date 14/11/19
 */
if ( !defined('H-KEI') ) { exit; }

ini_set("log_errors", 1);
ini_set("error_log", CB_TEMP."/cb-php-error.log");

/**
 * Error report to Log file (cb-php-error.log)
 * @param string $text this text is put to a log file
 */
function cb_error_log($text) {
   error_log( $text );
}

/**
 * Error report to print
 * @param string $text this text is printing out
 */
function cb_error_print($text) {
   cb_debug( $text );
}

/**
 * Fatal error text, print the $text value and exit!
 * @param string $text this text is printing out
 */
function cb_error_fatal_print($text) {
   cb_debug( $text,TRUE );
}

/**
 * Useful test elem for print out variable results
 * @param string/array Data what is print/dump out
 * @param boolean Exit after print/dump (default FALSE)
 * @param boolean var_dump out, not print (default FALSE)
 */
function cb_debug($p,$exit = FALSE,$dump = FALSE) {
    if ( CB_DEBUG !== 'true' ) { return; }
    print "<pre>";
    $text = 'cb-debug-' . cb_generate_code() . ' ';
    print $text;
    if ( $dump === TRUE || $dump === 1 ) { var_dump($p); } else { print_r($p); }
    print "</pre>";
    if ( $exit === TRUE || $exit === 1 ) { exit; }
}
function cb_debug_admin($p,$exit = FALSE,$dump = FALSE) { global $user; if ( $user->cb_get_user_level() === 255 ) { cb_debug($p, $exit, $dump); } }

function cb_debug_end($p,$exit = FALSE,$dump = FALSE) {
    if ( CB_DEBUG !== 'true' ) { return; }
    global $debuger_end;
    $debuger_end[] = [
        'text'=>$p,
        'exit'=>($exit===TRUE||$exit===1)?TRUE:FALSE,
        'dump'=>($dump===TRUE||$dump===1)?TRUE:FALSE,
        ];
}
function cb_debug_end_admin($p,$exit = FALSE,$dump = FALSE) { global $user; if ( $user->cb_get_user_level() === 255 ) { cb_debug_end($p, $exit, $dump); } }

function cb_debug_end_build() {
    if(CB_DEBUG!=='true'){return;}
    global $debuger_end;
    if(empty($debuger_end)){return;}
    foreach($debuger_end as $de){
        print "<pre>";
        $t = 'cb-debug-' . cb_generate_code() . ' ';
        print $t;
        if($de['dump']===TRUE||$de['dump']===1){var_dump($de['text']);}else{print_r($de['text']);}
        print "</pre>";
        if($de['exit']===TRUE||$de['exit']===1){exit;}
    }
}

/**
 * <b>Alias for cb_debug()</b><br />Useful test elem for print out variable results
 * @param string/array Data what is print/dump out
 * @param boolean Exit after print/dump (default FALSE)
 * @param boolean var_dump out, not print (default FALSE)
 */
function cbd($p,$exit = FALSE,$dump = FALSE) {
    cb_debug($p, $exit, $dump);
}
function cbda($p,$exit = FALSE,$dump = FALSE) {
    cb_debug_admin($p, $exit, $dump);
}
function cbdl($p,$exit = FALSE) {
    cb_error_log(print_r($p,TRUE));
    if($exit===TRUE||$exit===1){exit;}
}
function cbdal($p,$exit = FALSE) {
    global $user; if ( $user->cb_get_user_level() === 255 ) { cbdl($p, $exit); }
}
function cbdlq($exit = FALSE,$dump = FALSE) {
    global $database;
    $p = $database->lq();
    cb_debug($p, $exit, $dump);
}
function cbdalq($exit = FALSE,$dump = FALSE) {
    global $database;
    $p = $database->lq();
    cb_debug_admin($p, $exit, $dump);
}
function cbdlql($preText='',$exit = FALSE) {
    global $database;
    $p = $database->lq();
    if ( $preText !== '' ) { $preText .= ' ';}
    cb_error_log($preText.$p);
    if ( $exit === TRUE || $exit === 1 ) { exit; }
}
function cbdalql($preText='',$exit = FALSE) {
    global $database;
    $p = $database->lq();
    if ( $preText !== '' ) { $preText .= ' ';}
    cb_error_log($preText.$p);
    if ( $exit === TRUE || $exit === 1 ) { exit; }
}
function cbde($p,$exit = FALSE,$dump = FALSE) {
    cb_debug_end($p, $exit, $dump);
}
function cbdea($p,$exit = FALSE,$dump = FALSE) {
    cb_debug_end_admin($p, $exit, $dump);
}
function cbdelq($exit = FALSE,$dump = FALSE) {
    global $database;
    $p = $database->lq();
    cb_debug_end($p, $exit, $dump);
}
function cbdealq($exit = FALSE,$dump = FALSE) {
    global $database;
    $p = $database->lq();
    cb_debug_end_admin($p, $exit, $dump);
}

return; ?>