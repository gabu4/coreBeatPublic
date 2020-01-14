<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v014
 * @date 02/11/19
 */
if ( !defined('H-KEI') ) { exit; }

class admin_function {

    /**
     * Admin icon pack
     * @param string $icon Icon name
     * @return string Icon <<span>> class (CSS rendered)
     */
    public function getIcon( $icon ) {

        if ( $icon === 'active' ) { return "<i class='text-dark fas fa-check-circle fa-2x' title='[LIST_TEXT_ACTIVE]'></i>"; }
        if ( $icon === 'inactive' ) { return "<i class='text-dark fas fa-times-circle fa-2x' title='[LIST_TEXT_INACTIVE]'></i>"; }
        if ( $icon === 'settings' ) { return "<i class='text-dark fas fa-cogs fa-2x' title='[LIST_TEXT_SETTINGS]'></i>"; }

        if ( $icon === 'edit' ) { return "<i class='text-dark fas fa-pen fa-2x' title='[LIST_TEXT_EDIT]'></i>"; }
        if ( $icon === 'view' ) { return "<i class='text-dark fas fa-eye fa-2x' title='[LIST_TEXT_VIEW]'></i>"; }

        if ( $icon === 'delete' ) { return "<i class='text-dark fas fa-trash-alt fa-2x' title='[LIST_TEXT_DELETE]'></i>"; }
        if ( $icon === 'trash' ) { return "<i class='text-dark fas fa-trash-alt fa-2x' title='[LIST_TEXT_TRASH]'></i>"; }

        if ( $icon === 'info' ) { return "<i class='text-dark fas fa-info-circle fa-2x' title='[LIST_TEXT_INFO]'></i>"; }
        if ( $icon === 'about' ) { return "<i class='text-dark fas fa-address-card fa-2x' title='[LIST_TEXT_ABOUT]'></i>"; }
        
        if ( $icon === 'statistics' ) { return "<i class='text-dark fas fa-chart-area fa-2x' title='[LIST_TEXT_STATISTICS]'></i>"; }

    }
	
    /**
     * Admin list generate
     * @param array $tableHeadArray Table <b>head</b>
     * @param array $tableBodyArray Table <b>body</b>
     * @param string $cssName Unique CSS name
     * @return string HTML code
     */
    public function listGenerate( $tableHeadArray, $tableBodyArray, $cssName = '', int $pageSize = 20, int $pageCurrent = 0, $pageSelectorName = 'page') {
        global $get, $theme;
        
        $elementCount = count($tableBodyArray);
        $pageCurrent = ( $pageCurrent === 0 && isset($get[$pageSelectorName]) && is_numeric($get[$pageSelectorName]) && (int) $get[$pageSelectorName] > 0 ? (int) $get[$pageSelectorName] : 1 );
        $elementStart = ( $pageCurrent > 1 ? ($pageCurrent-1) * $pageSize + 1 : 1 );
        $pageNumbers = (int) ceil($elementCount/$pageSize);
        
        $html = $theme->loadAdminTemplate2('list_generate_body');
        
        $replace = [];
        $replace['cssname'] = $cssName;
        
        $replace['head'] = [];
        $i = 0;
        foreach ( $tableHeadArray as $id => $text ) {
            $replace['head'][$i]['id'] = $id;
            $replace['head'][$i]['text'] = $text;
            $i++;
        }
        
        $replace['body'] = [];
        $j = 0;
        $js = 0;
        foreach ( $tableBodyArray as $rowid => $tableBodyRow ) {
            if ( ($j+1) > $pageSize ) { break; }
            if ( ($js+1) < $elementStart ) { $js++;continue; }
            $replace['body'][$j]['rowid'] = $rowid;
            $replace['body'][$j]['rownumber'] = $j;
            $k = 0;
            foreach ( $tableBodyRow as $colid => $content ) {
                $replace['body'][$j]['col'][$k] = [];
                $replace['body'][$j]['col'][$k]['colid'] = $colid;
                $replace['body'][$j]['col'][$k]['content'] = $content;
                $k++;
            }
            $j++;
            $js++;
        }
        
        if ( $pageNumbers > 1 ) {
            for ( $l=1;$l<=$pageNumbers;$l++){
                $replace['paginator'][$l-1]['pagenumber'] = $l;
                $replace['paginator'][$l-1]['text'] = ( $l === 1 ? '[LANG_SYS_FIRST_PAGE]' : ( $l === $pageNumbers ? '[LANG_SYS_LAST_PAGE]' : $l ) );
                $replace['paginator'][$l-1]['link'] = cb_link_clean(NULL,$pageSelectorName,$l);
                $replace['paginator'][$l-1]['active'] = ( $l === $pageCurrent ? TRUE : FALSE );
            }
        }
        
        $theme->mustache($replace,$html);
        
        return $html;
    }
    
