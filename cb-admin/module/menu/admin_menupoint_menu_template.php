<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 19/04/18
 */
if ( !defined('H-KEI') ) { exit; }

$JS['menupoint_html'][] = "menupoint_html.js";
$TEMPLATE['menupoint_html'] = <<<HTML
    <div class="row">
        <section class='menupointHtml'>
            <input type='hidden' name='id' value='{#ID}' />
            <input type='hidden' name='content_id' value='{#CONTENT_ID}' />
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{#TITLE}</h3>
                    </div>
                    <div class="box-body menuType-menu_html">
                        <div class="form-group form-cb-name">
                            <label>[ADMIN_TEXT_MENUPOINT_HTML_NAME]</label>
                            <input type='text' class='form-control' name='name' value='{#NAME}' /><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-language">
                            {#LANGUAGESELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-category">
                            <label>[ADMIN_TEXT_MENUPOINT_HTML_CATEGORY]</label>
                            {#GROUPSELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-parent">
                            <label>[ADMIN_TEXT_MENUPOINT_HTML_PARENT]</label>
                            {#PARENTSELECT}<span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-html_link">
                            <label>[ADMIN_TEXT_MENUPOINT_HTML_HTML_LINK]</label>
                            <input type='text' class='form-control' name='html_link' value='{#HTMLLINK}' /><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-is_blank">
                            <label><input type='checkbox' class='' name='is_blank' value='1' {#IFISBLANK} /> [ADMIN_TEXT_MENUPOINT_HTML_IS_BLANK]</label><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-order">
                            <label>[ADMIN_TEXT_MENUPOINT_HTML_ORDER]</label>
                            <input type='text' class='form-control' name='order' value='{#ORDER}' /><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-text">
                            <label>[ADMIN_TEXT_MENUPOINT_HTML_TEXT]</label>
                            <textarea class='form-control menuText' name='text' />{#TEXT}</textarea><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-state">
                            <h4>[ADMIN_TEXT_MENUPOINT_HTML_STATE]</h4>
                            <div class='radio'><label for='state1'><input type='radio' id='state1' name='state' value='1' {#IFSTATE1} />[ADMIN_TEXT_MENUPOINT_HTML_STATE_ACTIVE]</label></div>
                            <div class='radio'><label for='state0'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} />[ADMIN_TEXT_MENUPOINT_HTML_STATE_INACTIVE]</label></div>
                            <span class='comm'></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;


return; ?>