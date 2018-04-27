$(document).ready(function () {
    imprimeRelogio();
});

function obterDataHora() {
    var momentoAtual = new Date();
    var dia = momentoAtual.getDate();
    var mes = momentoAtual.getMonth() + 1;
    var ano = momentoAtual.getFullYear();
    var hora = momentoAtual.getHours();
    var minuto = momentoAtual.getMinutes();
    var segundo = momentoAtual.getSeconds();

    var horaImprimivel = ((dia < 10) ? "0" + dia : dia) + "/" + ((mes < 10) ? "0" + mes : mes) + "/" + ano + " " + ((hora < 10) ? "0" + hora : hora) + ":" + ((minuto < 10) ? "0" + minuto : minuto) + ":" + ((segundo < 10) ? "0" + segundo : segundo);

    return horaImprimivel;
}

function imprimeRelogio() {
    var atual = obterDataHora();

    $("#hora_atual").html(atual);

    setTimeout("imprimeRelogio()", 1000);
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
