jQuery(document).ready(function() {
    jQuery(".fancybox").fancybox({
        openEffect	: 'elastic',
        closeEffect	: 'elastic'
    });
    
    jQuery('.fancybox-media').fancybox({
        openEffect  : 'elastic',
        closeEffect : 'elastic',
        helpers : {
            media : {}
        }
    });
});