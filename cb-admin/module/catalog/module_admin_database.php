<?php
namespace module\admin\catalog;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v019
 * @date 07/12/18
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use lists\database;
    use catalog\database;
    use importexport\database;
    
    protected function db_callWithoutImage_list() {
        global $database;
        
        $database->newQuery();
        //$database->select("`sku`");
        $database->sSelect("sku");
        $database->sJSONType("media","");
        $database->from("`#__catalog`");
        $database->wAndIsLikeP("media",'"catalogimage": []');
        $database->qType("array");
        $result = $database->execute();
        return $result;
    }
}

return; ?>
