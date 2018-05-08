$(function () {
    $('#inscricao_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#inscricao_final').datepicker({
        language: 'pt-BR'
    });

    $('#prova_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#prova_final').datepicker({
        language: 'pt-BR'
    });

    $('#inscricao_inicial').mask('00/00/0000');
    $('#inscricao_final').mask('00/00/0000');
    $('#prova_inicial').mask('00/00/0000');
    $('#prova_final').mask('00/00/0000');
});
