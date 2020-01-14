<?php
namespace module\currency;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 10/11/18
 */
if ( !defined('H-KEI') ) { exit; }

$subModuleFile = Array();

//based on https://free.currencyconverterapi.com/ 

abstract class module {
    protected $baseCurrency;
    protected $apiKey;
    protected $refreshTime;
}

return; ?>
