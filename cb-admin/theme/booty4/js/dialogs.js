PreviewImage = function(uri) {

    //Get the HTML Elements
    imageDialog = $("#dialog");
    imageTag = $('#image');

    //Split the URI so we can get the file name
    uriParts = uri.split("/");

    //Set the image src
    imageTag.attr('src', uri);

    //When the image has loaded, display the dialog
    imageTag.load(function(){

        $('#dialog').dialog({
            modal: true,
            resizable: false,
            draggable: true,
            width: 'auto',
            title: uriParts[uriParts.length - 1]
        });

    }); 
}

$(document).ready(function() {
  
    $('body .imageLink').click(function(event){
        event.preventDefault();
        PreviewImage($(this).attr('href'));
    });
  
  if ( $('body #dialog').length == 0 ) {
      $('body').append('<div id="dialog" title="An Image!" style="text-align: center;display: none;"><img id="image" style="max-width:100%;" src=""/></div>');
  }
  
    $("body").on('click','.ui-widget-overlay',function () {
        $("#dialog").dialog( "close" );
    });
  
});