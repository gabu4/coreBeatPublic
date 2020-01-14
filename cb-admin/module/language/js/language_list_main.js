jQuery(document).ready(function() {
    listFilterJS();
});

var urlProtocol = jQuery(location).attr('protocol');
var urlHost = jQuery(location).attr('host');
var urlPathName = jQuery(location).attr('pathname');
var urlSearch = jQuery(location).attr('search');
var languageListXhr = "";

var listFilterJS = function() {
    if ( jQuery('.list-filter').length === 0 ) { return; }
    
    jQuery('.list-filter').on('keydown','input',function(e) {
        if( e.keyCode === 13) {
            e.preventDefault();
            jQuery(this).blur();
        }
    });
    
    jQuery('.list-filter').on('change','select, input', function() {
        if ( languageListXhr !== "" ) { languageListXhr.abort(); }
        var v = jQuery(this).val();
        var n = jQuery(this).attr('name');
        var a = getURLParameters(urlSearch);
        if ( v === "" ) { delete a[n]; } else { a[n] = v; }
        urlSearch = '?'+jQuery.param(a);
        var u = urlProtocol+'//'+urlHost+''+urlPathName+''+urlSearch;
        history.pushState({id: 'homepage'}, '', u);
        languageListXhr = jQuery.get( u, function( data ) {
            jQuery( ".language-scripts-content" ).html( data );
        });
    });
    
};

var getURLParameters = function(url){
    var result = {};
    var searchIndex = url.indexOf("?");
    if (searchIndex == -1 ) return result;
    var sPageURL = url.substring(searchIndex +1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {       
        var sParameterName = sURLVariables[i].split('=');      
        result[sParameterName[0]] = sParameterName[1];
    }
    return result;
};

var processAjaxData = function(response, urlPath){
     document.getElementById("content").innerHTML = response.html;
     document.title = response.pageTitle;
     window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
};