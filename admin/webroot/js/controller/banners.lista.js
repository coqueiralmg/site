function excluirBanner(id, titulo) {
    swal({
        title: "Deseja excluir este banner?",
        html: "A exclusão do banner <b> " + titulo + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/banners/delete/' + id;
    });
}