jQuery(document).ready(function() {
    gallerySortable();
    galleryElementDelete();
    gallerySizeButton();
    
    galleryImageUpload();
});

var gallerySortable = function() {
    var list = document.getElementById("sortable");
    Sortable.create(list, {
        animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
        handle: ".gDrag", // Restricts sort start click/touch to the specified element
        draggable: ".gTitle", // Specifies which items inside the element should be sortable
        onUpdate: function (evt/**Event*/){
            var item = evt.item; // the current dragged HTMLElement
        }
    });
};

var galleryElementDelete = function() {
    jQuery(".cbGallery-Admin").on("click",".gTitle button.delete",function() {
        jQuery(this).parents('.gTitle').slideUp('1000',function() {
            jQuery(this).remove();
        });
    });
};

var gallerySizeButton = function() {
    jQuery(".gallerySizeButton").on("click",function() {
        var s = jQuery(this).data('size');
        jQuery(".cbGallery-Admin").removeClass('small').removeClass('medium').removeClass('large');
        jQuery(".cbGallery-Admin").addClass(s);
    });
};

var galleryImageUpload = function() {
    var galleryid = jQuery('input#galleryid').val();
        
    jQuery( ".uploadField" ).on('click','#imageUpload',function( event ) {
        var formData = new FormData(jQuery(this).parents('form')[0]);
                        
            //event.preventDefault();
            
            jQuery.ajax({
                   url : "?admin=gallery&funct=list&fileupload=1&id="+galleryid,
                   type : 'POST',
                   data : formData,
                   processData: false,  // tell jQuery not to process the data
                   contentType: false,  // tell jQuery not to set contentType
                   success : function(data) {
                       var objData = jQuery.parseJSON(data);
                       
                       if ( objData.html ) {
                           jQuery(".cbGallery-Admin").append(objData.html);
                           jQuery("html, body").animate({ scrollTop: jQuery(document).height() }, 1000);
                           jQuery("#galleryFileUpload").val(''); 
                       }
                       //console.log(data);
                       //alert(data);
                   }
            },'json');
        
    });

};