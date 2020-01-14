jQuery(document).ready(function () {
    jQuery('body').on('click','.modalLink',function(e){
        loadContentToModal(e,jQuery(this));
    });
});

var loadContentToModal = function(e,c) {
    e.preventDefault();
    if ( jQuery('#cbPageModal').length === 0 ) { createModalToEndOfBody(); }
    var t = new Date();
    var dataURL = c.attr('href')+'&modal=1&t='+t;
    jQuery.get(dataURL, function(data) {
        jQuery('#cbPageModal .modal-body').html(data['body']);
        jQuery('#cbPageModal .modal-body h2.title').remove();
        jQuery('#cbPageModal .modal-header .modal-title').html(data['title']);
        jQuery('#cbPageModal').modal({show:true});
    }, "json");
    
    function createModalToEndOfBody() {
        var c = '<div class="modal fade" id="cbPageModal" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 class="modal-title"></h3></div><div class="modal-body"></div></div></div></div>';
        jQuery('body').append(c);
    }
};