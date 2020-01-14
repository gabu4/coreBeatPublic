<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v007
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }


$JSEND['catalog_fullpage'][] = "catalog-fullpage.js";
$TEMPLATE['catalog_fullpage'] = <<<HTML
<div class='catalogContentDiv catalogContentPageDiv catalog_id_{#CONTENTID} {#CLASS}'>

<div class="col-12">
    <h1 class='title'>{#CONTENTTITLE}</h1>
    <div class='shortcont w-100 text-center'>{#SHORTCONTENT}</div>
    <hr class="" />
    <div class="row">
        <div class="col-md-8 gall">
            {#IMAGE_0}
            {#IMAGE_GALLERY_SMALL}
        </div>
    
        <div class="col-md-4 content">
            <h3 class='modell'>Modell: <span>{#SKU}</span></h3>
            <div class='marka-logo'>{#CATEGORY_LOGO}</div>
        </div>
    </div>
    
</div>

<div class="more-catalog-element">
    <h2 class='title mt-5'>További választék</h2>
    {#MODULE,CATALOG,LIST_RANDOM,["id":"2";"limit":4;"template":"random"]}
</div>

</div>
HTML;



$JSEND['catalog_page'][] = "catalog-list.js";
$TEMPLATE['catalog_page'] = <<<HTML
<div class='catalogCategoryContentDiv catalog_category_id_{#CATEGORYID} {#CLASS}'>
    <h1 class='title'>{#CATEGORYTITLE}</h1>
    <hr class='title' />
    <div class="pull-left text-center catalogCategoryText">
            {#TEXT}
        </div>
        <div class="pull-right catalogCategoryImg">
            {#ORIGINAL_IMAGE}
        </div>
    <div class="catalogCategoryContents catalogElementList pageList">
        {#CATALOGS}
    </div>
</div>
HTML;


$JS['category_main_category'][] = "catalog-list.js";
$TEMPLATE['category_main_category'] = <<<HTML
<div class='catalogCategoryContentDiv catalog_category_id_{#CATEGORYID} {#CLASS}'>
    <div class="catalogCategoryContents catalogElementList mb-3 row row-eq-height">
        {#CATALOGS}
    </div>
</div>
HTML;


$TEMPLATE['catalog_element'] = <<<HTML
<div class="contentImg col-12 col-sm-6 col-lg-3 position-relative text-center">
    <a class='pict' href="{#CONTENT_LINK}" style="background-image:url('{#THUMBNAIL_SMALL_IMAGE_LINK_0}')">
        <img class='placeholder' src="{#THUMBNAIL_SMALL_IMAGE_LINK_0}" alt="{#CONTENTTITLE}" />
    </a>
</div>
HTML;

$JS['catalog_page_random'][] = "catalog-list.js";
$TEMPLATE['catalog_page_random'] = <<<HTML
<div class='catalogCategoryContentDiv catalog_category_id_{#CATEGORYID} {#CLASS}'>
    <div class="catalogCategoryContents catalogElementList mb-3 row row-eq-height randomList">
        {#CATALOGS}
    </div>
</div>
HTML;

$TEMPLATE['catalog_element_random'] = <<<HTML
<div class="contentImg col-12 col-sm-6 col-lg-3 position-relative text-center">
    <a class='pict' href="{#CONTENT_LINK}" style="background-image:url('{#THUMBNAIL_SMALL_IMAGE_LINK_0}')">
        <img class='placeholder' src="{#THUMBNAIL_SMALL_IMAGE_LINK_0}" alt="{#CONTENTTITLE}" />
    </a>
    <h3 class='title w-100'>{#CONTENTTITLE}</h3>
    <div class='btn-row w-100'><a href="{#CONTENT_LINK}" type="button" class="btn btn-light">[CATALOG_LIST_MORE_BUTTON]</a></div>
</div>
HTML;


return ?>
