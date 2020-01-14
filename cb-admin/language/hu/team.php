<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v013
 * @date 08/11/18
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MAIN TITLE */
cb_langdef('LANG_ADMIN_TEAM_MAIN_TNAME','Csapat kezelő');
cb_langdef('LANG_ADMIN_TEAM_CREATE_TNAME','Új munkatárs felvétele');
cb_langdef('LANG_ADMIN_TEAM_EDIT_TNAME','Munkatárs szerkesztése');

/* ADMIN MENU TITLE */
cb_langdef('LANG_ADMIN_TEAM_MAIN_MNAME','Csapat kezelő');

/* SQL ERROR MESSAGES */
cb_langdef('PAGE_NO_TEAM_DATA','Nincs felvéve munkatárs!');

/* ADMIN MESSAGE */
cb_langdef('ADMIN_MESSAGE_TEAM_SAVE_SUCCESS','Sikeres mentés');
cb_langdef('ADMIN_MESSAGE_TEAM_SAVE_ERROR_IN_DB','Belső hiba!<br />Sikertelen mentés :(');
cb_langdef('ADMIN_MESSATE_TEAM_TRASH_SUCCESS','A munkatárs sikeresen törölve');
cb_langdef('ADMIN_MESSAGE_TEAM_ERROR_ID_NOT_EXIST','Nem létező tartalom ID :(');
cb_langdef('ADMIN_MESSAGE_TEAM_TRASH_ERROR_ID_NOT_EXIST','Nem létező tartalom ID :(');
cb_langdef('ADMIN_TEXT_TEAM_CALL_DELETESURE','Biztos, hogy törölni akarod a kiválasztott munkatársat? (nem fogod tudni visszaállítani)');

cb_langdef('ADMIN_TEXT_TEAM_EDIT_STATE','Állapot');
cb_langdef('ADMIN_TEXT_TEAM_ORDER','Sorrend');
cb_langdef('ADMIN_TEXT_TEAM_TEAMMATE_NAME','Munkatárs neve');
cb_langdef('ADMIN_TEXT_TEAM_TEAMMATE_TITULUS','Titulus');
cb_langdef('ADMIN_TEXT_TEAM_TEAMMATE_MUNKAI','Munkái Facebook album ID');
cb_langdef('ADMIN_TEXT_TEAM_TEAMMATE_FOGLALAS','Online foglalás (link)');

cb_langdef('ADMIN_TEXT_TEAMMATE_EDIT_TABMENU_CONTENT','Leírás');

cb_langdef('ADMIN_TEXT_TEAM_IMAGE_TAB_IMAGE_TITLE','Profil kiskép');
cb_langdef('ADMIN_TEXT_TEAM_IMAGE_TAB_IMAGE_ERROR','<div id="image-message-error" class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>');
cb_langdef('ADMIN_TEXT_TEAM_IMAGE_TAB_IMAGE_DELETE','Feltöltött profilkép törlése');



return; ?>
