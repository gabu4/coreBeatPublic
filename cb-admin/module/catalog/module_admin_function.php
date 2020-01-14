<?php
namespace module\admin\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v016
 * @date 21/11/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    use lists\funct;
    use catalog\funct;
    use importexport\funct;
    
    protected function callCatalogWithoutImage_themeLoad() {
        $html="";
        $data = $this->db_callWithoutImage_list();
        if(!empty($data)||is_array($data)){
            $html .= "<h2>Termékek akiknek nincs képe (SKU):</h2>";
            foreach($data as $v){$html .= $v['sku'].'</br>';}
        }
        
        if ( empty($data) ) { $html .= "<h2>Minden terméknek van képe :)</h2>"; }
        return $html;
    }
}

return; ?>
