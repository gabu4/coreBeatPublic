$(document).ready(function() {
    formCreateJS_newRow();
});

var formCreateJS_newRow = function() {
    if ( jQuery('button.newRowButton').length === 0 ) { return false; }
    
    jQuery('button.newRowButton').on('click',function() {
        
        var t = jQuery.now();
        var typ = jQuery(this).data('type');
        var url = "?admin=contact&funct=forms_create&ajax=newrow&type="+typ+"&t="+t;
        var jqxhr = $.getJSON( url, function(data) {
            
            jQuery('.new_row_pace').append(data.html);
            
            /* $(document).ajaxStart(function() { Pace.restart(); }); */
        });
        
    });
    
    jQuery('.new_row_pace').on("click",".formRowJS .formRowRemoveButton",function() {
        jQuery(this).parents(".panel").removeClass('panel-default').addClass('panel-danger');
        var r = confirm("Biztos törli a sort?");
        if ( r !== true ) { 
            jQuery(this).parents(".panel").removeClass('panel-danger').addClass('panel-default');
            return false; 
        }
        jQuery(this).parents(".formRowJS").remove();
    });
    
    jQuery('.new_row_pace').on("change, keyup",".form-control.field_title",function() {
        var titleValue = jQuery(this).val();
        jQuery(this).parents(".panel-group").find(".rowTitle").text(titleValue);
    });
    
    $("ol.new_row_pace").sortable({
        handle: 'i.moveIcon'
    });
};