$(function () {
    $('form #btn-pesquisar').on('click', function (e) {

        var busca = $(this).siblings("#pesquisa").val();

        if (busca !== '') {
            LE.info('O usuário buscou ' + busca + ' no site.');
            ga('send', 'event', 'Geral', 'Busca', busca);
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