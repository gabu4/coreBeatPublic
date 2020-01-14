<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 23/09/14
 */
global $theme;
$theme->loadJquery();
$theme->loadJqueryUI();

$CSS[] = "eric-reset.css";
$CSS[] = "style.css";
$CSS[] = "style.main.css";
$JS[] = "main.js";

$THEMEBODY = '

<div id="pcenter">
<div id="pageadmin">
	<div id="logo">
		<img src="'.CB_ADMIN.'/theme/susi3/images/cb_alap.png" />
	</div>
	
	<div id="center">					
		<div class="tartalom">
			{#MODULE,ACCOUNT,ACCOUNT_BOX}
		</div>
	</div>
				
	<div id="lent">
		<p>CoreBeat SyStem Manager (By2011-2014) / version '.VERSION.'</p>
	</div>
</div>
</div>

';


return; ?>