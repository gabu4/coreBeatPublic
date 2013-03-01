$(document).ready(function() {
	loadMessagesIfHave();
});

function loadMessagesIfHave() {
	if ( $("div#messagebar div.loadmessage span").length > 0 ) {
		$("div#messagebar div.loadmessage span").each(function() {
			text = $(this).html();
			type = $(this).attr('class');
			$(this).remove();
			showMessage(text, type);
	//		span = $(this).clone();
	//		
	//		$("div#messagebar div.message").append(span.slideDown());
			
		});
	}
}

function showMessage(text, type) {
	message = "<span class='"+type+"' style='display:none;'>"+text+"</span>";
	$("div#messagebar div.message").append(message);
	$("div#messagebar div.message span:last-child").slideDown().delay(60000).slideUp().promise().done(function() { $(this).remove(); });
	
}