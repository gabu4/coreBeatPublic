<?php
namespace module\admin\catalog\importexport;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v005
 * @date 06/12/18
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    protected function import_html($upload = '') {
        global $theme;
        $html = $theme->loadAdminTemplate('admin_catalog_csv', 'csv_upload_main', TRUE, 'catalog');
        
        $replace = Array();
        $replace['uploadSuccess'] = "";
        
        $categoryDataCountRaw = $this->get_catalogDatabaseCount();
        $lastUpdateTime = cb_load_settings_cache('catalog_csv_update_time');
        
        $replace['COUNT_DB'] = ( !empty($categoryDataCountRaw) ) ? $categoryDataCountRaw : 0;
        $replace['UPDATEDATE_CSV'] = ( !empty($lastUpdateTime) ) ? date("Y F d H:i:s.",$lastUpdateTime) : "[LANG_ADMIN_CATALOG_CSV_LIST_UPLOAD_NEVERUPLOADED]";
        
        if ( !empty($upload) ) {
            
        }
        
        $theme->replace($replace, $html);
        
        return $html;
    }
    
    protected function csvImport_saveFile($isReplace = FALSE) {
        ini_set('max_execution_time', 300);
        
        if(!file_exists($_FILES['csv_import_file']['tmp_name'])) { return FALSE; }  // ha nem létezik FALSE
        
        $allowExtension = ['csv'];
        $allowType = ['application/vnd.ms-excel'];
        $extension = pathinfo(strtolower($_FILES['csv_import_file']['name']),PATHINFO_EXTENSION);
        
        if ( !in_array($extension,$allowExtension) ) { return FALSE; }
        if ( !in_array($_FILES['csv_import_file']['type'],$allowType) ) { return FALSE; }
                
        $target_dir = CB_FILE . "/csv/";
        $targetFile = $target_dir . "csv_import_".microtime(true);
        $targetFile .= ".csv";
        
        $uploadOk = move_uploaded_file($_FILES["csv_import_file"]["tmp_name"], $targetFile);
        
        $this->xmlUpdate($targetFile,$isReplace);
        
        return $uploadOk;
    }
    
    private function xmlUpdate($targetFile,$isReplace) {
        $row = 0;
        $headData = [];
        $csvData = [];
        if (($handle = fopen($targetFile, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ',', '"')) !== FALSE) {
                $csvData[$row++] = $data;
            }
            fclose($handle);
        }
        
        if ( empty($csvData) ) { return NULL; }
        $headData = $csvData[0];
        unset($csvData[0]);
        
        if ( empty($csvData) ) { return NULL; }
        
        $csvData2 = [];
        foreach ( $csvData as $k=>$d) {
            foreach ( $d as $k2=>$v ) {
                $csvData2[$k][strtolower($headData[$k2])] = $v;
            }
        }
        
        // cbd($csvData2,1,1);
        
        $this->putCsvToDB($csvData2,$isReplace);
    }
    
}

return; ?>