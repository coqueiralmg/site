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

function excluirConcurso(id, numero, titulo, tipo) {
    var mensagem = (tipo == 'PS') ? "A exclusão do processo seletivo <b>" + numero + " - " + titulo + "</b> irá tornar a operação irreversível." : "A exclusão do concurso público <b>" + numero + " - " + titulo + "</b> irá tornar a operação irreversível.";

    swal({
        title: "Deseja excluir este registro?",
        html: mensagem,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/concursos/delete/' + id;
    });
}

