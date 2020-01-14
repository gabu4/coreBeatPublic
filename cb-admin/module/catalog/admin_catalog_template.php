<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 19/10/18
 */
if ( !defined('H-KEI') ) { exit; }

global $theme;
//$theme->loadCKEditor();
$theme->loadTinymce();

$JS['list'][] = "catalog_list.js";
$JS['create'][] = "catalog_create.js";

$TEMPLATE['list'] = <<<HTML
    <div class="row">
        <section class='catalogList'>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class='text-right'>{#CATEGORY_FILTER}</div>
                    </div>
                    <div class="box-body ">
                        {#BODY}
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;


$TEMPLATE['create'] = <<<HTML
    <div class="row">
        <section class='catalogCreate catalogCreateLang_{#LANG} catalogCreatePageID_{#COUNTERID}'>
            <input type='hidden' name='catalog_id' value='{#CATALOG_ID}' />
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-6">
                            {#CATALOG_FIELD_NAME}
                        </div>
                        <div class="col-md-3 col-md-offset-3">
                            <div class="form-group form-cb-state">
                                <h4>[ADMIN_TEXT_CATALOG_EDIT_STATE]</h4>
                                <div class='radio'><label for='state1'><input type='radio' id='state1' name='state' value='1' {#IFSTATE1} />[ADMIN_TEXT_CATALOG_EDIT_STATE_ACTIVE]</label></div>
                                <div class='radio'><label for='state0'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} />[ADMIN_TEXT_CATALOG_EDIT_STATE_INACTIVE]</label></div>
                                <span class='comm'></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='nav-tabs-custom'>
                    <ul class='nav nav-tabs'>
                        {#CONTENT_TABS}
                        <li><a href='#tabs-category' data-toggle='tab'>[ADMIN_TEXT_CATALOG_EDIT_TABMENU_CATEGORY]</a></li>
                        <li><a href='#tabs-image' data-toggle='tab'>[ADMIN_TEXT_CATALOG_EDIT_TABMENU_IMAGE]</a></li>
                        {#META_TABS}
                    </ul>
                    <div class='tab-content'>
                        {#CONTENT_PANELS}
                        <div class='tab-pane pad' id='tabs-category'>
                            {#CATEGORY_LIST}
                        </div>
                        <div class='tab-pane pad' id='tabs-image'>
                            {#IMAGE_TAB}
                        </div>
                        {#META_PANELS}
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;

$TEMPLATE['create_field_name'] = <<<HTML
    <div class="name-field">
        <div class="row">
            <div class="form-group form-cb-name[{#LANG}]">
                <div class="col-xs-2">{#LANGUAGE_FLAG}</div>
                <div class="col-xs-10">
                    <label>[ADMIN_TEXT_CATALOG_EDIT_NAME]</label>
                    <input type='text' class='form-control catalogName lang_{#LANG}' data-lang="{#LANG}" name='name[{#LANG}]' value='{#NAME}' /><span class='comm'></span>
                </div>
            </div>
            <div class="form-group form-cb-seo_name[{#LANG}]">
            <input type='hidden' name='content_id[{#LANG}]' value='{#CONTENT_ID}' />
                <div class="col-xs-10 col-xs-offset-2">
                    <label>[ADMIN_TEXT_CATALOG_EDIT_SEO_NAME]</label>
                    <div class="input-group">
                        <input type='text' class='form-control catalogSEOName lang_{#LANG}' data-lang="{#LANG}" name='seo_name[{#LANG}]' value='{#SEO_NAME}' /><span class='comm'></span>
                        <span class="input-group-append">
                            <button type='button' class='btn btn-default' data-lang="{#LANG}" name='renewseo'>[ADMIN_TEXT_MENUPOINT_ARTICLE_SEO_NAME_REFRESH]</button>>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML;

$TEMPLATE['create_content_tabs'] = <<<HTML
    <li class='{#ACTIVE}'><a href='#tabs-content-{#LANG}' data-toggle='tab' {#ARIA_EXPANDED}>[ADMIN_TEXT_CATALOG_EDIT_TABMENU_CONTENT]{#LANGUAGE_FLAG}</a></li>
HTML;

$TEMPLATE['create_content_panels'] = <<<HTML
    <div class='tab-pane {#ACTIVE}' id='tabs-content-{#LANG}'>
        <div class="form-group form-cb-shorttext[{#LANG}]">
            <label>[ADMIN_TEXT_CATALOG_EDIT_SHORT_TEXT]</label>
            <textarea class='form-control contentEdit contentEditShort lang_{#LANG} contentTinyMCE' data-lang="{#LANG}" name='shorttext[{#LANG}]' id='ckEditorID00_{#LANG}' />{#SHORTTEXT}</textarea><span class='comm'></span>
        </div>
        <div class="form-group form-cb-text[{#LANG}]">
            <label>[ADMIN_TEXT_CATALOG_EDIT_LONG_TEXT]</label>
            <textarea class='form-control contentEditcontentEditLong lang_{#LANG} contentTinyMCE' data-lang="{#LANG}" name='text[{#LANG}]' id='ckEditorID01_{#LANG}' />{#TEXT}</textarea><span class='comm'></span>
        </div>
    </div>
HTML;

$TEMPLATE['create_meta_tabs'] = <<<HTML
    <li><a href='#tabs-meta-{#LANG}' data-toggle='tab'>[ADMIN_TEXT_CATALOG_EDIT_TABMENU_META]{#LANGUAGE_FLAG}</a></li>
HTML;

$TEMPLATE['create_meta_panels'] = <<<HTML
    <div class='tab-pane' id='tabs-meta-{#LANG}'>
        <div class="form-group">
            <label>[ADMIN_TEXT_CATALOG_META_EDIT_METAKEY]</label>
                <input type='text' class='form-control metaKeywords' name='meta_keywords[{#LANG}]' value='{#META_KEYWORDS}' />
            <label>[ADMIN_TEXT_CATALOG_META_EDIT_METADESC]</label>
                <textarea class='form-control metaDescription' name='meta_description[{#LANG}]' />{#META_DESCRIPTION}</textarea>
        </div>
    </div>
HTML;

return; ?>