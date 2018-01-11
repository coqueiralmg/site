function excluirFeriado(id, nome) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão do feriado <b> " + nome + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/feriado/delete/' + id;
    });
}