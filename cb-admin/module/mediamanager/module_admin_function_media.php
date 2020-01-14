<?php
namespace module\admin\mediamanager\media;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    protected function callMediaList_themeLoad() {
        global $theme, $lang, $admin_function, $get;
        
        $moduleName = ( isset($get['m']) && !empty($get['m']) ) ? $get['m'] : NULL;
        $moduleID = ( isset($get['i']) && is_numeric($get['i']) ) ? $get['i'] : 0;
        
        $listData = $this->callMediaList_databaseGet($moduleName,$moduleID);
        
        $replace = [];
        $html = $theme->loadTemplate2('mediamanager_list',TRUE,'mediamanager',TRUE);
        $theme->addTextEndJs($theme->loadTemplateJs('mediamanager_list','mediamanager',TRUE));
        
        if ( empty($listData) ) {
            $replace['body'] = "<h2 class='text-center'>[LANG_ADMIN_MEDIAMANAGER_LIST_EMPTY]</h2>";
        } else {
            $tableHead = Array(
                'id'=>"[LANG_ADMIN_MEDIAMANAGER_LIST_ID]",
                'name'=>"[LANG_ADMIN_MEDIAMANAGER_LIST_FILENAME]",
                'module'=>"[LANG_ADMIN_MEDIAMANAGER_LIST_MODULECONTENT]",
                'date'=>"[LANG_ADMIN_MEDIAMANAGER_LIST_UPLOADDATE]",
                "&nbsp;"
            );

            $tableBody = Array();$i = 0;

            foreach ( $listData as $v ) {
                $tableBody[$i] = Array();
                
                $modules = $this->callMediaList_moduleListBuild($v['id']);
                
                $tableBody[$i][] = $v['id'];
                $tableBody[$i][] = ( isset($v['file_name']) && !empty($v['file_name']) ) ? $v['file_name'] : "<span class='text-muted'><span class='small'><span class='small'>[LANG_ADMIN_MEDIAMANAGER_LIST_FILENAME_EMPTY]</span></span></span>";
                $tableBody[$i][] = $modules;
                $tableBody[$i][] = $v['date_upload'];
                
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=mediamanager&funct=media_modify&id=".$v['id']."' class='btn btn-default'><i class='fa fa-pencil' aria-hidden='true'></i> [LANG_SYS_TEXT_EDIT]</a>";
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=mediamanager&funct=media_remove&id=".$v['id']."' class='btn btn-danger deleteMediaContent'><i class='fa fa-trash' aria-hidden='true'></i> [LANG_SYS_TEXT_DELETE]</a>";
                
                $i++;
            }
            
            $replace['body'] = $admin_function->listGenerate2($tableHead, $tableBody, 'article_main');
        }
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    private function callMediaList_moduleListBuild($id) {
        $html = ""; 
        
        return $html;
    }
}

return; ?>