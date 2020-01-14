<?php
namespace sys\update;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 23/08/19
 */
if ( !defined('H-KEI') ) { exit; }

class update {
    
    private $update_path = 'http://update.corebeat.webed.hu/';
    private $update_version_change_file = 'cb-change.txt';
    private $version = "";
    private $version_number = 0;
    private $version_main = 0;
    private $version_sub = 0;
    private $version_day = 0;
    private $version_day_sub = 0;
    private $core_generation = 0;
    
    public function __construct() {
        $this->version = (string) VERSION;
        $this->version_number = $this->version_number_builder((string) VERSION);
        $this->version_main = (int) VERSION_MAIN;
        $this->version_sub = (int) VERSION_SUB;
        $this->version_day = (int) VERSION_DAY;
        $this->version_day_sub = (int) VERSION_DAY_SUB;
        $this->core_generation = (int) CORE_GENERATION;
    }
    
    public function get_update_path() { return $this->update_path; }
    public function get_version() { return $this->version; }
    public function get_version_number() { return (int) $this->version_number; }
    public function get_version_main() { return (int) $this->version_main; }
    public function get_version_sub() { return (int) $this->version_sub; }
    public function get_version_day() { return (int) $this->version_day; }
    public function get_version_day_sub() { return (int) $this->version_day_sub; }
    public function get_core_generation() { return (int) $this->core_generation; }
    public function get_version_change_file() { return (int) $this->core_generation; }
    
    public function version_number_builder($version) {
        $l2 = explode (".",trim($version));
        $main = "1".str_pad($l2[0], 2, '0', STR_PAD_LEFT);
        $sub = str_pad($l2[1], 3, '0', STR_PAD_LEFT);
        $day = str_pad($l2[2], 8, '0', STR_PAD_LEFT);
        return $main.$sub.$day;
    }
    
    public function server_check_version() {
        $cc = new \cb_cURL();
        $p = $cc->json($this->update_path.'version.php?main='.$this->version_main.'&sub='.$this->version_sub);
        
        if ( empty($p) ) { return '[LANG_SYS_UPDATE_VERSION_CHECK_FAIL]'; }
        
        $j = cb_is_json($p,TRUE);
        
        if ( $j ) {
            return $j;
        } else {
            return '[LANG_SYS_UPDATE_VERSION_CHECK_FAIL]';
        }
    }
    
    public function get_changes($version_target,&$version=[]) {
        $version = [];
        $version_target2 = $this->version_number_builder($version_target);
        
        if ( !is_dir(CB_UPDATE) ) { mkdir(CB_UPDATE, 0755, TRUE); }
        $version_file = CB_UPDATE."/version.txt";
        cb_file_download($version_file, $this->update_path.$this->update_version_change_file);
        
        $version_key = "";
        $version_change = "";
        $handle = fopen(CB_UPDATE."/version.txt", "r");
        
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if ( substr($line,0,1) === '#' ) {
                    $l = substr($line,1);
                    $version_key = $this->version_number_builder($l);
                    $version[$version_key] = "";
                }
                if ( $version_key === '' ) {continue;}
                if ( trim($line) === '' ) {continue;}
                $version[$version_key] .= nl2br($line);
            }
            fclose($handle);
        }
        
        ksort($version);
        
        foreach ($version as $k=>$v) {
            if ( $k <= $this->version_number ) { unset($version[$k]);continue; } 
            if ( $k > $version_target2 ) { unset($version[$k]);continue; }
            $version_change .= $v.'<br>';
        }
        
        return $version_change;
    }
}

global $cbupdate;
$cbupdate = new update();

return; ?>