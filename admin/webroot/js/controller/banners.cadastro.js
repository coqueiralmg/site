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

    $("input, textarea").change(function(){
        autosave();
    });

    if(hasCache('banner', idBanner)) {
        $("#cadastro_info").show('fade');
    }
});

function restaurar() {
    var data = getDataCache('banner', idBanner);

    if (data != null) {
        $("#nome").val(data.object.nome);
        $("#titulo").val(data.object.titulo);
        $("#descricao").val(data.object.descricao);
        $("#ordem").val(data.object.ordem);
        $("#validade").val(data.object.validade);
        $("#acao").val(data.object.acao);
        $("#destino").val(data.object.destino);
        $("#nome_arquivo").val(data.object.nomeArquivo);
        $("#ativo").prop("checked", data.object.ativo);
        $("#mantem_nome").prop("checked", data.object.manterNome);
        $("#unique_id").prop("checked", data.object.gerarUniqueID);
        $("#blank").prop("checked", data.object.novaJanela);

        if(data.object.manterNome) {
            $("#novo_nome_arquivo").hide();
        } else {
            $("#novo_nome_arquivo").show();
        }

        if(data.object.gerarUniqueID) {
            $("#nome_arquivo").prop("disabled", true);
        } else {
            $("#nome_arquivo").prop("disabled", false);
        }
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idBanner,
        object: {
            id: idBanner,
            nome: $("#nome").val(),
            titulo: $("#titulo").val(),
            descricao: $("#descricao").val(),
            ordem: $("#ordem").val(),
            validade: $("#validade").val(),
            acao: $("#acao").val(),
            destino: $("#destino").val(),
            nomeArquivo: $("#nome_arquivo").val(),
            ativo: $("#ativo").is(':checked'),
            manterNome: $("#mantem_nome").is(':checked'),
            gerarUniqueID: $("#unique_id").is(':checked'),
            novaJanela: $("#blank").is(':checked')
        }
    };

    cacheSave('banner', data);
}

function removeCache() {
    removeData('banner', idBanner);
}

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
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
