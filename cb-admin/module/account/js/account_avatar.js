jQuery(document).ready(function() {
    cbCheckAvatar();
});

var cbCheckAvatar = function() {
    if ( jQuery(".form-cb-image #imageTypeSelector").length > 0 && jQuery(".form-cb-email #email").length > 0 ) {
        jQuery(".form-cb-image,.form-cb-email").on("change keyup input","#imageTypeSelector,#email",function() {
            cbCheckAvatar_ajax();
        });
    }
};

var cbCheckAvatar_ajax = function() {
    var t = jQuery.now();
    var dataURL = '/?mod=account&funct=avatartype&t='+t;
    var dataEmail = jQuery(".form-cb-email #email").val();
    var dataImageType = jQuery(".form-cb-image #imageTypeSelector").val();
    jQuery.post(dataURL,{email:dataEmail,image:dataImageType},function(data) {
        if ( data.success !== "" ) {
            jQuery('.profil-image img').attr('src',data.image_url);
        }
    }, "json");
};