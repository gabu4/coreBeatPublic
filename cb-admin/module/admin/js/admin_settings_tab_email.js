jQuery(document).ready(function() {
    adminSettingsMailtypeSelectJS();
});

function adminSettingsMailtypeSelectJS() {
    if ( jQuery('select[name=mail_type]').length > 0 ) {
        jQuery('.mailType').hide();
        var v = jQuery('select[name=mail_type]').val();
        jQuery('.mailType_'+v).show();
        jQuery('select[name=mail_type]').on("change",function() {
            jQuery('.mailType').slideUp();
            v = jQuery('select[name=mail_type]').val();
            jQuery('.mailType_'+v).slideDown();
        });
    }
}