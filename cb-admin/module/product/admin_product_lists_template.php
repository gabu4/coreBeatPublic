<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 03/12/14
 */
if ( !defined('H-KEI') ) { exit; }

$JS['list'][0] = 'product_list.js';

$TEMPLATE['list'] = <<<HTML
        <div class='productDiv'>
            <div class='productSearchDiv'>
                {#LISTSEARCHBAR}
            </div>
            <div class='productListDiv'>
                <div class="table-responsive">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Név</th>
                            <th>Átmérő</th>
                            <th>Helyettesítő</th>
                            <th>Készlet</th>
                            <th>Ár</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#LISTTABLECONTENT}
                    </tbody>
                </table>
                </div>
            </div>
        </div>
HTML;

$JS['list2'][0] = 'product_list.js';

$TEMPLATE['list2'] = <<<HTML
        <div class='productDiv'>
            <div class='productSearchDiv'>
                {#LISTSEARCHBAR}
            </div>
            <div class='productListDiv'>
                <div class='text-center paging'>
                    {#PAGING}
                </div>
                {#TABLE}
                <div class='text-center paging'>
                    {#PAGING}
                </div>
            </div>
        </div>
HTML;


$TEMPLATE['list2_table'] = <<<HTML
        <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Készlet</th>
                    <th>Raktár</th>
                    <th>Utolsó beírt ár</th>
                </tr>
            </thead>
            <tbody>
                {#LISTTABLECONTENT}
            </tbody>
        </table>
        </div>
HTML;

$TEMPLATE['list2_table_row'] = <<<HTML
        <tr class='listProduct product_id_{#PRODUCT_ID}'>
        <td class='name'>{#PRODUCT_NAME}</td>
        <td>{#PRODUCT_RAKTARKESZLET}</td>
        <td>{#PRODUCT_RAKTAR}</td>
        <td>{#PRODUCT_PRICE}</td>
        </tr>
HTML;

$TEMPLATE['list_searchbar'] = <<<HTML
        <div class="productSearchBar panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Kereső</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12">
                    <label><input type="radio" name="searchmod" id="searchmod_kezdete" value="kezdete" {#IFSEARCHMOD_KEZDETE} /> Kezdete</label> 
                    <label><input type="radio" name="searchmod" id="searchmod_reszletre" value="reszletre" {#IFSEARCHMOD_RESZLETRE} /> Részletre</label> 
                    <label><input type="radio" name="searchmod" id="searchmod_pontos" value="pontos" {#IFSEARCHMOD_PONTOS} /> Pontos egyezés</label>
                </div>
                <div class="col-xs-12">
                    <div class="input-group input-group">
                        <input type="text" class="form-control" id="cikkszam" name="cikkszam" placeholder="pl.: 6204ZZ" value="{#CIKKSZAM}" />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">Keresés</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
HTML;


return ?>
