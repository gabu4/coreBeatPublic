<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 20/10/19
 */
global $theme;
$theme->loadJquery();
$theme->loadJqueryUI();
$theme->loadBootstrap4();
$theme->loadFontAwesome();
if ( defined('CB_ADMIN_THEMESET_COLOR_CUSTOM') ) {
    $theme->addBodyclass('skin-'.CB_ADMIN_THEMESET_COLOR_CUSTOM);
} elseif ( defined('CB_ADMIN_THEMESET_COLOR') ) {
    $theme->addBodyclass('skin-'.CB_ADMIN_THEMESET_COLOR);
} else {
    $theme->addBodyclass('skin-blue');
}

//$CSS[] = "eric-reset.css";
//$CSS[] = "../plugins/bootstrap/css/bootstrap.min.css";
//$CSS[] = "font-awesome.min.css";
//$CSS[] = "ionicons.min.css";
//$CSS[] = "AdminLTE.min.css";
//$CSS[] = "../plugins/iCheck/square/blue.css";
//$CSS[] = "style.css";
//$CSS[] = "style.main.css";
//$JS[] = "../plugins/jQuery/jQuery-2.1.4.min.js";
//$JS[] = "../plugins/bootstrap/js/bootstrap.min.js";
//$JS[] = "../plugins/iCheck/icheck.min.js";
//$JS[] = "main.js";

//$CSS[] = "../adminlte-need/css/bootstrap.min.css";
//$CSS[] = "../adminlte-need/css/font-awesome.min.css";
$CSS[] = "../adminlte-need/css/ionicons.min.css";
//$CSS[] = "../adminlte-need/css/AdminLTE.min.css";
$CSS[] = "booty4.css";
$CSS[] = "css/skins/_all-skins.min.css";
$CSS[] = "../adminlte-need/iCheck/square/blue.css";
$CSS[] = "pace.css";

//$JSEND[] = "../adminlte-need/js/jquery-ui.min.js";
//$JSEND[] = "../adminlte-need/js/bootstrap.min.js";
$JSEND[] = "../adminlte-need/js/jquery.slimscroll.min.js";
$JSEND[] = "../adminlte-need/js/fastclick.js";
$JSEND[] = "../adminlte-need/iCheck/icheck.min.js";
$JSEND[] = "dialogs.js";
$JSEND[] = "pace.min.js";

$THEMEBODY = '
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Core</b>Beat\'s</a>
        </div><!-- /.login-logo -->
        
        {#MODULE,ACCOUNT,ACCOUNT_BOX}
        
</div><!-- /.login-box -->
<footer class="fixed-bottom bg-white p-1">
    <div class="float-right">CoreBeat SyStem Manager (By2011-2019) / version '.VERSION.' / '.VERSION_NAME.'</div>
    <strong>Copyright &copy; 2011-2019 <a href="http://webed.hu">Webed Studio</a>.</strong> All rights reserved.
</footer>
';


return; ?>