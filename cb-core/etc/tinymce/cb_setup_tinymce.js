$(document).ready(function() {
    tinyMCE.init({
        selector: "textarea.contentTinyMCE",
        language: tinyMCELang,
        language_url: 'cb-core/etc/tinymce/langs/'+tinyMCELang+'.js',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste ",
            "autoresize"
        ],
        toolbar: "insertfile undo redo | styleselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
        //toolbar2: "|  | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        entity_encoding : "raw",
        image_advtab: true ,
        content_css: tinyMCECSSPath,
        relative_urls : false,
        remove_script_host : true,
        convert_urls : true,
        document_base_url: '/',
        file_browser_callback: RoxyFileBrowser
    });

});

function RoxyFileBrowser(field_name, url, type, win) {
    var roxyFileman = 'cb-core/etc/fileman/index.html';
    if (roxyFileman.indexOf("?") < 0) {
        roxyFileman += "?type=" + type;   
    }
    else {
        roxyFileman += "&type=" + type;
    }
    roxyFileman += '&input=' + field_name + '&value=' + document.getElementById(field_name).value;
    tinyMCE.activeEditor.windowManager.open({
        file: roxyFileman,
        title: 'Roxy Fileman',
        width: 850, 
        height: 650,
        resizable: "yes",
        plugins: "media",
        inline: "yes",
        close_previous: "no"  
    }, {     window: win,     input: field_name    });
    return false; 
}