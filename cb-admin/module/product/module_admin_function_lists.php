<?php
namespace module\admin\product\lists;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v006
 * @date 11/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    
    protected function listDataLanguageFilter($listDataRaw) {
        global $lang;
        
        $listData = array();
        
        if ( empty($listDataRaw) ) { return $listData; }
        
        foreach ( $listDataRaw as $v ) {
            $listData[$v['product_id']][$v['lang']] = $v;
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
        
        $replace = Array();
        $html = $theme->loadAdminTemplate('admin_product','list',TRUE,'product');
        
        if ( empty($listData) ) {
            $replace['body'] = "<h2 class='text-center'>[ADMIN_TEXT_PRODUCT_CALL_EMPTY]</h2>";
        } else {
            $tableHead = Array(
                "[ADMIN_TEXT_PRODUCT_CALL_MAIN_ID]",
                "[ADMIN_TEXT_PRODUCT_CALL_MAIN_ARTICLENAME]",
                "[ADMIN_TEXT_PRODUCT_CALL_MAIN_CDATE]",
                "[ADMIN_TEXT_PRODUCT_CALL_MAIN_MDATE]",
                "[ADMIN_TEXT_PRODUCT_CALL_MAIN_ACTIVE]",
                "&nbsp;",
                "&nbsp;"
            );

            $tableBody = Array();$i = 0;

            $flag = array();
            foreach ( $listData as $aid=>$v ) {

                $l = $lang->getLanguage();
                
                
                $tableBody[$i] = Array();
                
                $tableBody[$i][] = $aid;
                $tableBody[$i][] = ( isset($v[$l]['name']) && !empty($v[$l]['name']) ) ? $v[$l]['name']."{#FLAG_".$aid."_F}" : "<span class='text-muted'><span class='small'><span class='small'>[ADMIN_TEXT_PRODUCT_CALL_MAIN_ARTICLENAME_EMPTY]</span></span></span>{#FLAG_".$aid."_F}";
                $tableBody[$i][] = ( isset($v[$l]['cre_date']) ) ? $v[$l]['cre_date'] : " ----- ";
                $tableBody[$i][] = ( isset($v[$l]['mod_date']) && $v[$l]['mod_date'] != '0' ) ? $v[$l]['mod_date'] : " ----- ";
                $tableBody[$i][] = ( isset($v[$l]['state']) && $v[$l]['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');
                
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=product&funct=product_edit&id=".$aid."'>" . $admin_function->getIcon('edit') . "</a>";
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=product&funct=product_delete&id=".$aid."' class='deleteProductContent'>" . $admin_function->getIcon('trash') . "</a>";
                
                $i++;
                
                $flag[$aid] = "";
                if ( $lang->getAllowedLanguageCount() > 1 ) {
                    foreach ( $lang->getAllowedLanguageTypes() as $l2 ) {
                        
                        $haveContent = TRUE;
                        if ( ( ( !isset($v[$l2]) || empty($v[$l2]) ) || ( !isset($v[$l2]['name']) || empty($v[$l2]['name']) ) ) && ( !isset($v[$l2]['state']) || $v[$l2]['state'] != 1 ) ) {
                            $haveContent = FALSE;
                        }
                        if ( $haveContent == TRUE ) {
                            $flag[$aid] .= $admin_function->getLanguageFlag($l2);
                        } else {
                            $flag[$aid] .= "";
                        }
                    }
                }
            }
            
$script = <<<HTML
<script>
        function deleteProductContentJS() {
            jQuery('.deleteProductContent').on('click',function(e) {
                jQuery(this).parents('tr.trow').addClass('danger');
                if ( confirm('[ADMIN_TEXT_PRODUCT_CALL_DELETESURE]') ) {
                    return true;
                } else {
                    jQuery(this).parents('tr.trow').removeClass('danger');
                    return false;
                }
            });
        }
        
        deleteProductContentJS();
</script>                    
HTML;
        
            $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'product_main');
            $replace['body'] .= $script;
            
            foreach ( $flag as $aid=>$lng ) {
                $k = 'flag_'.$aid.'_f';
                $replace[$k] = $lng;
            }
        }
        
        $replace['title'] = "[ADMIN_TEXT_PRODUCT_CALL_MAIN_TITLE]";
        $replace['category_filter'] = $this->callMain_categoryFilter($currentCatId);
        
        $theme->replace($replace, $html);
        
        return $html;
    }
    
    private function callMain_categoryFilter($currentCatId) {
        $data = $this->callProductCreate_categoryListCreate_getData();
        
        $html = "";
        
        if ( !empty($data) ) {
            $html .= "<label>[ADMIN_TEXT_PRODUCT_CALL_MAIN_CATEGORY_SELECT_TEXT_TITLE] </label> ";
            $html .= "<select class='selectCatListFilter' id='catListId' name='catList' size='1'>";
            
            $html .= "<option value='0'>[ADMIN_TEXT_PRODUCT_CALL_MAIN_CATEGORY_SELECT_TEXT_ALL]</option>";
            $selected = ( $currentCatId != 0 && $currentCatId == -1 ) ? ' SELECTED ' : '';
            $html .= "<option value='-1' ".$selected.">[ADMIN_TEXT_PRODUCT_CALL_MAIN_CATEGORY_SELECT_TEXT_NOCATEGORY]</option>";
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