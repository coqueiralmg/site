$(function () {
    $('form #btn-pesquisar').on('click', function (e) {

        var busca = $(this).siblings("#pesquisa").val();

        if (busca !== '') {
            LE.info('O usuário buscou ' + busca + ' entre na legislação municipal.');
            ga('send', 'event', 'Legislação', 'Busca', busca);
            return true;
        } else {

            swal(
                'Atenção',
                'Por favor, digite a chave de busca.',
                'warning'
            );

            return false;
        }
    });
});
