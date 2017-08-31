function excluirSecretaria(id, titulo) {
    swal({
        title: "Deseja excluir esta secretaria?",
        html: "A exclusão de <b> " + titulo + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/secretarias/delete/' + id;
    });
}