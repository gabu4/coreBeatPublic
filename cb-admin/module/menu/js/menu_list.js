jQuery(document).ready(function() {
    menuMainListCategorySelectJS();
});

function menuMainListCategorySelectJS() {
    if ( jQuery('select.selectCatListFilter').length > 0 ) {
        if ( jQuery('select.selectCatListFilter>option').length > 0 ) {
            jQuery('.content').on("click","select.selectCatListFilter>option",function() {
                var catVal = jQuery(this).val();
                var catLang = jQuery('.menuList .activeCategoryLanguage').data('lang');
                var urlLink = '?admin=menu&funct=main&catid='+catVal+"&catlang="+catLang;
                //window.location.href = urlLink;
                jQuery.get(urlLink, function( articleListPage ) {
                    var articleList = jQuery(articleListPage).find('.menuList').html();
                    jQuery('.menuList').html(articleList);
                }, 'html');
                window.history.pushState({}, '', urlLink);
            });
            jQuery(window).bind('popstate', function(){
                window.location.href = window.location.href;
            });
        }
    }
}