<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v070
 * @date 27/11/19
 */
require_once( CB_CORE . "/sys.class.theme.ext.php" );
require_once( CB_CORE . "/sys.class.theme.m.native.php" );
require_once( CB_CORE . "/sys.class.theme.m.mustache.php" );
require_once( CB_CORE . "/sys.class.theme.m.twig.php" );

if (!defined('H-KEI')) { exit; }

class theme {
    use theme\extension;
    use theme\native;
    use theme\mustache;
    use theme\twig;
    
    public $theme = CB_THEMESET; //Oldal kinézetének tárolója (útvonal)
    public $admin_theme = CB_ADMIN_THEMESET; //Oldal admin kinézetének tárolója (útvonal)
    public $tempMETADESC = []; //META kereső rövid leírás tárolója
    public $tempMETAKEY = []; //META kereső kulcsok tárolója
    public $tempMETAAUTH = ""; //META szerző tárolója
    private $tempMain = []; //betöltött megjelenési stílusok ármeneti "CACHE" tárolója
    public $inMain = ''; //fő tartalmi rész tartalmi tárolója
    public $tempOut = ''; //kimeneti puffer
    
    private $bodyClass = []; //oldal HTML BODY elem class (osztály) elnevezések / meghívás addBodyClass($osztály)
    public $activeThemePath = ""; //jelenlegi theme teljes útvonala
    private $themeStyle = ""; //jelenlegi theme stílusa
    private $themeStyleForced = FALSE;
    
    
    private $loadedTemplateJsVar = []; //betöltött JS fájlok átmeneti tárolója (ne töltsön be mégegyszer az adott fájlami már egyszer beolvasásra került)
    private $loadedTemplateCssVar = []; //betöltött CSS fájlok átmeneti tárolója (ne töltsön be mégegyszer az adott fájlami már egyszer beolvasásra került)
    
    public $contentTitle = ""; //a weboldal tartalom címe
    public $contentLogoReplace = ""; //a weboldal logójának cseréje (ha van tartalomnak saját logója)

    private $contentCss = []; //betöltendő CSS fájlok tárolója
    private $contentJs = []; //betöltendő JS fáljok tárolója (headerbe kerül)
    private $contentEndJs = []; //betöltendő JS fáljok tárolója (body végébe kerül)

    private $textCss = []; //a weboldal stílus egyedi CSS (nem fájlban, szövegként)
    private $textJs = []; //a weboldal stílus egyedi JS (nem fájlban, szövegként)
    private $textEndJs = []; //a weboldal stílus egyedi JS (nem fájlban, szövegként)


    function __construct() {
    }

    public function init() {
        $this->tempMETAAUTH = CB_META_DEF_AUTH;
        $this->tempMETAKEY[] = CB_META_DEF_KEY;
        $this->tempMETADESC[] = CB_META_DEF_DESC;
    }

    public function themeModuleReplace(&$tempOut, $matchSearch = NULL, $admin = FALSE) {
        global $module;

        if ($matchSearch === NULL) { $matchSearch = $this->themeModuleReplace_pregMatchAll($tempOut, $admin); }

        if (!empty($matchSearch)) {
            foreach ($matchSearch as $matchValue) {
                if (!isset($matchValue[3])) {
                    $matchValue[3] = NULL;
                } else {
                    $this->themeModuleReplace_jsonlikeDecode($matchValue[3]);
                }
                $module->loadFunctionCallForm = $matchValue[0];
                if ( $admin === TRUE ) {
                    $funct = $module->loadAdminFunction($matchValue[1], $matchValue[2], $matchValue[3]);
                } else {
                    $funct = $module->loadFunction($matchValue[1], $matchValue[2], $matchValue[3]);
                }
                $tempOut = str_replace($matchValue[0], $funct, $tempOut);
            }

            $matchSearch = $this->themeModuleReplace_pregMatchAll($tempOut, $admin);

            if (!empty($matchSearch)) {
                $this->themeModuleReplace($tempOut, $matchSearch, $admin);
            }
        }
    }

