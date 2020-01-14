<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 20/12/17
 */
if ( !defined('H-KEI') ) { exit; }


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$phpmailer = new PHPMailer(true);

    //Server settings
    $phpmailer->SMTPDebug = 0;                                 // Enable verbose debug output
if ( CB_MAIL_TYPE == 'xoauth2' ) {
    $phpmailer->oauthUserEmail = CB_MAIL_XOAUTH2_USER_EMAIL;
    $phpmailer->oauthClientId = CB_MAIL_XOAUTH2_CLIENT_ID;
    $phpmailer->oauthClientSecret = CB_MAIL_XOAUTH2_CLIENT_SECRET;
    $phpmailer->oauthRefreshToken = CB_MAIL_XOAUTH2_REFRESH_TOKEN;
} else {
    $phpmailer->Host = CB_MAIL_SMTP_SERVER;  // Specify main and backup SMTP servers
    $phpmailer->SMTPAuth = CB_MAIL_SMTP_AUTH;                               // Enable SMTP authentication
    $phpmailer->Username = CB_MAIL_SMTP_USERNAME;                 // SMTP username
    $phpmailer->Password = CB_MAIL_SMTP_PASSWORD;                           // SMTP password
    $phpmailer->SMTPSecure = CB_MAIL_SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
    $phpmailer->Port = CB_MAIL_SMTP_PORT;                                    // TCP port to connect to
}
    $phpmailer->Timeout = 60;
    $phpmailer->CharSet = CB_MAIL_CHARSET;
    $phpmailer->SetFrom(CB_MAIL_FROM,CB_MAIL_FROM_NAME);
    $phpmailer->Mailer = CB_MAIL_TYPE; //Options: "mail", "sendmail", or "smtp".
    //$phpmailer->Sendmail = CB_MAIL_SENDMAIL_ROOT;
    $phpmailer->setLanguage('hu', CB_CORE . '/vendor/phpmailer/phpmailer/language/');

return; ?>