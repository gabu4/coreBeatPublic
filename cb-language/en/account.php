<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v012
 * @date 02/07/19
 */
if ( !defined('H-KEI') ) { exit; }

/* ADMIN MENU TITLE */
cb_langdef('ADMIN_LTEXT_ACCOUNT_MNAME','Account manager');

/* SQL ERROR MESSAGES */

cb_langdef('ACCOUNT_USERNAME_NOTVAILD_ERROR','The address is not valid!');


cb_langdef('MODAL_CLOSE','Close');
cb_langdef('LANG_ACCOUNT_USERNAME','E-mail');
cb_langdef('ACCOUNT_TEXT_USERNAME_TITLE','Please give e-mail address');
cb_langdef('ACCOUNT_TEXT_USERNAME_EXAMPLE','example@mail.com');
cb_langdef('ACCOUNT_TEXT_PASSWORD','Password');
cb_langdef('ACCOUNT_TEXT_PASSWORD_TITLE','Please give password');
cb_langdef('ACCOUNT_TEXT_REMEMBER_ME','Remember me');

cb_langdef('ACCOUNT_TEXT_THIS_IS_PRIVATE_DEVICE','(If the device is private)');

cb_langdef('ACCOUNT_TEXT_TITLE_NEWPASSWORD','Change user password');

cb_langdef('ACCOUNT_TEXT_TITLE_REGISTRATION_STEP1','Registration');
cb_langdef('ACCOUNT_TEXT_TITLE_REGISTRATION_STEP2','Registration');

cb_langdef('ADMIN_TEXT_ACCOUNT_MAIN_TITLE','Manage users');
cb_langdef('ADMIN_TEXT_ACCOUNT_INVITE_TITLE','Invite user');

cb_langdef('ACOUNT_TEXT_BUTTON_LOGIN','Log in');
cb_langdef('ACOUNT_TEXT_BUTTON_REGISTRATION','Registration');
cb_langdef('ACOUNT_TEXT_BUTTON_REGMAILRESEND','Activation email re-send');

/* REGISTRATION */
cb_langdef('ACCOUNT_TEXT_REGISTRATION_CLOSED','Currently the registration is offline, or based on invite.');


cb_langdef('ACCOUNT_TEXT_INV_CODE','Invitation code (if have)');
cb_langdef('ACCOUNT_TEXT_INV_CODE_TITLE','Invitation code (if have)');
cb_langdef('ACCOUNT_TEXT_INV_CODE_EXAMPLE','');
cb_langdef('ACCOUNT_TEXT_INV_CODE_HELPTEXT','');


/* FORGOT PASSWORD */
cb_langdef('ACCOUNT_TEXT_FORGOTPASSWORD_TITLE','Password reset');
cb_langdef('ACCOUNT_TEXT_FORGOTPASSWORD_BUTTON','Password reset');
cb_langdef('ACCOUNT_TEXT_FORGOTPASSWORD_HELPTEXT','To reset your password, please use your e-mail, <br />if the address is in the database you will get a mail.');

/* REGISTRATION SUCCESS */
cb_langdef('ACCOUNT_TEXT_REGISTRATION_TITLE_SUCCESS','Registration successful');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_NORMAL_TEXT','Thanks for the registration, you can use your account now!');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_EMAIL_TEXT','Thanks for the registration, we send you an activation e-mail!');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_ADMIN_TEXT','Thanks for the registration, one of the site administrators will review your account');

cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_EMAIL_ACTIVATION_REQUIRE_THEME','<page> - Successful registration - activation mail');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_EMAIL_ACTIVATION_REQUIRE_TEXT','Someone (hopefully you) registrated, to our site. If you want activate your account please click here <link>');

cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_ADMIN_ACTIVATION_REQUIRE_THEME','<page> - Successful registration-information mail');
cb_langdef('ACCOUNT_TEXT_REGISTRATION_SUCCESS_ADMIN_ACTIVATION_REQUIRE_TEXT','Thanks for the registration, one of the site administrators will review your accoount, we will send a mail after that!');

/* LOGOUT */
cb_langdef('ACCOUNT_TEXT_LOGOUT','Log out');
cb_langdef('ACCOUNT_TEXT_LOGOUT_SURE','Are you sure to log out?');
cb_langdef('ACCOUNT_TEXT_LOGOUT_BUTTON','Logout');

/* SETTINGS */
cb_langdef('ACCOUNT_TEXT_SETTINGS','User area');

 
 
 

/* SETTINGS USERDATA*/
cb_langdef('ACCOUNT_TEXT_SETTINGS_USERDATA_SAVE_SUCCESS','Successfully changed the user data(s)!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_FAILED','Unsuccessful save :(');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_USERDATA_FIRST_NAME','The first name is must be filled!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_USERDATA_LAST_NAME','The last name is must be filled!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_USERDATA_DISPLAY_NAME','The display name is must be filled!');

/* SETTINGS PASSWORD */
cb_langdef('ACCOUNT_TEXT_SETTINGS_PASSWORD_SAVE_SUCCESS','Password successfully changed!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_ORIGINAL_PASSWORD_NOT_GOOD','wrong current password!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_MUST_BE_FILL','The new password is must be filled!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_REPLY_MUST_BE_FILL','The new password check is must be filled!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME','The password does not match!');
cb_langdef('ACCOUNT_TEXT_ERROR_SAVE_PASSWORD_NEW_PASSWORD_NOT_SAME_AS_OLD',"The current and the new password can't be the same");

/* EMAIL PASSWORD RECOVERY */
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_TITLE',"Password recovery");
 
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_PRETEXT',"Someone want to reset your password on our site.");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_LINK',"To reset your password click here.");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_AFTTEXT',"This link will live for one hour, if it wasn't you, please check your other passwords!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_NEW_PASS_GET_FOOTER',"");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_MAIL_SEND_SUCCESS',"Mail sent!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_MAIL_SEND_ERROR',"Can't sent the mail!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_SEND_SUCCESS_TITLE',"Recovery mail sent!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_SEND_SUCCESS_TEXT',"We sent you a password recovery mail. The link will live for one hour!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_CODE_INVAILD',"Invaild code!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_PASSWORD_CHANGE_SUCCESS_TITLE',"Password change successfully!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_PASSWORD_CHANGE_SUCCESS_TEXT',"Password change successfully.");


/* Affiliate / EMAIL Invitation */
cb_langdef('ACCOUNT_TEXT_USERSETTINGS_AFFILIATE_TITLE',"Affiliate");

 
 
 
 
 
 

cb_langdef('ACCOUNT_TEXT_INVITATION_EMAIL_MAIL_SEND_SUCCESS',"Mail sent!");
 

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_SEND_SUCCESS_TITLE',"Recovery mail sent!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_SEND_SUCCESS_TEXT',"We sent you a password recovery mail. The link will live for one hour!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_EMAIL_CODE_INVAILD',"Invaild code!");

cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_PASSWORD_CHANGE_SUCCESS_TITLE',"Password change successfully!");
cb_langdef('ACCOUNT_TEXT_PASSWORD_RECOVERY_PASSWORD_CHANGE_SUCCESS_TEXT',"Password change successfully.");

return; ?>
