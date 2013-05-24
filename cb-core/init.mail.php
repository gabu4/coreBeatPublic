<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2013. 01. 28.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

require_once( CB_CORE .'/etc/phpmailer/class.phpmailer.php');
$phpmailer = new PHPMailer;

$phpmailer->CharSet = CB_MAIL_CHARSET;
$phpmailer->SetFrom(CB_MAIL_FROM,CB_MAIL_FROM_NAME);
$phpmailer->Mailer = CB_MAIL_TYPE;
$phpmailer->Sendmail = CB_MAIL_SENDMAIL_ROOT;
//$phpmailer->SMTPDebug = 1;
$phpmailer->Timeout = 60;
$phpmailer->Host = CB_MAIL_SMTP_SERVER;
$phpmailer->Port = CB_MAIL_SMTP_PORT;
$phpmailer->SMTPSecure = CB_MAIL_SMTP_SECURE;
$phpmailer->SMTPAuth = CB_MAIL_SMTP_AUTH;
$phpmailer->Username = CB_MAIL_SMTP_USERNAME;
$phpmailer->Password = CB_MAIL_SMTP_PASSWORD;

?>