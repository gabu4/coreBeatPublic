<?php
namespace menupoint\article\article_category;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v017
 * @date 18/10/18
 */
if ( !defined('H-KEI') ) { exit; }

class call extends funct {
    public function init() {
        global $database, $theme, $post, $handler;

        $catid = ( isset($_GET['catid']) && !empty($_GET['catid']) && is_numeric($_GET['catid']) ) ? $_GET['catid'] : 1;

        $html = "";

        if (
            isset($post['adminModuleMenuSave']) OR
            isset($post['adminModuleMenuSaveAndExit']) OR
            isset($post['adminModuleMenuSaveAndNew'])
            ) {

            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__content_type`");
            $database->where(" `module` = 'article' and `type` = 'article_category' ");
            $database->order("`id` DESC");
            $database->limit(" 1 ");
            $database->qType("result");
            $content_type_id = $database->execute();

            $state = ( !isset($post['state']) OR empty($post['state']) ) ? 0 : $post['state'];
            $is_blank = ( !isset($post['is_blank']) OR empty($post['is_blank']) ) ? 0 : $post['is_blank'];

            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__menu`");
            $database->order("`id` DESC");
            $database->limit(" 1 ");
            $database->qType("result");
            $id = $database->execute();
            $id = $id+1;

            $database->newQuery();
            $database->select("`id`");
            $database->from("`#__content`");
            $database->order("`id` DESC");
            $database->limit(" 1 ");
            $database->qType("result");
            $content_id = $database->execute();
            $content_id = $content_id+1;			

            $queryArray = array();
            $queryArray['id'] = $id;
            $queryArray['content_id'] = $content_id;
            $queryArray['category'] = $post['category'];
            $queryArray['parent'] = $post['parent'][$post['category']];
            $queryArray['order'] = $post['order'];
            $queryArray['state'] = $state;
            $queryArray['text'] = $post['text'];

            $database->insertTo("#__menu",$queryArray);

            $jsonContentRaw['id'] =  $post['article_category_id'];
            $jsonContentRaw['blank'] =  $is_blank;

            $jsonContent = json_encode($jsonContentRaw);

            $queryArray = array();
            $queryArray['id'] = $content_id;
            $queryArray['name'] = $post['name'];
            $queryArray['seo_name'] = $post['seo_name'];
            $queryArray['type'] = $content_type_id;
            $queryArray['lang'] = 'hu';
            $queryArray['value'] = $jsonContent;

            $database->insertTo("#__content",$queryArray);

            $handler->messageSuccess("Sikeres mentés",true,"save");

            if ( isset($post['adminModuleMenuSave']) ) {
                header("Location: ".CB_INDEX."?admin=menu&funct=edit&catid=".$catid."&id=".$id);
            } else if ( isset($post['adminModuleMenuSaveAndExit']) ) {
                header("Location: ".CB_INDEX."?admin=menu#funct=main&catid=".$catid."");
            } else if ( isset($post['adminModuleMenuSaveAndNew']) ) {
                header("Location: ".CB_INDEX."?admin=menu&funct=create&catid=".$catid."");
            }
        }
        
        if ( $this->menupoint_html_saveTest() ) {
            
            $error = $this->menupoint_html_saveTest_error();
            
            if ( $error ) {
                $this->menupoint_html_save_error($error);
            } else {
                $data = $post;
                $data['catid'] = $catid;
                $error = $this->menupoint_html_save($data);
                
                if ( $error !== TRUE ) { 
                    $this->menupoint_html_save_error($error);
                } else {
                    $this->menupoint_html_save_success($data);
                }
            }
        }

        $replace['DEFTAB'] = '';

        $html = $theme->loadAdminTemplate('admin_article','menupoint_article_category',1,'article');

        $replace['NAME'] = '';
        $replace['SEO_NAME'] = '';
        $replace['TEXT'] = '';
        $replace['ORDER'] = '';

        $replace['GROUPSELECT'] = $this->menupointArticle_menuGroupSelectCreate($catid);
        $replace['PARENTSELECT'] = $this->menupointArticle_menuParentSelectCreate($catid);
        $replace['ARTICLECATEGORYSELECT'] = $this->functionMenuArticleCategorySelect();
        $replace['IFSTATE0'] = '';
        $replace['IFSTATE1'] = ' CHECKED ';

        $replace['TITLE'] = 'Új menüpont: Bejegyzés kategória (hír rendezés)';
        foreach ( $replace as $key => $value ) {
            $html = str_replace( '{#'.strtoupper($key).'}', $value, $html );
        }

        return $html;
    }
}

return; ?>