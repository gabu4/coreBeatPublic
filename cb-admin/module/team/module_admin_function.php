<?php
namespace module\admin\team;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v030
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: form ellenörzés és js elemek nincsenek még megírva!
class funct extends database {
    use user\funct;
    
    protected function listDataLanguageFilter($listDataRaw) {
        global $lang;
        
        $listData = array();
        
        if ( empty($listDataRaw) ) { return $listData; }
        
        foreach ( $listDataRaw as $v ) {
            $listData[$v['team_id']][$v['lang']] = $v;
        }
        foreach ( $listData as $k=>$v ) {
            foreach ( $lang->getAllowedLanguageTypes() as $l ) {
                if ( !isset($v[$l]) ) {
                    $listData[$k][$l] = array();
                }
            }
        }
        
        return $listData;
    }


    protected function callMain_themeLoad($listData) {
        global $theme, $lang, $admin_function;
        
        $replace = Array();
        $html = $theme->loadAdminTemplate('admin_team','list',TRUE,'team');
        
        if ( empty($listData) ) {
            $replace['body'] = "<h2 class='text-center'>[PAGE_NO_TEAM_DATA]</h2>";
        } else {
            
            $replace['body'] = "";
            
            foreach ( $listData as $aid=>$v ) {
                $html2 = $theme->loadAdminTemplate('admin_team','list_element',TRUE,'team');
            
                $l = $lang->getLanguage();
                
                $media = json_decode($v[$l]['media'],true);
                $flag = "";
                if ( $lang->getAllowedLanguageCount() > 1 ) {
                    foreach ( $lang->getAllowedLanguageTypes() as $l2 ) {
                        $haveContent = TRUE;
                        if ( ( ( !isset($v[$l2]) || empty($v[$l2]) ) || ( !isset($v[$l2]['name']) || empty($v[$l2]['name']) ) ) && ( !isset($v[$l2]['state']) || $v[$l2]['state'] != 1 ) ) {
                            $haveContent = FALSE;
                        }
                        if ( $haveContent == TRUE ) {
                            $flag .= $admin_function->getLanguageFlag($l2);
                        }
                    }
                }
                
                if ( isset($media['image']) && !empty($media['image'])  ) {
                    $teamMate_image = $this->teamContentImagePathHTML.$this->teamContentImagePath_small.$media['image'];
                } else {
                    $teamMate_image = CB_ADMIN . "/module/team/img/default-user-image.png";
                }
                
                $replace2 = array();
                $replace2['image'] = $teamMate_image;
                $replace2['name'] = $v[$l]['name'];
                $replace2['flag'] = $flag;
                $replace2['state'] = ( isset($v[$l]['state']) && $v[$l]['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                $replace2['edit'] = "<a href='".CB_INDEX."?admin=team&funct=edit&id=".$aid."'>" . $admin_function->getIcon('edit') . "</a>";
                $replace2['delete'] = "<a href='".CB_INDEX."?admin=team&funct=trash&id=".$aid."' class='deleteTeamMateContent'>" . $admin_function->getIcon('trash') . "</a>";
                
                $theme->replace($replace2, $html2);
                
                $replace['body'] .= $html2;
                
            }
            
$script = <<<HTML
<script>
        function deleteTeamMateContentJS() {
            jQuery('.deleteTeamMateContent').on('click',function(e) {
                jQuery(this).parents('tr.trow').addClass('danger');
                if ( confirm('[ADMIN_TEXT_TEAM_CALL_DELETESURE]') ) {
                    return true;
                } else {
                    jQuery(this).parents('tr.trow').removeClass('danger');
                    return false;
                }
            });
        }
        
        deleteTeamMateContentJS();
</script>
HTML;
        
            $replace['body'] .= $script;
            
        }
                
        $theme->replace($replace, $html);
        
        return $html;
    }
    
    private function callMain_categoryFilter($currentCatId) {
        $data = $this->callCreate_categoryListCreate_getData();
        
        $html = "";
        
        if ( !empty($data) ) {
            $html .= "<label>[ADMIN_TEXT_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE] </label> ";
            $html .= "<select class='selectCatListFilter' id='catListId' name='catList' size='1'>";
            
            $html .= "<option value='0'>[ADMIN_TEXT_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_ALL]</option>";
            $selected = ( $currentCatId != 0 && $currentCatId == -1 ) ? ' SELECTED ' : '';
            $html .= "<option value='-1' ".$selected.">[ADMIN_TEXT_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_NOCATEGORY]</option>";
            foreach ( $data as $ldValue ) {
                $selected = ( $currentCatId != 0 && $currentCatId == $ldValue['cat_id'] ) ? ' SELECTED ' : '';
                $html .= "<option value='".$ldValue['id']."' ".$selected.">".$ldValue['name']."</option>";
            }
            $html .= "</select>";
        }
                
        return $html;
    }
        
}

return; ?>