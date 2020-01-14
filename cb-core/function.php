<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v062
 * @date 22/12/19
 */
if ( !defined('H-KEI') ) { exit; }

/**
 * Generate one custom length random code
 * @param integer $length [optional]<br>Code length (default: 8)
 * @return string Generated code
 */
function cb_generate_code($length = '8') {
    $chars = "abcdefghijkmnpqrstuvwxyz23456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i < $length) {
        $num = rand() % 31;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

/**
 * Generate a password to a crypted string
 * @param mixed $password The original password
 * @return string Undecodable string
 */
function cb_password_crypt($password) {
    $a = hash('sha512',$password);
    return $a;
}

/**
 * Return a number only hash
 * https://stackoverflow.com/a/23679870/175071
 * @param $str
 * @param null $len
 * @return number
 */
function cb_num_hash($str, $len=null) {
    $binhash = md5($str, true);
    $numhash = unpack('N2', $binhash);
    $hash = $numhash[1] . $numhash[2];
    if($len && is_int($len)) {
        $hash = substr($hash, 0, $len);
    }
    return $hash;
}

function cb_ceil(float $number,$float = 0) {
    $n = $number;
    if ( $float > 0 ) {
        $c = 1;
        for ( $i=0;$i<$float;$i++) { $c = $c * 10; }
        $n = ceil($n*$c)/$c;
    }
    return $n;
}

function cb_floor(float $number,$float = 0) {
    $n = $number;
    if ( $float > 0 ) {
        $c = 1;
        for ( $i=0;$i<$float;$i++) { $c = $c * 10; }
        $n = floor($n*$c)/$c;
    }
    return $n;
}

/**
 * Validate the email address
 * @param string $email The Email adress
 * @return boolean <b>TRUE</b> if the email adress is valid, otherwise <b>FALSE</b>
 */
function cb_check_email_address($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

/**
 * Remove HTML content from string
 * @param string $html The content
 * @return string Cleaned HTML content
 */
function cb_remove_input_html($html) {
    $mit = array (
        "'<script[^<]*?>.*?</script>'si", // javascript eltüntetése
        "'<[\/\!]*?[^<>]*?>'si",  // HTML elemek eltüntetése
        "'([\r\n])[\s]+'",  // térközök
        "'&(quot|#34);'i",  // HTML entitások
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d+);'e");  // PHP kódként értelmezze

    $mire = array (
        "",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)");

    return preg_replace_callback($mit, $mire, $html);
}


/**
 * Transform timestap value to a readable MYSQL datetime value
 * @param timestamp $time Timestamp value
 * @return string Readable date
 */
function cb_time_to_date($time = NULL) {
    if ( $time === NULL ) { $time = time(); }
	return date("Y-m-d H:i:s", $time);
}

/**
 * Checks if a value exists in a multi-dimensional array
 * 
 * @param mixed $needle The searched value.
 * If needle is a string, the comparison is done in a case-sensitive manner.
 * @param array $haystack The array.
 * @param bool $strict [optional]<br>
 * If the third parameter strict is set to <b>TRUE</b> then the <b>cb_in_array_multi</b> function will also check the types of the needle in the haystack.
 * 
 * @return bool <b>TRUE</b> if needle is found in the array, <b>FALSE</b> otherwise.
 *  */
function cb_in_array_multi($needle, array $haystack, $strict = '&false;') {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && cb_in_array_multi($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function cb_escape_json_string($value) {
    # list from www.json.org: (\b backspace, \f formfeed)    
    $escapers =     array("\\",     "/",   "\"",  "\n",  "\r",  "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t",  "\\f",  "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

function cb_json_encode($value, $f = TRUE) {
    $return = [];
    foreach ($value as $key1 => $val1) {
        if ( is_array($val1) ) {
            $return[$key1] = cb_json_encode($val1, FALSE);
        } else {
            $return[$key1] = cb_escape_json_string($val1);
        }
    }
    if ( $f === TRUE ) {
        return json_encode($return, JSON_UNESCAPED_UNICODE);
    } else {
        return $return;
    }
}

function cb_json_encode2($array) {
    $out = "";
    
    foreach ($array as $key1 => $val) {
        if ( !empty($out) ) { $out .= ','; }
        $out .= '"'.$key1.'":';
        if ( is_array($val) ) {
            $out .= cb_json_create_object($val);
        } else {
            if ( is_numeric($val) || is_float($val) ) {
                $out .= $val;
            } else {
                $out .= '"'.$val.'"';
            }
        }
    }

    return "{".$out."}";
}

function cb_json_create_object($array) {
    $out = "";
    if ( empty($array) ) { return "[]"; }
    foreach ( $array as $value ) {
        if ( !empty($out) ) { $out .= ','; }
        $out .= "{";
        $o = "";
        foreach ( $value as $k=>$v ) {
            if ( !empty($o) ) { $o .= ','; }
            $o .= '"'.$k.'":"'.$v.'"';
        }
        $out .= $o;
        $out .= "}";
    }
    return "[".$out."]";
}

$cb_json_test_error = "";
function cb_is_json($string,$returnArray=FALSE) {
    global $cb_json_test_error;
    
    if ( is_array($string) ) {
        $cb_json_test_error = 'The input is array, string required.';
    } else {
        // decode the JSON data
        $result = json_decode($string,$returnArray);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $cb_json_test_error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $cb_json_test_error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $cb_json_test_error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $cb_json_test_error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $cb_json_test_error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $cb_json_test_error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $cb_json_test_error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $cb_json_test_error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $cb_json_test_error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $cb_json_test_error = 'Unknown JSON error occured.';
                break;
        }
    }
    
    if ($cb_json_test_error !== '') { return FALSE; }

    return $result;
}

function cb_is_json_last_error($toLog=FALSE) {
    global $cb_json_test_error;
    if ($toLog) {cb_error_log($cb_json_test_error);}
    return $cb_json_test_error;
}

/**
 * Sort an multi-dimensional array by key
 * @param array $array The input array.
 * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
function cb_ksort_multi(array &$array) {
    if ( is_array($array) ) {
        ksort($array);
        $array2 = array();
        foreach ($array as $key => $value) {
            ksort($value);
            $array2[$key] = $value;
        }
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Remove accent from string
 * @param string $text input string
 * @return string output string
 */
function cb_remove_accent($text) {
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
    return str_replace($a, $b, $text);
}

/**
 * Transform UTF8 charcoding character to real UTF8 character from string
 * @param string $text input string
 * @return string output string
 */
function cb_utf8cc_to_utf8($valor='') {
    $utf8_ansi2 = array( "u00c0" =>"À", "u00c1" =>"Á", "u00c2" =>"Â", "u00c3" =>"Ã", "u00c4" =>"Ä", "u00c5" =>"Å", "u00c6" =>"Æ", "u00c7" =>"Ç", "u00c8" =>"È", "u00c9" =>"É", "u00ca" =>"Ê", "u00cb" =>"Ë", "u00cc" =>"Ì", "u00cd" =>"Í", "u00ce" =>"Î", "u00cf" =>"Ï", "u00d1" =>"Ñ", "u00d2" =>"Ò", "u00d3" =>"Ó", "u00d4" =>"Ô", "u00d5" =>"Õ", "u00d6" =>"Ö", "u00d8" =>"Ø", "u00d9" =>"Ù", "u00da" =>"Ú", "u00db" =>"Û", "u00dc" =>"Ü", "u00dd" =>"Ý", "u00df" =>"ß", "u00e0" =>"à", "u00e1" =>"á", "u00e2" =>"â", "u00e3" =>"ã", "u00e4" =>"ä", "u00e5" =>"å", "u00e6" =>"æ", "u00e7" =>"ç", "u00e8" =>"è", "u00e9" =>"é", "u00ea" =>"ê", "u00eb" =>"ë", "u00ec" =>"ì", "u00ed" =>"í", "u00ee" =>"î", "u00ef" =>"ï", "u00f0" =>"ð", "u00f1" =>"ñ", "u00f2" =>"ò", "u00f3" =>"ó", "u00f4" =>"ô", "u00f5" =>"õ", "u00f6" =>"ö", "u00f8" =>"ø", "u00f9" =>"ù", "u00fa" =>"ú", "u00fb" =>"û", "u00fc" =>"ü", "u00fd" =>"ý", "u00ff" =>"ÿ");
    return strtr($valor, $utf8_ansi2);
}

function cb_remove_space($text) {
    $a = array(' ');
    $b = array('');
    return str_replace($a, $b, $text);
}

function cb_urlready_name($text) {
    $text = cb_remove_accent($text);
    $a = array(' ','\\','/','&','"',"'","!","(",")","[","]","{","}");
    $b = array('-','-','-','-','-','-','-','-','-','-','-','-','-');
    return str_replace($a, $b, $text);
}

/**
 * Price clean, remove the blanks, and convert "," to "." character for to make a float price
 * @param string $price the price
 * @return float returning price,<br> this is mysql compabibile float value
 */
function cb_price_clean(&$price,$returnParameter=FALSE) {
    $a = array(' ', ',');
    $b = array('', '.');
    $result = (float) str_replace($a, $b, trim($price));
    if ( $returnParameter === TRUE ) { $price = $result; }
    return $result;
}

function cb_number_format($price,$format='hu_HU') {
    $fmt = new NumberFormatter( $format, NumberFormatter::DECIMAL );
    $p = $fmt->format($price);
    return $p;
}

function cb_number_format_custom($number,$decimals=-1,$dec_point=",",$thousands_sep=" ") {
    cb_price_clean($number,TRUE);
    if ( $decimals === -1 ) {
        $n = cb_floor($number,10);
    } else {
        $n = cb_floor($number,$decimals);
    }
    
    $d = explode('.', $n);
    if (isset($d[1])) {
        $decimals = strlen($d[1]);
    } else { $decimals = 0; }
    
    $out_number = number_format($n,$decimals,$dec_point,$thousands_sep);
    return $out_number;
}

function cb_number_round($number,int $decimals=2,$fixed=FALSE) {
    $n = round(cb_price_clean($number), $decimals);
    if ( $fixed === TRUE ) {
        $e = explode('.',(string)$n);
        if ( !isset($e[1]) ) { $e[1] = ""; }
        for ( ;strlen($e[1]) < $decimals; ) { $e[1] .= '0'; }
        $n = $e[0].'.'.$e[1];
    }
    return $n;
}

function cb_calculate_price($net = 0.00, $gross = 0.00, $vat = CB_VAT) {
    $price = array();
    $price['net_price'] = (float) cb_price_clean($net);
    $price['gross_price'] = (float) cb_price_clean($gross);
    $price['vat'] = (float) $vat;
    $price['vat_price'] = (float) 0;
    if ( !empty($net) && empty($gross) ) {
        $price['vat_price'] = (float) ( ($net*$vat) / 100 );
        $price['gross_price'] = (float) ( $net + $price['vat_price'] );
    } elseif ( empty($net) && !empty($gross) ) {
        $price['vat_price'] = (float) ( $price['gross_price'] - ( ( $price['gross_price'] / (100 + $vat) ) * 100 ) );
        $price['net_price'] = (float) ( $price['gross_price'] - $price['vat_price'] );
    } elseif ( !empty($net) && !empty($gross) ) {
        $price['vat_price'] = (float) ( $price['gross_price'] - $price['net_price'] );
    }
    return $price;
}



/**
 * Image Resizer plugin
 * @param string $inFile input filename with full path
 * @param string $outFile output filename with full path
 * @param string $width image new width
 * @param string $height image new height
 * @param string $mime (optional) file mimetype (pre-defend)
 * @param boolean $force (optional) force replicate (default FALSE)
 * @return array include whit in 'path' (filepath) and 'name' (filename) keys
 */
function cb_img_resize( $inFile, $outFile, $width, $height, $mime = NULL, $force = FALSE ){
    $ifnpos = \strrpos($inFile, "/", -1);
    $inFileName = \substr($inFile, $ifnpos+1);
    $inPath = \substr($inFile,0,$ifnpos);
    
    $expos = \strrpos($inFileName, '.', -1);
    $fileExtension = \strtolower(\substr($inFileName, $expos+1));
    
    $ofnpos = \strrpos($outFile, "/", -1);
    $outFileName = \substr($outFile, $ofnpos+1);
    $outPath = \substr($outFile,0,$ofnpos);
    
    $returnArray = Array();
    
    if ( !is_dir($outPath) ) { mkdir($outPath, 0755, TRUE); }
    if ( ( $force === TRUE ) AND is_file( $outFile ) ) { unlink($outFile); }
    if ( !is_file( $outFile ) ) {
        // Eredeti méret lekérdezése
        list($width_orig, $height_orig) = getimagesize($inFile);
        $ratio_orig = $width_orig/$height_orig;
        if ( ($width_orig < $width) AND ($height_orig < $height) ) {
            copy($inFile, $outFile);
            $returnArray['path'] = $outFile;
            $returnArray['name'] = $outFileName;
            return $returnArray;
        }

        if ($width/$height > $ratio_orig) {
            $width = $height*$ratio_orig;
        } else {
            $height = $width/$ratio_orig;
        }
        $image_p = imagecreatetruecolor($width, $height);

        if ( $mime === NULL ) {
            if ( (strnatcmp(phpversion(),'5.3') >= 0) AND function_exists('finfo_open') ) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
            //    $mime = strtolower(finfo_file($finfo, CB_ROOTDIR.$inFile));
                $mime = strtolower(finfo_file($finfo, $inFile));
                finfo_close($finfo);
            } elseif ( function_exists('mime_content_type') ) {
                error_reporting(0);
            //    $mime = strtolower(mime_content_type(CB_ROOTDIR.$inFile));
                $mime = strtolower(mime_content_type($inFile));
            } else {
                if ( ($fileExtension === 'jpg') OR ($fileExtension === 'jpeg') ) {
                    $mime = "image/jpeg";
                } elseif ( $fileExtension == 'png' ) {
                    $mime = "image/png";
                } elseif ( $fileExtension == 'gif' ) {
                    $mime = "image/gif";
                }
            }
        }

        if ( ($mime === "image/jpeg") OR ($mime === "image/pjpeg") ) {
            $fileExtension = 'jpg';
            $image = imagecreatefromjpeg($inFile);
            cb_image_fix_orientation($image,$inFile);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagejpeg($image_p, $outFile, 100);
        } elseif ($mime == "image/png") {
            $fileExtension = 'png';
            $image_p = imagecreatetruecolor($width, $height);
            imageAlphaBlending($image_p, false);
            imageSaveAlpha($image_p, true);
            $image = imageCreateFromPng($inFile);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagepng($image_p, $outFile, 9);
        } elseif ($mime == "image/gif") {
            $fileExtension = 'gif';
            $image_p = imagecreatetruecolor($width, $height);
            imageAlphaBlending($image_p, false);
            imageSaveAlpha($image_p, true);
            $image = imagecreatefromgif($inFile);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagegif($image_p, $outFile);
        } else {
            return FALSE;
        }
        imagedestroy($image_p);

        $return['path'] = $outFile;
        $return['name'] = $outFileName;

    } else {
        $return['path'] = $outFile;
        $return['name'] = $outFileName;
    }
	
    return $return;
}

/**
 * Fix the uploaded image position
 * @param string $filename var
 * @param string $destination image path
 * @return no return value
 */
function cb_image_fix_orientation(&$image, $filename) {
    $exif = exif_read_data($filename);

    if (!empty($exif['Orientation'])) {
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
    }
}

function cb_move_uploaded_file(string $filename, string $destination) {
    move_uploaded_file($filename, $destination);
    
    $f = explode("/", $destination);
    $filename = end($f);
    $e = explode(".", $filename);
    $ext = end($e);
    try {
        $exif = @exif_read_data($destination);

        $orientation = ( isset($exif['Orientation']) ) ? $exif['Orientation'] : 1;

        if (isset($orientation) && $orientation != 1){
            switch ($orientation) {
                case 3:
                $deg = 180;
                break;
                case 6:
                $deg = 270;
                break;
                case 8:
                $deg = 90;
                break;
            }

            if ($deg) {

                // If png
                if ($ext == "png") {
                    $img_new = imagecreatefrompng($destination);
                    $img_new = imagerotate($img_new, $deg, 0);

                    // Save rotated image
                    imagepng($img_new,$destination,9);
                } elseif ( $ext == "gif" ) {
                    $img_new = imagecreatefromgif($destination);
                    $img_new = imagerotate($img_new, $deg, 0);

                    // Save rotated image
                    imagegif($img_new,$destination);
                } elseif ( $ext == "jpg" || $ext == "jpeg" ) {
                    $img_new = imagecreatefromjpeg($destination);
                    $img_new = imagerotate($img_new, $deg, 0);

                    // Save rotated image
                    imagejpeg($img_new,$destination,100);
                }
            }
        }

    } catch (Exception $e) {
        cbd( "error: ".$e);
    }
}

function cb_require_to_var($file){
    ob_start();
    require($file);
    $var = ob_get_clean();
    return $var;
}

function cb_csv_in_array($url,$delm=";",$encl="\"",$head=false) {
    
    $csvxrow = file($url);   // ---- csv rows to array ----
    
    $csvxrow[0] = chop($csvxrow[0]); 
    $csvxrow[0] = str_replace($encl,'',$csvxrow[0]); 
    $keydata = explode($delm,$csvxrow[0]); 
    $keynumb = count($keydata); 
    
    if ($head === true) { 
    $anzdata = count($csvxrow); 
    $z=0;
    $out = array();
    for($x=1; $x<$anzdata; $x++) { 
        $csvxrow[$x] = chop($csvxrow[$x]); 
        $csvxrow[$x] = str_replace($encl,'',$csvxrow[$x]); 
        $csv_data[$x] = explode($delm,$csvxrow[$x]); 
        $i=0; 
        foreach($keydata as $key) { 
            $out[$z][$key] = $csv_data[$x][$i]; 
            $i++;
            }    
        $z++;
        }
    }
    else { 
        $i=0;
        foreach($csvxrow as $item) { 
            $item = chop($item);
            $item = str_replace($encl,'',$item); 
            $csv_data = explode($delm,$item); 
            for ($y=0; $y<$keynumb; $y++) { 
               $out[$i][$y] = $csv_data[$y]; 
            }
        $i++;
        }
    }

    return $out; 
}

/**
 * Link cleaner, ideal for ordering or others
 * @param string $link url path
 * @param string $dkey link get parameter
 * @param string $value (optional) link get value (if empty, when the get parameter become to remove from the link)
 * @return string modifited url path
 */
function cb_link_clean($link = NULL,$dkey = NULL,$dvalue = NULL) {
    if ( $link == NULL || empty($link) ) { $link = CB_HTTPPAGEADDRESS; }
    
    $part0 = explode("?",$link);
    $newLink = $part0[0];
    $newLinkTail = "";
    if ( isset($part0[1]) ) {
        $part1 = explode("&",$part0[1]);
        foreach ( $part1 as $key => $value ) {
            $part2 = explode("=",$value);
            if ( $part2[0] == $dkey ) {
                unset($part1[$key]);
            } else {
                $newLinkTail .= ( empty($newLinkTail) ) ? "?".$part1[$key] : '&'.$part1[$key];
            }
        }
    }
    if ( $dvalue !== NULL ) {
        $newPart = $dkey."=".$dvalue;
        $newLinkTail .= ( empty($newLinkTail) ) ? "?".$newPart : '&'.$newPart;
    }
    $newLink .= $newLinkTail;
    
    return $newLink;
}

/**
 * Remove new row elements from html ( \r\n )
 * @param string $html
 * @return string cleaned html code
 */
function cb_make_json_ready_html($html) {
    $html = str_replace("\r\n","",$html);
    
    return $html;
}

/**
 * Generate tiny url from a long URL (checked to work 2019.01.)
 * @param string url address
 * @return string tiny url
 */
function cb_gen_tiny_url($url) {
    if ( substr($url, 0, 7 ) !== 'http://' && substr($url, 0, 8 ) !== 'https://' ) {
        $protocol = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $url = $protocol.@$_SERVER['HTTP_HOST'].'/'.$url;
    }
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

/**
 * If var is isset and not empty return TRUE else FALSE
 * @param mixed $var string or array
 * @param string $key (optional) array key, if have value, <b>$var</b> is need to be array
 * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
function cb_is_not_empty($var,$key = NULL) {
    if ( !isset($var) ) { return FALSE; }
    if ( is_array($var) && $key !== NULL ) {
        if ( isset($var[$key]) && !empty($var[$key]) ) { return TRUE; }
    } else {
        if ( !empty($var) ) { return TRUE; }
    }
    return FALSE;
}

/**
 * If var is not exist or value empty return TRUE else FALSE, if var is not exist return TRUE
 * @param mixed $var string or array
 * @param string $key (optional) array key, if have value, <b>$var</b> is need to be array
 * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
function cb_is_empty($var,$key = NULL) {
    if ( !isset($var) || empty($var) ) { return TRUE; }
    if ( is_array($var) && $key !== NULL ) {
        if ( !isset($var[$key]) || empty($var[$key]) ) { return TRUE; } 
    }
    return FALSE;
}

/**
 * If var is empty return TRUE else FALSE, if var is not exist return FALSE
 * @param mixed $var string or array
 * @param string $key (optional) array key, if have value, <b>$var</b> is need to be array
 * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
function cb_is_empty_x($var,$key = NULL) {
    if ( !isset($var) ) { return FALSE; }
    if ( is_array($var) && $key !== NULL ) {
        if ( !isset($var[$key]) ) { return FALSE; } 
        if ( empty($var[$key]) ) { return TRUE; } 
    } else {
        if ( empty($var) ) { return TRUE; }
    }
    return FALSE;
}

/**
 * Check file is uploaded or not
 * @param string $name need a $_FILES['<b>name</b>'] value
 * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
function cb_file_uploaded($name) {
    if(empty($_FILES)) {
        return false;       
    } 
    $file = $_FILES[$name];
    if(!file_exists($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])){
        return false;
    }
    return true;
}

/**
 * Image uplodat to imageshack (checked to work 2016.06.)
 * @param string image path to upload
 * @return string imageshack url
 */
function cb_gen_imageshack($imagepath) {
    $url = 'http://imageshack.us/upload_api.php';
    $key = '7BDHJNPQ61e9bb9934d6f819b26b871b7dfc353f';
    $max_file_size = '5242880';
    $temp = $imagepath;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_URL, $url);

    $post = array(
        "fileupload" => '@' . $temp,
        "key" => $key,
        "format" => 'json',
        "max_file_size" => $max_file_size,
        "Content-type" => "multipart/form-data"
    );
    $RealTitleID = time();
    $args['fileupload'] = new CurlFile($temp,'file/exgpd',$temp);
    $args['key'] = $key;
    $args['format'] = 'json';
    $args['Content-type'] = 'multipart/form-data';
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    $response = curl_exec($ch);
    $json_a=json_decode($response,true);
    
    return $json_a['links']['image_link'];
}

/**
 * Userfriendly date format.. probably
 * @param string $time (MYSQL format)
 * @return string date-text
 */
function cb_date_for_user($time) {
    $ret = "";
    
    $today = time();
    $oneDay = strtotime("+1 day",$today);
    $yesterday = strtotime("-1 day",$today);
    $day2 = strtotime("-2 day", $today);
    $day3 = strtotime("-3 day", $today);
    $day4 = strtotime("-4 day", $today);
    $day5 = strtotime("-5 day", $today);
    $day6 = strtotime("-6 day", $today);
    $day7 = strtotime("-7 day", $today);
    $weak1 = strtotime("-1 weak", $today);
    $weak2 = strtotime("-2 weak", $today);
    $weak3 = strtotime("-3 weak", $today);
    $weak4 = strtotime("-4 weak", $today);
    $weak5 = strtotime("-5 weak", $today);
    $month1 = strtotime("-1 month", $today);
    $month2 = strtotime("-2 month", $today);
    $month3 = strtotime("-3 month", $today);
    $month4 = strtotime("-4 month", $today);
    $month5 = strtotime("-5 month", $today);
    $month6 = strtotime("-6 month", $today);
    $month7 = strtotime("-7 month", $today);
    $month8 = strtotime("-8 month", $today);
    $month9 = strtotime("-9 month", $today);
    $month10 = strtotime("-10 month", $today);
    $month11 = strtotime("-11 month", $today);
    $month12 = strtotime("-12 month", $today);
    $year1 = strtotime("-1 year", $today);
    $year2 = strtotime("-2 year", $today);
    $year3 = strtotime("-3 year", $today);
    $year4 = strtotime("-4 year", $today);
    $year5 = strtotime("-5 year", $today);
    $year6 = strtotime("-6 year", $today);
    $year7 = strtotime("-7 year", $today);
    $year8 = strtotime("-8 year", $today);
    $year9 = strtotime("-9 year", $today);
    $year10 = strtotime("-10 year", $today);
    $year11 = strtotime("-11 year", $today);
    
    if($time-$yesterday>=0){$ret="[LANG_SYS_DATE_TODAY]";
    }elseif($time-$day2>=0){$ret="[LANG_SYS_DATE_YESTERDAY]";
    }elseif($time-$day3>=0){$ret="2 [LANG_SYS_DATE_DAYS_AGO]";
    }elseif($time-$day4>=0){$ret="3 [LANG_SYS_DATE_DAYS_AGO]";
    }elseif($time-$day5>=0){$ret="4 [LANG_SYS_DATE_DAYS_AGO]";
    }elseif($time-$day6>=0){$ret="5 [LANG_SYS_DATE_DAYS_AGO]";
    }elseif($time-$day7>=0){$ret="6 [LANG_SYS_DATE_DAYS_AGO]";
    }elseif($time-$weak2>=0){$ret="1 [LANG_SYS_DATE_WEAK_AGO]";
    }elseif($time-$weak3>=0){$ret="2 [LANG_SYS_DATE_WEAKS_AGO]";
    }elseif($time-$weak4>=0){$ret="3 [LANG_SYS_DATE_WEAKS_AGO]";
    }elseif($time-$weak5>=0){$ret="4 [LANG_SYS_DATE_WEAKS_AGO]";
    }elseif($time-$month2>=0){$ret="1 [LANG_SYS_DATE_MONTH_AGO]";
    }elseif($time-$month3>=0){$ret="2 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month4>=0){$ret="3 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month5>=0){$ret="4 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month6>=0){$ret="5 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month7>=0){$ret="6 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month8>=0){$ret="7 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month9>=0){$ret="8 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month10>=0){$ret="9 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month11>=0){$ret="10 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$month12>=0){$ret="11 [LANG_SYS_DATE_MONTHS_AGO]";
    }elseif($time-$year2>=0){$ret="1 [LANG_SYS_DATE_YEAR_AGO]";
    }elseif($time-$year3>=0){$ret="2 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year4>=0){$ret="3 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year5>=0){$ret="4 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year6>=0){$ret="5 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year7>=0){$ret="6 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year8>=0){$ret="7 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year9>=0){$ret="8 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year10>=0){$ret="9 [LANG_SYS_DATE_YEARS_AGO]";
    }elseif($time-$year11>=0){$ret="10 [LANG_SYS_DATE_YEARS_AGO]";
    }else{$ret=date("Y.m.d.",$time);}
    
    return $ret;
}

// FIXME: cookie nincs sessionra bontva!
class cb_cURL {
//$cc = new \cb_cURL();
//$cc->get('http://www.example.com');
//$cc->post('http://www.example.com','foo=bar');
    
    var $headers;
    var $user_agent;
    var $compression;
    var $cookie_file;
    var $proxy;
    
    function __construct($cookies=TRUE,$cookie=CB_TEMP.'/cookies.txt',$compression='gzip',$proxy='') {
        
        $this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $this->headers[] = 'Connection: Keep-Alive';
        $this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $this->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0';
        $this->compression=$compression;
        $this->proxy=$proxy;
        $this->cookies=$cookies;
        if ($this->cookies == TRUE) $this->cookie($cookie);
    }
    
    protected function cookie($cookie_file) {
        if (file_exists($cookie_file)) {
            $this->cookie_file=$cookie_file;
        } else {
            $f = fopen($cookie_file,'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
            $this->cookie_file=$cookie_file;
            fclose($f);
        }
    }
    
    public function get($url) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($process,CURLOPT_ENCODING , $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }
    
    public function post($url,$data) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($process, CURLOPT_ENCODING , $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_POST, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }
    
    public function json($url) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($process,CURLOPT_ENCODING , $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }
    
    protected function error($error) {
        cbd("cURL Error: $error",1);
    }

}

function cb_is_jsonlike($string) {
    if ( substr($string, 0, 1) !== '[' ) { return FALSE; }
    if ( substr($string, -1) !== ']' ) { return FALSE; }
    return TRUE;
}

function cb_transform_jsonlike_to_json($string) {
    $a = array('[', ']', ';');
    $b = array('{', '}', ',');
    $json = str_replace($a, $b, $string);
    
    return $json;
}


function cb_crc33($string,int $length = 10) {
    return substr(md5(uniqid($string.rand(1,6))), 0, $length);
}

function cb_array_sort_by_lenght(&$array) {
    usort($array,function ($a,$b){ return strlen($a)-strlen($b); });
    return $array;
}

function cb_array_sort_by_reverse_lenght(&$array) {
    usort($array,function ($a,$b){ return strlen($b)-strlen($a); });
    return $array;
}

return; ?>