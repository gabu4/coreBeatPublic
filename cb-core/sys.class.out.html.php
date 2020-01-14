<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v055
 * @date 20/10/19
 */
if (!defined('H-KEI')) {
    exit;
}

class out_html {

    private $contentData = array(); //aktuális oldal tartalom tároló
    private $isSeo = FALSE;
    private $seo = "";
    private $seoLanguage = "";
    
    //inicializáció
    public function __construct() {
        $this->checkSeo();
        $this->languageSetup();
    }
    
    public function getContentData() {
        return $this->contentData;
    }
    
    private function checkSeo() {
        global $get, $lang;
        
        if (( CB_IS_SEO !== 'true' ) || !isset($get['seo']) || empty($get['seo'])) { return FALSE; }
        
        $this->isSeo = TRUE;
        $seo = $this->seo = $get['seo'];
        
        $seoPart = explode('/', mb_strtolower($seo, 'UTF-8'), 2);
        
        $language = $lang->getLanguage();
        
        if ( isset($seoPart[1]) && in_array($seoPart[0], $lang->getAllowedLanguageTypes()) ) {
            $this->seoLanguage = $language = $get['lang'] = $seoPart[0];
            $lang->setLanguage($language);
            $this->seo = $seoPart[1];
        } elseif ( strlen($seo) == 2 && in_array($seo, $lang->getAllowedLanguageTypes())) {
            $this->seoLanguage = $language = $get['lang'] = $seo;
            $lang->setLanguage($language);
            $this->seo = $seo = "";
        }
        
        return TRUE;
    }
    
    private function languageSetup() {
        global $get, $lang;
        
        if (isset($get['lang']) and ! empty($get['lang'])) {
            $get['lang'] = mb_strtolower(trim($get['lang']), 'UTF-8');
            if (in_array($get['lang'], $lang->getAllowedLanguageTypes())) {
                $language = $get['lang'];
                $lang->setLanguage($language);
            }
        }
    }

    /* SEO URL felbontás és elemzés, $_GET tagok beállítása találat alapján
      $seo - oldal seo url tagjának vége

     */

    private function dataSet_bySeo() {
        global $lang, $database;
        
        $language = $this->seoLanguage;
        $seo = $this->seo;
        
        if ( empty($seo) ) { return FALSE; }
        
        $contentData = $database->newQuery()
                                ->select("`c`.`id`,`c`.`value`,`ct`.`module`,`ct`.`type`,`c`.`lang`")
                                ->from("`#__content_seo` `c`")
                                ->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`")
                                ->where("`c`.`seo_name` = '" . $seo . "' AND `c`.`lang` = '" . $language . "' ")
                                ->qType("row")
                                ->execute();
        
        if (!empty($contentData)) {
            $this->contentData['id'] = $contentData['id'];
            $this->contentData['value'] = json_decode($contentData['value'],true);
            $this->contentData['module'] = $contentData['module'];
            $this->contentData['type'] = $contentData['type'];
            $lang->setLanguage($contentData['lang']);
            return TRUE;
        }
        
        $contentData = $database->newQuery()
                                ->select("`c`.`id`,`c`.`value`,`ct`.`module`,`ct`.`type`,`c`.`lang`")
                                ->from("`#__content` `c`")
                                ->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`")
                                ->where("`c`.`seo_name` = '" . $seo . "' AND `c`.`lang` = '" . $language . "' ")
                                ->qType("row")
                                ->execute();
        
        if (!empty($contentData)) {
            $this->contentData['id'] = $contentData['id'];
            $this->contentData['value'] = json_decode($contentData['value'],true);
            $this->contentData['module'] = $contentData['module'];
            $this->contentData['type'] = $contentData['type'];
            $lang->setLanguage($contentData['lang']);
            return TRUE;
        }
        
        $contentData = $database->newQuery()
                                ->select("`c`.`id`,`c`.`value`,`ct`.`module`,`ct`.`type`,`c`.`lang`")
                                ->from("`#__content_seo` `c`")
                                ->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`")
                                ->where("`c`.`seo_name` = '" . $seo . "' ")
                                ->qType("row")
                                ->execute();
        
        if (!empty($contentData)) {
            $this->contentData['id'] = $contentData['id'];
            $this->contentData['value'] = json_decode($contentData['value'],true);
            $this->contentData['module'] = $contentData['module'];
            $this->contentData['type'] = $contentData['type'];
            $lang->setLanguage($contentData['lang']);
            return TRUE;
        }
        
        $contentData = $database->newQuery()
                                ->select("`c`.`id`,`c`.`value`,`ct`.`module`,`ct`.`type`,`c`.`lang`")
                                ->from("`#__content` `c`")
                                ->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`")
                                ->where("`c`.`seo_name` = '" . $seo . "' ")
                                ->qType("row")
                                ->execute();
        
        if (!empty($contentData)) {
            $this->contentData['id'] = $contentData['id'];
            $this->contentData['value'] = json_decode($contentData['value'],true);
            $this->contentData['module'] = $contentData['module'];
            $this->contentData['type'] = $contentData['type'];
            $lang->setLanguage($contentData['lang']);
            return TRUE;
        }
        
        return FALSE;
    }

    private function dataSet_byId($id) {
        global $database, $lang;

        $contentData = $database->newQuery()
                                ->select("`c`.`id`,`c`.`value`,`ct`.`module`,`ct`.`type`,`c`.`lang`")
                                ->from("`#__content` `c`")
                                ->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`")
                                ->where("`c`.`id` = '" . $id . "' ")
                                ->qType("row")
                                ->execute();

        if (!empty($contentData)) {
            $this->contentData['id'] = $contentData['id'];
            $this->contentData['value'] = json_decode($contentData['value'],true);
            $this->contentData['module'] = $contentData['module'];
            $this->contentData['type'] = $contentData['type'];
            $lang->setLanguage($contentData['lang']);
            return TRUE;
        }

        return FALSE;
    }
    
    private function dataSet_byArticleId($id,$article_language = NULL) {
        global $database, $lang;

        if ( $article_language === NULL ) {
            $article_language = $lang->getLanguage();
        }
        
        $articleData = $database->newQuery()
                                ->select("`article_id`,`lang`")
                                ->from("`#__article`")
                                ->where("`article_id` = '" . $id . "' AND `lang` = '" . $article_language . "' AND `state` = 1 ")
                                ->limit("1")
                                ->order("`version` DESC")
                                ->qType("row")
                                ->execute();

        if (!empty($articleData)) {
            $this->contentData['id'] = 0;
            $this->contentData['module'] = 'article';
            $this->contentData['type'] = 'article_id';
            $this->contentData['value'] = json_decode('{"id":"'.$id.'","language":"'.$article_language.'"}',true);
            $lang->setLanguage($articleData['lang']);
            return TRUE;
        }

        return FALSE;
    }

