jQuery(document).ready(function() {
    ajaxThumbnailJS_preview();
    ajaxHeaderImageJS_preview();
    
    ajaxContentPreviewJS();
});

ajaxThumbnailJS_preview = function() {
    if ( jQuery('#thumbnail_file').length === 0 ) { return false; }
    jQuery("#thumbnail-message-error").hide();
    var prevImg = jQuery('#preview_thumb').attr('src');
    var defFileField = jQuery('#p-thumbnail_file').html();
    jQuery("#tabs-image").on("change","#thumbnail_file",function() {
        jQuery("#thumbnail-message-error").hide();
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg","image/gif"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]))) {
            jQuery('#preview_thumb').attr('src',prevImg);
            jQuery("#p-thumbnail_file").html(defFileField);
            jQuery("#thumbnail-message-error").show();
            return false;
        } else {
            jQuery("input[name=thumbnail_delete]").prop('checked', false);
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
        
    function imageIsLoaded(e) {
        //jQuery("#file").css("color","green");
        jQuery('#preview_thumb').attr('src', e.target.result);
    };
};

ajaxHeaderImageJS_preview = function() {
    if ( jQuery('#headerimage_file').length === 0 ) { return false; }
    jQuery("#headerimage-message-error").hide();
    var prevImg = jQuery('#preview_headerimage').attr('src');
    var defFileField = jQuery('#p-headerimage_file').html();
    jQuery("#headerimage_file").change(function() {
        jQuery("#headerimage-message-error").hide();
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg","image/gif"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]))) {
            jQuery('#preview_headerimage').attr('src',prevImg);
            jQuery("#p-headerimage_file").html(defFileField);
            jQuery("#").replaceWith(jQuery(this).clone());
            jQuery("#headerimage-message-error").show();
            return false;
        } else {
            jQuery("input[name=headerimage_delete]").prop('checked', false);
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
        
    function imageIsLoaded(e) {
        //jQuery("#file").css("color","green");
        jQuery('#preview_headerimage').attr('src', e.target.result);
    };
};

ajaxContentPreviewJS = function() {
    if ( jQuery('.link.contentPreview').length === 0 ) { return false; }
    
    jQuery(".link.contentPreview").on("click",function(event) {
        event.preventDefault();
        
        var postData = jQuery("form.adminForm").serialize();
        
        var pst = jQuery.post("?admin=article&funct=create_preview", postData);
        
        pst.done(function(data) {
            var url = "?mod=article&funct=article_preview&id=".jQuery(data).text();
            window.open(url);
        });
        
    });
    
};