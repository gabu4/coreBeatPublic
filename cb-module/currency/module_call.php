<?php
namespace module\currency;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 13/02/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
	
    function __construct() {
        $this->baseCurrency = CB_CURRENCY_BASE;
        $this->apiKey = '40a58e7b0afd21721ccf';
        $this->refreshTime = CB_CURRENCY_REFRESHTIME;
    }
    
    public function __call_main() {
        
    }
    
    public function __call_show($v) {
        
    }
    
    public function __call_convert($v) {
        $base = $v['base'];
        $vto = $v['vto'];
        $amount = $v['amount'];
        
        $a = $this->convert($base, $vto, $amount);
        
        return $a;
    }
    
    public function __call_refreshCurrencyList() {
        $this->refreshCurrencyList();
    }
    
    public function __call_getCurrencyList($print = TRUE) {
        return $this->getCurrencyList($print);
    }
}

return; ?>
