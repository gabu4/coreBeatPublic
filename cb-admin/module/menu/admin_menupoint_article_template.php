<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 19/04/18
 */
if ( !defined('H-KEI') ) { exit; }

$JS['menupoint_article'][] = "menupoint_article.js";
$TEMPLATE['menupoint_article'] = <<<HTML
    <div class="row">
        <section class='menupointArticle'>
            <input type='hidden' name='id' value='{#ID}' />
            <input type='hidden' name='content_id' value='{#CONTENT_ID}' />
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{#TITLE}</h3>
                    </div>
                    <div class="box-body menuType-menu_html">
                        <div class="form-group form-cb-name">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_NAME]</label>
                            <input type='text' class='form-control' name='name' value='{#NAME}' /><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-seo_name">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_SEO_NAME]</label>
                            <div class="input-group input-group-sm">
                                <input type='text' class='form-control' name='seo_name' value='{#SEO_NAME}' /><span class='comm'></span>
                                <span class="input-group-btn">
                                    <button type='button' class='btn btn-default' name='renewseo'>[ADMIN_TEXT_MENUPOINT_ARTICLE_SEO_NAME_REFRESH]</button>>
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-cb-language">
                            {#LANGUAGESELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-category">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_CATEGORY]</label>
                            {#GROUPSELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-parent">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_PARENT]</label>
                            {#PARENTSELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-article">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_ATRICLE]</label>
                            {#ARTICLESELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-is_blank">
                            <label><input type='checkbox' class='' name='is_blank' value='1' {#IFISBLANK} /> [ADMIN_TEXT_MENUPOINT_ARTICLE_IS_BLANK]</label><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-order">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_ORDER]</label>
                            <input type='text' class='form-control' name='order' value='{#ORDER}' /><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-text">
                            <label>[ADMIN_TEXT_MENUPOINT_ARTICLE_TEXT]</label>
                            <textarea class='form-control menuText' name='text' />{#TEXT}</textarea><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-state">
                            <h4>[ADMIN_TEXT_MENUPOINT_ARTICLE_STATE]</h4>
                            <div class='radio'><label for='state1'><input type='radio' id='state1' name='state' value='1' {#IFSTATE1} />[ADMIN_TEXT_MENUPOINT_ARTICLE_STATE_ACTIVE]</label></div>
                            <div class='radio'><label for='state0'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} />[ADMIN_TEXT_MENUPOINT_ARTICLE_STATE_INACTIVE]</label></div>
                            <span class='comm'></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;

$TEMPLATE['menupoint_article_category'] = <<<HTML
    <div class='pageContent'>
        <p><span class='inpText'>Menüpont neve</span><input type='text' name='name' value='{#NAME}' /><span class='comm'></span></p>
        <p><span class='inpText'>Seo név</span><input type='text' class='seo_name' name='seo_name' value='{#SEO_NAME}' /><span class='comm'></span><input type='button' name='renewseo' value='SEO frissítés' /></p>
        <p><span class='inpText'>Menü csoport</span>{#GROUPSELECT}<span class='comm'></span></p>
        <p><span class='inpText'>Menü szülő</span>{#PARENTSELECT}<span class='comm'></span></p>
        <p><span class='inpText'>Kategória</span>{#ARTICLECATEGORYSELECT}<span class='comm'></span></p>
        <p><span class='inpText'>Új oldalon nyílik meg</span><input type='checkbox' id='is_blank' name='is_blank' value='1' {#IFISBLANK} /><span class='comm'></span></p>
        <p><span class='inpText'>Sorrend</span><input type='text' name='order' value='{#ORDER}' /><span class='comm'></span></p>
        <p><span class='inpText'>Menüpont leírás</span><textarea class='menuText' name='text' />{#TEXT}</textarea><span class='comm'></span></p>
        <p><span class='inpText'>Állapot</span><div class='radio'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} /><label for='state0'>Inaktív</label> <input type='radio' id='state1' name='state' value='1' {#IFSTATE1} /><label for='state1'>Aktív</label></div><span class='comm'></span></p>
    </div>
HTML;

return; ?>