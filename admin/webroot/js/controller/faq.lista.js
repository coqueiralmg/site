function excluirPergunta(id, nome) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão da pergunta com o título da questão <b>" + nome + "</b> tornará a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/faq/delete/' + id;
    });
}
