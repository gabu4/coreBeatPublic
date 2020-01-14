<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v028
 * @date 30/08/19
 */
if (!defined('H-KEI')) { exit; }

class language {

    private $currentUserLanguage = NULL;
    private $currentAdminLanguage = NULL;
    private $allowedLanguageTypes = Array();
    private $allowedLanguageCount = 0;
    private $languageStringStorage = Array();
    private $loadLangStore = Array();
    private $loadLangRawDatabaseStore = [0=>[],1=>[]];
    
    public function setLanguage($language = NULL,$isAdmin = FALSE) {
        $language2 = strtolower(trim($language));
        if ( $language2 !== NULL ) {
            $lt = $this->loadLanguageFile($language2,'_standard',$isAdmin);
            if ( $lt && $isAdmin ) {
                //return $this->currentAdminLanguage = $this->currentUserLanguage = $language2;
                return $this->currentAdminLanguage = $language2;
            } elseif ( $lt && !$isAdmin ) {
                return $this->currentUserLanguage = $language2;
            }
        }
        
        $language3 = ( $isAdmin ? strtolower(trim(CB_LANGTYPE_ADMIN_DEFAULT)) : strtolower(trim(CB_LANGTYPE_USER_DEFAULT)) );
        $lt = $this->loadLanguageFile($language3,'_standard',$isAdmin);
        if ( $lt && $isAdmin ) {
            //return $this->currentAdminLanguage = $this->currentUserLanguage = $language3;
            return $this->currentAdminLanguage = $language3;
        } elseif ( $lt && !$isAdmin ) {
            return $this->currentUserLanguage = $language3;
        }
        
        foreach ( $this->allowedLanguageTypes as $l ) {
            $lt = $this->loadLanguageFile($l,'_standard',$isAdmin);
            if ( $lt && $isAdmin ) {
                return $this->currentAdminLanguage = $this->currentUserLanguage = $l;
            } elseif ( $lt && !$isAdmin ) {
                return $this->currentUserLanguage = $l;
            }
        }
        return FALSE;
    }
    
    private function loadLanguageFile($language,$module,$isAdmin=FALSE,$isAdminPath=FALSE) {
        $path = ( $isAdminPath === TRUE ? CB_ADMIN . "/language" : CB_LANGUAGE );
        $languageFilePath = $path . "/" . $language . "/".$module.'.php';
        if ( file_exists($languageFilePath) ) {
            include_once( $languageFilePath );
            return TRUE;
        }
        return FALSE;
    }
    
    public function setLoadLangStore($module, $isAdmin) {
        $this->loadLangStore[] = array("module"=>$module,"isadmin"=>$isAdmin);
        $this->cb_load_language($module, $isAdmin);
    }
    
    public function getAdminLanguage() {
        return $this->currentAdminLanguage;
    }
    
    public function getUserLanguage() {
        return $this->currentUserLanguage;
    }
    
    public function getLanguage() {
        global $user;
        return ( $user->cb_is_admin_territory() && !empty($this->currentAdminLanguage) ? $this->currentAdminLanguage : $this->currentUserLanguage );
    }
    
    public function setAllowedLanguageTypes($language) {
        $this->allowedLanguageTypes = explode('|',$language);
        $this->allowedLanguageCount = count($this->allowedLanguageTypes);
    }
    
    public function getAllowedLanguageTypes() {
        return $this->allowedLanguageTypes;
    }
    
    public function getAllowedLanguageCount() {
        return $this->allowedLanguageCount;
    }
    
    public function startLanguageDatabaseStore() {
        global $database;
        
        foreach ($this->allowedLanguageTypes as $ltyp) {
            $data = $database->newQuery()
                             ->sSelect("lang")
                             ->sSelect("is_admin")
                             ->sSelect("module")
                             ->sSelect("constant")
                             ->sSelect("text")
                             ->sSelect("translate_need")
                             ->from("`#__language`")
                             ->wAndIsEqual("lang",$ltyp)
                             ->qType("array")
                             ->execute();
            if ( empty($data) ) { continue; }
            foreach ( $data as $d ) {
                $this->loadLangRawDatabaseStore[$d['is_admin']][$d['module']][$d['constant']][$d['lang']] = $d['text'];
            }
        }
    }
    
