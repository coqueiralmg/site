$(function () {
    $('#pesquisar-noticias input').on('keypress', function (e) {

        if(e != null && e.keyCode != 13) 
            return true;
        
        var busca = $(this).val();

        if (busca !== '') {
            LE.info('O usuário buscou ' + busca + ' entre as notícias no site.');
            ga('send', 'event', 'Noticias', 'Busca', busca);
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