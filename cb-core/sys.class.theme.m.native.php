<?php
namespace theme;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 28/11/19
 */
if ( !defined('H-KEI') ) { exit; }

trait native {
	private $loadedTemplateVar = []; //betöltött templatek átmeneti tárolója (ne töltsön be mégegyszer az a modul ami már egyszer betöltötte a fájlait)
	
    /**
     * Template betöltés funkció
     * @param string $name template neve ( _templade.php rész nélkül )
     * @param string $field templaten belüli betöltendő elrendezés
     * @param boolean $title template feljécét betöltse-e ha van ( FALSE - nem, TRUE - igen, )
     * @param string $module adott modul név aminek a templétjét betöltenénk
     * @param boolean $typeAdmin admin modul template betöltés ( FALSE - nem, TRUE - igen )
     * @return html_code kért template adatok ha létezik, egyébként NULL
     */
    public function loadTemplate($name, $field = 0, $title = TRUE, $module = NULL, $typeAdmin = FALSE) {

        $return = NULL;

        if ($typeAdmin) {
            $name2 = $name . "_adm";
        } else {
            $name2 = $name . "_mod";
        }

        if ( $typeAdmin === TRUE ) {
            $templatePath = CB_ADMIN . "/theme/_template/";
            $modulePathSelf = CB_ADMIN . "/module/" . $module . "-self/";
            $modulePath = CB_ADMIN . "/module/" . $module . "/";
            $themePath = CB_ADMIN . "/theme/" . $this->admin_theme . "/";
        } else {
            $templatePath = CB_THEME . "/_template/";
            $modulePathSelf = CB_MODULE . "/" . $module . "-self/";
            $modulePath = CB_MODULE . "/" . $module . "/";
            $themePath = CB_THEME . "/" . $this->theme . "/";
        }

        $dataSourceRoot = Array();

        $dataSourceRoot[] = $templatePath;

        if (!empty($module)) {
            $mpath = $modulePathSelf;
            if (!file_exists($mpath)) {
                $mpath = $modulePath;
            }
            $dataSourceRoot[] = $mpath;
        }
        $dataSourceRoot[] = $themePath;

        if (!isset($this->loadedTemplateVar[$name2]['template'][$field])) {
            $filename = $name . "_template.php";

            $raw = Array(
                "template" => Array(),
                "css" => Array(),
                "js" => Array(),
                "jsend" => Array(),
                "title" => "",
                "bodyclass" => Array()
            );

            // Main feldolgozás
            foreach ($dataSourceRoot as $path) {
                if (file_exists($path . $filename)) {
                    include($path . $filename);
                    $this->loadTemplate_to_raw($raw, $field, @$TEMPLATE, @$CSS, @$JS, @$JSEND, @$TITLE, @$BODYCLASS);
                    unset($TEMPLATE);
                    unset($CSS);
                    unset($JS);
                    unset($JSEND);
                    unset($TITLE);
                    unset($BODYCLASS);
                }
            }

            if (empty($raw['template'])) {
                cb_error_log("Fatal ERROR: Not Exist Template! ".$name." | ".$field);
                die("Fatal ERROR: Not Exist Template! ".$name." | ".$field);
            }

            $this->loadedTemplateVar[$name2][$field] = $raw;
        }

        if (isset($this->loadedTemplateVar[$name2][$field]['template']) && !empty($this->loadedTemplateVar[$name2][$field]['template'])) {
            $return = $this->loadedTemplateVar[$name2][$field]['template'];

            if (!empty($this->loadedTemplateVar[$name2][$field]['css'])) { foreach ($this->loadedTemplateVar[$name2][$field]['css'] as $val) { $this->addContentCss($val,$module,$typeAdmin); } }
            if (!empty($this->loadedTemplateVar[$name2][$field]['js'])) { foreach ($this->loadedTemplateVar[$name2][$field]['js'] as $val) { $this->addContentJs($val,$module,$typeAdmin); } }
            if (!empty($this->loadedTemplateVar[$name2][$field]['jsend'])) { foreach ($this->loadedTemplateVar[$name2][$field]['jsend'] as $val) { $this->addContentEndJs($val,$module,$typeAdmin); } }

            if ($title === TRUE && isset($this->loadedTemplateVar[$name2][$field]['title'])) { $this->contentTitle = $this->loadedTemplateVar[$name2][$field]['title']; }
            if (!empty($this->loadedTemplateVar[$name2][$field]['bodyclass'])) { foreach ($this->loadedTemplateVar[$name2][$field]['bodyclass'] as $class) { $this->addBodyClass($class); } }
        }

        return $return;
    }

