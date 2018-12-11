$(function () {
    $('form #btn-pesquisar').on('click', function (e) {

        var busca = $(this).siblings("#pesquisa").val();

        if (busca !== '') {
            LE.info('O usuário buscou ' + busca + ' entre as licitações no site.');
            ga('send', 'event', 'Licitações', 'Busca', busca);
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

    $(function () {
        var tabs = $("#tabs").tabs({
            collapsible: true
        });

        tabs.find(".ui-tabs-nav").sortable({
            axis: "x",
            stop: function () {
                tabs.tabs("refresh");
            }
        });

        $("#loader").hide();
        $("#tabs").show('fade');
    });
});
