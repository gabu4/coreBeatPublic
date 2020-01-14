<?php
namespace module\menu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 05/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    protected function getMenuCategory_fromDb() {
        global $database;

        $database->newQuery();
        $database->select("`m`.*");
        $database->from("`#__menu_category` `m`");
        $database->where("`m`.`state` = '1'");
        $database->order("`m`.`id` ASC");
        $database->cache(TRUE);
        $cidRaw = $database->execute();

        if ( !empty($cidRaw) ) {
            foreach( $cidRaw as $val ) {
                $this->menuCategory[$val['id']]['id'] = $val['id'];
                $this->menuCategory[$val['id']]['class'] = $val['class'];
                $this->menuCategory[$val['id']]['name'] = $val['name'];
            }
        }

    }
    
    protected function menu_activeMenuCheck() {
        global $database, $out_html;

        if ( !empty($out_html->getContentData()) ) {
            $database->newQuery();
            $database->select("`m`.`id`");
            $database->from("`#__menu` `m`");
            $database->where("`m`.`state` = '1' AND `m`.`content_id` = '".$out_html->getContentData()['id']."' ");
            $database->order("`m`.`id` ASC");
            $database->cache(TRUE);
            $cidRaw = $database->execute();

            if ( !empty($cidRaw) ) {
                foreach( $cidRaw as $val ) {
                    $this->activeMenu[$val['id']] = $val['id'];
                }
            }
        }
    }
    
    protected function getMenuData_fromDb($cid, $language) {
        global $database;

        $database->newQuery();
        $database->select("`m`.*,`c`.`seo_name`,`c`.`name`,`c`.`value`");
        $database->from("`#__menu` `m`");
        $database->join("left","`#__content` `c` ON `m`.`content_id` = `c`.`id`");
        $database->join("left","`#__content_type` `ct` ON `c`.`type` = `ct`.`id`");
        $database->where("`m`.`state` = '1' AND `m`.`category` = '".$cid."' AND `c`.`lang` = '".$language."' ");
        $database->order("`m`.`parent` ASC, `m`.`order` ASC, `m`.`id` ASC");
        $database->cache(TRUE);
        $menus = $database->execute();

        if ( empty($menus) ) return '';

        $menuData = Array();
        foreach ( $menus as $value ) {
            $menuData[$value['parent']][$value['id']] = $value;
        }
        
        return $menuData;
    }

}

return; ?>