    private function themeModuleReplace_pregMatchAll(&$tempOut, $admin = FALSE) {
        $matchSearch = Array();
        if ( $admin === TRUE ) {
            preg_match_all("/<textarea[^>]*>.*?<\/textarea\s*>(*SKIP)(*FAIL)|{#ADMIN,(.[^,}{]*),(.[^,}{]*),?(.[^,}{]*)?}/i", $tempOut, $matchSearch, PREG_SET_ORDER);
        } else {
            preg_match_all("/<textarea[^>]*>.*?<\/textarea\s*>(*SKIP)(*FAIL)|\{#MODULE,(.[^,}{]*),(.[^,}{]*),?(.[^,}{]*|\[\{[.\"\'a-zA-Z0-9,:\.\*]*\}\]|\{[.\"\'a-zA-Z0-9,:\.\*]*\})?\}/i", $tempOut, $matchSearch, PREG_SET_ORDER);
        }
        return $matchSearch;
    }

    private function themeModuleReplace_jsonlikeDecode(&$value) {
        if ( strpos($value,'[') === FALSE || strpos($value,']') === FALSE || strpos($value,':') === FALSE ) {
            return FALSE;
        } else {
            $value = json_decode(cb_transform_jsonlike_to_json($value),true);
            return TRUE;
        }
    }
    
    public function loadPageTheme($theme = NULL, $themeStyle = NULL, $force = FALSE) {
        global $user;

        if ( $this->themeStyleForced === TRUE ) { return; }

        if (empty($theme) || $theme === NULL) { $theme = $this->theme; }
        if (empty($themeStyle) || $themeStyle === NULL) { $themeStyle = 'main'; }

        $this->theme = $theme;
        $this->themeStyle = $themeStyle = strtolower($themeStyle);

        $this->activeThemePath = $path = CB_THEME . "/" . $theme . "/";
        $filename = $themeStyle . ".mustache";


        if ( $user->cb_is_admin_territory() === TRUE ) {
            $adminThemePath = $path = CB_ADMIN . "/theme/" . $theme . "/";
            $this->activeThemePath = $path = $adminThemePath;
            $filename = "login.mustache";
            if (file_exists( $adminThemePath . $themeStyle . ".mustache") && $user->cb_is_admin_access() === TRUE) {
                $this->theme = $theme;
                $filename = $themeStyle . ".mustache";
            }
        }

        if ( !file_exists($path . $filename)) { return $this->loadPageTheme_old($theme, $themeStyle, $force); }

        $raw = [
            "template" => "",
            "css" => [],
            "js" => [],
            "jsend" => [],
            "bodyclass" => [],
            "load" => [],
        ];

        $c = file_get_contents($path . $filename);
        $this->loadTemplate_to_raw2($c, $raw, $path.$filename);

        $this->tempMain[strtoupper($themeStyle)] = $raw['template'];

        if (!empty($raw['css'])) { foreach ($raw['css'] as $val) { $this->addContentCss($val,NULL,$user->cb_is_admin_territory()); } }
        if (!empty($raw['js'])) { foreach ($raw['js'] as $val) { $this->addContentJs($val,NULL,$user->cb_is_admin_territory()); } }
        if (!empty($raw['jsend'])) { foreach ($raw['jsend'] as $val) { $this->addContentEndJs($val,NULL,$user->cb_is_admin_territory()); } }

        if (!empty($raw['bodyclass'])) { foreach ($raw['bodyclass'] as $class) { $this->addBodyClass($class); } }
        if (!empty($raw['load'])) { foreach ($raw['load'] as $load) { $this->$load(); } }
        
        if ( $force === TRUE ) { $this->themeStyleForced = TRUE; }
    }

