<?php
namespace module\currency;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 10/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    protected function convert($base, $vto, $amount) {
        $base = strtolower($base);
        $vto = strtolower($vto);
        
        $c = strtoupper($base.'_'.$vto);
        
        $value = $this->convert_getDB($base,$vto);
        
        if ( $value ) {
            return $value * $amount;
        } else {
            $url = 'https://free.currencyconverterapi.com/api/v6/convert?q='.$c.'&compact=ultra&apiKey='.$this->apiKey;

            $cc = new \cb_cURL();
            $return = $cc->json($url);
            
            $r2 = json_decode($return,TRUE);
            
            $value = $this->convert_saveDB($base,$vto,$r2[$c]);
            
            return $r2[$c] * $amount;
        }
    }
    
    protected function refreshCurrencyList() {
        $url = 'https://free.currencyconverterapi.com/api/v6/currencies';
        
        $cc = new \cb_cURL();
        $return = $cc->json($url);
        
        $r2 = json_decode($return,TRUE);
        
        if ( !empty($r2) && isset($r2['results']) && !empty($r2['results']) ) {
            $this->refreshCurrencyList_saveDB($r2['results']);
        }
        
    }
    
    protected function getCurrencyList($print) {
        $data = $this->getCurrencyList_DB();
        
        if ( $print ) {
            global $out_html;
            $out_html->printOutContent(json_encode($data));
        } else {
            return $data;
        }
    }
}

return; ?>
