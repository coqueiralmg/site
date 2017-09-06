var enviaArquivo = (idBanner == 0);

$(function () {
    $('#validade').datepicker({
        language: 'pt-BR'
    });

    $('#validade').mask('00/00/0000');

    if(idBanner == 0){
        $('#ordem').val(0);
    }

    $("#mantem_nome").click(function(){
        $("#novo_nome_arquivo").toggle();
    });

    $("#unique_id").click(function(){
        if ($(this).prop("checked")) {
           $("#nome_arquivo").prop("disabled", true);
        } else {
            $("#nome_arquivo").prop("disabled", false);
        }
    });
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

        if(!$("#mantem_nome").prop("checked") && !$("#unique_id").prop("checked")){
            if($("#nome_arquivo").val() === ""){
                mensagem += "<li> É obrigatório informar o nome do arquivo. Você pode manter o nome original do arquivo, como pode pedir ao sistema para gerar o código Unique ID como nome do arquivo.</li>";
                $("label[for='nome-arquivo']").css("color", "red");
            } else {
                $("label[for='nome-arquivo']").css("color", "#aaa");
            }
        } else {
            $("label[for='nome-arquivo']").css("color", "#aaa");
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