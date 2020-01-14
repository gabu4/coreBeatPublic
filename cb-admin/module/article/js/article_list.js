jQuery(document).ready(function() {
    articleMainListCategorySelectJS();
    deleteArticleContentJS();
});

var articleMainListCategorySelectJS = function() {
    if ( jQuery('select.selectCatListFilter').length > 0 ) {
        if ( jQuery('select.selectCatListFilter>option').length > 0 ) {
            jQuery('.content').on("click","select.selectCatListFilter>option",function() {
                var catVal = jQuery(this).val();
                var urlLink = '?admin=article&funct=main&cat='+catVal;
                //window.location.href = urlLink;
                jQuery.get(urlLink, function( articleListPage ) {
                    var articleList = jQuery(articleListPage).find('.articleList').html();
                    jQuery('.articleList').html(articleList);
                }, 'html');
                window.history.pushState({}, '', urlLink);
            });
            jQuery(window).bind('popstate', function(){
                window.location.href = window.location.href;
            });
        }
    }
};

var deleteArticleContentJS = function() {
    jQuery('.deleteArticleContent').on('click',function(e) {
        jQuery(this).parents('tr.trow').addClass('danger');
        var str = '[LANG_ADMIN_ARTICLE_CALL_DELETESURE]';
        var regex = /<br\s*[\/]?>/gi;
        if ( confirm(str.replace(regex, "\n")) ) {
            return true;
        } else {
            jQuery(this).parents('tr.trow').removeClass('danger');
            return false;
        }
    });
};