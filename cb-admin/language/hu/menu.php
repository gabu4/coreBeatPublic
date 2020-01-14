<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 17/03/19
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MAIN TITLE */
cb_langdef('LANG_ADMIN_MENU_MAIN_TNAME','Menü kezelő');
cb_langdef('LANG_ADMIN_MENU_GROUP_MAIN_TNAME','Menü kategóriák');
cb_langdef('LANG_ADMIN_MENU_GROUP_CREATE_TNAME','Menü kategória létrehozása');
cb_langdef('LANG_ADMIN_MENU_GROUP_EDIT_TNAME','Menü kategória szerkesztése');
cb_langdef('LANG_ADMIN_MENU_LIST_TNAME','Menüpont elemek');
cb_langdef('LANG_ADMIN_MENU_CREATE_TNAME','Új menüpont');
cb_langdef('LANG_ADMIN_MENU_EDIT_TNAME','Menüpont szekresztés');

/* ADMIN MENU TITLE */
cb_langdef('LANG_ADMIN_MENU_MAIN_MNAME','Menü kezelő');
cb_langdef('LANG_ADMIN_MENU_GROUP_MAIN_MNAME','Kategóriák');

/* ADMIN MENUPOINT */
cb_langdef('LANG_ADMIN_MENU_MENUPOINT_MENU_TITLE','Egyéb menü elemek');
cb_langdef('LANG_ADMIN_MENU_MENUPOINT_MENU_HTML_NAME','Külső oldal');

/* MENU MAIN LIST TEXT */
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_TITLE','Menü kategóriák');
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_ID','ID');
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_MENUNAME','Menü név');
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_MENULISTNAME','Menüpont név');
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_STATE','Állapot');
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_ORDER','Sorrend');
cb_langdef('ADMIN_TEXT_MENU_CALL_DELETESURE','Biztos, hogy törölni akarod a kiválasztott csoportot? (nem fogod tudni visszaállítani és a benne levő menüpontok szintén törlődnek)');
cb_langdef('ADMIN_TEXT_MENU_CALL_EMPTY','Jelenleg nincs létrehozott menücsoport :-(');

cb_langdef('ADMIN_TEXT_MENU_LIST_DELETESURE','Biztos, hogy törölni akarod a menüpontot?');
cb_langdef('ADMIN_TEXT_MENU_LIST_EMPTY','A menücsoport sajnos üres :-(');
cb_langdef('ADMIN_TEXT_MENU_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE','Kategória szűrés: ');


/* CALL CREATE MENUPOINT */
cb_langdef('ADMIN_TEXT_MENUPOINT_SELECTOR_LANGUAGE','Menüpont nyelv');
cb_langdef('ADMIN_TEXT_MENUPOINT_SELECTOR_PARENT_MAINMENU','FŐMENÜ');

/* CALL CREATE MENUPOINT HTML */
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_CREATE_TITLE','Új menüpont: Külső oldal');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_EDIT_TITLE','Menüpont szerkesztés: Külső oldal');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_STATE','Állapot');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_STATE_INACTIVE','Inaktív');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_STATE_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_NAME','Menüpont neve');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_CATEGORY','Menü csoport');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_PARENT','Menü szülő');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_HTML_LINK','Oldal URL cím');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_IS_BLANK','Új oldalon nyílik meg');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_ORDER','Sorrend');
cb_langdef('ADMIN_TEXT_MENUPOINT_HTML_TEXT','Menüpont leírás');

/* CALL CREATE MENUPOINT ARTICLE */
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_CREATE_TITLE','Új menüpont: Bejegyzés');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_EDIT_TITLE','Menüpont szerkesztés: Bejegyzés');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_STATE','Állapot');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_STATE_INACTIVE','Inaktív');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_STATE_ACTIVE','Aktív');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_NAME','Menüpont neve');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_SEO_NAME','SEO név');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_SEO_NAME_REFRESH','SEO frissítés');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_CATEGORY','Menü csoport');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_PARENT','Menü szülő');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_ATRICLE','Tartalom');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_HTML_LINK','Oldal URL cím');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_IS_BLANK','Új oldalon nyílik meg');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_ORDER','Sorrend');
cb_langdef('ADMIN_TEXT_MENUPOINT_ARTICLE_TEXT','Menüpont leírás');

/* SQL ERROR MESSAGES */
cb_langdef('ADMIN_MESSAGE_MENUPOINT_SAVE_ERROR_IN_MENUTABLE','Hiba történt mentés közben! ERROR ID: #MENU-1711');
cb_langdef('ADMIN_MESSAGE_MENUPOINT_SAVE_ERROR_IN_CONTENTTABLE','Hiba történt mentés közben! ERROR ID: #MENU-1712');

cb_langdef('ADMIN_MESSAGE_MENUPOINT_SAVE_SUCCESS','A menüpont mentése sikeres!');

return; ?>