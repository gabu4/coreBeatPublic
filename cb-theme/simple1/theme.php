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
			<img src="' . CB_THEME . '/' . THEMESET . '/slide/1.png" alt="" />
			<img src="' . CB_THEME . '/' . THEMESET . '/slide/2.png" alt="" />
			<img src="' . CB_THEME . '/' . THEMESET . '/slide/3.png" alt="" />
		</div>
		<div id="fejlec_cover"></div>
		
		<div id="menu">{#MENU_1}</div>

		<div id="kozep">  
			<div id="balsav">
					
				<div id="floatBox">
					<a href="#" title="elérhetőség">
						<img src="' . CB_THEME . '/' . THEMESET . '/images/fhb.png" />
					</a>
				</div>
				
				<div id="boxteto">
				
				</div> 
				<div id="box">
					{#ACCOUNTBOX}
						<div id="menu2">
					{#MENU_2}
					</div>
				</div>
				<div id="boxalj">
				</div>
				<img src="' . CB_THEME . '/' . THEMESET . '/images/likeus.png" />
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
