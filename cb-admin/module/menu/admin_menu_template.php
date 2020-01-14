<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 06/03/18
 */
if ( !defined('H-KEI') ) { exit; }

$TEMPLATE['menugrouplist'] = <<<HTML
    <div class="row">
        <section class='menuGroupList'>
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-body ">
                        {#BODY}
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;
	
$JSEND['menulist'][] = "menu_list.js";
$TEMPLATE['menulist'] = <<<HTML
    <div class="row">
        <section class='menuList'>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header ">
                        <div class="float-left languageSelector">
                            {#LANGUAGE_FILTER}
                        </div>
                        <div class="float-right categorySelector">
                            {#CATEGORY_FILTER}
                        </div>
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
        <section class='menuCreate'>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{#TITLE}</h3>
                    </div>
                    <div class="box-body menuTypeSelect">
                        {#BODY}
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;


return; ?>