cbGalleryPage = function () {
    if ( jQuery('.cbGallery').length === 0 ) return false;
    
    jQuery('.cbGallery').each(function() {
        var elem = jQuery(this);
        if ( jQuery(elem).find('.cbGalleryPage').length > 1 ) {
            jQuery(elem).find('.cbGalleryPage').hide(0);
            
            jQuery(elem).find('.cbGalleryPage-number-1').show();
            jQuery(elem).find('.cbGalleryPaginator .cbGalleryPaginatorElement-number-1').addClass('active');
            
            cbGalleryFirstHeight(elem);
        }
    });
    
    cbGalleryClick();
};

cbGalleryClick = function() {
    jQuery('.cbGallery').on('click','.cbGalleryPaginatorElement',function() {
        var pageNumber = jQuery(this).data('pagenumber');
        var pageContent = jQuery(this).parents('.cbGallery');
        
        jQuery(pageContent).find('.cbGalleryPaginator .cbGalleryPaginatorElement-number-'+pageNumber).addClass('active').siblings().removeClass('active');
        jQuery(pageContent).find('.cbGalleryPage').slideUp();
        jQuery(pageContent).find('.cbGalleryPage-number-'+pageNumber).slideDown();
        
    });
};

cbGalleryFirstHeight = function(elem) {
    var previousCss  = jQuery(elem).find('.cbGalleryPage-number-1').attr("style");

    jQuery(elem).find('.cbGalleryPage-number-1')
        .css({
            position:   'absolute', // Optional if #myDiv is already absolute
            visibility: 'hidden',
            display:    'block'
        });

    optionHeight = jQuery(elem).find('.cbGalleryPage-number-1').height();

    var eh = jQuery(elem).find('.cbGalleryPage').first().height();
    //alert(eh);
    jQuery(elem).find('.cbGalleryPage').last().height(eh);
    jQuery(elem).find('.cbGalleryPage-number-1').attr("style", previousCss ? previousCss : "");
};

cbGalleryResize = function() {
    if ( jQuery('.cbGallery').length === 0 ) return false;
    jQuery('.cbGallery').each(function() {
        var elem = jQuery(this);
        if ( jQuery(elem).find('.cbGalleryPage').length > 1 ) {
            cbGalleryFirstHeight(elem);
        }
    });
};

jQuery(document).ready(function () {
    cbGalleryPage();
});

jQuery(window).resize(function () {
    cbGalleryResize();
});