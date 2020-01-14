<?php
namespace theme;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v024
 * @date 20/11/19
 */
if ( !defined('H-KEI') ) { exit; }

trait extension {
    /**
     * Build-in theme replacer, this is a simple replacer, in a string
     * @param array $array $array[$key] = $value<br>$key => Replace WHAT<br>$value => Replace TO
     * @param string $html Replace in this<br>info: no return value, the $html have changing value
     * @return string replaced $html value
     */
    public function replace($array, &$html) {
        foreach ( $array as $key => $value ) {
            $html = \str_replace( '{#'.  \strtoupper($key) .'}', $value, $html );
        }

        return $html;
    }
    
    public function replace2($key, $value, &$html) {
        foreach ( $key as $kk => $kv ) {
            $html = \str_replace( $kv[0], $value[$kk], $html );
        }
        
        return $html;
    }
    
    public function replace3($what, $to, &$html) {
        $html = \str_replace( $what, $to, $html );
        
        return $html;
    }
    
    public function search_pregMatchAll($prefix, $html) {
        $matchSearch = Array();
    //    preg_match_all("/\{#".$prefix.",(.[^,}{]*),?(.[^,}{]*|\[\{[.\"\'a-zA-Z0-9,:\.\*]*\}\]|\{[.\"\'a-zA-Z\x{80c4}-\x{bfc9}0-9,:\\s\.\*]*\})?\}/iu", $html, $matchSearch, PREG_SET_ORDER);
        preg_match_all("/\{#".$prefix.",(.[^,}{]*),(.[^,}{]*),?(.[^,}{]*|\[\{[.\"\'a-zA-Z0-9,:\.\*]*\}\]|\{[.\"\'a-zA-Z0-9,:\.\*]*\})?\}/i", $html, $matchSearch, PREG_SET_ORDER);
        return $matchSearch;
    }
    
    
    
    protected $jquery = FALSE;
    protected $jquery_ui = FALSE;
    protected $bootstrap3 = FALSE; //bootstrap 3.*
    protected $bootstrap4 = FALSE; //bootstrap 4.*
    protected $modernizr = FALSE;
    protected $tinymce = FALSE;
    protected $modalsytem = FALSE;
    protected $momentJs = FALSE;
    protected $inputmask = FALSE;
    protected $fontAwesome = FALSE;
    protected $parallaxbackground = FALSE;
    
    public function loadJquery() { $this->jquery = TRUE; }
    public function is_loadJquery() { return $this->jquery; }
    public function loadJqueryUI() { $this->jquery_ui = TRUE; }
    public function is_loadJqueryUI() { return $this->jquery_ui; }
    
    public function loadBootstrap() { $this->loadBootstrap3(); }
    public function is_loadBootstrap() { return $this->is_loadBootstrap3(); }
    public function loadBootstrap3() { $this->bootstrap3 = TRUE; }
    public function is_loadBootstrap3() { return $this->bootstrap3; }
    public function loadBootstrap4() { $this->bootstrap4 = TRUE; }
    public function is_loadBootstrap4() { return $this->bootstrap4; }
    
    public function loadModernizr() { $this->modernizr = TRUE; }
    public function is_loadModernizr() { return $this->modernizr; }
    public function loadTinymce() { $this->tinymce = TRUE; }
    public function is_loadTinymce() { return $this->tinymce; }
    public function loadMomentJs() { $this->momentJs = TRUE; }
    public function is_loadMomentJs() { return $this->momentJs; }
    public function loadInputmask() { $this->inputmask = TRUE; }
    public function is_loadInputmask() { return $this->inputmask; }
    public function loadFontAwesome() { $this->fontAwesome = TRUE; }
    public function is_loadFontAwesome() { return $this->fontAwesome; }
    
    /**
     * Load system modal windows for AJAX usage, use for this CLASS <b>.modalLink</b>
     */
    public function loadModalSytem() { $this->modalsytem = TRUE; }
    public function is_loadModalSytem() { return $this->modalsytem; }
    
    /**
     * Make parallax background in container use for this CLASS: <b>parallaxBackground</b>
     */
    public function loadParallaxBackground() { $this->parallaxbackground = TRUE; }
    public function is_loadParallaxBackground() { return $this->parallaxbackground; }
    