    public function getLanguageFullName($l) {
        $languageFilePath = CB_LANGUAGE . "/" . $this->getLanguage() . "/_language.php";
        if ( file_exists($languageFilePath) ) {
            include_once( $languageFilePath );
        }
        
        $la = '[LANGUAGE_FULL_NAME_'.strtoupper($l).']';
        return $la;
    }

    public function cb_load_language($module, $isAdmin = FALSE) {
        $module_trim = strtolower(trim($module));
        $this->cb_load_language_databaseLoad($module_trim, $isAdmin);
        $this->cb_load_language_fileLoad($module_trim, $isAdmin);
    }
    
    public function cb_load_language_databaseLoad($module, $isAdmin) {
        $modulem = strtolower($module);
        $language = ( $isAdmin === TRUE ? $this->currentAdminLanguage : $this->currentUserLanguage );
        $isAdminValue = ( $isAdmin === TRUE ? 1 : 0 );
        
        if ( !isset($this->loadLangRawDatabaseStore[$isAdminValue][$module]) ) { return FALSE; }
        $data = $this->loadLangRawDatabaseStore[$isAdminValue][$module];
        
        if ( empty($data) ) { return NULL; }
        foreach ( $data as $constant=>$d ) {
            if ( !isset($d[$language]) ) { continue; }
            $name = 'LANG_';
            $name .= ($isAdmin === TRUE) ? 'ADMIN_' : '';
            $name .= $modulem.'_'.$constant;
            $this->cb_lang_define($name,$d[$language]);
        }
        return TRUE;
    }

    
    public function cb_load_language_fileLoad($module, $isAdmin) {
        $language = ( $isAdmin === TRUE ? $this->currentAdminLanguage : $this->currentUserLanguage );
        $language2 = strtolower(trim($language));
        if ( $language !== NULL ) {
            $lt = $this->loadLanguageFile($language2,$module,$isAdmin,$isAdmin);
            if ( $lt ) { return $language2; } 
        }
        
        $language3 = ( $isAdmin ? strtolower(trim(CB_LANGTYPE_ADMIN_DEFAULT)) : strtolower(trim(CB_LANGTYPE_USER_DEFAULT)) );
        $lt = $this->loadLanguageFile($language3,$module,$isAdmin,$isAdmin);
        if ( $lt ) { return $language3; }
        
        foreach ( $this->allowedLanguageTypes as $l ) {
            $lt = $this->loadLanguageFile($l,$module,$isAdmin,$isAdmin);
            if ( $lt ) { return $l; }
        }
    }

    /**
     * Language definer, if exist will not fall<br><br>This fuction NO MORE calling a standard define PHP method with an if defined method
     * @param string $who Define name
     * @param string $what Define value
     */
    public function cb_lang_define($who, $what) {
        $who2 = strtoupper(cb_remove_space(cb_remove_accent($who)));
        $this->languageStringStorage[$who2] = $what;
    }

    public function cb_lang_start() {
        $this->cb_load_lang_start();
        global $theme;
        
        $textArray = Array();
        
        if (!empty($this->languageStringStorage)) {
            foreach ($this->languageStringStorage as $ptext => $text) {
                $textArray[$ptext] = $text;
            }
        }
        $this->langReplace($textArray, $theme->tempOut);
        if ( CB_DEBUG === 'true' ) {
             $this->language_debugger_predict_search($theme->tempOut);
        }
    }
    
    private function langReplace($array, &$html) {
        foreach ( $array as $key => $value ) {
            $html = \str_replace( '['.  \strtoupper($key) .']', $value, $html );
        }
/*        foreach ( $array as $key => $value ) {
            $html = \str_replace( ''.  \strtoupper($key) .'', $value, $html );
        } */

        return $html;
    }
    
    protected function cb_load_lang_start() {
        foreach ( $this->loadLangStore as $k=>$v ) {
            $this->cb_load_language($v['module'], $v['isadmin']);
        }
    }

