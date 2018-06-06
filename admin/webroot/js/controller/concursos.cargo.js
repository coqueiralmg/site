var modificado = false;

$(function () {

    $('#vencimento').mask("#.##0,00", {reverse: true});
    $('#taxaInscricao').mask("#.##0,00", {reverse: true});

    CKEDITOR.replace('atribuicoes', {
        height: 300
    });

    CKEDITOR.replace('observacoes', {
        height: 150
    });

    $("input").change(function(){
        //autosave();
    });

    if(hasCache('cargoConcurso', idDocumentoConcurso)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});
