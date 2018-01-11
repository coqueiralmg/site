$(function () {
    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');
});

function validar() {
    var mensagem = "";

    if ($("#data").val() === "") {
        mensagem += "<li> É obrigatório informar a data de feriado.</li>";
        $("label[for='data']").css("color", "red");
    } else {
        $("label[for='data']").css("color", "#aaa");
    }

    if ($("#descricao").val() === "") {
        mensagem += "<li> É obrigatório informar a descrição do feriado.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if ($("#nivel").val() === "") {
        mensagem += "<li> É obrigatório informar o tipo do feriado.</li>";
        $("label[for='nivel']").css("color", "red");
    } else {
        $("label[for='nivel']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}