    public function cb_lang_replace_in_text($rawText) {
        if (!empty($this->languageStringStorage)) {
            foreach ($this->languageStringStorage as $ptext => $text) {
                $rawText = \str_replace( '['.  \strtoupper($ptext) .']', $text, $rawText );
            }
        }
        
        if ( CB_DEBUG === 'true' ) {
             $this->language_debugger_predict_search($rawText);
        }
        
        return $rawText;
    }
    
    public function cb_lang_text($text) {
        $textc = strtoupper(cb_remove_space(cb_remove_accent($text)));
        if ( isset($this->languageStringStorage[$textc]) ) {
            return $this->languageStringStorage[$textc];
        }
        
        return $text;
    }
    
    public function cb_lang_defined($text) {
        $textc = strtoupper(cb_remove_space(cb_remove_accent($text)));
        if ( isset($this->languageStringStorage[$textc]) ) {
            return TRUE;
        }
        
        return FALSE;
    }

    private function language_debugger_predict($text) {
        global $module;
        $t = strtolower($text);
        $t = str_replace(['[',']'],['',''],$t);
        if ( substr($t,0,11) === 'lang_admin_' ) {
            $t1 = substr($t,11);
            $a = 1;
        } elseif ( substr($t,0,5) === 'lang_' ) {
            $t1 = substr($t,5);
            $a = 0;
        } else {
            return FALSE;
        }
        $l = $this->getLanguage();
        $m = '';
        foreach ( $module->cb_get_module_name_list(TRUE) as $mn ) {
            $mn_l = strlen($mn);
            if ( substr($t1,0,$mn_l) === $mn && substr($t1,$mn_l,1) === '_' ) {
                $m = $mn;
                $c = substr($t1,$mn_l+1);
                break;
            }
        }
        if ( $m === '' ) { return FALSE; }
        $this->language_debugger_predict_save($t,$a,$l,$m,$c);
    }
    
    private function language_debugger_predict_save($text,$a,$l,$m,$c) {
        global $database;
        
        $test = $database->newQuery()->sSelect('id')->from('#__language')->wAndIsEqual('lang',$l)->wAndIsEqual('is_admin',$a)->wAndIsEqual('module',$m)->wAndIsEqual('constant',$c)->limit('1')->qtype('result')->execute();
        if ( $test ) { return; }
        
        $id = (int) $database->newQuery()->sSelect('id')->from('#__language')->limit('1')->orderDESC('id')->qtype('result')->execute();
        
        $data = [
                "id" => $id+1,
                "lang" => $l,
                "is_admin" => $a,
                "module" => $m,
                "constant" => $c,
                "text" => strtoupper('['.$text.']'),
                "tag" => '',
                "debugger_predicted" => 1,
                "translate_need" => 1
            ];
            
        $database->insertOrUpdate("#__language",$data);
    }
    
    private function language_debugger_predict_search($tempOut) {
        $matchSearch = Array();
        preg_match_all("/\[LANG_.*?\]/i", $tempOut, $matchSearch, PREG_SET_ORDER);
        if ( !empty($matchSearch) ) {
            foreach ( $matchSearch as $m ) {
                $this->language_debugger_predict($m[0]);
            }
        }
    }
}

$lang = new language();
$lang->setAllowedLanguageTypes(CB_LANGTYPE);
$lang->setLanguage();
$lang->setLanguage(NULL,1);
$lang->startLanguageDatabaseStore();

function cb_langdef($WHO, $WHAT) {
    global $lang;
    $lang->cb_lang_define($WHO, $WHAT);
}

function cb_load_lang($module, $isAdmin = FALSE) {
    global $lang;
    
    $lang->setLoadLangStore($module,$isAdmin);
}

function cb_lang_text($text) {
    global $lang;
    return $lang->cb_lang_text($text);
}

function cb_lang_defined($text) {
    global $lang;
    return $lang->cb_lang_defined($text);
}

function cb_lang_replace($text) {
    global $lang;
    return $lang->cb_lang_replace_in_text($text);
}

return;
?>