<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v024
 * @date 15/11/18
 */
global $theme, $module;
$theme->loadJquery();
//$theme->loadJqueryUI();
//$theme->loadBootstrap();
$theme->addBodyclass('hold-transition');
if ( defined('CB_ADMIN_THEMESET_COLOR') ) {
    $theme->addBodyclass('skin-'.CB_ADMIN_THEMESET_COLOR);
} else {
    $theme->addBodyclass('skin-blue');
}
$theme->addBodyclass('sidebar-mini');

$CSS[] = "../adminlte-need/css/bootstrap.min.css";
$CSS[] = "../adminlte-need/css/font-awesome.min.css";
$CSS[] = "../adminlte-need/css/ionicons.min.css";
$CSS[] = "../adminlte-need/css/AdminLTE.min.css";
$CSS[] = "../adminlte-need/css/skins/_all-skins.min.css";
$CSS[] = "pace.css";
$CSS[] = "style.main.css";


//$CSS[] = "eric-reset.css";
//$CSS[] = "style.css";

//$JS[] = "../adminlte-need/js/jquery.min.js";
$JS[] = "../adminlte-need/js/jquery-ui.min.js";
$JS[] = "../adminlte-need/js/bootstrap.min.js";
$JS[] = "../adminlte-need/js/jquery.slimscroll.min.js";
$JS[] = "../adminlte-need/js/fastclick.js";
$JS[] = "../adminlte-need/js/adminlte.min.js";
//$JS[] = "adminlte.functions.js";
$JSEND[] = "main.js";
$JSEND[] = "pace.min.js";
$JSEND[] = "dialogs.js";


$version = VERSION;
$version_name = VERSION_NAME;
$webpageAddress = CB_WEBPAGEADDRESS;
$httpAddress = CB_HTTPADDRESS;

$THEMEBODY = <<<HTML

<div class="wrapper opacityZero" style="opacity:0;">
    <header class="main-header">
        <!-- Logo -->
        <a href="?admin" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>C</b>B</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Core</b>Beat</span>
        </a>
        
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    
                    <!-- User Account -->
                    {#MODULE,ACCOUNT,ACCOUNT_BOX}
                    <li>
                        <a href="$httpAddress" class="" target="cb_pageReview">
                            <i class="fa fa-home"></i>&nbsp;&nbsp;$webpageAddress <span class="sr-only"> Weboldal megtekintése</span>
                        </a>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
		{#ADMIN,ADMIN,FORMMENU,START}
        
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">
            {#ADMIN,ADMIN,SUBMENU}
            <!-- sidebar menu: : style can be found in sidebar.less -->
            {#ADMIN,ADMIN,MENU}
        </section>
        <!-- /.sidebar -->
    </aside>
                
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {#ADMINTITLE}
                <small>{#ADMINSUBTITLE}</small>
            </h1>
            {#ADMIN,ADMIN,BREADCRUMB}
            
        </section>

        <!-- Main content -->
        <section class="content">
          
            {#MAIN}
        
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
        {#ADMIN,ADMIN,FORMMENU,END}
    <footer class="main-footer">
        <div class="pull-right d-none">
            CoreBeat SyStem Manager <b>Version</b> $version / $version_name
        </div>
        <strong>Copyright &copy; 2011-2019 <a href="http://webed.hu">Webed Studio</a>.</strong> All rights reserved.
    </footer>

      
</div><!-- ./wrapper -->
    
HTML;


$THEMEINMAIN = <<<HTML
    {#ADMIN,ADMIN,ADMINMAINPAGE}
HTML;


?>