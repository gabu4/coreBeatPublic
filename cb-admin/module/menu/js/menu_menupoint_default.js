jQuery(document).ready(function() {
    categoryChangeJS();
    languageChangeJS();
    jQuery('button[name=renewseo]').click(function () {
        seoNameCreate('TRUE');
    });
});

function seoNameCreate(forced) {
    if ( jQuery('input[name=seo_name]').val() === '' || forced === 'TRUE' ) {
        jQuery('input[name=seo_name]').prop('readonly', true);
        var name = jQuery('input[name=name]').val();
        var seoname = jQuery('input[name=seo_name]').val();
        var language = jQuery('input[name=language]').val();
        var t = new Date().getTime();
        var renew = ( forced === 'TRUE' ) ? "&renew=1" : "";
        var url = '?admin=admin&funct=seoNameGenerate&name='+name+'&seoname='+seoname+renew+"&language="+language+"&seoname_gen=1&t="+t;
        jQuery.getJSON( url, function(e) {
            jQuery('input[name=seo_name]').val(e.seoname);
        }).always(function() {
            jQuery('input[name=seo_name]').prop('readonly', false);
        });

    }
}

function categoryChangeJS() {
    if ( jQuery('select.categorySelect').length > 0 ) {
        if ( jQuery('select.categorySelect>option').length > 0 ) {
            jQuery('select.categorySelect>option').on("click",function() {
                var lang = jQuery("select.languageSelect :selected").data('selected-raw');
                var i = jQuery(this).data('selected-raw');
                jQuery('.parentSelect').attr('disabled',true).hide();
                jQuery('.parentSelect_'+lang+'_'+i).attr('disabled',false).removeClass('hidden').show();
            });
        }
    }
}

function languageChangeJS() {
    if ( jQuery('select.languageSelect').length > 0 ) {
        if ( jQuery('select.languageSelect>option').length > 0 ) {
            jQuery('select.languageSelect>option').on("click",function() {
                var lang = jQuery(this).data('selected-raw');
                var i = jQuery("select.categorySelect :selected").data('selected-raw');
                
                jQuery('.parentSelect').attr('disabled',true).hide();
                jQuery('.parentSelect_'+lang+'_'+i).attr('disabled',false).removeClass('hidden').show();
            });
        }
    }
}