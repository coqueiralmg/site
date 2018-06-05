var modificado = false;

$(function () {

    $("input").change(function(){
        autosave();
    });

    if(hasCache('documentoConcurso', idDocumentoConcurso)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});
