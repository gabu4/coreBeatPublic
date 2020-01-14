<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 08/11/18
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MAIN TITLE */
cb_langdef('LANG_ADMIN_CONTACT_MAIN_TNAME','Kapcsolat');
cb_langdef('LANG_ADMIN_CONTACT_POSTS_TNAME','Űrlap üzenetek');
cb_langdef('LANG_ADMIN_CONTACT_MAPS_TNAME','Térképek');

/* ADMIN MENU TITLE */
cb_langdef('LANG_ADMIN_CONTACT_MAIN_MNAME','Kapcsolat');
cb_langdef('LANG_ADMIN_CONTACT_FORMS_MNAME','Űrlapok');
cb_langdef('LANG_ADMIN_CONTACT_POSTS_MNAME','Űrlap üzenetek');
cb_langdef('LANG_ADMIN_CONTACT_MAPS_MNAME','Térképek');

/* CALL CONTACT:FORMS TEXTS */
cb_langdef('LANG_ADMIN_CONTACT_FORMS_TNAME','Űrlapok');
cb_langdef('ADMIN_TEXT_CONTACT_FORMS_CALL_EMPTY','Még nincs létrehozott űrlap :-(');
cb_langdef('ADMIN_TEXT_CONTACT_CALL_DELETESURE','Biztos, hogy törli akarod az adott űrlapot? (nem fogod tudni visszaállítani)');
cb_langdef('ADMIN_MESSAGE_CONTACT_ERROR_ID_NOT_EXIST','Nem létező tartalom ID :(');

/* CALL CONTACT:FORMS_CREATE TEXTS */
cb_langdef('LANG_ADMIN_CONTACT_FORMS_CREATE_TNAME','Új űrlap létrehozása');
cb_langdef('LANG_ADMIN_CONTACT_FORMS_EDIT_TNAME','Űrlap szerkesztése');
cb_langdef('ADMIN_TEXT_FORM_CREATE_NAME','Űrlap neve');
cb_langdef('ADMIN_TEXT_FORM_CREATE_STATE','Állapot');
cb_langdef('ADMIN_TEXT_FORM_CREATE_STATE_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_FORM_CREATE_STATE_INACTIVE','Inaktív');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_SUBJECT','Téma címe az emailben');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_EMAIL','Cél email cím (ahova az üzenetek mennek)<br /><small><i>Több cím megadható ha <bold>;</bold>-vel elválasztjuk</i></small>');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_FORM_CLASS','CSS osztály');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_SEND_TEXT','Küldés gomb felirata');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_SEND_TEXT_DEFAULT','Küldés');


/* CALL CONTACT:FORMS_CREATE SUCCESS TEXTS */
cb_langdef('ADMIN_TEXT_FORM_CREATE_SUCCESS_MESSAGE','Az űrlap létrehozása sikeres!');
cb_langdef('ADMIN_TEXT_FORM_EDIT_SUCCESS_MESSAGE','Az űrlap módosítása sikeres!');

/* CALL CONTACT:FORMS_CREATE ERROR TEXTS */
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_SOME_ERROR_IN_FIELDS','Az űrlap kitöltése közben egy vagy több hiba keletkezett!');
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_SOME_ERROR_IN_SAVE_DB','Hiba az űrlap adatbázisba mentése közben!');

cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_NAME_MUST_BE_FILL','Az űrlap nevének kitöltése kötelező!');
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_TARGET_EMAIL_MUST_BE_FILL','Cél email cím megadása kötelező!');
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_SEND_TEXT_MUST_BE_FILL','Gomb felirat megadása kötelező!');


/* SQL ERROR MESSAGES */

return; ?>