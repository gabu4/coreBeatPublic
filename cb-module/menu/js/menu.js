jQuery(window).on('load',function() {
    menuWorksJS();
});

menuWorksJS = function() {
    if ( jQuery("li.menu.have_sub").length > 0 ) {
        jQuery("li.menu.have_sub>a").on('click',function(e){
            e.preventDefault();
        });
        jQuery("li.menu.have_sub>a").on('dblclick',function(){
            window.location = jQuery(this).attr('href');
        });
    }
};
