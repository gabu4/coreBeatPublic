<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 05/05/16
 */
global $theme;
$theme->loadJquery();
//$theme->loadJqueryUI();
//$theme->loadBootstrap();

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

$CSS[] = "../adminlte-need/css/bootstrap.min.css";
$CSS[] = "../adminlte-need/css/font-awesome.min.css";
$CSS[] = "../adminlte-need/css/ionicons.min.css";
$CSS[] = "../adminlte-need/css/AdminLTE.min.css";
$CSS[] = "../adminlte-need/css/skins/_all-skins.min.css";
$CSS[] = "../adminlte-need/iCheck/square/blue.css";
$CSS[] = "pace.css";

$JSEND[] = "../adminlte-need/js/jquery-ui.min.js";
$JSEND[] = "../adminlte-need/js/bootstrap.min.js";
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
        
		
    <div id="lent">
            <p>CoreBeat SyStem Manager (By2011-2019) / version '.VERSION.' / '.VERSION_NAME.'</p>
    </div>
</div><!-- /.login-box -->


';


return; ?>