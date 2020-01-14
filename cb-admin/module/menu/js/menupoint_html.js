jQuery(document).ready(function() {
    categoryChangeJS();
    languageChangeJS();
});

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