    private function dataSet_byModule() {
        global $module, $get, $lang;
        if (
                isset($get['mod']) and ! empty($get['mod']) and
                isset($get['funct']) and ! empty($get['funct'])) {

            $mod = strtolower(trim($get['mod']));
            $funct = strtolower(trim($get['funct']));
            if ($module->cb_check_access($mod, $funct)) {
                $this->contentData['module'] = $mod;
                $this->contentData['type'] = $funct;
                $this->contentData['id'] = 0;
                $this->contentData['value'] = NULL;
                return TRUE;
            }
        }
        
        return FALSE;
    }

    private function dataSet_contentStart() {
        global $module;

        if (!empty($this->contentData)) {
            $html = $module->loadFunction($this->contentData['module'], $this->contentData['type'], $this->contentData['value'], TRUE);
            
            if ( $html === FALSE ) { $html = $this->loadErrorPage403(); }
            return $html;
        } else {
            return $this->loadErrorPage404();
        }
    }

    private function dataSet_admin() {
        global $module, $theme, $get, $user, $lang;
        
        if ( $user->cb_is_admin_access_and_territory() === true ) {
            $lang->setLanguage(NULL,TRUE);
            $get['admin'] = trim($get['admin']);
            if (empty($get['admin'])) {
                $get['admin'] = 'admin';
            }
            if (!isset($get['funct']) OR empty($get['funct'])) {
                $get['funct'] = 'main';
            } else {
                $get['funct'] = trim($get['funct']);
            }
            $get['set'] = ( isset($get['set']) ) ? $get['set'] : NULL;

            $theme->addContentCss("icon.css",NULL,TRUE);
            
            $theme->theme = CB_ADMIN_THEMESET;
            
            $userDataExtra = $user->cb_get_user_data_extra($user->cb_get_user_id());
            if ( isset($userDataExtra['admin_theme_style']) && !empty($userDataExtra['admin_theme_style']) ) {
                define('CB_ADMIN_THEMESET_COLOR_CUSTOM',$userDataExtra['admin_theme_style']);
            }
            
            if (($get['admin'] !== 'admin') || ( ($get['admin'] === 'admin') /* && $get['funct'] !== 'main' */ )) {
                $ok = $module->loadAdminFunction($get['admin'], $get['funct'], NULL, TRUE);
                
                if ( $ok ) {
                    $theme->inMain = $ok;
                } else {
                    $theme->inMain = 'Nem létező, vagy elkészült funkció lett meghívva! :-( <i><b>'. $get['admin'] . ' ' . $get['funct'] . '</b></i>';
                }
            } else {
                $this->loadErrorPage403();
            }
            
            return true;
        } elseif ( $user->cb_is_admin_territory() && ( $user->cb_get_user_id() > 0 ) && $user->cb_is_admin_access() === FALSE ) {
            $lang->setLanguage(NULL,TRUE);
            $theme->theme = CB_ADMIN_THEMESET;
            return 'NO_ACCESS';
        } elseif ( $user->cb_is_admin_territory() && ( $user->cb_get_user_id() === 0 ) ) {
            $lang->setLanguage(NULL,TRUE);
            $theme->theme = CB_ADMIN_THEMESET;
            return 'NO_LOGIN';
        }

        return false;
    }

