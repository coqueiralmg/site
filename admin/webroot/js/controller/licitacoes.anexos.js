function excluirDocumentoLicitacao(id, descricao) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão do anexo <b>" + descricao + "</b> tornará a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/anexos/delete/' + id;
    });
}
