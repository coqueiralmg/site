function excluirMensagem(id, assunto) {
    swal({
        title: "Deseja excluir esta mensagem " + assunto + "?",
        html: "A exclusão desta registro irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/mensagens/excluir/' + id;
    });
}