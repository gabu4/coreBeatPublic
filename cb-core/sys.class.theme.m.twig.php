<?php
namespace theme;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 20/12/19
 */

if ( !defined('H-KEI') ) { exit; }

trait twig {
    private $loadedTemplateTwigVar = []; //betöltött templatek átmeneti tárolója (ne töltsön be mégegyszer az a modul ami már egyszer betöltötte a fájlait)
    private $loadedTemplateTwigNameStore = []; //betöltött templatek átmeneti tárolója (ne töltsön be mégegyszer az a modul ami már egyszer betöltötte a fájlait)
	
    private $twigEngine = NULL;
    private $twigEngineLoaded = FALSE;
    private $twigEngineVar = [];
    private $twigEngineCounter = 0;
    
    /**
     * Template betöltés funkció (twig template)
     * @param string $name template neve ( .twig rész nélkül )
     * @param boolean $title template feljécét betöltse-e ha van ( FALSE - nem, TRUE - igen, )
     * @param string $module adott modul név aminek a templétjét betöltenénk
     * @param boolean $typeAdmin admin modul template betöltés ( FALSE - nem, TRUE - igen )
     * @return html_code kért template adatok ha létezik, egyébként NULL
     */
    public function loadTemplateTwig($name, $title = FALSE, $module = NULL, $typeAdmin = FALSE) {
        $return = NULL;

        $templatePath = [];
        $this->loadTemplate_path($module,$typeAdmin,$templatePath);

        if ($module) { $name2 = $module.'_'.$name; } else { $name2 = $name; }
        if ($typeAdmin) { $name3 = $name2 . "_adm"; } else { $name3 = $name2 . "_mod"; }

        if (!isset($this->loadedTemplateTwigVar[$name3]['template'])) {
            $filename = $name . ".twig";

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
                cb_error_log("Not Exist Twig Template! ".$name3);
                die("Not Exist Twig Template! ".$name3);
            }

            $this->loadedTemplateTwigVar[$name3] = $raw;
        }

        if (isset($this->loadedTemplateTwigVar[$name3]['template']) && !empty($this->loadedTemplateTwigVar[$name3]['template'])) {
            $this->loadedTemplateTwigNameStore[] = $name3;
            
            $return = $this->loadedTemplateTwigVar[$name3]['template'];

            if (!empty($this->loadedTemplateTwigVar[$name3]['css'])) { foreach ($this->loadedTemplateTwigVar[$name3]['css'] as $val) { $this->addContentCss($val,$module,$typeAdmin); } }
            if (!empty($this->loadedTemplateTwigVar[$name3]['js'])) { foreach ($this->loadedTemplateTwigVar[$name3]['js'] as $val) { $this->addContentJs($val,$module,$typeAdmin); } }
            if (!empty($this->loadedTemplateTwigVar[$name3]['jsend'])) { foreach ($this->loadedTemplateTwigVar[$name3]['jsend'] as $val) { $this->addContentEndJs($val,$module,$typeAdmin); } }

            if ($title === TRUE && isset($this->loadedTemplateTwigVar[$name3]['title'])) { $this->contentTitle = $this->loadedTemplateTwigVar[$name3]['title']; }

            if (!empty($this->loadedTemplateTwigVar[$name3]['bodyclass'])) { foreach ($this->loadedTemplateTwigVar[$name3]['bodyclass'] as $class) { $this->addBodyClass($class); } }
            if (!empty($this->loadedTemplateTwigVar[$name3]['load'])) { foreach ($this->loadedTemplateTwigVar[$name3]['load'] as $load) { $this->$load(); } }
        }

        return $return;
    }
    
    public function loadAdminTemplateTwig($name, $title = FALSE, $module = NULL) {
        return $this->loadTemplateTwig($name, $title, $module, TRUE);
    }
    
    public function replaceTwig(array $replace=[],&$body="",$templateName=""){
        $this->twigEngineLoaded = TRUE;
        $tn = ( $templateName === "" ? 'tmp_'.$this->twigEngineCounter++ : $templateName );
        
        $loader = new \Twig\Loader\ArrayLoader([$tn=>$body]);
        $twig = new \Twig\Environment($loader);
        
        $body = $twig->render($tn,$replace);
        return TRUE;
    }
}

return; ?>