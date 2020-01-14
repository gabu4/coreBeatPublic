<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v013
 * @date 08/11/18
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MAIN TITLE */
cb_langdef('LANG_ADMIN_CATALOG_MAIN_TNAME','Katalógus');
cb_langdef('LANG_ADMIN_CATALOG_LIST_TNAME','Katalógus');
cb_langdef('LANG_ADMIN_CATALOG_CATALOG_CREATE_TNAME','Termék létrehozás');
cb_langdef('LANG_ADMIN_CATALOG_CATALOG_EDIT_TNAME','Termék szerkesztés');

/* ADMIN MENU TITLE */
cb_langdef('LANG_ADMIN_CATALOG_MAIN_MNAME','Katalógus');
cb_langdef('LANG_ADMIN_CATALOG_LIST_MNAME','Termék lista');

/* SQL ERROR MESSAGES */


/* ADMIN MESSAGE */
cb_langdef('ADMIN_MESSAGE_CATALOG_CATALOG_DELETE_SUCCESS_DELETE','Sikeres törlés');


/* ADMIN MENUPOINT */

/* CALL LIST TEXTS */
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_TITLE','Termékek');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_ID','ID');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_ARTICLENAME','Bejegyzés név');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_ARTICLENAME_EMPTY','<-- Bejegyzés név nincs megadva -->');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_CDATE','Készítési idő');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_MDATE','Módosítási idő');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_EMPTY','Jelenleg nincs feltöltött termék :-(');

cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE','Kategória szűrés: ');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_CATEGORY_SELECT_TEXT_ALL','- mind -');
cb_langdef('ADMIN_TEXT_CATALOG_CALL_MAIN_CATEGORY_SELECT_TEXT_NOCATEGORY','- kategória nélküliek -');

/* CALL CREATE TEXTS */
cb_langdef('ADMIN_TEXT_CATALOG_CREATE_TITLE','Termék létrehozás');
cb_langdef('ADMIN_TEXT_CATALOG_NO_CATEGORY_SELECT_TEXT','- kategória nélkül -');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_STATE','Állapot');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_STATE_INACTIVE','Inaktív');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_STATE_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_TABMENU_CONTENT','Hosszú termék leírás');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_TABMENU_CATEGORY','Kategória');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_TABMENU_IMAGE','Termék kép');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_TABMENU_META','META');

cb_langdef('ADMIN_TEXT_CATALOG_CALL_DELETESURE','Biztos, hogy törölni akarod a kiválasztott terméket? (nem fogod tudni visszaállítani)');
cb_langdef('ADMIN_MESSAGE_CATALOG_SAVE_SUCCESS','Sikeres mentés');
cb_langdef('ADMIN_MESSAGE_CATALOG_SAVE_ERROR_IN_DB','Belső hiba!<br />Sikertelen mentés :(');

/* Content names */
cb_langdef('ADMIN_TEXT_CATALOG_LIST_TITLE','Termék kezelő');

cb_langdef('ADMIN_TEXT_CATALOG_TITLE','Termék ...');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_TITLE','Termék szerkesztés');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_NAME','Termék neve');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_SEO_NAME','SEO név');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_CONTENT','Tartalom');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_SHORT_TEXT','Rövid leírás');
cb_langdef('ADMIN_TEXT_CATALOG_EDIT_LONG_TEXT','Hosszú leírás');

cb_langdef('ADMIN_TEXT_CATALOG_CATEGORY_EDIT_NAME','Kategória néve');
cb_langdef('ADMIN_TEXT_CATALOG_CATEGORY_EDIT_DESP','Kategória leírás');

cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_THUMBNAIL_TITLE','Termék kiskép');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_THUMBNAIL_ERROR','<div id="thumbnail-message-error" class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_THUMBNAIL_DELETE','Feltöltött kiskép törlése');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_HEADERIMG_TITLE','Egyedi oldal fejléckép');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_HEADERIMG_ERROR','<div id="headerimage-message-error" class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_HEADERIMG_DELETE','Feltöltött fejléckép törlése');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_CATALOGIMG_TITLE','Termék nagykép');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_CATALOGIMG_ERROR','<div id="catalogimage-message-error" class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_CATALOGIMG_DELETE','Feltöltött nagykép törlése');
cb_langdef('ADMIN_TEXT_CATALOG_IMAGE_TAB_YOUTUBE_TITLE','Youtube video ID');


cb_langdef('ADMIN_TEXT_CATALOG_META_EDIT_METAKEY','Kereső kulcsok:');
cb_langdef('ADMIN_TEXT_CATALOG_META_EDIT_METADESC','Kereső leírás:');

return; ?>
