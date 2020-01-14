<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v009
 * @date 18/06/18
 */
if ( !defined('H-KEI') ) { exit; }

global $theme;
//$theme->loadCKEditor();
$theme->loadTinymce();

$CSS['list'][] = "teammate_list.css";
$TEMPLATE['list'] = <<<HTML
    <div class="row">
        <section class='teamList'>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body ">
                        {#BODY}
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;

$TEMPLATE['list_element'] = <<<HTML
    <div class="teamMate col-md-3">
        <div class="panel panel-default">
            <div class="box-header">
                {#NAME}<div class="flags">{#FLAG}</div>
            </div>
            <div class="box-body ">
                <img class="img" src="{#IMAGE}" />
            </div>
            <div class="box-footer">
                {#STATE}{#EDIT}{#DELETE}
            </div>
        </div>
    </div>
HTML;


$CSS['create'][] = "teammate_create.css";
$JS['create'][] = "team_create.js";
$TEMPLATE['create'] = <<<HTML
    <div class="row">
        <section class='teamCreate teamCreateLang_{#LANG} teamCreatePageID_{#COUNTERID}'>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-6">
                            {#TEAM_FIELD_NAME}
                        </div>
                        <div class="col-md-3 col-md-offset-3">
                            <div class="form-group form-cb-state">
                                <h4>[ADMIN_TEXT_TEAM_EDIT_STATE]</h4>
                                <div class='radio'><label for='state1'><input type='radio' id='state1' name='state' value='1' {#IFSTATE1} />[ADMIN_TEXT_ARTICLE_EDIT_STATE_ACTIVE]</label></div>
                                <div class='radio'><label for='state0'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} />[ADMIN_TEXT_ARTICLE_EDIT_STATE_INACTIVE]</label></div>
                                <span class='comm'></span>
                            </div>
                            <div class="form-group form-cb-short_order">
                                <h4>[ADMIN_TEXT_TEAM_ORDER]</h4>
                                <input type='text' class='form-control' name='short_order' value='{#SHORT_ORDER}' />
                                <span class='comm'></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='nav-tabs-custom'>
                    <ul class='nav nav-tabs'>
                        {#CONTENT_TABS}
                        <li><a href='#tabs-image' data-toggle='tab'>[ADMIN_TEXT_ARTICLE_EDIT_TABMENU_IMAGE]</a></li>
                    </ul>
                    <div class='tab-content'>
                        {#CONTENT_PANELS}
                        <div class='tab-pane pad' id='tabs-image'>
                            {#IMAGE_TAB}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;

$TEMPLATE['create_field_name'] = <<<HTML
    <div class="form-group name-field form-cb-name[{#LANG}]">
        <div class="row">
            <div class="col-xs-2">{#LANGUAGE_FLAG}</div>
            <div class="col-xs-10">
                <label>[ADMIN_TEXT_TEAM_TEAMMATE_NAME]</label>
                <input type='text' class='form-control' name='name[{#LANG}]' value='{#NAME}' /><span class='comm'></span>
                
                <label>[ADMIN_TEXT_TEAM_TEAMMATE_TITULUS]</label>
                <input type='text' class='form-control' name='titulus[{#LANG}]' value='{#TITULUS}' /><span class='comm'></span>
            </div>
        </div>
    </div>
HTML;

$TEMPLATE['create_content_tabs'] = <<<HTML
    <li class='{#ACTIVE}'><a href='#tabs-content-{#LANG}' data-toggle='tab' {#ARIA_EXPANDED}>[ADMIN_TEXT_TEAMMATE_EDIT_TABMENU_CONTENT]{#LANGUAGE_FLAG}</a></li>
HTML;

$TEMPLATE['create_content_panels'] = <<<HTML
    <div class='tab-pane {#ACTIVE} form-cb-text[{#LANG}]' id='tabs-content-{#LANG}'>
        <div class="form-group">
            <label>[ADMIN_TEXT_TEAM_TEAMMATE_MUNKAI]</label>
            <input type='text' class='form-control' name='munkai[{#LANG}]' value='{#MUNKAI}' /><span class='comm'></span>
        </div>
        <div class="form-group">
            <label>[ADMIN_TEXT_TEAM_TEAMMATE_FOGLALAS]</label>
            <input type='text' class='form-control' name='foglalas[{#LANG}]' value='{#FOGLALAS}' /><span class='comm'></span>
        </div>
        
        <textarea class='form-control teammateTextEdit contentTinyMCE' name='text[{#LANG}]' id='ckEditorID01_{#LANG}' />{#TEXT}</textarea><span class='comm'></span>
    </div>
HTML;


$TEMPLATE['group_create'] = <<<HTML
    <div class="row">
        <section class='articleGroupCreate'>
            <div class="col-md-6 col-md-offset-3">
        
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kategória szerkesztés</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group form-cb-name">
                            <label>[ADMIN_TEXT_ARTICLE_CATEGORY_EDIT_NAME]</label>
                            <input type='text' class='form-control' name='name' value='{#NAME}' /><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-text">
                            <label>[ADMIN_TEXT_ARTICLE_CATEGORY_EDIT_DESP]</label>
                            <textarea class='form-control contentEdit' name='text' />{#TEXT}</textarea><span class='comm'></span>
                        </div>
                        <div class="form-group form-cb-state">
                            <h4>[ADMIN_TEXT_ARTICLE_EDIT_STATE]</h4>
                            <div class='radio'><label for='state1'><input type='radio' id='state1' name='state' value='1' {#IFSTATE1} />[ADMIN_TEXT_ARTICLE_EDIT_STATE_ACTIVE]</label></div>
                            <div class='radio'><label for='state0'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} />[ADMIN_TEXT_ARTICLE_EDIT_STATE_INACTIVE]</label></div>
                            <span class='comm'></span>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">

                    </div>
                    <!-- /.box-footer-->
                </div>
            </div>
        </section>
    </div>
HTML;
return; ?>