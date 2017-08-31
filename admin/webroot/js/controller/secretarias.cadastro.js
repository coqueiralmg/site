$(function () {
    CKEDITOR.replace('descricao');

    $('#telefone').mask('(00)0000-00000');
});

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome da secretaria é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if ($("#responsavel").val() === "") {
        mensagem += "<li> O nome do responsavel pela secretaria é obrigatório.</li>";
        $("label[for='responsavel']").css("color", "red");
    } else {
        $("label[for='responsavel']").css("color", "#aaa");
    }
    
    if (CKEDITOR.instances.descricao.getData() === "") {
        mensagem += "<li> É obrigatório informar a descrição da secretaria.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