    private function loadPageTheme_old($theme = NULL, $themeStyle = NULL, $force = FALSE) {
        global $user;

        if ( $this->themeStyleForced === TRUE ) { return; }

        if (empty($theme) || $theme === NULL) { $theme = $this->theme; }
        if (empty($themeStyle) || $themeStyle === NULL) { $themeStyle = 'main'; }

        $this->theme = $theme;
        $this->themeStyle = strtoupper($themeStyle);

        $this->activeThemePath = CB_THEME . "/" . $theme . "/";
        $filename = strtolower($themeStyle) . ".php";
        
        if ( $user->cb_is_admin_territory() === TRUE ) {
            $adminThemePath = CB_ADMIN . "/theme/" . $theme . "/";
            $this->activeThemePath = $adminThemePath;
            $filename = "login.php";
            if (file_exists( $adminThemePath . $themeStyle . ".php") && $user->cb_is_admin_access() === TRUE) {
                $this->theme = $theme;
                $filename = $themeStyle . ".php";
            }
        }

        require($this->activeThemePath . $filename);
        
        $this->tempMain[strtoupper($themeStyle)] = $THEMEBODY;

        if (isset($CSS)) { foreach ($CSS as $val) { $this->addContentCss($val,NULL,$user->cb_is_admin_territory()); } }
        if (isset($JS)) { foreach ($JS as $val) { $this->addContentJs($val,NULL,$user->cb_is_admin_territory()); } }
        if (isset($JSEND)) { foreach ($JSEND as $val) { $this->addContentEndJs($val,NULL,$user->cb_is_admin_territory()); } }
        if ( $force === TRUE ) { $this->themeStyleForced = TRUE; }
    }

    
    public function loadTemplateJs($name, $module = NULL, $typeAdmin = FALSE) {
        $templatePath = [];
        $this->loadTemplateJs_path($module,$typeAdmin,$templatePath);
        
        if ($module) { $name2 = $module.'_'.$name; } else { $name2 = $name; }
        if ($typeAdmin) { $name3 = $name2 . "_adm"; } else { $name3 = $name2 . "_mod"; }

        if (!isset($this->loadedTemplateJsVar[$name3])) {
            $filename = $name . ".js";
            
            $js_fail = TRUE;
            
            // Main feldolgozás
            foreach ($templatePath as $path) {
                if (file_exists($path . $filename)) {
                    $js_fail = FALSE;
                    $raw = file_get_contents($path . $filename);
                    break;
                } else {
                    continue;
                }
            }

            if ( $js_fail === TRUE) {
                cb_error_log("Fatal ERROR: Not Exist Javascript file! ".$module.' '.$filename);
                die("Fatal ERROR: Not Exist Javasctipt file! ".$module.' '.$filename);
            }

            $this->loadedTemplateJsVar[$name3] = $raw;
        }
        
        return $this->loadedTemplateJsVar[$name3];
    }

    public function loadTemplateCss($name, $module = NULL, $typeAdmin = FALSE) {
        $templatePath = [];
        $this->loadTemplateCss_path($module,$typeAdmin,$templatePath);
        
        if ($module) { $name2 = $module.'_'.$name; } else { $name2 = $name; }
        if ($typeAdmin) { $name3 = $name2 . "_adm"; } else { $name3 = $name2 . "_mod"; }

        if (!isset($this->loadedTemplateCssVar[$name3])) {
            $filename = $name . ".css";
            
            $js_fail = TRUE;
            
            // Main feldolgozás
            foreach ($templatePath as $path) {
                if (file_exists($path . $filename)) {
                    $js_fail = FALSE;
                    $raw = file_get_contents($path . $filename);
                    break;
                } else {
                    continue;
                }
            }

            if ( $js_fail === TRUE) {
                cb_error_log("Fatal ERROR: Not Exist Css file! ".$module.' '.$filename);
                die("Fatal ERROR: Not Exist Css file! ".$module.' '.$filename);
            }

            $this->loadedTemplateCssVar[$name3] = $raw;
        }
        
        return $this->loadedTemplateCssVar[$name3];
    }
    
