$(function () {
    $('.detalhes').click(function () {
        $(this).hide('fade');
        $(this).next().show('fade');
    });
});

function lerEdital() {
    var titulo = document.title;
    var documento = titulo.split("|")[0].trim();

    LE.info("Edital de licitação lida: " + documento);
    ga('send', 'event', 'Licitações', 'Download', 'Edital');
}
