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

$phpmailer->CharSet = MAIL_CHARSET;
$phpmailer->SetFrom(MAIL_FROM,MAIL_FROM_NAME);
$phpmailer->Mailer = MAIL_TYPE;
$phpmailer->Sendmail = MAIL_SENDMAIL_ROOT;
//$phpmailer->SMTPDebug = 1;
$phpmailer->Timeout = 60;
$phpmailer->Host = MAIL_SMTP_SERVER;
$phpmailer->Port = MAIL_SMTP_PORT;
$phpmailer->SMTPSecure = MAIL_SMTP_SECURE;
$phpmailer->SMTPAuth = MAIL_SMTP_AUTH;
$phpmailer->Username = MAIL_SMTP_USERNAME;
$phpmailer->Password = MAIL_SMTP_PASSWORD;

?>