<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 06/03/18
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MAIN TITLE */
cb_langdef('ADMIN_TITLE_CONTACT_MAIN_TNAME','Contact');
cb_langdef('ADMIN_TITLE_CONTACT_POSTS_TNAME','Form message');
cb_langdef('ADMIN_TITLE_CONTACT_MAPS_TNAME','Maps');

/* ADMIN MENU TITLE */
cb_langdef('ADMIN_LTEXT_CONTACT_MAIN_MNAME','Contact');
cb_langdef('ADMIN_LTEXT_CONTACT_FORMS_MNAME','Forms');
cb_langdef('ADMIN_LTEXT_CONTACT_POSTS_MNAME','Form message');
cb_langdef('ADMIN_LTEXT_CONTACT_MAPS_MNAME','Maps');

/* CALL CONTACT:FORMS TEXTS */
cb_langdef('ADMIN_TITLE_CONTACT_FORMS_TNAME','Forms');
cb_langdef('ADMIN_TEXT_CONTACT_FORMS_CALL_EMPTY','There is no forms yet :-(');
cb_langdef('ADMIN_TEXT_CONTACT_CALL_DELETESURE','Are you sure to delete this form permanently?');
cb_langdef('ADMIN_MESSAGE_CONTACT_ERROR_ID_NOT_EXIST','The content ID does not exist :(');

/* CALL CONTACT:FORMS_CREATE TEXTS */
cb_langdef('ADMIN_TITLE_CONTACT_FORMS_CREATE_TNAME','New form');
cb_langdef('ADMIN_TITLE_CONTACT_FORMS_EDIT_TNAME','Edit form');
cb_langdef('ADMIN_TEXT_FORM_CREATE_NAME','Form name');
cb_langdef('ADMIN_TEXT_FORM_CREATE_STATE','Status');
cb_langdef('ADMIN_TEXT_FORM_CREATE_STATE_ACTIVE','Active');
cb_langdef('ADMIN_TEXT_FORM_CREATE_STATE_INACTIVE','Inactive');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_SUBJECT','subject in mail');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_EMAIL','Destination address (where mails will go<br /><small><i>Separate more addresses with: ;</i></small>');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_FORM_CLASS','CSS class');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_SEND_TEXT','Text on submit button');
cb_langdef('ADMIN_TEXT_FORM_CREATE_TARGET_SEND_TEXT_DEFAULT','Send');


/* CALL CONTACT:FORMS_CREATE SUCCESS TEXTS */
cb_langdef('ADMIN_TEXT_FORM_CREATE_SUCCESS_MESSAGE','Form created!');
cb_langdef('ADMIN_TEXT_FORM_EDIT_SUCCESS_MESSAGE','Form edited!');

/* CALL CONTACT:FORMS_CREATE ERROR TEXTS */
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_SOME_ERROR_IN_FIELDS','There was one or more error while create the form!');
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_SOME_ERROR_IN_SAVE_DB','There was some DB error while saveing!');

cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_NAME_MUST_BE_FILL','The form title must be filled!');
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_TARGET_EMAIL_MUST_BE_FILL','Destination address is must be filled!');
cb_langdef('ADMIN_TEXT_FORM_CREATE_ERROR_SEND_TEXT_MUST_BE_FILL','Submit button text must be filled!');


/* SQL ERROR MESSAGES */

return; ?>