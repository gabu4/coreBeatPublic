<?php
namespace module\admin\language;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 10/10/19
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {

    protected function list_buildHTML($ajax = FALSE) {
        global $theme, $lang, $get, $module, $admin_function;
        
        $l = $lang->getLanguage();
        
        $data = $this->getListDatabase();
        
        if ( $ajax === TRUE ) {
            $html = $theme->loadAdminTemplate2('language_list_main_ajax',TRUE,'language');
        } else {
            $html = $theme->loadAdminTemplate2('language_list_main',TRUE,'language');
        }
        
        if ( empty($data) ) {
            $replace['body'] = "<h2 class='text-center'>[LANG_ADMIN_LANGUAGE_LIST_EMPTY]</h2>";
        } else {
            $tableHead = [
                "id"=>"[LANG_ADMIN_LANGUAGE_LIST_MAIN_ID]",
                "language"=>"[LANG_ADMIN_LANGUAGE_LIST_MAIN_LANGUAGE]",
                "module"=>"[LANG_ADMIN_LANGUAGE_LIST_MAIN_MODULE]",
                "constant"=>"[LANG_ADMIN_LANGUAGE_LIST_MAIN_CONSTANT]",
                "[LANG_ADMIN_LANGUAGE_LIST_MAIN_TEXT]",
                "is_admin"=>"[LANG_ADMIN_LANGUAGE_LIST_MAIN_ADMIN]",
                "translate"=>"[LANG_ADMIN_LANGUAGE_LIST_MAIN_TRANSLATE_NEED]",
                "&nbsp;"
            ];

            $tableBody = Array();$i = 0;

            foreach ( $data as $v ) {
                $tableBody[$i] = Array();
                
                $more = "<span data-toggle='tootlip' data-placement='bottom' title='".$v['text']."'>".mb_substr($v['text'],0,50,'utf8')." ...</span>";
                $text = ( mb_strlen($v['text'], 'utf8') > 50 && $v['translate_need'] === '0' ? $more : $v['text'] );
                $tableBody[$i][] = $v['id'];
                $tableBody[$i][] = $v['lang'];
                $tableBody[$i][] = $v['module'];
                $tableBody[$i][] = $v['constant'];
                $tableBody[$i][] = $text;
                $tableBody[$i][] = ( $v['is_admin'] !== '0' ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                $tableBody[$i][] = ( $v['translate_need'] !== '0' ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=language&funct=edit&id=".$v['id']."'>" . $admin_function->getIcon('edit') . "</a>"
                        . "<a href='".CB_INDEX."?admin=language&funct=delete&id=".$v['id']."'>" . $admin_function->getIcon('trash') . "</a>";
                
                $i++;
            }
            
            $replace['body'] = $admin_function->listGenerate2($tableHead, $tableBody, 'language_list_main', CB_BASEDIR."?admin=language&funct=list");
            
        }
        
        if ( $ajax !== TRUE ) {
            $replace['filter_text'] = ( isset($get['ft']) && !empty($get['ft']) ? $get['ft'] : '' );

            $replace['filter_language'] = [];
            $allowedLanguageTypes = $lang->getAllowedLanguageTypes();
            foreach ( $allowedLanguageTypes as $alt ) {
                $a = [
                    //'name' => '[LANGUAGE_FULL_NAME_'. strtoupper($alt).']',
                    'name' => $lang->getLanguageFullName($alt),
                    'value' => $alt,
                    'active' => ( isset($get['fl']) && !empty($get['fl']) && $get['fl'] === $alt ? TRUE : FALSE )
                ];
                $replace['filter_language'][] = $a;
            }

            $replace['filter_module'] = [];
            $m = $module->cb_get_module_name_list(TRUE);
            sort($m);
            foreach ( $m as $alt ) {
                $a = [
                    'name' => $alt,
                    'value' => $alt,
                    'active' => ( isset($get['fm']) && !empty($get['fm']) && $get['fm'] === $alt ? TRUE : FALSE )
                ];
                $replace['filter_module'][] = $a;
            }

            $replace['filter_admin_none'] = ( isset($get['fa']) && !empty($get['fa']) && $get['fa'] === '0' ? TRUE : FALSE );
            $replace['filter_admin_yes'] = ( isset($get['fa']) && !empty($get['fa']) && $get['fa'] === '1' ? TRUE : FALSE );

            $replace['filter_debugger_none'] = ( isset($get['fd']) && !empty($get['fd']) && $get['fd'] === '0' ? TRUE : FALSE );
            $replace['filter_debugger_yes'] = ( isset($get['fd']) && !empty($get['fd']) && $get['fd'] === '1' ? TRUE : FALSE );

            $replace['filter_translate_none'] = ( isset($get['fn']) && !empty($get['fn']) && $get['fn'] === '0' ? TRUE : FALSE );
            $replace['filter_translate_yes'] = ( isset($get['fn']) && !empty($get['fn']) && $get['fn'] === '1' ? TRUE : FALSE );
        }
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    protected function new_buildHTML() {
        global $theme, $lang, $module, $admin_function;
        
        $html = $theme->loadAdminTemplate2('language_edit',TRUE,'language');
        
        if ( isset($_SESSION['langugage_script_last_save']) && !empty($_SESSION['langugage_script_last_save']) ) { $data = $_SESSION['langugage_script_last_save']; unset($_SESSION['langugage_script_last_save']); }
        
        $replace = [];
        
        $replace['id'] = 0;
        $replace['create_date'] = '';
        
        $replace['language_flag_main'] = ( isset($data['lang']) ? $data['lang'] : $admin_function->getLanguageFlag($lang->getLanguage()) );
        $replace['language_strings'] = '';
        
        $replace['selector_constant'] = '';
        $replace['selector_text'] = '';
        
        $replace['selector_language'] = [];
        $allowedLanguageTypes = $lang->getAllowedLanguageTypes();
        foreach ( $allowedLanguageTypes as $k=>$alt ) {
            $a = [
                'name' => $lang->getLanguageFullName($alt),
                'value' => $alt,
                'active' => ( ( isset($data['lang']) && $data['lang'] === $alt ) || $k === 0 ? TRUE : FALSE )
            ];
            $replace['selector_language'][] = $a;
        }
        
        $replace['selector_module'] = [];
        $m = $module->cb_get_module_name_list(TRUE);
        sort($m);
        foreach ( $m as $alt ) {
            $a = [
                'name' => $alt,
                'value' => $alt,
                'active' => ( isset($data['module']) && $data['module'] === $alt ? TRUE : FALSE )
            ];
            $replace['selector_module'][] = $a;
        }

        $replace['selector_admin_none'] = ( isset($data['is_admin']) && $data['is_admin'] === '0' ? TRUE : FALSE );
        $replace['selector_admin_yes'] = ( isset($data['is_admin']) && $data['is_admin'] === '1' ? TRUE : FALSE );

        $replace['selector_debugger_none'] = ( isset($data['debugger']) && $data['debugger'] === '0' ? TRUE : FALSE );
        $replace['selector_debugger_yes'] = ( isset($data['debugger']) && $data['debugger'] === '1' ? TRUE : FALSE );

        $replace['selector_translate_none'] = ( isset($data['translate']) && $data['translate'] === '0' ? TRUE : FALSE );
        $replace['selector_translate_yes'] = ( isset($data['translate']) && (int) $data['translate'] >= 1 ? TRUE : FALSE );
        
        $replace['otherlanguage'] = FALSE;
        
        $theme->mustache($replace,$html);
        
        return $html;
    }

    protected function edit_buildHTML($id) {
        global $theme, $lang, $module, $admin_function;
        
        $data = $this->getData($id);
        if ( !$data ) { return FALSE; }
        
        $dataLanguageVersions = $this->getDataLanguageVersions($data['is_admin'],$data['module'],$data['constant']);
        $html = $theme->loadAdminTemplate2('language_edit',TRUE,'language');
        
        $replace = [];
        
        $replace['id'] = $data['id'];
        $replace['create_date'] = $data['date_create'];
        $string = strtoupper('LANG_'.( $data['is_admin'] === '1' ? 'ADMIN_' : '').$data['module'].'_'.$data['constant']);
        $replace['language_flag_main'] = $admin_function->getLanguageFlag($data['lang']);
        $replace['language_strings'] = $string;
        
        $replace['selector_constant'] = $data['constant'];
        $replace['selector_text'] = $data['text'];
        
        $replace['selector_language'] = [];
        $allowedLanguageTypes = $lang->getAllowedLanguageTypes();
        foreach ( $allowedLanguageTypes as $alt ) {
            $a = [
                //'name' => '[LANGUAGE_FULL_NAME_'. strtoupper($alt).']',
                'image' => $admin_function->getLanguageFlag($alt),
                'name' => $lang->getLanguageFullName($alt),
                'value' => $alt,
                'active' => ( $data['lang'] === $alt ? TRUE : FALSE )
            ];
            $replace['selector_language'][] = $a;
        }
        
        $replace['selector_module'] = [];
        $m = $module->cb_get_module_name_list(TRUE);
        sort($m);
        foreach ( $m as $alt ) {
            $a = [
                'name' => $alt,
                'value' => $alt,
                'active' => ( $data['module'] === $alt ? TRUE : FALSE )
            ];
            $replace['selector_module'][] = $a;
        }

        $replace['selector_admin_none'] = ( $data['is_admin'] === '0' ? TRUE : FALSE );
        $replace['selector_admin_yes'] = ( $data['is_admin'] === '1' ? TRUE : FALSE );

        $replace['selector_debugger_none'] = ( $data['debugger_predicted'] === '0' ? TRUE : FALSE );
        $replace['selector_debugger_yes'] = ( $data['debugger_predicted'] === '1' ? TRUE : FALSE );

        $replace['selector_translate_none'] = ( $data['translate_need'] === '0' ? TRUE : FALSE );
        $replace['selector_translate_yes'] = ( (int) $data['translate_need'] >= 1 ? TRUE : FALSE );
        
        $replace['otherlanguage'] = FALSE;
        if ( $dataLanguageVersions !== FALSE ) {
            $replace['otherlanguage'] = [];
            $i = 0;
            foreach ( $dataLanguageVersions as $v ) {
                $replace['otherlanguage'][$i]['active'] = ( $i === 0 ? 'active' : '');
                $replace['otherlanguage'][$i]['langid'] = 'lang_'.$v['lang'];
                $replace['otherlanguage'][$i]['langflag'] = $admin_function->getLanguageFlag($v['lang']);
                $replace['otherlanguage'][$i]['langname'] = $lang->getLanguageFullName($v['lang']);
                $replace['otherlanguage'][$i]['langtext'] = $v['text'];
                
                $i++;
            }
        }
            
        $theme->mustache($replace,$html);
        
        return $html;
    }
    
    protected function saveString(&$id) {
        global $post, $handler;
        
        $error = $this->saveStringTest($post);
        
        if ( !empty($error) ) {
            $handler->textErrorForInput($error,true,"save",$post);
            $handler->messageError2(NULL,"[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_ERROR]","save");
            return FALSE;
        }
        
        if ( $id === 0 ) {
            $ok = $this->saveString_new($id,$post);
        } else {
            $ok = $this->saveString_update($id,$post);
        }
        
        if ( $ok ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_SUCCESS]","save");
            $_SESSION['langugage_script_last_save'] = $post;
            return $ok;
        } else {
            $handler->textErrorForInput($error,true,"save",$post);
            $handler->messageError2(NULL,"[LANG_ADMIN_LANGUAGE_MESSAGE_SAVE_ERROR_IN_DB]","save");
            return FALSE;
        }
    }
    
    protected function deleteString($id) {
        global $post, $handler;
        
        $data = $this->getData($id);
        
        if ( empty($data) ) {
            $handler->messageError2(NULL,"[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_ERROR]","save");
            return FALSE;
        }
        
        $ok = $this->deleteString_db($id);
        
        if ( $ok ) {
            $handler->messageSuccess2(NULL,"[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_SUCCESS]","save");
            return $ok;
        } else {
            $handler->messageError2(NULL,"[LANG_ADMIN_LANGUAGE_MESSAGE_DELETE_ERROR_IN_DB]","save");
            return FALSE;
        }
    }
    
    private function saveStringTest($data) {
        $error = [];
        
        return $error;
    }
}

return; ?>