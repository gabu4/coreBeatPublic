<?php
namespace module_api\update;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 17/10/18
 */
if (!defined('H-KEI')) { exit; }

class funct extends database {
    protected function api_update() {
        global $user, $out_api;
        
        if ( $user->cb_get_user_id() > 0 ) {
            $out_api->responseOut('200','TOKEN_VALID',array('sid'=>$_SESSION['SID']));
        } else {
            $out_api->responseOut('401','TOKEN_INVALID');
        }
        
    }
    
}

return;
?>
