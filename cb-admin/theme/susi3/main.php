<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v003
 * @date 27/06/15
 */
global $theme, $module;
$theme->loadJquery();
$theme->loadJqueryUI();

$CSS[] = "eric-reset.css";
$CSS[] = "style.css";
$JS[] = "main.js";
$JS[] = "dialogs.js";

$THEMEBODY = '

<div id="pcenter">
<div id="pageadmin">
	<div id="logo">
		<img src="'.CB_ADMIN.'/theme/susi3/images/cb_alap.png" />
		{#MODULE,ACCOUNT,ACCOUNT_BOX}
	</div>
	<div id="menu">
		{#ADMIN,ADMIN,MENU}
	</div>
	
		{#ADMIN,ADMIN,FORMMENU,START}
        
        ';
if ( $module->loadAdminFunction('admin','havesidemenu') ) {
$THEMEBODY .= ' 
        <div id="left">
               <div id="subMenu">
			{#ADMIN,ADMIN,SUBMENU}
		</div>
		<div id="infoPanel">
			{#ADMIN,ADMIN,INFOPANEL}
		</div>
	</div>
';
}
$THEMEBODY .= ' 
	<div id="center">					
		<div class="tartalom">
			{#MAIN}
		</div>
	</div>
		
		{#ADMIN,ADMIN,FORMMENU,END}
		
	<div id="lent">
		<p>CoreBeat SyStem Manager (By2011-2014) / version '.VERSION.'</p>
	</div>
</div>
</div>

';

$THEMEINMAIN = '
	{#ADMIN,ADMIN,ADMINMAINPAGE}
';


?>