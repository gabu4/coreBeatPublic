jQuery(document).ready(function () {
    cbProductListChangeCheck();
});

var cbProductListChangeCheck_run = false;
cbProductListChangeCheck = function () {
    if ( cbProductListChangeCheck_run !== false ) { cbProductListChangeCheck_run.abort(); }
    if ( jQuery('#listSearchBarForm').length === 0 ) return false;
    
    jQuery('#listSearchBarForm input, #listSearchBarForm select').on('change keyup',function() {
        
        var t = jQuery.now();
        var url = '/termekek?ajaxsearchget=1&t='+t;
        cbProductListChangeCheck_run = jQuery.get( url, $( "#listSearchBarForm" ).serialize(), function( data ) {
            alert( data.chtml );
        }, "json");
    });
    
};
