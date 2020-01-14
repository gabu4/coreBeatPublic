jQuery(document).ready(function() {
    cbCheckFormPrevText();
});

var cbCheckFormPrevText = function() {
    if ( jQuery("#cbMessageInputPrevText .prevText").length > 0 ) {
        jQuery("#cbMessageInputPrevText .prevText").each(function() {
            var mName = jQuery(this).data("name");
            var mText = jQuery(this).text();
            
            if ( jQuery(".form-group input[name="+mName+"]").length !== 0 ) {
                jQuery(".form-group input[name="+mName+"]").val(mText);
            }
        });
    }
};