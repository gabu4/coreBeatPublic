jQuery(document).ready(function() {
    ajaxThumbnailJS_preview();
    ajaxCatalogImageJS_preview();
    ajaxHeaderImageJS_preview();
    catalogCreateJS();
});

function ajaxThumbnailJS_preview() {
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
}

function ajaxCatalogImageJS_preview() {
    if ( jQuery('#catalogimage_file').length === 0 ) { return false; }
    jQuery("#catalogimage-message-error").hide();
    var prevImg = jQuery('#preview_catalogimage').attr('src');
    var defFileField = jQuery('#p-catalogimage_file').html();
    jQuery("#tabs-image").on("change","#catalogimage_file",function() {
        jQuery("#catalogimage-message-error").hide();
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg","image/gif"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]))) {
            jQuery('#preview_catalogimage').attr('src',prevImg);
            jQuery("#p-catalogimage_file").html(defFileField);
            jQuery("#catalogimage-message-error").show();
            return false;
        } else {
            jQuery("input[name=catalogimage_delete]").prop('checked', false);
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
        
    function imageIsLoaded(e) {
        //jQuery("#file").css("color","green");
        jQuery('#preview_catalogimage').attr('src', e.target.result);
    };
}

function ajaxHeaderImageJS_preview() {
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
}

function catalogCreateJS() {
    if ( jQuery('input.catalogName').length > 0 ) {
        jQuery('input.catalogName').on("change",function() {
            var lang = jQuery(this).data('lang');
            var name = jQuery(this).val();
            
            if ( jQuery('input.catalogSEOName.lang_'+lang).val() === '' ) {
                jQuery('input[name=name]').val(name);
                seoNameCreate(name,lang,false);
            }
        });
        jQuery('button[name=renewseo]').click(function () {
            var lang = jQuery(this).data('lang');
            var name = jQuery('input.catalogName.lang_'+lang).val();
            seoNameCreate(name,lang,true);
        });
    }
}

function seoNameCreate(name,lang,forced) {
    jQuery('input.catalogSEOName.lang_'+lang).prop('readonly', true);
    var seoname = jQuery('input.catalogSEOName.lang_'+lang).val();
    var t = new Date().getTime();
    var renew = ( forced === true ) ? "&renew=1" : "";
    var url = '?admin=admin&funct=seoNameGenerate&name='+name+'&seoname='+seoname+renew+"&seoname_gen=1&t="+t;
    jQuery.getJSON( url, function(e) {
        jQuery('input.catalogSEOName.lang_'+lang).val(e.seoname);
    }).always(function() {
        jQuery('input.catalogSEOName.lang_'+lang).prop('readonly', false);
    });
}
