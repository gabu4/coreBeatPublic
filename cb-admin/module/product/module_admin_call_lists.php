<?php
namespace module\admin\product\lists;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 11/11/17
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    public function __call_list() {
        global $get;
        
        $currentCatId = ( isset($get['cat']) && is_numeric($get['cat']) ) ? $get['cat'] : 0;
        
        $listDataRaw = $this->callList_databaseGet($currentCatId);
        
        $listData = $this->listDataLanguageFilter($listDataRaw);
        
        $html = $this->callMain_themeLoad($listData,$currentCatId);
        
        return $html;
    }
    
}

return; ?>