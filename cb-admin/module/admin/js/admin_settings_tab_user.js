jQuery(document).ready(function() {
    adminSettingsUserLocalSelectJS();
    adminSettingsUserApiSelectJS();
    adminSettingsUserFacebookSelectJS();
    adminSettingsUserGoogleSelectJS();
});

function adminSettingsUserLocalSelectJS() {
    if ( jQuery('select[name=account_login_type]').length > 0 ) {
        jQuery('.userLoginMethod-local').hide();
        var v = jQuery('select[name=account_login_type]').val();
        jQuery('.userLoginMethod-local.'+v).show();
        jQuery('select[name=account_login_type]').on("change",function() {
            jQuery('.userLoginMethod-local').slideUp();
            v = jQuery('select[name=account_login_type]').val();
            jQuery('.userLoginMethod-local.'+v).slideDown();
        });
    }
}

function adminSettingsUserApiSelectJS() {
    if ( jQuery('select[name=account_api_login]').length > 0 ) {
        jQuery('.userLoginMethod-api').hide();
        var v = jQuery('select[name=account_api_login]').val();
        jQuery('.userLoginMethod-api.'+v).show();
        jQuery('select[name=account_api_login]').on("change",function() {
            jQuery('.userLoginMethod-api').slideUp();
            v = jQuery('select[name=account_api_login]').val();
            jQuery('.userLoginMethod-api.'+v).slideDown();
        });
    }
}

function adminSettingsUserFacebookSelectJS() {
    if ( jQuery('select[name=login_fb_enable]').length > 0 ) {
        jQuery('.userLoginMethod-facebook').hide();
        var v = jQuery('select[name=login_fb_enable]').val();
        jQuery('.userLoginMethod-facebook.'+v).show();
        jQuery('select[name=login_fb_enable]').on("change",function() {
            jQuery('.userLoginMethod-facebook').slideUp();
            v = jQuery('select[name=login_fb_enable]').val();
            jQuery('.userLoginMethod-facebook.'+v).slideDown();
        });
    }
}

function adminSettingsUserGoogleSelectJS() {
    if ( jQuery('select[name=login_gp_enable]').length > 0 ) {
        jQuery('.userLoginMethod-google').hide();
        var v = jQuery('select[name=login_gp_enable]').val();
        jQuery('.userLoginMethod-google.'+v).show();
        jQuery('select[name=login_gp_enable]').on("change",function() {
            jQuery('.userLoginMethod-google').slideUp();
            v = jQuery('select[name=login_gp_enable]').val();
            jQuery('.userLoginMethod-google.'+v).slideDown();
        });
    }
}
