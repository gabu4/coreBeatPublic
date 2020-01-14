<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 03/05/18
 */
if ( !defined('H-KEI') ) { exit; }

$CSS['product'][] = "termek-adatlap.css";
$JSEND['product'][] = "termek-adatlap-vezerles.js";
$TEMPLATE['product'] = <<<HTML
<div class='productContentDiv productContentPageDiv product_id_{#CONTENTID} {#CLASS}'>
        
<!--  A kép és a tartalom duplikaltan szerepel -->
<div class="termek-adatlapja-kontener">
    <div class="szeles-nezet">
        <div class="bal">
            <div class="felso kep">
                {#PRODUCT_IMAGE}
            </div>
            <!-- A VIDEO athelyezesre kerul! -->
            
        <script>
	    var youtubevideoid="{#YOUTUBEVIDEO_CODE}";
	</script>
        
            <div class="also video">
                <div class="video-kontener"> 
                    <div id="termekAdatlapVideoPlayer">
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="jobb tartalom">
            {#CONTENT}
        </div>
    </div>
    <div class="keskeny-nezet">
        <div class="kep">
            {#PRODUCT_IMAGE}
        </div>
        <div class="tartalom">
            {#CONTENT}
        </div>
        
        <div class="video">
            
        </div>
        
    </div>
</div>


<div class="termekek-listaja">
    {#MODULE,PRODUCT,LIST_RANDOM,1|3|random|{#CONTENTID}}
</div>


</div>
HTML;

$CSS['category_main'][] = "termekek.css";
$TEMPLATE['category_main'] = <<<HTML
<div class='productCategoryContentDiv product_category_id_{#CATEGORYID} {#CLASS}'>
    <div class="termekek-listaja-felso-sav">
        <div class="tabla">
            <div class="tabla-sor">
                <div class="tabla-cella bevezeto univerzalis-szoveg-blokk-1">

                        {#MODULE,ARTICLE,ARTICLE_ID,12}

                </div>
                <div class="tabla-cella kep">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="productCategoryContents termekek-listaja">
        {#ARTICLES}
    </div>
</div>
HTML;

$TEMPLATE['product_category'] = <<<HTML
<div class='productContentDiv categoryContent product_id_{#CONTENTID} {#CLASS} termek-lista-elem'>
    <div class='productContent'>
        <div class="contentImg kep">
            {#IMAGE}
        </div>
        <h2 class='title cim'>{#CONTENTTITLE}</h2>
        <div class='tartalom'>{#SHORTCONTENT}</div>
        <div class='gomb'><a href="{#CONTENT_LINK}" class="zold-gomb">[PRODUCT_LIST_MORE_BUTTON]</a></div>
    </div>
</div>
HTML;


$CSS['category_main_category_random'][] = "termekek.css";
$TEMPLATE['category_main_category_random'] = <<<HTML
<div class='productCategoryContentDiv product_category_id_{#CATEGORYID} {#CLASS}'>
    
    <div class="productCategoryContents termekek-listaja">

        {#ARTICLES}

    </div>
</div>
HTML;

$TEMPLATE['product_category_random'] = <<<HTML
<div class='productContentDiv categoryContent product_id_{#CONTENTID} {#CLASS} termek-lista-elem'>
    <div class='productContent'>
        <div class="contentImg kep">
            {#IMAGE}
        </div>
        <h2 class='title cim'>{#CONTENTTITLE}</h2>
        <div class='tartalom'>{#SHORTCONTENT}</div>
        <div class='gomb'><a href="{#CONTENT_LINK}" class="zold-gomb">[PRODUCT_LIST_MORE_BUTTON]</a></div>
    </div>
</div>
HTML;



$CSS['category_main_category_dark_main'][] = "termekek.css";
$TEMPLATE['category_main_category_dark_main'] = <<<HTML
<div class='productCategoryContentDiv product_category_id_{#CATEGORYID} {#CLASS} slider'>
    
        {#ARTICLES}

</div>
HTML;

$TEMPLATE['product_category_dark_main'] = <<<HTML
<div class='productContentDiv categoryContent product_id_{#CONTENTID} {#CLASS} slider-elem'>
    
        <div class="slider-elem"> 
            <img src="{#IMAGE_LINK}"/>
            <h1>{#CONTENTTITLE}</h1>
            <p>{#SHORTCONTENT}</p>
            <a class="zold-gomb" href="{#CONTENT_LINK}">[PRODUCT_LIST_MORE_BUTTON]</a>
        </div>
</div>
HTML;







$JS['category_main_cascadeslider'][] = "cascade-slider.js";
$CSS['category_main_cascadeslider'][] = "cascade-slider.css";
$TEMPLATE['category_main_cascadeslider'] = <<<HTML
<h2 class="text-center">Ajánlott termékek</h2>

<div class="cascade-slider_container articleCategoryContentDiv article_category_id_{#CATEGORYID} {#CLASS}" id="cascade-slider">
    <div class="cascade-slider_slides articleCategoryContents">
        {#ARTICLES}
    </div>
        
  <span class="cascade-slider_arrow cascade-slider_arrow-left" data-action="prev"><span>Prev</span></span>
  <span class="cascade-slider_arrow cascade-slider_arrow-right" data-action="next"><span>Next</span></span>
</div>
        
<script>
jQuery(window).on('load',function() {
    jQuery('#cascade-slider').cascadeSlider();
});
</script>
HTML;

$TEMPLATE['article_category_cascadeslider'] = <<<HTML
<div class='cascade-slider_item articleContentDiv categoryContent article_id_{#CONTENTID} {#CLASS} {#CATEGORIES}'>
    <a class='text-center' href='{#CONTENT_LINK}'>
        <p class='img'><img src="{#THUMBNAIL_IMAGE_LINK}" alt="" /></p>
        <p class='more'>Részletek</p>
        <h4 class='title'>{#CONTENTTITLE}</h4>
    </a>
</div>
HTML;

return ?>
