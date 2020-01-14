jQuery('document').ready(function() {
    jQuery('.parallaxBackground').each(function() {
        var bg = jQuery(this).css('background-image');
        bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
        jQuery(this).css('background-image','none').css('background','transparent');
        jQuery(this).parallax({imageSrc: bg});
    });
});