jQuery(window).on('load',function() {
    catalogCategoryListContentsJS();
});

catalogCategoryListContentsJS = function() {
    if ( jQuery("div.catalogCategoryContents.catalogElementList .contentImg").length > 0 ) {
        var h = 0;
        var h2 = 0;
        jQuery("div.catalogCategoryContents.catalogElementList .contentImg a.pict img.placeholder").each(function() {
            h2 = jQuery(this).height();
            if ( h2 > h ) { h = h2; }
        });
        jQuery("div.catalogCategoryContents.catalogElementList .contentImg").animate({opacity:1},100);
        jQuery("div.catalogCategoryContents.catalogElementList .contentImg a.pict").animate({height:h+'px'},100);
        
        /*
        var p = parseInt(jQuery("div.catalogCategoryContents.catalogElementList .contentImg").css("padding-top"));
        
        jQuery("div.catalogCategoryContents.catalogElementList.pageList .contentImg").mouseover(function(){
            jQuery(this).animate({height:+(2*p)+'px',padding:-p+'px'},300);
        }).mouseout(function(){
            jQuery(this).animate({height:h+'px',padding:p+'px'},300);
        });
        
        */
        
        //var mh = h * 1.2;
        //jQuery("div.catalogCategoryContents.catalogElementList .contentImg img.floating").css({minHeight:mh+'px'});
        
    }
};
