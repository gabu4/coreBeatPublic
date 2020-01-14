<?php
namespace module\admin\article\group;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v015
 * @date 13/08/19
 */
if ( !defined('H-KEI') ) { exit; }

trait funct {
    protected function callGroupMain_themeLoad($listData) {
        global $theme, $admin_function;
        
        $replace = [];
        $html = $theme->loadTemplate2('article_group_list',TRUE,'article',TRUE);
        $theme->addTextEndJs($theme->loadTemplateJs('article_group_list','article',TRUE));
        
        if ( empty($listData) ) {
            $replace['body'] = "<h2 class='text-center'>[LANG_ADMIN_ARTICLE_GROUP_EMPTY]</h2>";
        } else {
            $tableHead = Array(
                "[LANG_ADMIN_ARTICLE_GROUP_MAIN_ID]",
                "[LANG_ADMIN_ARTICLE_GROUP_MAIN_CATEGORYNAME]",
                "[LANG_ADMIN_ARTICLE_GROUP_MAIN_CONTENTNUMBER]",
                "[LANG_ADMIN_ARTICLE_GROUP_MAIN_ACTIVE]",
                "&nbsp;",
                "&nbsp;"
            );

            $tableBody = Array();$i = 0;

            foreach ( $listData as $val ) {
                
                $count = $this->callGroupMain_count($val['id']);
                
                $tableBody[$i] = Array();

                $tableBody[$i][] = $val['id'];
                $tableBody[$i][] = $val['name'];
                $tableBody[$i][] = $count;
                $tableBody[$i][] = ( $val['state'] == 1 ) ? $admin_function->getIcon('active') : $admin_function->getIcon('inactive');

                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=article&funct=group_edit&id=".$val['id']."'>" . $admin_function->getIcon('edit') . "</a>";
                $tableBody[$i][] = "<a href='".CB_INDEX."?admin=article&funct=group_trash&id=".$val['id']."' class='deleteArticleGroupContent'>" . $admin_function->getIcon('trash') . "</a>";

                $i++;
            }
            
            $replace['body'] = $admin_function->listGenerate($tableHead, $tableBody, 'article_main');
        }
        
        $theme->mustache($replace, $html);
        
        return $html;
    }
}

return; ?>