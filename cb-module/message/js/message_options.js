var focusFlag = 1;
jQuery(document).ready(function() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-{#POSITION}",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "{#TIME}",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    
    JScheckTicketMessage();
});


var JScheckTicketMessage_time = {#REFRESH_TIME};
var JScheckTicketMessage_var = null;
var JScheckTicketMessage = function() {
    if (JScheckTicketMessage_var !== null) { clearTimeout(JScheckTicketMessage_var); JScheckTicketMessage_var = null; }
    JScheckTicketMessage_ajaxCheck();
    JScheckTicketMessage_var = setTimeout(function() {JScheckTicketMessage();},JScheckTicketMessage_time);
};

var JScheckTicketMessage_ajaxCheck_run = false;
var JScheckTicketMessage_ajaxCheck = function() {
    if ( JScheckTicketMessage_ajaxCheck_run !== false ) { JScheckTicketMessage_ajaxCheck_run.abort(); }
    var t = jQuery.now();
    var url = '/?ticketsystem=1&t='+t;
    
    var focused = 0;
    var mTimeOut = 600000;
    
    jQuery(window).bind("focus",function(event){
        focusFlag = 1;
    }).bind("blur", function(event){
        focusFlag = 0;
    });
        
    jQuery(window).focus(function() { focused = 1; });
    JScheckTicketMessage_ajaxCheck_run = jQuery.get( url, function( data ) {
        
        if ( data.state == 'success' ) {
            jQuery.each(data.messages, function(i, item) {
                if ( focusFlag === 0 && item.multi !== '1' ) { return true; }
                
                if ( focusFlag === 1 || item.time > mTimeOut ) { mTimeOut = item.time; }
                
                if ( item.type === 'success' ) { toastr.success(item.text,item.title,{"timeOut": mTimeOut,"onclick": function () { JScheckTicketMessage_ajaxFeedback(item.mid); }}); }
                else if ( item.type === 'info' ) { toastr.info(item.text,item.title,{"timeOut": mTimeOut,"onclick": function () { JScheckTicketMessage_ajaxFeedback(item.mid); }}); }
                else if ( item.type === 'warning' ) { toastr.warning(item.text,item.title,{"timeOut": mTimeOut,"onclick": function () { JScheckTicketMessage_ajaxFeedback(item.mid); }}); }
                else if ( item.type === 'danger' ) { toastr.error(item.text,item.title,{"timeOut": mTimeOut,"onclick": function () { JScheckTicketMessage_ajaxFeedback(item.mid); }}); }
                
                if ( focusFlag === 1 && item.multi !== '1' ) { JScheckTicketMessage_ajaxFeedback(item.mid); }
            });
        }
        
    }, "json");
};

var JScheckTicketMessage_ajaxFeedback_run = false;
var JScheckTicketMessage_ajaxFeedback = function(mid) {
//    if ( JScheckTicketMessage_ajaxFeedback_run !== false ) { JScheckTicketMessage_ajaxFeedback_run.abort(); }
    var t = jQuery.now();
    var url = '/?ticketsystem=1&mid='+mid+'&t='+t;
    
    JScheckTicketMessage_ajaxFeedback_run = jQuery.get( url );
};