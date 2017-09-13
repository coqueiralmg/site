function lerEdital() {
    var titulo = document.title;
    var documento = titulo.split("|")[0].trim();

    LE.info("Publicação lida: " + documento);
    ga('send', 'event', 'Publicações', 'Download', 'Documento');
}