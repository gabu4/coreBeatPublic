<?php
namespace module\language;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 27/04/18
 */
if ( !defined('H-KEI') ) { exit; }

class funct extends database {
    protected function callSelector_buildHTML() {
        global $lang;
        
        $l = $lang->getLanguage();
        $gal = $lang->getAllowedLanguageTypes();
        
        if ( count($gal) === 1 ) { return ""; }
        
        $html = " <div class='languageSelector'>";
        $first = TRUE;
        foreach( $gal as $l2 ) {
            if ( $first !== TRUE ) { $html .= "&nbsp;&nbsp;/&nbsp;&nbsp;"; }
            if ( $l == $l2 ) {
                $html .= "<span class='language selectedLanguage active'>".$l2."</span>";
            } else {
                if ( $l2 === $gal[0] ) {
                    $href = "/";
                } else {
                    $href = $l2."/";
                }
                $html .= "<a href='".$href."' class='language'>".$l2."</a>";
            }
            $first = FALSE;
        }
        $html .= "</div>";
        
        return $html;
    }
}

return; ?>
