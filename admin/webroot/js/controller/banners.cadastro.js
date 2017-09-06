var enviaArquivo = (idBanner == 0);

$(function () {
    $('#validade').datepicker({
        language: 'pt-BR'
    });

    $('#validade').mask('00/00/0000');

    if(idBanner == 0){
        $('#ordem').val(0);
    }
});