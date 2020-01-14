<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 04/09/14
 */
if ( !defined('H-KEI') ) { exit; }

class formGenerator {
		
    function formGenerator() {

    }

    public function input( $name = NULL, $value = '', $rowTitle = NULL, $type = 'text', $autocomplete = TRUE, $error = '' ) {
        $html = "";
        
        $name2 = ( !empty($name) ) ? trim($name) : $name;
        
        $vAutocompete = ( $autocomplete === TRUE ) ? "autocomplete='on'" : "autocomplete='off'";
        
        $vRowTitle = ( $rowTitle !== NULL ) ? "<span class='rowTitle'>$rowTitle</span>" : '';
                
        $html .= <<<HTML
            <p class='row fg row_fg input $type $name2'>
                $vRowTitle
                <span class='rowField input $type $name2'><input type='$type' value='$value' name='$name2' $vAutocompete /></span>
                <span class='comm'>$error</span>
            </p>
HTML;

        return $html;
    }

    public function textarea( $name = NULL, $value = '', $rowTitle = NULL, $error = '' ){
        $html = "";
        
        $name2 = ( !empty($name) ) ? trim($name) : $name;
        
        $vRowTitle = ( $rowTitle !== NULL ) ? "<span class='rowTitle'>$rowTitle</span>" : '';
        
        $html .= <<<HTML
            <p class='row fg row_fg textarea $name2'>
                $vRowTitle
                <span class='rowField textarea $name2'><textarea name='$name2'>$value<textarea/></span>
                <span class='comm'>$error</span>
            </p>
HTML;

        return $html;
    }
    
    /**
     * Select form field create
     * @param string $name Form element name
     * @param array $value Form element option value (value text)
     * @param array $text [optional]<br>Form element option element (row text)<br>need to a <i>same key</i> like the <b>$value</b>
     * @param array $selected [optional]<br>Form element check<br>need to a <i>same key</i> like the <b>$value</b>
     * @param array $disabled [optional]<br>Form element disable<br>need to a <i>same key</i> like the <b>$value</b>
     * @param string $rowTitle [optional]<br>Row title
     * @param integer $size [optional]<br>Select row height
     * @param bool $multiple [optional]<br>Multiple line select<br><b>TRUE</b> or <b>FALSE</b> <i>(default)</i>
     * @param string $error [optional]<br>Preset error message
     * @return string Generated HTML code
     */
    public function select( $name = NULL, array $value, array $text, array $selected, array $disabled, $rowTitle = NULL, $size = 1, $multiple = FALSE, $error = NULL ){
        $html = "";
        
        $name2 = ( !empty($name) ) ? trim($name) : $name;
        
        $valueCode = "";
        
        foreach ( $value as $key => $val ) {
            $vText = ( isset($text[$key]) ) ? $text[$key] : $val;
            $vSelected = ( isset($selected[$key]) && $selected[$key] === TRUE ) ? 'selected': '';
            $vDisabled = ( isset($disabled[$key]) && $disabled[$key] === TRUE ) ? 'disabled': '';
            $valueCode .= <<<HTML
                <option value='$val' $vSelected $vDisabled>$vText</option>
HTML;
        }
        $vRowTitle = ( $rowTitle !== NULL ) ? "<span class='rowTitle'>$rowTitle</span>" : '';
        
        $vMultiple = ( $multiple === TRUE ) ? 'multiple' : '';
        $html .= <<<HTML
            <p class='row fg row_fg select $name2'>
                $vRowTitle
                <span class='rowField select $name2'><select name='$name2' size='$size' $vMultiple>$valueCode</select></span>
                <span class='comm'>$error</span>
            </p>
HTML;

        return $html;
    }
    
    public function radio( $name = NULL, array $value, array $text, array $selected, array $disabled, $rowTitle = NULL, $size = 1, $multiple = FALSE, $error = NULL ){
        $html = "";
        
        $name2 = ( !empty($name) ) ? trim($name) : $name;
        
        $valueCode = "";
        
        foreach ( $value as $key => $val ) {
            $vText = ( isset($text[$key]) ) ? $text[$key] : $val;
            $vSelected = ( isset($selected[$key]) && $selected[$key] === TRUE ) ? 'selected': '';
            $vDisabled = ( isset($disabled[$key]) && $disabled[$key] === TRUE ) ? 'disabled': '';
            $valueCode .= <<<HTML
                    <option value='$val' $vSelected $vDisabled>$vText</option>
HTML;
        }
        
        $vMultiple = ( $multiple === TRUE ) ? 'multiple' : '';
        $html .= <<<HTML
                <p class='row fg row_fg select $name2'>
                    <span class='rowTitle'>$rowTitle</span>
                    <span class='rowField select $name2'><select name='$name2' size='$size' $vMultiple>$valueCode</select></span>
                    <span class='comm'>$error</span>
                </p>
HTML;

        return $html;
    }
}

return; ?>
