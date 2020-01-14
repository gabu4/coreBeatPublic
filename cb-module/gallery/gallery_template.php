<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 23/04/18
 */
if ( !defined('H-KEI') ) { exit; }

$JS['main'][0] = 'jquery.mousewheel-3.0.6.pack.js';
$JS['main'][1] = '../fancybox/jquery.fancybox.pack.js';
$JS['main'][2] = '../fancybox/helpers/jquery.fancybox-media.js';
$JS['main'][3] = '../fancybox/helpers/jquery.fancybox-thumbs.js';
$JS['main'][4] = 'fancybox.js';
$JS['gallerypage'][0] = 'pagination.js';
$CSS['main'][0] = '../fancybox/jquery.fancybox.css';
$CSS['main'][1] = '../fancybox/helpers/jquery.fancybox-thumbs.css';
$CSS['main'][2] = 'gallery.css';
$CSS['gallerypage'][0] = 'pagination.css';

$TEMPLATE['main'] = <<<HTML
<section class='galleryblock col-xs-12'>
<div class='cbGallery'>
    {#GALLERYPAGE}
    {#GALLERYPAGINATOR}
</div>
</section>
HTML;

$TEMPLATE['gallerypage'] = <<<HTML
<div class='cbGalleryPage cbGalleryPage-number-{#PAGENUMBER}'>
    {#GALLERYCONTENT}
</div>
HTML;

$TEMPLATE['gallerycontent'] = <<<HTML
<div class="cbGalleryMosaic cbGalleryMosaic-number-{#MOSAICNUMBER} cbGalleryMosaic-id-{#MOSAICID}">
    <a href="{#PATH}" class='fancybox' rel="{#SUBDIR}" title="{#TITLE}">
        <img src="{#PATHTHUMB}" alt="{#TITLE}" />
    </a>
    <div class="cbGalleryMosaicText">{#TITLE}</div>
</div>
HTML;

$TEMPLATE['gallerypaginator'] = <<<HTML
<div class='cbGalleryPaginator'>
    {#DATAS}
</div>
HTML;

$TEMPLATE['gallerypaginatorelement'] = <<<HTML
<a class='cbGalleryPaginatorElement cbGalleryPaginatorElement-number-{#PAGENUMBER}' data-pagenumber='{#PAGENUMBER}'>{#PAGENUMBER}</a>
HTML;


$CSS['slide_demo'][] = "../slick-carousel/slick.css";
$CSS['slide_demo'][] = "../slick-carousel/slick-theme.css";
$CSS['slide_demo'][] = "slide_demo.css";
$JSEND['slide_demo'][] = "../slick-carousel/slick.js";
$JSEND['slide_demo'][] = "slide_demo.js";
$TEMPLATE['slide_demo'] = <<<HTML
    <div class="rolunk-galeria-slider-kontener">
            <div class="rolunk-galeria-slider">
                
                <div class="slider-elem nowrap">
                    <a href="{#LINK}#galeria">
                        {#GALLERY_1}
                    </a>
                </div>

                <div class="slider-elem nowrap">
                    <a href="{#LINK}#eskuvo">
                        {#GALLERY_2}
                    </a>
                </div>	
                
                <div class="slider-elem nowrap">
                    <a href="{#LINK}#szalon">
                        {#GALLERY_3}
                    </a>
                </div>

            </div>
        </div>
		 
HTML;

return ?>
