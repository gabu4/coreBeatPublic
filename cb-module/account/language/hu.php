<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2013. 01. 30.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

/* SQL ERROR MESSAGES */
define('ACCOUNT_USERNAME_ERROR','Felhasználónév nem lehet üres!');
define('ACCOUNT_USERPASSW_ERROR','Jelszó nem lehet üres!');

define('ACCOUNT_VALID_ERROR','Hibás felhasználónév/e-mail cím vagy jelszó!');
define('ACCOUNT_LOGIN_SUCCESS','Sikeres bejelentkezés');
define('ACCOUNT_LOGOUT_SUCCESS','Sikeres kijelentkezés!');

define('ACCOUNT_TEXT_USERNAME','Felh. (név v. e-mail)');
define('ACCOUNT_TEXT_PASSWORD','Jelszó');

define('ACCOUNT_TEXT_TITLE_USERSETUP','Felhasználói adatmódosítás');
define('ACCOUNT_TEXT_TITLE_NEWPASSWORD','Felhasználói jelszó módosítás');

define('ACCOUNT_TEXT_TITLE_REGISTRATION_STEP1','Regisztráció');
define('ACCOUNT_TEXT_TITLE_REGISTRATION_STEP2','Regisztráció');

define('ADMIN_TEXT_ACCOUNT_MAIN_TITLE','Felhasználók kezelése');
define('ADMIN_TEXT_ACCOUNT_INVITE_TITLE','Felhasználó meghívása');

return; ?>