    public function loadStart() {
        global $theme, $get, $lang;
        
        $lang->setLanguage();
        $ret = $this->dataSet_admin();
        if ($ret == true) {
            return;
        } else if ($ret == 'NO_ACCESS') {
            $theme->inMain = $this->loadErrorPage403();
            return;
        } else if ($ret == 'NO_LOGIN') {
            $theme->inMain = $theme->loadAdminTemplate('login');
            return;
        }
        
        $contentLoad = FALSE;

        if ( $this->isSeo ) {
            $t = $this->dataSet_bySeo();
            if ( !empty($this->contentData) ) {
                $contentLoad = TRUE;
            }
        }

        if (empty($this->contentData) and isset($get['c']) and ! empty($get['c']) and is_numeric($get['c'])) {
            $this->dataSet_byId($get['c']);
            if ( !empty($this->contentData) ) {
                $contentLoad = TRUE;
            }
        }
        
        if (empty($this->contentData) and isset($get['a']) and ! empty($get['a']) and is_numeric($get['a'])) {
            $this->dataSet_byArticleId($get['a']);
            if ( !empty($this->contentData) ) {
                $contentLoad = TRUE;
            }
        }
        
        if (empty($this->contentData) and ( isset($get['mod']) and ! empty($get['mod']) and isset($get['funct']) and ! empty($get['funct']) )) {
            $r = $this->dataSet_byModule();
            if ( !empty($this->contentData) ) {
                $contentLoad = TRUE;
            } elseif ( $r === FALSE ) {
                $theme->inMain = $this->loadErrorPage403();
                return;
            }
        }
        
        if ( empty($this->contentData) && ( !isset($get['c']) || empty($get['c']) ) && ( !isset($get['a']) || empty($get['a']) ) && ( !isset($get['mod']) || empty($get['mod']) ) && empty($this->seo) ) {
            $this->loadDefaultContent();
            $contentLoad = TRUE;
        }
        
        if ( $contentLoad == FALSE && CB_ERROR404_LOAD_MAINPAGE === 'true' ) {
            $this->loadErrorPage404_mainpage();
        } elseif ( $contentLoad == FALSE ) {
            $theme->inMain = $this->loadErrorPage404();
            return;
        }

        $theme->inMain = $this->dataSet_contentStart();
        return;
    }

    public function loadDefaultContent() {
        global $lang, $database;
        
        $def_pageId = CB_DEF_PAGE;
        
        $database->newQuery();
        $database->select("`content_id`");
        $database->from("`#__menu`");
        $database->where("`lang` = '" . $lang->getLanguage() . "' AND `default_load` = '1'");
        $database->qType("result");
        $d = $database->execute();
        
        if ( $d ) {
            $def_pageId = $d;
        }

        $this->dataSet_byId($def_pageId);
    }
    
    public function loadErrorPage429() {
        global $theme, $lang;
        
        $this->languageSetup();
        $lang->cb_lang_start();
        http_response_code(429);
        print $lang->cb_lang_replace_in_text($theme->loadTemplate2('sys_html_error429',TRUE));exit;
    }

    public function loadErrorPage404() {
        global $theme, $systemlog;
        
        http_response_code(404);
        $systemlog->setLogDisable(TRUE);
        $html = $theme->loadTemplate2('sys_html_error404',TRUE);

        return $html;
    }
    
    public function loadErrorPage404_mainpage() {
        global $lang;
        $l = "";
        if ( $lang->getLanguage() !== $lang->getAllowedLanguageTypes()[0] ) {
            if ( $this->isSeo === TRUE ) {
                $l = $lang->getLanguage();
            } else {
                $l = '?lang='.$lang->getLanguage();
            }
        }
        $this->redirect(CB_HTTPADDRESS."/".$l);
    }

    public function loadErrorPage403() {
        global $theme, $user;
        
        if ( CB_ERROR403_USER_LOGIN === 'true' && $user->cb_get_user_level() === 0 ) {
            http_response_code(403);
            $html = $theme->loadTemplate2('sys_html_error403_login',TRUE);
        } else {
            http_response_code(403);
            $html = $theme->loadTemplate2('sys_html_error403',TRUE);
        }
        
        return $html;
    }
    
