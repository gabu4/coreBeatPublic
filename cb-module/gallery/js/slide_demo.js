slideDemoJs = function () {
    jQuery(document).ready(function() {
        jQuery('.rolunk-galeria-slider').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            dots: false,
            arrows: false
        });
    });		
};

jQuery(document).ready(function () {
    slideDemoJs();
});
