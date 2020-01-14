jQuery(window).on('load',function() {
    catalogCategoryPageContentsJS();
    catalogCategoryPageLogoTopMarginJS();
});

catalogCategoryPageContentsJS = function() {
    if ( jQuery("div.catalogContentPageDiv .image.gallery .contentCatalogImage").length > 0 ) {
        jQuery("div.catalogContentPageDiv .image.gallery>a").on('click',function(event) {
            event.preventDefault();
            var t = jQuery(this).attr('href');
            
            jQuery("div.catalogContentPageDiv .image.one .contentCatalogImage").attr('src',t);
        });
    }
};

catalogCategoryPageLogoTopMarginJS = function() {
    if ( jQuery("div.catalogContentPageDiv .marka-logo, div.catalogContentPageDiv .image.one img").length > 0 ) {
        var h = jQuery("div.catalogContentPageDiv .image.one img").height();
        
        jQuery("div.catalogContentPageDiv .marka-logo").css('margin-top',h/3+'px');
                
    }
};