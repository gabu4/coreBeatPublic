<?php

/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 02/08/19
 */
if (!defined('H-KEI')) { exit; }

require_once('init.function.ext.php');

function cb_user_only() {
    global $user, $out_html;
    if ( $user->cb_get_user_id() === 0 ) { $out_html->loadErrorPage403(); }
}

function cb_api_token_only() {
    global $out_api, $session;
    if ( !$session->get_token() ) { $out_api->responseOut(401,'AUTH_FAIL_TOKEN_NOT_FOUND',[],['AUTH_FAIL_TOKEN_NOT_FOUND']); }
}

function cb_api_user_only() {
    global $user, $out_api;
    if ( $user->cb_get_user_id() === 0 ) { $out_api->responseOut(401,'UNAUTHORIZED',[],['UNAUTHORIZED']); }
}

function cb_api_admin_only() {
    global $user, $out_api;
    if ( $user->cb_get_user_id() === 0 ) { $out_api->responseOut(401,'UNAUTHORIZED',[],['UNAUTHORIZED']); }
    if ( !$user->cb_is_admin_access() ) { $out_api->responseOut(401,'UNAUTHORIZED',[],['UNAUTHORIZED']); }
}

function cb_text_encrypt($plaintext,$key) {
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
    return $ciphertext;
}

function cb_text_decrypt($ciphertext,$key) {
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
    {
        return $original_plaintext;
    }
    return FALSE;
}

function cb_password_strength($password,int &$point=0) {
    $min_character = 8;
    $p = 0;
    $number_only = TRUE;
    $bannedpasswords = @file(CB_CORE.'/bannedpasswords.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    // Validate password strength
    if ( !empty($bannedpasswords) && in_array(mb_strtolower($password,'utf8'),$bannedpasswords) ) { $p-=10; }
    $uppercase = preg_match('@[A-Z]@', $password);
    if ( $uppercase ) { $p++;$number_only=FALSE; }
    $lowercase = preg_match('@[a-z]@', $password);
    if ( $lowercase ) { $p++;$number_only=FALSE; }
    $number = preg_match('@[0-9]@', $password);
    if ( $number ) { $p++; }
    $specialChars = preg_match('@[^\w]@', $password);
    if ( $specialChars ) { $p++;$number_only=FALSE; }
    
    $length = strlen($password);
    if ( $length >= $min_character*5 ) { $p+=7; }
    elseif ( $length >= $min_character*4 ) { $p+=6; }
    elseif ( $length >= $min_character*3 ) { $p+=5; }
    elseif ( $length >= $min_character*2.5 ) { $p+=4; }
    elseif ( $length >= $min_character*2 ) { $p+=3; }
    elseif ( $length >= $min_character*1.5 ) { $p+=2; }
    elseif ( $length >= $min_character*1 ) { $p+=1; }
    
    if ( $number_only === TRUE ) { $p-=5; }
    $point = ( $p > 10 ? 10 : ( $p < 0 ? 0 : round($p) ) );
    
    if( $p >= 5) {
        return TRUE;
    }else{
        return FALSE;
    }
}

function cb_generate_qr_code($codeText,$ecc=1,$size=10) {
    if ( empty($codeText) ) { return FALSE; }
    
    $code_cr = crc32($codeText.'-'.$ecc.'-'.$size);
    
    $outPath = CB_TEMP."/qrcodegen";
    if ( !is_dir($outPath) ) { mkdir($outPath, 0755, TRUE); }
    $path = $outPath."/".$code_cr.".png";
    if (is_file($path) ) { unlink($path); }
    
    switch ($ecc) {
        case 2:
            $ecc_level = 'QR_ECLEVEL_M';
            break;
        case 3:
            $ecc_level = 'QR_ECLEVEL_Q';
            break;
        case 4:
            $ecc_level = 'QR_ECLEVEL_H';
            break;
        case 1:
        default:
            $ecc_level = 'QR_ECLEVEL_L';
            break;
    }
    
    require_once('components/phpqrcode/qrlib.php');
    
    // outputs image directly into browser, as PNG stream
    $v = QRcode::png($codeText,$path,$ecc_level,$size,1);
    
    return $path;
}

unset($cb_init_system_function);

return; ?>
