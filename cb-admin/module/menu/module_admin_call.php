<?php
namespace module\admin\menu;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v018
 * @date 17/03/19
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    use grouplist\call;
    use menulist\call;
    
    function module_admin_menu_call() { }

    public function __call_main() {
        //header("Location: ".CB_INDEX."?admin=menu&funct=list");exit;
        return $this->__call_list();
    }
    
    public function __call_create() {
        global $theme, $database, $module, $get, $lang;
                
        $catid = ( isset($get['catid']) && !empty($get['catid']) && is_numeric($get['catid']) ) ? $get['catid'] : 1;
        $catlang = ( isset($get['catlang']) && !empty($get['catlang']) ) ? $get['catlang'] : $lang->getAllowedLanguageTypes()[0];
        
        $contentTypeRaw = $this->getPossibleContentTypeFromDB();
        
        $contentType = array();
        $contentTypeTable = array();
        $contentType2 = array();
        foreach ( $contentTypeRaw as $cTValue ) { 
            $contentType[$cTValue['id']] = $cTValue;
            $contentType2[$cTValue['module']][$cTValue['type']] = $cTValue;
            $contentTypeTable[$cTValue['id']] = $cTValue['module']."_".$cTValue['type'];
        }

        cb_ksort_multi($contentType2);

        $type = "";

        if ( isset($get['type']) and !empty($get['type']) ) $type = strtolower($get['type']);

        if (
            !in_array($type,$contentTypeTable)
            ) {

            $html = $theme->loadAdminTemplate('admin_menu','create',TRUE,'menu');

            $body = "";

            $constantTitle_old = "";
            
            foreach ( $contentType2 as $tempVal ) { foreach ( $tempVal as $cTVal ) {

                $constantTitle = "LANG_ADMIN_MENU_MENUPOINT_" . strtoupper( $cTVal['module'] ) . "_TITLE";

                if ( $constantTitle_old != $constantTitle ) { 
                    if ( !empty( $constantTitle_old ) ) {
                        $body .= "</ul>";
                    }

                    $constantTitle_old = $constantTitle;
                    $nameTitle = ( defined($constantTitle_old) ) ? constant($constantTitle_old) : $constantTitle_old;
                    $body .= "<h3>" . $nameTitle . "</h3>";
                    $body .= "<ul>";
                } 

                $constantName = "LANG_ADMIN_MENU_MENUPOINT_" . strtoupper( $cTVal['module'] ) . "_" . strtoupper( $cTVal['type'] ) . "_NAME";

                $name = ( defined($constantName) ) ? constant($constantName) : $constantName;

                $type = $cTVal['module'] . "_" . $cTVal['type'];
                
                $body .= "<li><a href='" . CB_BASEDIR . "?admin=menu&funct=create&catid=" . $catid . "&catlang=" . $catlang . "&type=" . $type . "'>" . $name . "</a></li>";
            }}
            $body .= "</ul>";

            $replace['TITLE'] = "Új menüpont: menütípus választás";
            $replace['BODY'] = $body;
            
            $theme->replace($replace,$html);

        } else {

            $typeR = explode("_",$type,2);
            
            $html = $this->loadMenuFunction($typeR[0], $typeR[1]);

        }

        return $html;
    }
    
    public function __call_edit() {
        global $module, $get;
        
        if ( isset($get['type']) and !empty($get['type']) ) $type = strtolower($get['type']); //Menütípus lekérdezése
        
        $typeR = explode("_",$type,2);
        
        $html = $this->loadMenuFunction($typeR[0], $typeR[1]);
        
        return $html;
    }
    
    public function __call_trash() {		
            global $database, $handler, $get, $lang;
            
            if ( !isset($get['id']) OR empty($get['id']) ) { return 'Hibás ID'; }
            $id = $get['id'];
            $catlang = $lang->getAdminLanguage();
            $catid = 1;
            if ( !isset($get['catlang']) && !empty($get['catlang']) ) { $catlang = $get['catlang']; }
            if ( !isset($get['catid']) && !empty($get['catid']) ) { $catid = $get['catid']; }
            
            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__menu`");
            $database->where("`id` = '".$id."'");
            $database->limit(" 1 ");
            $database->qType("result");
            $extid = $database->execute();
            
            if ( empty($extid) ) { return 'Hibás ID'; }
            
            $database->doQuery("UPDATE `#__menu` SET `state` = '-1' WHERE `id` = '".$extid."' ");
            
            $handler->messageSuccess('A menüpont lomtárba helyezése sikeres!',true,'delete');
            
            header("Location: ?admin=menu&funct=main&catid=".$catid."&catlang=".$catlang);
    }
}

return; ?>