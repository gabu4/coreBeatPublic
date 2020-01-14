<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v012
 * @date 25/05/18
 */
if ( !defined('H-KEI') ) { exit; }

global $theme;
$theme->loadTinyMCE();

$JS['create'][] = "jquery-sortable.js";
$JS['create'][] = "forms_create.js";

$TEMPLATE['list'] = <<<HTML
    <div class="row">
        <section class='contactFormsList'>
            <div class="col-md-offset-3 col-md-6">
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
	

$TEMPLATE['create'] = <<<HTML
    <div class="row">
        <section class='contactFormsCreate'>
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <p>Új sor hozzáadása</p>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_1" data-type="1"><i class="fa fa-plus"></i> Rövid mező (input)</button></p>
                        
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_2" data-type="2"><i class="fa fa-at"></i> E-mail mező (input)</button></p>
        
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_3" data-type="3"><i class="fa fa-plus"></i> Szám mező (input)</button></p>
        
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_4" data-type="4"><i class="fa fa-plus"></i> Hosszú mező (textarea)</button></p>
        
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_5" data-type="5"><i class="fa fa-check-square-o"></i> Jelölő négyzet (checkbox)</button></p>
        
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_6" data-type="6"><i class="fa fa-dot-circle-o"></i> Rádió gomb (radio)</button></p>
        
                            <p class="new_row_button"><button type="button" class="btn btn-default newRowButton type_7" data-type="7"><i class="fa fa-caret-square-o-down "></i> Lenyíló menü (select)</button></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-9">
                            <div class="form-group form-cb-name">
                                <label>[ADMIN_TEXT_FORM_CREATE_NAME]</label>
                                <input type='text' class='form-control' name='name' value='{#NAME}' />
                                <input type='hidden' name='id' value='{#FORM_ID}' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-cb-state">
                                <label>[ADMIN_TEXT_FORM_CREATE_STATE]</label>
                                <div class='radio'><label for='state1'><input type='radio' id='state1' name='state' value='1' {#IFSTATE1} />[ADMIN_TEXT_FORM_CREATE_STATE_ACTIVE]</label></div>
                                <div class='radio'><label for='state0'><input type='radio' id='state0' name='state' value='0' {#IFSTATE0} />[ADMIN_TEXT_FORM_CREATE_STATE_INACTIVE]</label></div>
                                <span class='comm'></span>
                            </div>
                        </div>
                    
                        <div class="col-md-12">
                            <div class="form-group form-cb-target_subject">
                                <label>[ADMIN_TEXT_FORM_CREATE_TARGET_SUBJECT]</label>
                                <input type='text' class='form-control' name='target_subject' value='{#TARGET_SUBJECT}' />
                            </div>
                            <div class="form-group form-cb-target_email">
                                <label>[ADMIN_TEXT_FORM_CREATE_TARGET_EMAIL]</label>
                                <input type='email' class='form-control' name='target_email' value='{#TARGET_EMAIL}' />
                            </div>
                            <div class="form-group form-cb-send_text">
                                <label>[ADMIN_TEXT_FORM_CREATE_TARGET_SEND_TEXT]</label>
                                <input type='text' class='form-control' name='send_text' value='{#SEND_TEXT}' />
                            </div>
                            <div class="form-group form-cb-form_class">
                                <label>[ADMIN_TEXT_FORM_CREATE_TARGET_FORM_CLASS]</label>
                                <input type='text' class='form-control' name='form_class' value='{#FORM_CLASS}' />
                            </div>
                            <ol class="new_row_pace">
                                {#EXIST_ROWS}
                            </ol>
                            
                        </div>
        
                    </div>
                </div>
            </div>
        </section>
    </div>
HTML;

/* "<select class="form-control" name="type[{#I}]">
            <option value='1'>Szövegdoboz (input)</option>
            <option value='2'>E-mail (input)</option>
            <option value='3'>Szám mező (input)</option>
            <option value='4'>Szövegmező (textarea)</option>
            <option value='5'>Jelölődoboz (checkbox)</option>
            <option value='6'>Rádiógomb (radio)</option>
            <option value='7'>Legördülő menü (select)</option>
        </select>"; */

/* rövid szöveg mező */
$TEMPLATE['create_newrow_type_1'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Rövid mező (input) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='1' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Mező címe: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;


/* email mező */
$TEMPLATE['create_newrow_type_2'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Email mező (input) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='2' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Mező címe: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][formcopy]' value='1' {#FIELD_FORMCOPY} /> Űrlap elküldése a megadott címre (is) </label>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][replyemail]' value='1' {#FIELD_REPLYEMAIL} /> Válasz email cím </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;


/* szám mező */
$TEMPLATE['create_newrow_type_3'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Szám mező (input) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='3' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Mező címe: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;


/* hosszú szöveg mező */
$TEMPLATE['create_newrow_type_4'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Hosszú mező (textarea) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='4' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Mező címe: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;


/* jelölő négyzet mező */
$TEMPLATE['create_newrow_type_5'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Jelölő négyzet (checkbox) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='5' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Jelölő négyzet felirata: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;


/* rádió gomb */
$TEMPLATE['create_newrow_type_6'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Rádió gomb (radio) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='6' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Rádió gombok címe: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Választási lehetőségek (minden sorba 1 lehetőség): </label>
                    <textarea class='form-control field_setup' name='field[{#I}][setup]' />{#FIELD_SETUP}</textarea>
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;


/* lenyíló menü */
$TEMPLATE['create_newrow_type_7'] = <<<HTML
<li class="panel-group formRowJS">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <span class="moveIconSpan"><i class="fas fa-ellipsis-v moveIcon"></i></span>
                <a data-toggle="collapse" href="#collapse_{#I}">Lenyíló menü (select) <span class='rowTitle'>{#FIELD_TITLE}</span></a>
                <div class="float-right">
                    <button type="button" class="btn btn-box-tool formRowRemoveButton"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <div id="collapse_{#I}" class="panel-body panel-collapse collapse">
            <div class="form-group">
                {#ID_NAME}
                <input type='hidden' name='field[{#I}][type]' value='7' />
                <input type='hidden' name='field[{#I}][name]' value='{#FIELD_NAME}' />
                <p>
                    <label>Lenyíló menü címe: </label>
                    <input type='text' class='form-control field_title' name='field[{#I}][title]' value='{#FIELD_TITLE}' />
                </p>
                <p>
                    <label>Választási lehetőségek (minden sorba 1 lehetőség): </label>
                    <textarea class='form-control field_setup' name='field[{#I}][setup]' />{#FIELD_SETUP}</textarea>
                </p>
                <p>
                    <label>Infó: </label>
                    <textarea class='form-control field_info' name='field[{#I}][info]' />{#FIELD_INFO}</textarea>
                </p>
                <p>
                    <label><input type='checkbox' name='field[{#I}][required]' value='1' {#FIELD_REQUIRED} /> Kötelező </label>
                </p>
                <p>
                    <label>CSS osztály: </label>
                    <input type='text' class='form-control field_class' name='field[{#I}][class]' value='{#FIELD_CLASS}' />
                </p>
            </div>
        </div>
    </div>
</li>
HTML;

return; ?>