    /**
     * Admin list generate
     * @param array $tableHeadArray Table <b>head</b>
     * @param array $tableBodyArray Table <b>body</b>
     * @param string $cssName Unique CSS name
     * @return string HTML code
     */
    public function listGenerate2( $tableHeadArray, $tableBodyArray, $cssName = '', $link = NULL, int $pageSize = 20, int $pageCurrent = 0, $pageSelectorName = 'page' ) {
        global $get, $theme;
        
        $elementCount = count($tableBodyArray);
        $pageCurrent = ( $pageCurrent === 0 && isset($get[$pageSelectorName]) && is_numeric($get[$pageSelectorName]) && (int) $get[$pageSelectorName] > 0 ? (int) $get[$pageSelectorName] : 1 );
        $elementStart = ( $pageCurrent > 1 ? ($pageCurrent-1) * $pageSize + 1 : 1 );
        $pageNumbers = (int) ceil($elementCount/$pageSize);
        
        $html = $theme->loadAdminTemplate2('list_generate2_body');
        
        $replace = [];
        $replace['cssname'] = $cssName;
        
        $replace['head'] = [];
        $i = 0;
        $orderAllowArray = [];
        foreach ( $tableHeadArray as $id => $val ) {
            $text = $val;
            if ( !is_numeric($id) ) {
                $orderAllowArray[$i] = $id;
                if ( !isset($get[$id]) || isset($get[$id]) && $get[$id] !== 'asd' ) {
                    $link_asc = cb_link_clean($link,$id,'asd');
                    $active = '';
                } else {
                    $link_asc = cb_link_clean($link,$id,'');
                    $active = 'text-danger';
                }
                $text .= " <a href='$link_asc'><i class='fa fa-chevron-up ".$active."' aria-hidden='true'></i></a>";
                if ( !isset($get[$id]) || isset($get[$id]) && $get[$id] !== 'desc' ) {
                    $link_desc = cb_link_clean($link,$id,'desc');
                    $active = '';
                } else {
                    $link_desc = cb_link_clean($link,$id,'');
                    $active = 'text-danger';
                }
                $text .= "<a href='$link_desc'><i class='fa fa-chevron-down ".$active."' aria-hidden='true'></i></a>";
            }
            
            $replace['head'][$i]['id'] = $id;
            $replace['head'][$i]['text'] = $text;
            $i++;
        }
        
        foreach ( $get as $gorder=>$gvalue ) {
            if ( in_array($gorder,$orderAllowArray) ) {
                $key = array_search($gorder,$orderAllowArray);
                if ( $gvalue === 'asd' ) {
                    usort($tableBodyArray, function($a, $b) use ($key) {
                        return $a[$key] <=> $b[$key];
                    });
                } elseif ( $gvalue === 'desc' ) {
                    usort($tableBodyArray, function($b, $a) use ($key) {
                        return $a[$key] <=> $b[$key];
                    });
                }
            }
        }
        
        $replace['body'] = [];
        $j = 0;
        $js = 0;
        foreach ( $tableBodyArray as $rowid => $tableBodyRow ) {
            if ( ($j+1) > $pageSize ) { break; }
            if ( ($js+1) < $elementStart ) { $js++;continue; }
            $replace['body'][$j]['rowid'] = $rowid;
            $replace['body'][$j]['rownumber'] = $j;
            $k = 0;
            foreach ( $tableBodyRow as $colid => $content ) {
                $replace['body'][$j]['col'][$k] = [];
                $replace['body'][$j]['col'][$k]['colid'] = $colid;
                $replace['body'][$j]['col'][$k]['content'] = $content;
                $k++;
            }
            $j++;
            $js++;
        }
        
        if ( $pageNumbers > 1 ) {
            for ( $l=1;$l<=$pageNumbers;$l++){
                $replace['paginator'][$l-1]['pagenumber'] = $l;
                $replace['paginator'][$l-1]['text'] = ( $l === 1 ? '[LANG_SYS_FIRST_PAGE]' : ( $l === $pageNumbers ? '[LANG_SYS_LAST_PAGE]' : $l ) );
                $replace['paginator'][$l-1]['link'] = cb_link_clean(NULL,$pageSelectorName,$l);
                $replace['paginator'][$l-1]['active'] = ( $l === $pageCurrent ? TRUE : FALSE );
            }
        }
        
        $theme->mustache($replace,$html);

        return $html;
    }
        
    public function getLanguageFlag($languageISO = NULL ) {
        if ( $languageISO === NULL ) { return ""; }
        $html = "";
        
        $path = CB_THEME . "/_template/icon/flags/" . $languageISO . ".png";
        
        $html .= " <span class='flag'><img src='$path' alt='".$languageISO."' /> </span>";
        
        return $html;
    }
    
    public function textareaModuleSafe($content) {
        return str_replace(['#','{','}'],['&#35;','&#123;','&#125;'],$content);
    }
}

return; ?>