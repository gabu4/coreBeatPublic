jQuery(document).ready(function() {
    productMainListCategorySelectJS();
});

function productMainListCategorySelectJS() {
    if ( jQuery('select.selectCatListFilter').length > 0 ) {
        if ( jQuery('select.selectCatListFilter>option').length > 0 ) {
            jQuery('.content').on("click","select.selectCatListFilter>option",function() {
                var catVal = jQuery(this).val();
                var urlLink = '?admin=product&funct=main&cat='+catVal;
                //window.location.href = urlLink;
                jQuery.get(urlLink, function( productListPage ) {
                    var productList = jQuery(productListPage).find('.productList').html();
                    jQuery('.productList').html(productList);
                }, 'html');
                window.history.pushState({}, '', urlLink);
            });
            jQuery(window).bind('popstate', function(){
                window.location.href = window.location.href;
            });
        }
    }
}