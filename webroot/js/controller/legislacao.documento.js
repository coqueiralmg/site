function lerEdital() {
    var titulo = document.title;
    var documento = titulo.split("|")[0].trim();

    LE.info("Legislação lida: " + documento);
    ga('send', 'event', 'Legislação', 'Download', 'Documento');
}
