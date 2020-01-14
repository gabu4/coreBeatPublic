<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 21/11/18
 */
if ( !defined('H-KEI') ) { exit; }

global $theme;

$TEMPLATE['csv_upload_main'] = <<<HTML
    <section class='content'>
        <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <!-- Default box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">[LANG_ADMIN_CATALOG_CSV_LIST_UPLOAD_TITLE]</h3>
                </div>
                <div class="box-body productFileUpdatePage">
                    <div class="form-group">
                        <label for="csv_import_file"></label>
                        <input id="csv_import_file" type="file" name="csv_import_file" />
                        <p class="form-text">[LANG_ADMIN_CATALOG_CSV_LIST_UPLOAD_HELPBLOCK]</p>
                        <p class="file-list-block text-right">
                            <small><small>
                                [LANG_ADMIN_CATALOG_CSV_LIST_UPLOAD_LASTIMPORT]<i>{#UPDATEDATE_CSV}</i> <br/>
                                <button type="submit" class="btn btn-xs btn-warning" name="refresh" value="csv_import_file"><i class="fa fa-fw fa-repeat"></i> Frissítés / újra importálás</button>
                            </small></small>
                        </p>
                        <p><input id="list_replace" type="checkbox" name="list_replace" value="1" /> Listában nem szereplő termékek törlése</p>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="csv_import_file" value="1"><i class="fa fa-fw fa-upload"></i> Feltöltés</button>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
                
    </section>
HTML;

return; ?>