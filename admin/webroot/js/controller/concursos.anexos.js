function excluirDocumentoConcurso(id, descricao) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão do documento <b>" + descricao + "</b> tornará a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/documentos/delete/' + id;
    });
}
