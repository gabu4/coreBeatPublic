<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 27/06/15
 */
if ( !defined('H-KEI') ) { exit; }

class module_admin_slide_call extends module_admin_slide_function {
	
	function module_admin_slide_call( ) {
		
	}
	
	public function __call_main() {
            $html = "";
            $html .= "<h1 class='title'>Galléria</h1>";
            $html .= "Használat:<br /><br /><b>{#MODULE,SLIDE,MAIN}</b><br /><br />a képeket a slide mappába kell feltölteni.";
            
            return $html;
	}
	
	
}

return; ?>