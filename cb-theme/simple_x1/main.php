<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 05/10/12
 */
global $theme;
$theme->loadJquery();

$CSS[] = "style.css";
$CSS[] = "menu.css";
$CSS[] = "accountboxs.css";
$JS[] = "javascript.js";

$THEMEBODY = '

<div id="page_center">
<div id="page">
	<div id="head">
		<div id="logo"></div>
		<div id="menu_top">{#MODULE,MENU,MENU,1}</div>
	</div>

	<div id="main">
		<div id="content_left">
			
			<div id="menu_left">
				{#MODULE,MENU,MENU,2}
			</div>
			
			<div id="account_box">
				{#MODULE,ACCOUNT,ACCOUNT_BOX}
			</div>
			
		</div>
		
		<div id="content">
			{#MAIN}
		</div>
	</div>

	<div id="foot">  
		Create By NovaFactory ; Since 2013
	</div>
	
	
</div>
</div>

';


return; ?>
