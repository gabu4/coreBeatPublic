jQuery(document).ready(function() {
    deleteArticleGroupContentJS();
});


var deleteArticleGroupContentJS = function() {
    jQuery('.deleteArticleGroupContent').on('click',function(e) {
        jQuery(this).parents('tr.trow').addClass('danger');
        var str = '[LANG_ADMIN_ARTICLE_GROUP_DELETESURE]';
        var regex = /<br\s*[\/]?>/gi;
        if ( confirm(str.replace(regex, "\n")) ) {
            return true;
        } else {
            jQuery(this).parents('tr.trow').removeClass('danger');
            return false;
        }
    });
};