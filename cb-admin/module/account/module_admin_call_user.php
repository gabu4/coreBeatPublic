<?php
namespace module\admin\account\user;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v060
 * @date 02/11/19
 */
if ( !defined('H-KEI') ) { exit; }

trait call {
    
    /* Felhasználókezelő főoldal */
    public function __call_main() {
        
        $html = $this->callMain_themeLoad();
        
        return $html;
    }
    
    public function __call_create() {
        if ( $this->callCreate_checkPost() ) { $this->callCreate_savePost(); }
        
        $html = $this->callCreate_themeLoad();
        return $html;
    }

    public function __call_edit() {
        global $get, $handler;
        
        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            $account_id = $get['id'];
            
            if ( $this->callCreate_checkPost(TRUE, $account_id) ) { $this->callCreate_savePost($account_id); }
            
            $html = $this->callCreate_themeLoad($account_id);
            
            return $html;
        
        } else {
            $handler->messageError2('','[LANG_ADMIN_ACCOUNT_MESSAGE_ERROR_ID_NOT_EXIST]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
        }
        
        return $html;
    }
    
    public function __call_delete() {
        global $get, $handler;
        
        if ( isset($get['id']) and is_numeric($get['id']) and ($get['id'] > 0) ) {
            if ( $this->callDelete_checkUser($get['id']) ) {
                $t = $this->callDelete_userDelete($get['id']);
                if ( $t ) {
                    $handler->messageSuccess2('','[LANG_ADMIN_ACCOUNT_MESSAGE_ACCOUNT_DELETE_SUCCESS]',true,"save");
                    global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
                } else {
                    $handler->messageError2('','[LANG_ADMIN_ACCOUNT_MESSAGE_ERROR_IN_ACOUNT_DELETE]',true,"save");
                    global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
                }
            } else {
                $handler->messageError2('','[LANG_ADMIN_ACCOUNT_MESSAGE_ERROR_NO_RIGHTS_FOR_ACCOUNT_DELETE]',true,"save");
                global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
            }
        } else {
            $handler->messageError2('','[LANG_ADMIN_ACCOUNT_MESSAGE_ERROR_ID_NOT_EXIST]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
        }
        
        return $html;
    }
    
    public function __call_details() {
        global $theme, $user, $database, $handler, $get, $post;

        if (!isset($get['id']) OR empty($get['id'])) {
            $handler->messageError2('','[LANG_ADMIN_ACCOUNT_MESSAGE_ERROR_ID_NOT_EXIST]',true,"save");
            global $out_html;$out_html->redirect(CB_INDEX."?admin=account&funct=main");
        }
        
        $account_id = $get['id'];
        
        $html = $this->callDetails_themeLoad($account_id);
        
        return $html;
    }
    
    
/* Ezután a pont után elavult/nem működő újrairandó elemek! */
    
    
    
    //FIXME: újraírni!
    public function __call_invite() {
        global $theme, $database, $mail, $user, $handler, $post;

        $html = $theme->loadModuleTemplate('_admin_account_invite_template');

        if (isset($post['adminAccountInviteButton'])) {
            $error = $this->test_call_acountinvite();

            if (empty($error)) {
                $account_id = $user->cb_create_user($post['email']);
                $data = $user->cb_get_user_data_from_id($account_id);
                
                $mail->AddAddress($post['email']);
                $mail->Subject = "Meghívás";
                $regLink = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?c=registration&code=" . $data['reg_code'];
                $mail->Body = "Meghívást kapott<br />
				Regisztrálhat az alábbi linkre kattintva: <br />
				<a href='" . $regLink . "'>" . $regLink . "</a><br /><br />
				" . nl2br($post['message']);
                $mail->AltBody = "Meghívást kapott/n
				Regisztrálhat az alábbi linket követve: /n
				" . $regLink . "/n/n
				" . $post['message'];

                if (!$mail->Send()) {
                    $handler->messageError[] = 'Hiba, e-mail nincs elküldve! (' . $mail->ErrorInfo . ')';
                    //		echo 'Mailer error: ' . $mail->ErrorInfo;
                } else {
                    $handler->messageSuccess[] = 'E-mail elküldve';
                }
            } else {
                $handler->messageError = $error;
            }
        }

        return $html;
    }


}

return; ?>