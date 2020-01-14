jQuery(document).ready(function () {
    cbProductAddToCart();
    cbProductRemoveFromCart();
});

var cbProductListAddToCart_run = false;
cbProductAddToCart = function() {
    if ( cbProductListAddToCart_run !== false ) { cbProductListAddToCart_run.abort(); }
    if ( jQuery('.productListDiv, .productCartDiv').length === 0 || jQuery('.productListDiv .addToCart, .productCartDiv .addToCart').length === 0 ) { return false; }
    
    jQuery('.productListDiv, .productCartDiv').on('click','.addToCart',function() {
        var productId = jQuery(this).data('id');
        var t = jQuery.now();
        var url = 'index.php?mod=product&funct=addtocart&id='+productId+'&count=1&t='+t;
        cbProductListAddToCart_run = jQuery.get( url, function( data ) {
            showMessage( data.text, data.icon );
            
            jQuery(".productCartContent .cartProduct.product_id_"+data.id+" .name").html(data.cartName);
            jQuery(".productCartContent .cartProduct.product_id_"+data.id+" .count").text(data.count);
        }, "json");
    });
};


var cbProductListRemoveFromCart_run = false;
cbProductRemoveFromCart = function() {
    if ( cbProductListRemoveFromCart_run !== false ) { cbProductListRemoveFromCart_run.abort(); }
    if ( jQuery('.productCartDiv').length === 0 || jQuery('.productCartDiv .removeFromCart').length === 0 ) { return false; }
    
    jQuery('.productCartDiv').on('click','.removeFromCart',function() {
        var productId = jQuery(this).data('id');
        var t = jQuery.now();
        var url = 'index.php?mod=product&funct=removefromcart&id='+productId+'&count=1&t='+t;
        cbProductListRemoveFromCart_run = jQuery.get( url, function( data ) {
            showMessage( data.text, data.icon );
            
            if ( data.count === 0 ) {
                jQuery(".productCartContent .cartProduct.product_id_"+data.id).slideUp(function() { jQuery(this).remove(); });
            } else {
                jQuery(".productCartContent .cartProduct.product_id_"+data.id+" .name").html(data.cartName);
                jQuery(".productCartContent .cartProduct.product_id_"+data.id+" .count").text(data.count);
            }
        }, "json");
    });
};