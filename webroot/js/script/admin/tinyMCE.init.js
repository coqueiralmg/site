tinyMCE.init({
    selector: "div.editor-texto",
    language: "pt_BR",
    height: 350,
    menubar: false,
    
    plugins: [
         "advlist autolink link image lists charmap print preview fullpage hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   	],
   	toolbar: "styleselect | insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | preview code fullpage | forecolor backcolor emoticons",

    //menubar: false,
    /*toolbar: [
        "undo redo | bold italic | link image | alignleft aligncenter alignright"
    ]*/
});