<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 12/12/18
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MESSAGE */
cb_langdef('ADMIN_MESSAGE_SETTINGS_SAVE_SUCCESS','Saved Successfully!');
cb_langdef('ADMIN_MESSAGE_SETTINGS_SAVE_ERROR_IN_DB','Insider, database error!<br />Save was unsuccessful :(');

/* ADMIN SETTINGS TAB TEXT */
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_GENERAL','General');
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_USER','Users');
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_EMAIL','Email sending');
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_SEO','SEO');
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_THEME','Theme');
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_CONTENT','Content');
cb_langdef('ADMIN_TEXT_ADMIN_TABMENU_OTHER','Other');


/* ADMIN SETTINGS TEXT */
//cb_langdef('ADMIN_TEXT_SETTINGS_ROW_GOOGLE_ANALYTICS_CODE','Google Analytics kód<br /><small>Ha elvan helyezve akkor az oldal kódjában elhelyeződik a Google Analytics kód, ami az oldal forgalmának mérésére és elemzésére használható.</small>');
cb_langdef('ADMIN_LTEXT_ADMIN_SETTINGS_MNAME','System Settings');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_SITETITLE','Site title');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_SITETITLE2','Site sub-title (if in use)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_LANGTYPE','Managed languages');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_LANGTYPE_USER_DEFAULT','Default user language');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_LANGTYPE_ADMIN_DEFAULT','Default admin language');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_DEBUG','Debug mode?');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_DEBUG_FALSE','Debug and log show, switch off');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_DEBUG_TRUE','Debug and log show, switch on');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_DEF_PAGE','Default static page (menu ID)');

cb_langdef('ADMIN_TEXT_SETTINGS_ROW_SESSIONVALUE','How long keep you logged in, <i>in sec</i> <small>(session value)</small>');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_SESSIONSTAYLOGINVALUE','If stay logged in checkbox is on, <i>in sec</i> <small>(cookie time)</small>');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_REGMODE','Registration mode');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_REGMODE_NONE','Registration off');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_REGMODE_NORMAL','Registration without email');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_REGMODE_NORMAL_EMAIL','Registration with, activation email!');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_REGMODE_NORMAL_ADMIN','Registration after admin rewiev!');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_REGMODE_INVITED','Registration with invation!');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_REGMODE_ADMIN_INVITED','Registration ONLY with admin invation!');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_REGISTRATION_TERM_ID','Regisztrációs feltételek (Bejegyzés ID)<br /><small>Ha van megadva ID, akkor regisztrációkor a feltétel elfogadása kötelező!<br />Ha nincs megadva ID, akkor nem jelenik meg a regisztrációs formon az erre vonatkozó checkbox!</small>');

cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_CHARSET','Email charset (prefer: utf-8)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_FROM','Default sender (from)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_FROM_NAME','Default sender name');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_TYPE','Mail type');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SENDMAIL_ROOT','Sendmail ROOT  (usually: "/usr/bin/sendmail")');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SMTP_AUTH','SMTP authentication is needed?');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SMTP_USERNAME','SMTP username');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SMTP_PASSWORD','SMTP password');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SMTP_SERVER','SMTP server');

cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SMTP_PORT','SMTP port');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_MAIL_SMTP_SECURE','SMTP secure type (if got)');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_SECURE_NONE','None secure');

cb_langdef('ADMIN_TEXT_SETTINGS_ROW_IS_SEO','SEO URL use?');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_META_DEF_AUTH','Default META owner');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_META_DEF_DESC','Default META description');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_META_DEF_KEY','Default META keywords');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_GOOGLE_ANALYTICS_CODE','Google Analytics code');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_SEO_LINK_IMAGE','Defaul SEO link image, when shared on SM. (eg.: fb, viber, stb..)');

cb_langdef('ADMIN_TEXT_SETTINGS_ROW_THEMESET','Site themeset');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ADMIN_THEMESET','Admin themeset');

cb_langdef('ADMIN_TEXT_SETTINGS_ROW_PAGETITLE_STYLE','Site, browser title order and style');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_PAGETITLE_1','[site title] - [content title]');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_PAGETITLE_2','[content title] - [site title]');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_PAGETITLE_3','[Content title]');
    cb_langdef('ADMIN_TEXT_SETTINGS_MASKED_PAGETITLE_4','[Site title]');
    
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ARTICLE_HEADERIMG_HEIGHT','Article individual header height  (pixel)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ARTICLE_HEADERIMG_WIDTH','Article individual header width (pixelben)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ARTICLE_THUMBNAIL_NORMAL_HEIGHT','Article individual thumbnail height, normal (pixel)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ARTICLE_THUMBNAIL_NORMAL_WIDTH','Article individual thumbnail width normal (pixel)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ARTICLE_THUMBNAIL_SMALL_HEIGHT','Article individual thumbnail height, small (pixel)');
cb_langdef('ADMIN_TEXT_SETTINGS_ROW_ARTICLE_THUMBNAIL_SMALL_WIDTH','Article individual thumbnail width, small (pixel)');
/* SQL ERROR MESSAGES */

return; ?>