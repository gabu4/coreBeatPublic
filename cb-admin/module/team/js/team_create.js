jQuery(document).ready(function() {
    ajaxImageJS_preview();
});

function ajaxImageJS_preview() {
    if ( jQuery('#image_file').length === 0 ) { return false; }
    jQuery("#image-message-error").hide();
    var prevImg = jQuery('#image_preview').attr('src');
    var defFileField = jQuery('#p-image_file').html();
    jQuery("#tabs-image").on("change","#image_file",function() {
        jQuery("#image-message-error").hide();
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg","image/gif"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]))) {
            jQuery('#preview_image').attr('src',prevImg);
            jQuery("#p-image_file").html(defFileField);
            jQuery("#image-message-error").show();
            return false;
        } else {
            jQuery("input[name=image_delete]").prop('checked', false);
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    function imageIsLoaded(e) {
        //jQuery("#file").css("color","green");
        jQuery('#preview_image').attr('src', e.target.result);
    };
}
