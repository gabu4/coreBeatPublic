<?php
namespace module\admin\article;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v032
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: form ellenörzés és js elemek nincsenek még megírva!
class funct extends database {
    use group\funct;
    use article\funct;
    use article_preview\funct;
    
    protected function listDataLanguageFilter($listDataRaw) {
        global $lang;
        
        $listData = array();
        
        if ( empty($listDataRaw) ) { return $listData; }
        
        foreach ( $listDataRaw as $v ) {
            $listData[$v['article_id']][$v['lang']] = $v;
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


    protected function callMain_themeLoad($listData,$currentCatId) {
        global $theme, $lang, $admin_function;
        
        $replace = [];
        $html = $theme->loadTemplate2('article_list',TRUE,'article',TRUE);
        $theme->addTextEndJs($theme->loadTemplateJs('article_list','article',TRUE));
        
        if ( empty($listData) ) {
            $replace['body'] = "<h2 class='text-center'>[LANG_ADMIN_ARTICLE_CALL_EMPTY]</h2>";
        } else {
            $tableHead = Array(
                "[LANG_ADMIN_ARTICLE_CALL_MAIN_ID]",
                "[LANG_ADMIN_ARTICLE_CALL_MAIN_ARTICLENAME]",
                "[LANG_ADMIN_ARTICLE_CALL_MAIN_CDATE]",
                "[LANG_ADMIN_ARTICLE_CALL_MAIN_MDATE]",
                "[LANG_ADMIN_ARTICLE_CALL_MAIN_ACTIVE]",
                "&nbsp;",
                "&nbsp;"
            );

            $tableBody = Array();$i = 0;

            foreach ( $listData as $aid=>$v ) {
                $l = $lang->getLanguage();
                
                $tableBody[$i] = Array();
                
                $flag = $admin_function->getLanguageFlag($v[$l]['lang']);
                
                $tableBody[$i][] = $aid;
                $tableBody[$i][] = ( isset($v[$l]['name']) && !empty($v[$l]['name']) ) ? $v[$l]['name'].$flag : "<span class='text-muted'><span class='small'><span class='small'>[LANG_ADMIN_ARTICLE_CALL_MAIN_ARTICLENAME_EMPTY]</span></span></span>".$flag;
                $tableBody[$i][] = ( isset($v[$l]['date_create']) ) ? $v[$l]['date_create'] : " ----- ";
                $tableBody[$i][] = ( isset($v[$l]['date_mod']) && $v[$l]['date_mod'] != '0' ) ? $v[$l]['date_mod'] : " ----- ";
                $tableBody[$i][] = ( isset($v[$l]['state']) && $v[$l]['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=article&funct=edit&id=".$aid."'>" . $admin_function->getIcon('edit') . "</a>";
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=article&funct=trash&id=".$aid."' class='deleteArticleContent'>" . $admin_function->getIcon('trash') . "</a>";
                
                $i++;
            }
            
            $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'article_main');
        }
        
        $replace['category_filter'] = $this->callMain_categoryFilter($currentCatId);
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
    
    private function callMain_categoryFilter($currentCatId) {
        $data = $this->callCreate_categoryListCreate_getData();
        
        $html = "";
        
        if ( !empty($data) ) {
            $dataOrdered = $this->dataOrdering($data);
        
            $html .= "<label>[LANG_ADMIN_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE] </label> ";
            $html .= "<select class='selectCatListFilter' id='catListId' name='catList' size='1'>";
            
            $html .= "<option value='0'>[LANG_ADMIN_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_ALL]</option>";
            $selected = ( $currentCatId != 0 && $currentCatId == -1 ) ? ' SELECTED ' : '';
            $html .= "<option value='-1' ".$selected.">[LANG_ADMIN_ARTICLE_CALL_MAIN_CATEGORY_SELECT_TEXT_NOCATEGORY]</option>";
            foreach ( $dataOrdered as $ldValue ) {
                $name = "";
                for ( $i2 = 0; $i2 < $ldValue['level']; $i2++ ) {
                        $name .= "--";
                }
                $name .= $ldValue['name'];
                $selected = ( $currentCatId != 0 && $currentCatId == $ldValue['cat_id'] ) ? ' SELECTED ' : '';
                $html .= "<option value='".$ldValue['cat_id']."' ".$selected.">".$name."</option>";
            }
            $html .= "</select>";
        }
        
        return $html;
    }
    
    protected function dataOrdering($data) {
        $data2 = array();
        
        foreach ( $data as $v ) {
            $data2[$v['parent']][$v['cat_id']] = $v;
        }
        
        $data3 = $this->callCreate_categoryListCreate_dataOrdering_repeat($data2, 0, 0);
        
        return $data3;
    }
        
}

return; ?>