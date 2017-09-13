function lerEdital(){
    var titulo = document.title;
    var documento = titulo.split("|")[0].trim();

    LE.info("Edital de licitação lida: " + documento);
    ga('send', 'event', 'Licitações', 'Download', 'Edital');
}