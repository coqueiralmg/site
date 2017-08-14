$(function () {
    var enviaArquivo = (idPublicacao == 0);

    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');
    $('#hora').mask('00:00');

    CKEDITOR.replace('descricao');

    $('#enviaArquivo').val(enviaArquivo);
});

function toggleArquivo() {
    $("#arquivo").hide();
    $("#envio").show();
    
    enviaArquivo = true;
    $('#enviaArquivo').val(enviaArquivo);
}

function validar() {
    var mensagem = "";

    if ($("#numero").val() === "") {
        mensagem += "<li> O número da pulicação é obrigatório.</li>";
        $("label[for='numero']").css("color", "red");
    } else {
        $("label[for='numero']").css("color", "#aaa");
    }

    if ($("#titulo").val() === "") {
        mensagem += "<li> O título da publicação é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if ($("#data").val() === "") {
        mensagem += "<li> A data da publicação é obrigatória.</li>";
        $("label[for='data']").css("color", "red");
    } else {
        $("label[for='data']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.descricao.getData() === "") {
        mensagem += "<li> É obrigatório informa a descrição da publicação.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if (enviaArquivo) {
        if (document.getElementById("arquivo").files.length == 0) {
            mensagem += "<li> É obrigatório informa a descrição da publicação.</li>";
            $("label[for='arquivo']").css("color", "red");
        } else {
            $("label[for='arquivo']").css("color", "#aaa");
        }
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
