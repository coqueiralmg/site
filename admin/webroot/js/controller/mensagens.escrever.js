$(function () {

    CKEDITOR.replace('mensagem');
});

function validar() {
    var mensagem = "";

    if ($("#assunto").val() === "") {
        mensagem += "<li> É obrigatório informar o assunto da mensagem.</li>";
        $("label[for='assunto']").css("color", "red");
    } else {
        $("label[for='assunto']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.mensagem.getData() === "") {
        mensagem += "<li> É obrigatório informar o conteúdo da mensagem.</li>";
        $("label[for='mensagem']").css("color", "red");
    } else {
        $("label[for='mensagem']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}