    private function loadTemplate_to_raw(&$raw, $field, $template = Array(), $css = Array(), $js = Array(), $jsend = Array(), $title = Array(), $bodyClass = Array()) {
        if (isset($template) && !empty($template) && isset($template[$field]) && !empty($template[$field]) ) {
            $raw['template'] = $template[$field];
            //print_r($template);
            if (isset($css[$field]) && !empty($css[$field])) {
                foreach ($css[$field] as $key => $val) {
                    if (!in_array($val, $raw['css'])) {
                        $raw['css'][$key] = $val;
                        unset($css[$field][$key]);
                    }
                }
                unset($css[$field]);
            }
            if (!empty($css)) {
                foreach ($css as $key => $val) {
                    if ( is_numeric($key) && !in_array($val, $raw['css']) ) {
                        $raw['css'][] = $val;
                    }
                    unset($css[$key]);
                }
            }


            if (isset($js[$field]) && !empty($js[$field])) {
                foreach ($js[$field] as $key => $val) {
                    if (!in_array($val, $raw['js'])) {
                        $raw['js'][$key] = $val;
                        unset($js[$field][$key]);
                    }
                }
                unset($js[$field]);
            }
            if (!empty($js)) {
                foreach ($js as $key => $val) {
                    if ( is_numeric($key) && !in_array($val, $raw['js']) ) {
                        $raw['js'][] = $val;
                    }
                    unset($js[$key]);
                }
            }


            if (isset($jsend[$field]) && !empty($jsend[$field])) {
                foreach ($jsend[$field] as $key => $val) {
                    if (!in_array($val, $raw['jsend'])) {
                        $raw['jsend'][$key] = $val;
                        unset($jsend[$field][$key]);
                    }
                }
                unset($jsend[$field]);
            }
            if (!empty($jsend)) {
                foreach ($jsend as $key => $val) {
                    if ( is_numeric($key) && !in_array($val, $raw['jsend']) ) {
                        $raw['jsend'][] = $val;
                    }
                    unset($jsend[$key]);
                }
            }

            if (!empty($title) && isset($title[$field])) {
                $raw['title'] = $title[$field];
                unset($title[$field]);
            }


            if (isset($bodyClass[$field]) && !empty($bodyClass[$field])) {
                foreach ($bodyClass[$field] as $key => $val) {
                    if (!in_array($val, $raw['bodyclass'])) {
                        $raw['bodyclass'][] = $val;
                        unset($bodyClass[$field][$key]);
                    }
                }
                unset($bodyClass[$field]);
            }
            if (!empty($bodyClass)) {
                foreach ($bodyClass as $key => $val) {
                    if ( is_numeric($key) && !in_array($val, $raw['bodyClass']) ) {
                        $raw['jsend'][] = $val;
                    }
                    unset($bodyClass[$key]);
                }
            }
        }

    }

    /**
     * Admin template betöltés funkció
     * @param string $name template neve ( _templade.php rész nélkül )
     * @param string $field templaten belüli betöltendő elrendezés
     * @param boolean $title template feljécét betöltse-e ha van ( FALSE - nem, TRUE - igen, )
     * @param string $module adott modul név aminek a templétjét betöltenénk
     * @return html_code kért template adatok ha létezik, egyébként NULL
     */
    public function loadAdminTemplate($name, $field = 0, $title = TRUE, $module = NULL) {
        //    if ( $module == NULL ) $name = 'admin/'.$name;
        return $this->loadTemplate($name, $field, $title, $module, TRUE);
    }

}

return; ?>