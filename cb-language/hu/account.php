<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v008
 * @date 02/07/19
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MENU TITLE */
cb_langdef('ADMIN_LTEXT_ACCOUNT_MNAME','Felhasználó kezelő');

/* SQL ERROR MESSAGES */

cb_langdef('ACCOUNT_USERNAME_NOTVAILD_ERROR','E-mail cím nem valódi e-mail cím!');


cb_langdef('MODAL_CLOSE','Bezárás');
cb_langdef('LANG_ACCOUNT_USERNAME','E-mail');
cb_langdef('ACCOUNT_TEXT_USERNAME_TITLE','Kérem adja meg az e-mail címét');
cb_langdef('ACCOUNT_TEXT_USERNAME_EXAMPLE','example@mail.com');

cb_langdef('ACCOUNT_TEXT_PASSWORD_TITLE','Kérem adja meg a jelszavát');

cb_langdef('ACCOUNT_TEXT_THIS_IS_PRIVATE_DEVICE','(Ha ez egy privát eszköz)');

cb_langdef('ACCOUNT_TEXT_TITLE_NEWPASSWORD','Felhasználói jelszó módosítás');

cb_langdef('ACCOUNT_TEXT_TITLE_REGISTRATION_STEP1','Regisztráció');
cb_langdef('ACCOUNT_TEXT_TITLE_REGISTRATION_STEP2','Regisztráció');

cb_langdef('ADMIN_TEXT_ACCOUNT_MAIN_TITLE','Felhasználók kezelése');
cb_langdef('ADMIN_TEXT_ACCOUNT_INVITE_TITLE','Felhasználó meghívása');

cb_langdef('ACOUNT_TEXT_BUTTON_LOGIN','Bejelentkezés');
cb_langdef('ACOUNT_TEXT_BUTTON_REGMAILRESEND','Aktivációs e-mail újraküldés');

/* REGISTRATION */
cb_langdef('ACCOUNT_TEXT_REGISTRATION_CLOSED','Az oldalon a regisztráció inaktív, vagy csak meghívásra lehetséges!');


/* FORGOT PASSWORD */
cb_langdef('ACCOUNT_TEXT_FORGOTPASSWORD_TITLE','Elfelejtett jelszó helyreállítás');
cb_langdef('ACCOUNT_TEXT_FORGOTPASSWORD_BUTTON','Jelszó helyreállítása');
cb_langdef('ACCOUNT_TEXT_FORGOTPASSWORD_HELPTEXT','Az elfelejtett jelszó helyreállításához kérem adja meg az e-mail címét.<br />Amennyiben a cím létezik a rendszerben kapni fog egy levelet a további teendőkröl.');

/* REGISTRATION SUCCESS */
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_TITLE','Sikeres regisztráció');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_NORMAL_TEXT','Köszönjük, hogy regisztrált oldalunkra!<br />A felhasználói profilt aktiváltuk, Ön mostantól bejelentkezhet!');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_EMAIL_TEXT','Köszönjük, hogy regisztrált oldalunkra!<br />Emailben elküldtük önnek, az aktiváláshoz szükséges linket.');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_ADMIN_TEXT','Köszönjük, hogy regisztrált oldalunkra!<br />Regisztrációja az oldal üzembentartója általi jóváhagyással kerül élesítésre, amiről emailt fog kapni.');

cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_EMAIL_ACTIVATION_REQUIRE_THEME','<page> - Sikeres regisztráció, aktiváló email');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_EMAIL_ACTIVATION_REQUIRE_TEXT','Ön, vagy valaki az Ön nevében regisztrált weblapunkra.<br />Amennyiben regisztrációját érvényesíteni szeretné, kérem kattintson a következő linkre: <link>');

cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_ADMIN_ACTIVATION_REQUIRE_THEME','<page> - Sikeres regisztráció, visszaigazoló email');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_ADMIN_ACTIVATION_REQUIRE_TEXT','Köszönjük, hogy regisztrált a weblapunkra.<br />Fiókjának aktivációja a rendszer üzemeltetője által fog megtörténni, amelynek megtörténtéről szintén kapni fog emailt!');

/* LOGOUT */
cb_langdef('ACCOUNT_TEXT_LOGOUT','Kijelentkezés');
cb_langdef('ACCOUNT_TEXT_LOGOUT_SURE','Biztos, hogy ki szeretne lépni az oldalról?');
cb_langdef('ACCOUNT_TEXT_LOGOUT_BUTTON','Kijelentkezek');

/* SETTINGS */
cb_langdef('ACCOUNT_TEXT_SETTINGS','Felhasználói felület');





/* SETTINGS USERDATA*/
cb_langdef('ACCOUNT_TEXT_SETTINGS_USERDATA_SAVE_SUCCESS','Sikeres profil adat módosítás!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_FAILED','Sikertelen mentés :(');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_USERDATA_FIRST_NAME','Az utónév megadása kötelező!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_USERDATA_LAST_NAME','A vezetéknév megadása kötelező!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_USERDATA_DISPLAY_NAME','A megjelenő név megadása kötelező!');

/* SETTINGS PASSWORD */
cb_langdef('ACCOUNT_TEXT_SETTINGS_PASSWORD_SAVE_SUCCESS','Sikeres jelszó módosítás!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_ORIGINAL_PASSWORD_NOT_GOOD','Hibás régi jelszó!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_MUST_BE_FILL','Az új jelszó nem lehet üres!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_REPLY_MUST_BE_FILL','Az új jelszó ismételt megadása kötelező!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME','A két jelszó nem egyezik!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME_AS_OLD','A régi és új jelszó nem lehet azonos!');

/* EMAIL PASSWORD RECOVERY */
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_TITLE',"jelszó helyreállítás");
 
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_PRETEXT',"A fenti oldalon valaki egy jelszó helyreállítást kezdeményezett az email címeddel.");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_LINK',"Jelszó helyreállításhoz bökjön ide.");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_AFTTEXT',"A fenti link egy órán keresztül érvényes!<br />Amennyiben nem te kezdeményezted a helyreállítást, úgy kérlek tekíntsd ezt az emailt tárgytalannak!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_FOOTER',"");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_MAIL_SEND_SUCCESS',"Az email elküldése sikeres!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_MAIL_SEND_ERROR',"Az email elküldése sikertelen!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_SEND_SUCCESS_TITLE',"A helyreállítási email elküldve!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_SEND_SUCCESS_TEXT',"Elküldtünk önnek egy jelszó helyreállító emailt.<br />Az emailben található link 1 órán keresztül érvényes!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_CODE_INVAILD',"Érvénytelen kód!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_PASSWORD_CHANGE_SUCCESS_TITLE',"Sikeres jelszó változtatás!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_PASSWORD_CHANGE_SUCCESS_TEXT',"Ön sikeresen megváltozatta a jelszavát.");

return; ?>
