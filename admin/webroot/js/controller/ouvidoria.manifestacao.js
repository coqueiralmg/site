function validar() {
    var mensagem = "";

    if ($("#resposta").val() === "") {
        mensagem += "<li> É obrigatório informar o conteúdo da resposta ao manifestante.</li>";
        $("label[for='resposta']").css("color", "red");
    } else {
        $("label[for='resposta']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#lista_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}