    protected function loadSystemHeadExtensionElements() {
        $html = "";

        if ($this->jquery == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/components/jquery/jquery.min.js'></script>\r\n";
        }
        if ($this->jquery_ui == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/components/jqueryui/jquery-ui.min.js'></script>\r\n";
            $html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/vendor/components/jqueryui/themes/black-tie/jquery-ui.min.css' rel='stylesheet' />\r\n";
            $html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/vendor/components/jqueryui/themes/black-tie/theme.css' rel='stylesheet' />\r\n";
        }
        if ($this->bootstrap4 == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/twbs/bootstrap/dist/js/bootstrap.min.js'></script>\r\n";
            $html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/vendor/twbs/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' />\r\n";
            //$html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/etc/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' />";
        } elseif ($this->bootstrap3 == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/etc/bootstrap3/js/bootstrap.min.js'></script>\r\n";
            $html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/etc/bootstrap3/css/bootstrap.min.css' rel='stylesheet' />\r\n";
            //$html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/etc/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' />";
        }
        if ($this->modernizr == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/components/modernizr/modernizr.js'></script>\r\n";
        }
        if ($this->tinymce == TRUE) {
            global $lang;
            $cssFile = "" . CB_THEME . "/" . $this->theme . "/css/fonts-style.css";
            if ( !file_exists($cssFile) ) { $cssFile = ""; } else { $cssFile .= "?tmpstm=".time(); }
            if ( !empty($this->contentCss) ) {
                foreach ( $this->contentCss as $css ) {
                    $path1 = "" . CB_FILE . "/css/".$css;
                    $path2 = "" . CB_THEME . "/" . $this->theme . "/css/".$css;
                    if ( file_exists($path1) ) {
                        $cssFile .= ",".$path1."?tmpstm=".time();
                    } elseif ( file_exists($path2) ) {
                        $cssFile .= ",".$path2."?tmpstm=".time();
                    }
                }
            }
            $html .= "<script type='text/javascript'>var tinyMCECSSPath = '".$cssFile."';</script>\r\n";
            $html .= "<script type='text/javascript'>var tinyMCELang = '".$this->tinyMCELangTransform($lang->getAdminLanguage())."';</script>\r\n";
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/tinymce/tinymce/tinymce.min.js'></script>\r\n";
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/etc/tinymce/cb_setup_tinymce.js'></script>\r\n";
        }
        if ($this->momentJs == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/moment/moment/min/moment-with-locales.min.js'></script>\r\n";
        }
        if ($this->inputmask == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/vendor/robinherbots/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'></script>\r\n";
        }
        if ($this->fontAwesome == TRUE) {
            $html .= "<link type='text/css' href='" . CB_URI . CB_CORE . "/vendor/components/font-awesome/css/all.min.css' rel='stylesheet' />\r\n";
        }
        
        return $html;
    }
    
    protected function loadGoogleAnalytics() {
        $html = "";

        if ( !empty(CB_GOOGLE_ANALYTICS_CODE) ) {
            $c = trim(CB_GOOGLE_ANALYTICS_CODE);
            $html .= <<<HTML
<script async src="https://www.googletagmanager.com/gtag/js?id=$c"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '$c');
</script>                    
HTML;
        }
        
        return $html;
    }
    
    private function tinyMCELangTransform($l) {
        if ( $l == 'hu' ) {
            return 'hu_HU';
        } elseif ( $l == 'en' ) {
            return 'en_GB';
        } elseif ( $l == 'de' ) {
            return 'de_AT';
        }
    }
    
    protected function loadSystemEndExtensionElements() {
        $html = "";

        if ($this->modalsytem == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_THEME . "/_template/js/modalsystem.js'></script>\r\n";
        }
        if ($this->parallaxbackground == TRUE) {
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/etc/parallax.js-1.5.0/parallax.min.js'></script>\r\n";
            $html .= "<script type='text/javascript' src='" . CB_URI . CB_CORE . "/etc/parallax.js-1.5.0/customload.parallax.js'></script>\r\n";
        }
        
        return $html;
    }
}

return; ?>
