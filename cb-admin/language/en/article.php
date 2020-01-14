<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 17/03/19
 */
if ( !defined('H-KEI') ) { exit; }

/* SQL ERROR MESSAGES */
cb_langdef('PAGE_NO_ARTICLE_DATA','No content for article!');

/* ADMIN MESSAGE */
cb_langdef('ADMIN_MESSAGE_ARTICLE_SAVE_SUCCESS','Saved successfully');
cb_langdef('ADMIN_MESSAGE_ARTICLE_SAVE_ERROR_IN_DB','Belső hiba!<br />Sikertelen mentés :(');
cb_langdef('ADMIN_MESSAGE_ARTICLE_ERROR_ID_NOT_EXIST','Nem létező tartalom ID :(');
cb_langdef('ADMIN_MESSAGE_ARTICLE_TRASH_ERROR_ID_NOT_EXIST','Nem létező tartalom ID :(');

cb_langdef('ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_SUCCESS','Sikeres mentés');
cb_langdef('ADMIN_MESSAGE_MENUPOINTARTICLE_SAVE_ERROR_IN_DB','Belső hiba!<br />Sikertelen mentés :(');

/* ADMIN MENUPOINT */
cb_langdef('LANG_ADMIN_MENU_MENUPOINT_ARTICLE_TITLE','Bejegyzés elemek');
cb_langdef('LANG_ADMIN_MENU_MENUPOINT_ARTICLE_ARTICLE_NAME','Bejegyzés');
cb_langdef('LANG_ADMIN_MENU_MENUPOINT_ARTICLE_ARTICLE_CATEGORY_NAME','Bejegyzés kategória (hír rendezés)');
cb_langdef('LANG_ADMIN_MENU_MENUPOINT_ARTICLE_PARALAX_NAME','Paralax oldal');

/* CALL MAIN TEXTS */
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_TITLE','Bejegyzések');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_ID','ID');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_ARTICLENAME','Bejegyzés név');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_ARTICLENAME_EMPTY','<-- Bejegyzés név nincs megadva -->');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_CDATE','Készítési idő');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_MDATE','Módosítási idő');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_DELETESURE','Biztos, hogy törölni akarod a kiválasztott bejegyzést? (nem fogod tudni visszaállítani)');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_EMPTY','Jelenleg nincs feltöltött bejegyzés :-(');

cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE','Kategória szűrés: ');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_ALL','- mind -');
cb_langdef('ADMIN_TEXT_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_NOCATEGORY','- kategória nélküliek -');

/* CALL CREATE TEXTS */
cb_langdef('ADMIN_TEXT_ARTICLE_CREATE_TITLE','Bejegyzés létrehozás');
cb_langdef('ADMIN_TEXT_ARTICLE_NO_CATEGORY_SELECT_TEXT','- kategória nélkül -');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_STATE','Állapot');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_STATE_INACTIVE','Inaktív');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_STATE_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TABMENU_CONTENT','Tartalom');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TABMENU_CATEGORY','Kategória');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TABMENU_IMAGE','Bejegyzés kép');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TABMENU_MENUPOINT','Menüpont');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TABMENU_META','META');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TABMENU_OTHER','Egyéb');

/* Content names */
cb_langdef('ADMIN_TEXT_ARTICLE_LIST_TITLE','Bejegyzés kezelő');

cb_langdef('ADMIN_TEXT_ARTICLE_TITLE','Bejegyzés ...');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_TITLE','Bejegyzés szerkesztés');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_NAME','Bejegyzés neve');
cb_langdef('ADMIN_TEXT_ARTICLE_EDIT_CONTENT','Tartalom');

cb_langdef('ADMIN_TEXT_ARTICLE_CATEGORY_EDIT_NAME','Kategória néve');
cb_langdef('ADMIN_TEXT_ARTICLE_CATEGORY_EDIT_DESP','Kategória leírás');

cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_THUMBNAIL_TITLE','Bejegyzés kiskép');
cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_THUMBNAIL_ERROR','<div id="thumbnail-message-error" class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>');
cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_THUMBNAIL_DELETE','Feltöltött kiskép törlése');
cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_HEADERIMG_TITLE','Egyedi oldal fejléckép');
cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_HEADERIMG_ERROR','<div id="headerimage-message-error" class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Nem engedélyezett formátum! <b>Megjegyzés:</b> Csak jpeg, jpg, png és gif képek engedélyezettek! </div>');
cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_HEADERIMG_DELETE','Feltöltött fejléckép törlése');
cb_langdef('ADMIN_TEXT_ARTICLE_IMAGE_TAB_YOUTUBE_TITLE','Youtube video ID');


cb_langdef('ADMIN_TEXT_ARTICLE_META_EDIT_METAKEY','Kereső kulcsok:');
cb_langdef('ADMIN_TEXT_ARTICLE_META_EDIT_METADESC','Kereső leírás:');

cb_langdef('ADMIN_TEXT_ARTICLE_OTHER_TAB_TEMPLATE','Egyedi template stílus:');
cb_langdef('ADMIN_TEXT_ARTICLE_OTHER_TAB_CLASS','Egyedi CSS osztály:');
cb_langdef('ADMIN_TEXT_ARTICLE_OTHER_TAB_CSS','Saját CSS fájl beltöltés: <small> (vesszővel elválaszva több fájl is megadható)</small>');
cb_langdef('ADMIN_TEXT_ARTICLE_OTHER_TAB_JS','Saját Javascript fájl betöltés: <small> (vesszővel elválaszva több fájl is megadható)</small>');



return; ?>