    private function loadTemplate_path($module,$typeAdmin,&$templatePath) {
        if ( $typeAdmin === TRUE ) {
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/template/" . $module . "/"; }
            $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/template/";
            $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/";
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "-self/template/"; }
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "/template/"; }
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/theme/_template/" . $module . "/"; }
            $templatePath[] = CB_ADMIN . "/theme/_template/";
            $templatePath[] = CB_THEME . "/_template/";
        } else {
            if (!empty($module)) { $templatePath[] = CB_THEME . "/" . $this->theme . "/template/" . $module . "/"; }
            $templatePath[] = CB_THEME . "/" . $this->theme . "/template/";
            $templatePath[] = CB_THEME . "/" . $this->theme . "/";
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "-self/template/"; }
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "/template/"; }
            if (!empty($module)) { $templatePath[] = CB_THEME . "/_template/" . $module . "/"; }
            $templatePath[] = CB_THEME . "/_template/";
        }
    }

    private function loadTemplateJs_path($module,$typeAdmin,&$templatePath) {
        if ( $typeAdmin === TRUE ) {
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/js/" . $module . "/"; }
            $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/js/";
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "-self/js/"; }
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "/js/"; }
            $templatePath[] = CB_ADMIN . "/theme/_template/js/";
            $templatePath[] = CB_THEME . "/_template/js/";
        } else {
            if (!empty($module)) { $templatePath[] = CB_THEME . "/" . $this->theme . "/js/" . $module . "/"; }
            $templatePath[] = CB_THEME . "/" . $this->theme . "/js/";
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "-self/js/"; }
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "/js/"; }
            $templatePath[] = CB_THEME . "/_template/js/";
        }
    }

    private function loadTemplateCss_path($module,$typeAdmin,&$templatePath) {
        if ( $typeAdmin === TRUE ) {
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/css/" . $module . "/"; }
            $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/css/";
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "-self/css/"; }
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "/css/"; }
            $templatePath[] = CB_ADMIN . "/theme/_template/css/";
            $templatePath[] = CB_THEME . "/_template/css/";
        } else {
            if (!empty($module)) { $templatePath[] = CB_THEME . "/" . $this->theme . "/css/" . $module . "/"; }
            $templatePath[] = CB_THEME . "/" . $this->theme . "/css/";
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "-self/css/"; }
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "/css/"; }
            $templatePath[] = CB_THEME . "/_template/css/";
        }
    }

    private function loadTemplateTL_path($module,$typeAdmin,&$templatePath) {
        if ( $typeAdmin === TRUE ) {
            $templatePath[] = CB_THEME . "/_template/";
            $templatePath[] = CB_ADMIN . "/theme/_template/";
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "/"; }
            if (!empty($module)) { $templatePath[] = CB_ADMIN . "/module/" . $module . "-self/"; }
            $templatePath[] = CB_ADMIN . "/theme/" . $this->admin_theme . "/";
        } else {
            $templatePath[] = CB_THEME . "/_template/";
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "/"; }
            if (!empty($module)) { $templatePath[] = CB_MODULE . "/" . $module . "-self/"; }
            $templatePath[] = CB_THEME . "/" . $this->theme . "/";
        }
    }
    
    private function loadTemplate_to_raw2($template, &$raw, $debugFilename) {
        if ( empty($template) ) { return NULL; }

        $templateLined = explode(PHP_EOL,$template);

        $titleRowState = FALSE;
        $titleRow = [];

        foreach ( $templateLined as $k=>$v ) {
            $v = trim($v);
            if ( $titleRowState === FALSE && strtolower($v) !== '{#' ) { break; }
            unset($templateLined[$k]);
            $titleRowState = TRUE;
            if ( strtolower($v) === '{#' ) { continue; }
            if ( strtolower($v) === '#}' ) { break; }
            $titleRow[] = $v;
        }

        $raw['template'] = implode(PHP_EOL,$templateLined);

        if ( empty($titleRow) ) { return TRUE; }

        $i = 1;
        foreach ( $titleRow as $tr ) {
            $a = explode(':',$tr,2);
            if ( !isset($a[1]) ) { cb_error_log("Error_in_template_file: ".$debugFilename." (#$i) ".$tr);continue; }
            $i++;
            $e = strtolower(trim($a[0]));
            $c = trim($a[1]);
            if ( $e === 'title' ) { $raw['title'] = $c; }
            elseif ( $e === 'css' ) { $raw['css'][] = $c; }
            elseif ( $e === 'js' ) { $raw['js'][] = $c; }
            elseif ( $e === 'jsend' ) { $raw['jsend'][] = $c; }
            elseif ( $e === 'bodyclass' ) { $raw['bodyclass'][] = $c; }
            elseif ( $e === 'load' ) { $raw['load'][] = $c; }
        }

        return TRUE;
    }
    
    
    public function metaAuth() {
        $html = "";
        if (!empty($this->tempMETAAUTH)) {
            $html = "<meta name='author' content='" . $this->tempMETAAUTH . "' />";
        }
        return $html;
    }

    public function metaKey() {
        $html = "";
        if (!empty($this->tempMETAKEY)) {
            $meta = "";
            foreach ($this->tempMETAKEY as $val) {
                if (!empty($meta)) {
                    $meta .= ",";
                }
                $meta .= $val;
            }
            $html .= "<meta name='keywords' content='" . $meta . "' />";
        }
        return $html;
    }

    public function metaDesc() {
        $html = "";
        if (!empty($this->tempMETADESC)) {
            $meta = "";
            foreach ($this->tempMETADESC as $val) {
                if (!empty($meta)) {
                    $meta .= " - ";
                }
                $meta .= $val;
            }
            $html .= "<meta name='description' content='" . $meta . "' />";
        }
        return $html;
    }

    public function addBodyClass($class) {
        $class2 = trim($class);
        $this->bodyClass[md5($class2)] = $class2;

        return TRUE;
    }

    private function getBodyClass() {
        $ret = "";

        if (!empty($this->bodyClass)) {
            foreach ($this->bodyClass as $value) {
                $ret .= $value . " ";
            }
        }

        return $ret;
    }

    private function getAdminBar() {
        global $module;

        $html = "";
        if ( $module->cb_check_access('admin','headerbar') ) {
            $html = $module->loadFunction('admin','headerbar');
        }

        return $html;
    }

    public function buildPage() {
        global $user, $lang;

        $replace = Array(
            'THEMEMAIN' => $this->tempMain[strtoupper($this->themeStyle)],
            'PAGETITLE' => $this->buildPageTitle(),
            'SITETITLE' => CB_SITETITLE,
            'CONTENTTITLE' => $this->contentTitle,
            'MAIN' => $this->inMain
        );

        $typeAdmin = FALSE;
        if ( $user->cb_is_admin_territory() ) { $typeAdmin = TRUE; }
        $html_head = $this->loadTemplate2("sys_html_head",FALSE,NULL,$typeAdmin);
        $html_body_head = $this->loadTemplate2("sys_html_body_head",FALSE,NULL,$typeAdmin);
        $html_body_content = $this->loadTemplate2("sys_html_body_content",FALSE,NULL,$typeAdmin);
        $html_body_foot = $this->loadTemplate2("sys_html_body_foot",FALSE,NULL,$typeAdmin);
        $html_foot = $this->loadTemplate2("sys_html_foot",FALSE,NULL,$typeAdmin);

        $html = $html_head . $html_body_head . $html_body_content . $html_body_foot . $html_foot;

        $this->replace($replace, $html);

        if ( $user->cb_is_admin_access_and_territory() ) {
            $this->pageAdminTitleAndPathReplace($html);
        }

        $this->tempOut = $html;

        $this->themeModuleReplace($this->tempOut,NULL);
        $this->themeModuleReplace($this->tempOut,NULL,TRUE);
        //$this->themeAdminModuleReplace();
        $this->addContentEndJs('cookie.js');
        
        $replace2 = array(
            'IS_ADMIN_BAR' => $this->getAdminBar(),
            'LOADMETA' => $this->loadSystemMeta(),
            'LOADSHE' => $this->loadSystemHeadElements(),
            'LOADSEE' => $this->loadSystemEndElements(),
            'BODYCLASS' => $this->getBodyClass(),
            'LANG' => $lang->getLanguage(),
            'GOOGLE_ANALYTICS' => $this->loadGoogleAnalytics(),
        );

        $this->replace($replace2, $this->tempOut);

    }

    private function pageAdminTitleAndPathReplace(&$html) {
        global $get;

        $p = strtoupper($get['admin']);
        $admintitle = "[LANG_ADMIN_".$p."_MAIN_TNAME]";
        $adminsubtitle = "";
        if ( $get['funct'] !== 'main' ) {
            $f = strtoupper($get['funct']);
            $adminsubtitle = "[LANG_ADMIN_".$p."_".$f."_TNAME]";
        }

        $replace = Array(
            'ADMINTITLE' => $admintitle,
            'ADMINSUBTITLE' => $adminsubtitle,
        );

        $this->replace($replace, $html);
    }

    private function loadSystemMeta() {
        $html = "";

        $html .= $this->metaAuth();
        $html .= $this->metaDesc();
        $html .= $this->metaKey();

        return $html;
    }

    private function loadSystemHeadElements() {
        $html = "";

        $html .= $this->loadSystemHeadExtensionElements();
        $html .= $this->loadSystemHeadPluginElements();

        return $html;
    }

    private function loadSystemHeadPluginElements() {
        $html = "";
        if ( !empty($this->contentJs) ) {
            foreach ( $this->contentJs as $val ) {
                $html .= "<script type='text/javascript' src='" . $val . "'></script>\r\n";
            }
        }
        if (!empty($this->textJs)) {
            foreach ($this->textJs as $val) {
                $html .= '<script>'.$val.'</script>';
            }
        }
        if (!empty($this->contentCss)) {
            foreach ( $this->contentCss as $val ) {
                $html .= "<link type='text/css' href='" . $val . "' rel='stylesheet' />\r\n";
            }
        }
        if (!empty($this->textCss)) {
            foreach ($this->textCss as $val) {
                $html .= '<style type="text/css">'.$val.'</style>';
            }
        }
        return $html;
    }

    private function loadSystemEndElements() {
        $html = "";

        if ( !empty($this->contentLogoReplace) ) {
            $html .= "<script>jQuery('.cbPageLogo').css('background-image','url(".$this->contentLogoReplace.")');</script>\r\n";
        }
        $html .= $this->loadSystemEndExtensionElements();
        if ( !empty($this->contentEndJs) ) {
            foreach ( $this->contentEndJs as $val ) {
                $html .= "<script type='text/javascript' src='" . $val . "'></script>\r\n";
            }
        }
        if (!empty($this->textEndJs)) {
            foreach ($this->textEndJs as $val) {
                $html .= '<script>'.$val.'</script>';
            }
        }
        return $html;
    }

    private function buildPageTitle() {
        global $user;

        if ( $user->cb_is_admin_access_and_territory() && empty($this->contentTitle) ) { // admin terület esetén a cím
            global $get;

            $p = strtoupper($get['admin']);
            $title2 = "[LANG_ADMIN_".$p."_MAIN_TNAME]";
            if ( $get['funct'] !== 'main' ) {
                $f = strtoupper($get['funct']);
                $title2 .= " - [LANG_ADMIN_".$p."_".$f."_TNAME]";
            }

            $title = CB_SITETITLE . " - " . $title2;
        } elseif (CB_PAGETITLE_STYLE == 1 && !empty($this->contentTitle)) { // "{weboldalcím} - {tartalomcím}" elrendezés
            $title = CB_SITETITLE . " - " . $this->contentTitle;
        } elseif (CB_PAGETITLE_STYLE == 2 && !empty($this->contentTitle)) { // "{tartalomcím} - {weboldalcím}" elrendezés
            $title = $this->contentTitle . " - " . CB_SITETITLE;
        } elseif (CB_PAGETITLE_STYLE == 3 && !empty($this->contentTitle)) { // "{tartalomcím}" elrendezés
            $title = $this->contentTitle;
        } elseif (CB_PAGETITLE_STYLE == 4) { // "{weboldalcím}" elrendezés
            $title = CB_SITETITLE;
        } else { // alapértelmezett "{weboldalcím}" elrendezés
            $title = CB_SITETITLE;
        }

        return $title;
    }

    public function addContentCss($val,$mod=NULL,$admin=FALSE) {
        $templatePath = [];
        $this->loadTemplateTL_path($mod,$admin,$templatePath);
        if ( substr($val, 0, 7 ) === 'http://' || substr($val, 0, 8 ) === 'https://' ) {
                $i = crc32($val);
                $this->contentCss[$i] = $val;
        } else {
            foreach ($templatePath as $path) {
                $pathval = $path . "css/" . $val;
                if (file_exists($pathval)) {
                    $i = crc32(CB_URI.$pathval);
                    $this->contentCss[$i] = CB_URI.$pathval;
                }
            }
        }
    }

    public function addContentJs($val,$mod=NULL,$admin=FALSE) {
        $templatePath = [];
        $this->loadTemplateTL_path($mod,$admin,$templatePath);
        if ( substr($val, 0, 7 ) === 'http://' || substr($val, 0, 8 ) === 'https://' ) {
            $i = crc32($val);
            $this->contentJs[$i] = $val;
        } else {
            foreach ($templatePath as $path) {
                $pathval = $path . "js/" . $val;
                if (file_exists($pathval)) {
                    $i = crc32(CB_URI.$pathval);
                    $this->contentJs[$i] = CB_URI.$pathval;
                }
            }
        }
    }

    public function addContentEndJs($val,$mod=NULL,$admin=FALSE) {
        $templatePath = [];
        $this->loadTemplateTL_path($mod,$admin,$templatePath);
        if ( substr($val, 0, 7 ) === 'http://' || substr($val, 0, 8 ) === 'https://' ) {
            $i = crc32($val);
            $this->contentEndJs[$i] = $val;
        } else {
            foreach ($templatePath as $path) {
                $pathval = $path . "js/" . $val;
                if (file_exists($pathval)) {
                    $i = crc32(CB_URI.$pathval);
                    $this->contentEndJs[$i] = CB_URI.$pathval;
                }
            }
        }
    }

    public function addTextCss($cssText) {
        $i = crc32($cssText);
        $this->textCss[$i] = $cssText;
    }

    public function addTextJs($jsText) {
        $i = crc32($jsText);
        $this->textJs[$i] = $jsText;
    }

    public function addTextEndJs($jsText) {
        $i = crc32($jsText);
        $this->textEndJs[$i] = $jsText;
    }
}

return;
?>
