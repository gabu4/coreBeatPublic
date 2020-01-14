jQuery(document).ready(function() {
    cbCheckFormErrorText();
    cbFormErrorClick();
});

var cbCheckFormErrorText = function() {
    if ( jQuery("#cbMessageInputErrorText .errorText").length > 0 ) {
        jQuery("#cbMessageInputErrorText .errorText").each(function() {
            var mName = jQuery(this).data("name");
            var mClass = jQuery(this).data("class"); mClass = " cl-"+mClass;
            var mMessage = jQuery(this).text();
            
            var errorRow = "<p class='errorRow name-"+mName+mClass+"'><i class='fas fa-exclamation-circle'></i><span class='sr-only'>Error:</span> "+mMessage+"</p>";
            
            if ( jQuery("*[name="+mName+"]").parents('form').find(".error-block").length === 0 ) {
                var blockHolder = "<div class='error-block col-md-12'><div class='alert alert-danger' role='alert'></div></div>";
                jQuery("*[name="+mName+"]").parents('form').find(".form-group").first().before(blockHolder);
            }
            
            jQuery("*[name="+mName+"]").parents('form').find(".error-block .alert").append(errorRow);
            
            jQuery("*[name="+mName+"]").parents('.form-group').addClass('has-error');
        });
    }
};

var cbFormErrorClick = function() {
    jQuery("form").on('focus','.form-group.has-error input, .form-group.has-error textarea', function() {
        jQuery(this).parents('.form-group').removeClass('has-error');
    });
};