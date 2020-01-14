<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v011
 * @date 09/03/19
 */
if ( !defined('H-KEI') ) { exit; }

$JS['menupoint_article'][] = "article_menupoint.js";

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