<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v001
|     Date: 2012. 10. 05.
+------------------------------------------------------------------------------+
*/

$CSS[] = "style.css";
$CSS[] = "css.css";
$CSS[] = "menu.css";
$CSS[] = "accountbox.css";
$CSS[] = "nivoslider.css";
$CSS[] = "../nivo-slider/nivo-slider.css";
$JS[] = "../nivo-slider/jquery.nivo.slider.pack.js";
$JS[] = "javascript.js";

$THEMEBODY['main'] = '

<div id="lap">
	<div id="fent">
	</div>

	<div id="kh">
	
		<div id="fejlec" class="nivoSlider">  
			<img src="' . CB_THEME . '/' . CB_THEMESET . '/slide/1.png" alt="" />
			<img src="' . CB_THEME . '/' . CB_THEMESET . '/slide/2.png" alt="" />
			<img src="' . CB_THEME . '/' . CB_THEMESET . '/slide/3.png" alt="" />
		</div>
		<div id="fejlec_cover"></div>
		
		<div id="menu">{#MODULE,MENU,MENU,1}</div>

		<div id="kozep">  
			<div id="balsav">
					
				<div id="floatBox">
					<a href="#" title="elérhetőség">
						<img src="' . CB_THEME . '/' . CB_THEMESET . '/images/fhb.png" />
					</a>
				</div>
				
				<div id="boxteto">
				
				</div> 
				<div id="box">
				
					{#MODULE,ACCOUNT,ACCOUNT_BOX,}
						<div id="menu2">
					{#MODULE,MENU,MENU,2}
					</div>
				</div>
				<div id="boxalj">
				</div>
				<img src="' . CB_THEME . '/' . CB_THEMESET . '/images/likeus.png" />
			</div>
			
			<div id="tartalom">
				{#MAIN}
			</div>
	
		</div>
	</div>

	<div id="lent">  
		
	</div>
	
	
</div>

';


?>
