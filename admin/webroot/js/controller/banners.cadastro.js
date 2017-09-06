var enviaArquivo = (idBanner == 0);

$(function () {
    $('#validade').datepicker({
        language: 'pt-BR'
    });

    $('#validade').mask('00/00/0000');

    if(idBanner == 0){
        $('#ordem').val(0);
    }
});

function toggleArquivo() {
    $("#panel_arquivo").hide();
    $("#panel_envio").show();

    enviaArquivo = true;
    $('#enviaArquivo').val(enviaArquivo);
}

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome de identificação do banner é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if ($("#ordem").val() === "") {
        mensagem += "<li> A ordem de exibição do banner é obrigatório.</li>";
        $("label[for='ordem']").css("color", "red");
    } else {
        $("label[for='ordem']").css("color", "#aaa");
    }

    if ($("#acao").val() !== "") {
        if ($("#destino").val() === "") {
            mensagem += "<li> O destino da ação do banner é obrigatório. Deixe o campo \'Ação\' em branco, caso não queira botão de ação para este banner.</li>";
            $("label[for='destino']").css("color", "red");
        } else {
            $("label[for='destino']").css("color", "#aaa");
        }   
    } else {
        $("label[for='destino']").css("color", "#aaa");
    }

    if (enviaArquivo) {
        if (document.getElementById("arquivo").files.length == 0) {
            mensagem += "<li> É obrigatório informar o arquivo de imagem em anexo.</li>";
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