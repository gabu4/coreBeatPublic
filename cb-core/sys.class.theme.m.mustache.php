<?php
namespace theme;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 20/12/19
 */
if ( !defined('H-KEI') ) { exit; }

trait mustache {
    private $loadedTemplate2Var = []; //betöltött templatek átmeneti tárolója (ne töltsön be mégegyszer az a modul ami már egyszer betöltötte a fájlait)
	
    private $mustacheEngine = NULL;
    
    private function loadMustacheEngine() {
        $mustachePath = CB_CORE . "/vendor/mustache/mustache/src/Mustache/Autoloader.php";
        if (!file_exists($mustachePath)) { $this->mustacheEngine = FALSE;return FALSE; }
        require_once $mustachePath;
        $this->mustacheEngine = new \Mustache_Engine();
    }

    public function mustache(array $replace=[],&$body=""){
        if ( $this->mustacheEngine === NULL ) { $this->loadMustacheEngine(); }
        if ( $this->mustacheEngine === FALSE ) { cb_error_log("Mustache Engine not avaitable!");return FALSE; }
        if ( !empty($replace) ) {
            foreach ( $replace as $k => $v ) {
                $this->mustache_check($k,$v,$replace);
            }
        }
        $body = $this->mustacheEngine->render($body,$replace);
        return TRUE;
    }
    
    private function mustache_check($k,$v,&$replace) {
        if ( ( empty($v) || $v === false ) && !is_numeric($k) ) {
            $replace['?'.$k] = false;
            $replace['!'.$k] = true;
        } elseif ( !is_numeric($k) ) {
            $replace['?'.$k] = true;
            $replace['!'.$k] = false;
        }
        if ( is_array($v) ) {
            foreach ( $v as $k2=>$v2 ) {
                $this->mustache_check($k2,$v2,$replace[$k]);
            }
        }
    }

    
    /**
     * Template betöltés funkció (mustache template)
     * @param string $name template neve ( .mustache rész nélkül )
     * @param boolean $title template feljécét betöltse-e ha van ( FALSE - nem, TRUE - igen, )
     * @param string $module adott modul név aminek a templétjét betöltenénk
     * @param boolean $typeAdmin admin modul template betöltés ( FALSE - nem, TRUE - igen )
     * @return html_code kért template adatok ha létezik, egyébként NULL
     */
    public function loadTemplate2($name, $title = FALSE, $module = NULL, $typeAdmin = FALSE) {
        $return = NULL;

        $templatePath = [];
        $this->loadTemplate_path($module,$typeAdmin,$templatePath);

        if ($module) { $name2 = $module.'_'.$name; } else { $name2 = $name; }
        if ($typeAdmin) { $name3 = $name2 . "_adm"; } else { $name3 = $name2 . "_mod"; }

        if (!isset($this->loadedTemplate2Var[$name3]['template'])) {
            $filename = $name . ".mustache";

            $raw = [
                "template" => "",
                "template_f" => FALSE,
                "css" => [],
                "js" => [],
                "jsend" => [],
                "title" => "",
                "bodyclass" => [],
                "load" => [],
            ];

            // Main feldolgozás
            foreach ($templatePath as $path) {
                if (file_exists($path . $filename)) {
                    $raw['template_f'] = TRUE;
                    $c = file_get_contents($path . $filename);
                    $this->loadTemplate_to_raw2($c, $raw, $path.$filename);
                    break;
                } else {
                    continue;
                }
            }

            if ( $raw['template_f'] !== TRUE) {
                cb_error_log("Fatal ERROR: Not Exist Template2! ".$name3);
                die("Fatal ERROR: Not Exist Template2! ".$name3);
            }

            $this->loadedTemplate2Var[$name3] = $raw;
        }

        if (isset($this->loadedTemplate2Var[$name3]['template']) && !empty($this->loadedTemplate2Var[$name3]['template'])) {
            $return = $this->loadedTemplate2Var[$name3]['template'];

            if (!empty($this->loadedTemplate2Var[$name3]['css'])) { foreach ($this->loadedTemplate2Var[$name3]['css'] as $val) { $this->addContentCss($val,$module,$typeAdmin); } }
            if (!empty($this->loadedTemplate2Var[$name3]['js'])) { foreach ($this->loadedTemplate2Var[$name3]['js'] as $val) { $this->addContentJs($val,$module,$typeAdmin); } }
            if (!empty($this->loadedTemplate2Var[$name3]['jsend'])) { foreach ($this->loadedTemplate2Var[$name3]['jsend'] as $val) { $this->addContentEndJs($val,$module,$typeAdmin); } }

            if ($title === TRUE && isset($this->loadedTemplate2Var[$name3]['title'])) { $this->contentTitle = $this->loadedTemplate2Var[$name3]['title']; }

            if (!empty($this->loadedTemplate2Var[$name3]['bodyclass'])) { foreach ($this->loadedTemplate2Var[$name3]['bodyclass'] as $class) { $this->addBodyClass($class); } }
            if (!empty($this->loadedTemplate2Var[$name3]['load'])) { foreach ($this->loadedTemplate2Var[$name3]['load'] as $load) { $this->$load(); } }
        }

        return $return;
    }

    public function checkTemplate2($name, $module = NULL, $typeAdmin = FALSE) {
        $templatePath = [];
        $this->loadTemplate_path($module,$typeAdmin,$templatePath);

        if ($module) { $name2 = $module.'_'.$name; } else { $name2 = $name; }
        if ($typeAdmin) { $name3 = $name2 . "_adm"; } else { $name3 = $name2 . "_mod"; }

        if (!isset($this->loadedTemplate2Var[$name3]['template'])) {
            $filename = $name . ".mustache";

            foreach ($templatePath as $path) {
                if (file_exists($path . $filename)) {
                    return TRUE;
                } else {
                    continue;
                }
            }

            return FALSE;
        }

        return TRUE;
    }

    public function loadAdminTemplate2($name, $title = FALSE, $module = NULL) {
        return $this->loadTemplate2($name, $title, $module, TRUE);
    }
}

return; ?>