    public function loadMaintenancePage() {
        global $theme, $lang;
        
        print $lang->cb_lang_replace_in_text($theme->loadTemplate2('sys_html_maintenance',TRUE));exit;
    }
    
    public function getModuleFuctionName($module,$function,$more = '',$seo_allowed=TRUE) {
        global $database, $lang;
        
        $language = $lang->getLanguage();
        
        $defaultLanguage = $lang->getAllowedLanguageTypes()[0];
        
        $seoName = FALSE;
        
        $link = "";
        if ( CB_IS_SEO === 'true' && $seo_allowed ) {
            
            $database->newQuery();
            $database->select("`c`.`id`,`c`.`seo_name`,`c`.`name_prefix`");
            $database->from("`#__content_seo` `c`");
            $database->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`");
            $database->where("`ct`.`module` = '" . $module . "' AND `ct`.`type` = '" . $function . "' AND `c`.`lang` = '" . $language . "' ");
            $database->qType("row");
            $d = $database->execute();
            
            if ( empty($d) ) {
                $database->newQuery();
                $database->select("`c`.`id`,`c`.`seo_name`,`c`.`name_prefix`");
                $database->from("`#__content` `c`");
                $database->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`");
                $database->where("`ct`.`module` = '" . $module . "' AND `ct`.`type` = '" . $function . "' AND `c`.`lang` = '" . $language . "' ");
                $database->qType("row");
                $d = $database->execute();
            }
            
            if ( !empty($d) ) {
                if ( $language !== $defaultLanguage ) { $link .= $language."/"; }
                if ( !empty($d['name_prefix']) ) { $link .= $d['name_prefix']."/"; }
                $link .= $d['seo_name'];
                $seoName = TRUE;
            }
        }
        
        if ( empty($link)) {
            $link .= CB_INDEX."?mod=".$module."&funct=".$function;
            if ( $language !== $defaultLanguage ) { $link .= "&lang=".$language; }
        }
        
        if ( !empty($more) ) { 
            if ( $seoName === TRUE ) { $link .= "?"; } else { $link .= "&"; }
            $link .= $more;
        }
        
        return $link;
    }
    
    public function getSeoNameFromContentID($contentId) {
        global $database, $lang;
                
        $defaultLanguage = $lang->getAllowedLanguageTypes()[0];
        
        $seoName = FALSE;
        
        $link = "/";
        if ( CB_IS_SEO == 'true' ) {
            
            $database->newQuery();
            $database->select("`c`.`id`,`c`.`seo_name`,`c`.`name_prefix`,`c`.`value`,`c`.`lang`");
            $database->from("`#__content` `c`");
            $database->where("`c`.`id` = '" . $contentId . "' ");
            $database->qType("row");
            $d = $database->execute();
            
            if ( !empty($d) ) {
                if ( $d['lang'] !== $defaultLanguage ) { $link .= $d['lang']."/"; }
                if ( !empty($d['name_prefix']) ) { $link .= $d['name_prefix']."/"; }
                $link .= $d['seo_name'];
                $seoName = TRUE;
            }
        } else {
            $database->newQuery();
            $database->select("`c`.`id`,`c`.`value`,`c`.`lang`,`ct`.`module`,`ct`.`type`");
            $database->from("`#__content` `c`");
            $database->join("left", "`#__content_type` `ct` ON `c`.`type` = `ct`.`id`");
            $database->where("`c`.`id` = '" . $contentId . "' ");
            $database->qType("row");
            $d = $database->execute();
            
            if ( !empty($d) ) {
                if ( $d['lang'] !== $defaultLanguage ) { $link .= $language."/"; }
                if ( !empty($d['name_prefix']) ) { $link .= $d['name_prefix']."/"; }
                
                $link .= CB_INDEX."?mod=".$module."&funct=".$function;
                
                $val = json_decode($d['value'], true);
                foreach ( $val as $k=>$v ) {
                    $link .= "&".$k."=".$v;
                }
                
                if ( $d['lang'] !== $defaultLanguage ) { $link .= "&lang=".$language; }
            }
        }
                
        return $link;
    }
    
    public function printOutContent($content) {
        global $lang;
        $lang->cb_lang_start();
        
        print $lang->cb_lang_replace_in_text($content);exit;
    }
    
    public function printOutAjaxContent($array) {
        global $lang;
        
        if ( !empty($array) && is_array($array) ) {
            $lang->cb_lang_start();
            
            $json = $lang->cb_lang_replace_in_text(json_encode($array));
            
            print $json;exit;
        }
        
    }
    
    /// global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=permission");
    public function redirect($link = NULL) {
        global $systemlog;
        if ( $link === NULL ) { $link = CB_HTTPADDRESS; } else
        if ( $link === TRUE ) { $link = CB_HTTPPAGEADDRESS; }
        $systemlog->saveLogStatus($link);
        header('Location: '.$link);exit;
    }
}

return;
?>