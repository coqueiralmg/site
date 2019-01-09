function excluirCategoriaPergunta(id, nome) {
    swal({
        title: "Deseja excluir este registro?",
        html: "A exclusão da categoria de perguntas e respostas chamada <b>" + nome + "</b> tornará a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/faq/drop/' + id;
    });
}
