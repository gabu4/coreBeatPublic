jQuery(document).ready(function() {
    cbCheckShowPass();
    cbCheckPStrength();
});

var cbCheckShowPass = function() {
    if ( jQuery(".jsCBShowPass").length > 0 ) {
        jQuery(".jsCBShowPass").on("click",".passshow",function() {
            jQuery(this).parent().find("i").hide();
            jQuery(this).parent().find("i.passhide").show();
            jQuery(this).parents('.form-group,.input-group').find("input").attr('type','text');
        });
        jQuery(".jsCBShowPass").on("click",".passhide",function() {
            jQuery(this).parent().find("i").hide();
            jQuery(this).parent().find("i.passshow").show();
            jQuery(this).parents('.form-group,.input-group').find("input").attr('type','password');
        });
    }
};

var cbCheckPStrength = function() {
    if ( jQuery(".cb-password_strength").length > 0 && jQuery(".form-cb-password #password").length > 0) {
        jQuery(".form-cb-password").on("change keyup input","#password",function() {
            cbCheckPStrength_ajax();
        });
    }
};

var cbCheckPStrength_ajax = function() {
    var t = jQuery.now();
    var dataURL = '/?mod=account&funct=pwcheck&t='+t;
    var dataPW = jQuery(".form-cb-password #password").val();
    jQuery.post(dataURL,{pw:dataPW},function(data) {
        if ( data.success !== "" ) {
            jQuery('.cb-password_strength .text-strength').html(data.text);
            jQuery('.cb-password_strength .progress-bar').css('width',data.width+'%');
            jQuery('.cb-password_strength .progress-bar').attr('aria-valuenow',data.width);
            jQuery('.cb-password_strength .progress-bar').removeClass('bg-danger bg-warning bg-success');
            if ( data.style !== "" ) {
                jQuery('.cb-password_strength .progress-bar').addClass(data.style);
            }
        }
    }, "json");
};