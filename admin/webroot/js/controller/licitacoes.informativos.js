function excluirInformativoLicitacao(id, titulo) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão da atualização com o título <b>" + titulo + "</b> tornará a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/atualizacoes/delete/' + id;
    });
}
