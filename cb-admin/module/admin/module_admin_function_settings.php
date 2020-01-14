<?php
namespace module\admin\admin\settings;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    protected function callSettings_createLook($settingsData) {
        global $theme, $module;
        
        $html = $theme->loadAdminTemplate2('admin_settings',TRUE,'admin');
        
        $settingsArray = array();
        $replace = Array();
        
        if ( !empty($settingsData) ) {
            foreach ( $settingsData as $value ) {
                if (!$module->cb_check_access('admin',$value['edit_level'],'admin')) {continue;}
                $bName = strtoupper("LANG_ADMIN_ADMIN_SETTINGS_ROW_".$value['key']);
                $name = ( cb_lang_defined($bName) ) ? cb_lang_text($bName) : $value['key'];
                $settingsArray[$value['key']]['name'] = $name;
                $settingsArray[$value['key']]['value'] = $value['value'];
                //$html .= "<tr><td class='rowTitle'>".$name."</td><td class='rowText'><input name='".$value['key']."' value='".$value['value']."'></td></tr>";
            }
        }
        
        $replace['content_general'] = $this->callSettings_createLook_contentTab('general',$settingsArray);
        $replace['content_security'] = $this->callSettings_createLook_contentTab('security',$settingsArray);
        $replace['content_user'] = $this->callSettings_createLook_contentTab('user',$settingsArray);
        $replace['content_email'] = $this->callSettings_createLook_contentTab('email',$settingsArray);
        $replace['content_seo'] = $this->callSettings_createLook_contentTab('seo',$settingsArray);
        $replace['content_theme'] = $this->callSettings_createLook_contentTab('theme',$settingsArray);
        $replace['content_content'] = $this->callSettings_createLook_contentTab('content',$settingsArray);
        $replace['content_product'] = $this->callSettings_createLook_contentTab('product',$settingsArray);
        $replace['content_currency'] = $this->callSettings_createLook_contentTab('currency',$settingsArray);
        $replace['content_catalog'] = $this->callSettings_createLook_contentTab('catalog',$settingsArray);
        $replace['content_media'] = $this->callSettings_createLook_contentTab('media',$settingsArray);
        $replace['content_gallery'] = $this->callSettings_createLook_contentTab('gallery',$settingsArray);
        
        
        $contentOther = "";
        if ( !empty($settingsArray) ) {
            foreach( $settingsArray as $k=>$v ) {
                $contentOther .= $this->callSettings_createLook_contentTab_text($v['name'],'',$settingsArray);
            }
        }
        
        $replace['content_other'] = $contentOther;
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    private function callSettings_createLook_contentTab($tab,&$settingsArray) {
        global $theme;
        $empty = TRUE;
        $html = $theme->loadAdminTemplate2('admin_settings_'.$tab,FALSE,'admin');
        
        $row = $theme->search_pregMatchAll('S',$html);
        if ( !empty($row) ) {
            foreach ( $row as $v ) {
                $replaceWhat = $v[0];
                $name = strtolower($v[1]);
                $type = strtolower($v[2]);
                $setup = ( isset($v[3]) ) ? $v[3] : "";
                if ( !isset($settingsArray[$name]) ) { $theme->replace3($replaceWhat,'',$html);continue; } else { $empty = FALSE; }
                if ( !empty($setup) ) {
                    $s = explode(";",$setup);
                    unset($setup);
                    foreach ( $s as $k=>$s2 ) {
                        $s3 = explode("|",$s2);
                        $setup[$k]['value'] = $s3[0];
                        $setup[$k]['text'] = $s3[0];
                        if ( isset($s3[1]) ) {
                            $mText = strtoupper("LANG_ADMIN_ADMIN_SETTINGS_MASKED_".$s3[1]);
                            $setup[$k]['text'] = ( cb_lang_defined($mText) ) ? cb_lang_text($mText) : $s3[1];
                        } elseif ( $s3[0] === 'true' ) {
                            $mText = strtoupper("LANG_ADMIN_ADMIN_SETTINGS_MASKED_TRUE");
                            $setup[$k]['text'] = ( cb_lang_defined($mText) ) ? cb_lang_text($mText) : $s3[0];
                        } elseif ( $s3[0] === 'false' ) {
                            $mText = strtoupper("LANG_ADMIN_ADMIN_SETTINGS_MASKED_FALSE");
                            $setup[$k]['text'] = ( cb_lang_defined($mText) ) ? cb_lang_text($mText) : $s3[0];
                        }
                    }
                }
                if ( $type === 'text' ) { $rowHtml = $this->callSettings_createLook_contentTab_text($name,$setup,$settingsArray); $theme->replace3($replaceWhat,$rowHtml,$html); }
                elseif ( $type === 'select' ) { $rowHtml = $this->callSettings_createLook_contentTab_select($name,$setup,$settingsArray); $theme->replace3($replaceWhat,$rowHtml,$html); }
            }
        }
        
        if ($empty) {return '';} else {return $html;}
    }
    
    private function callSettings_createLook_contentTab_text($name,$setup,&$settingsArray) {
        $html = "";
        if ( isset($settingsArray[$name]) ) {
            $html .= "<div class='form-group'><label>".$settingsArray[$name]['name']."</label><input class='form-control' placeholder='' type='text' name='".$name."' value='".$settingsArray[$name]['value']."'></div>";
        } else {
            cb_error_log("Admin settings, missing setup value: $name");
        }
        unset($settingsArray[$name]);
        return $html;
    }
    
    private function callSettings_createLook_contentTab_select($name,$setup,&$settingsArray) {
        if ( empty($setup) || !is_array($setup) ) { return false; }
        $option = "";
        foreach ( $setup as $opt ) {
            $v = $opt['value']; $n = $opt['text'];
            $checked = ( $settingsArray[$name]['value'] === $v ) ? " SELECTED" : "";
            $option .= "<option value='$v' $checked>$n</option>";
        }
        $html = "<div class='form-group'><label>".$settingsArray[$name]['name']."</label><select class='form-control' name='$name'>$option</select></div>";
        unset($settingsArray[$name]);
        return $html;
    }
    
    protected function callSettings_saveData(&$settingsData) {
        global $post, $handler, $out_html;
        
        $saveData = array();
        foreach ( $settingsData as $k=>$v ) {
            if ( isset($post[$v['key']]) ) { $settingsData[$k]['value'] = $saveData[$v['key']] = $post[$v['key']]; }
        }
        
        $ret = $this->callSettings_saveDataToDB($saveData);
        
        if ( $ret ) {
            $handler->messageSuccess("[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_SUCCESS]",true,"save");
            $out_html->redirect(CB_HTTPPAGEADDRESS);
        } else {
            $handler->messageError("[LANG_ADMIN_ADMIN_SETTINGS_MESSAGE_SAVE_ERROR_IN_DB] #106",true,"save");
            $out_html->redirect(CB_HTTPPAGEADDRESS);
        }
    }
}

return; ?>