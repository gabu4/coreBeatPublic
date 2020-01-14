<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 30/05/18
 */
if ( !defined('H-KEI') ) { exit; }


$JSEND['team_page_works'][] = 'jquery.mousewheel-3.0.6.pack.js';
$JSEND['team_page_works'][] = '../fancybox/jquery.fancybox.pack.js';
$JSEND['team_page_works'][] = '../fancybox/helpers/jquery.fancybox-media.js';
$JSEND['team_page_works'][] = '../fancybox/helpers/jquery.fancybox-thumbs.js';
$JSEND['team_page_works'][] = 'fancybox2.js';
$JSEND['team_page_works'][] = 'galeria2.js';
$CSS['team_page_works'][] = '../fancybox/jquery.fancybox.css';
$CSS['team_page_works'][] = '../fancybox/helpers/jquery.fancybox-thumbs.css';
$CSS['team_page_works'][] = 'gallery2.css';

$TEMPLATE['team_page_works'] = <<<HTML
<div class='container team_id_{#TEAM_MATE_ID} {#CLASS}'>
    <section class='textblock col-xs-12 '>
        <div class="teamWorksText">
            <h1>{#CONTENTTITLE}</h1>
            <h2>{#TITULUS}</h2>
            {#CONTENT}
        </div>
    </section>
    <section class='galleryblock col-xs-12 galeria'>
        <div class='cbGallery text-center'>
            {#GALLERY}
        </div>
    </section>
</div>
HTML;

$CSS['team_list_main'][] = "rolunk.css";
$JSEND['team_list_main'][] = "rolunk-vezerles.js";
$TEMPLATE['team_list_main'] = <<<HTML
<div class='teamCategoryContentDiv rolunk-blokkok'>
    
    <div class="teamCategoryContents ">
        {#MODULE,GALLERY,LIST,slide_demo}
        <div class="a-csapat-kontener tabla">
            <div class="tabla-sor">
                <div class="tabla-cella bal"></div>
                <div class="tabla-cella kozep"><div class="szoveg">[TEXT_TEAM_THE_TEAM]</div></div>
                <div class="tabla-cella jobb"></div>
            </div>			
        </div>
        {#TEAM}
        
    </div>
    
</div>
{#MODULE,ARTICLE,ARTICLE_ID,2}
HTML;


$TEMPLATE['team_list_element_category'] = <<<HTML
    <div class="team_mate_id_{#TEAM_MATE_ID} rolunk-blokk tabla {#CLASS}" id="{#HORGONY}">
        <a name="{#HORGONY}"></a>
        <div class="tabla-sor">
            <div class="tabla-cella kep">
                <a href="#{#HORGONY}" title="...link">
                {#IMAGE}
                </a>
            </div>
            <div class="tabla-cella szoveg">
                <h1>{#CONTENTTITLE}</h1>
                <h2>{#TITULUS}</h2>
                {#CONTENT}
                    <p class="munka-es-idopontfoglalas-link">
                        {#MUNKAI}
                        {#FOGLALAS}
                    </p>
            </div>
        </div>
    </div>
HTML;

$TEMPLATE['gallerycontent'] = <<<HTML
<div class="cbGalleryMosaic2 cbGalleryMosaic-number-{#MOSAICNUMBER} cbGalleryMosaic-id-{#MOSAICID}">
    <div class="thumb1" style="background-image:url({#PATHTHUMB});">
        <a href="{#PATH}" class='fancybox' rel="media" title="{#TITLE}"></a>
    </div> 
    <div class="cbGalleryMosaicText">{#TITLE}</div>
</div>
HTML;


return ?>
