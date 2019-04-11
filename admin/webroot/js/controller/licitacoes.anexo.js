var enviaArquivo = (idAnexoLicitacao == 0);
var modificado = false;

$(function () {
    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#enviaArquivo').val(enviaArquivo);

    $("input").change(function () {
        autosave();
    });

    if (hasCache('anexoLicitacao', idAnexoLicitacao)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });

    $('#data').mask('00/00/0000');
});

function restaurar() {
    var data = getDataCache('anexoLicitacao', idAnexoLicitacao);

    if (data != null) {
        $("#numero").val(data.object.numero);
        $("#descricao").val(data.object.descricao);
        $("#data").val(data.object.data);
        $("#ativo").prop("checked", data.object.ativo);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idAnexoLicitacao,
        object: {
            id: idAnexoLicitacao,
            numero: $("#numero").val(),
            descricao: $("#descricao").val(),
            data: $("#data").val(),
            ativo: $("#ativo").is(':checked'),
        }
    };

    cacheSave('anexoLicitacao', data);
    modificado = true;
}

function removeCache() {
    removeData('anexoLicitacao', idAnexoLicitacao);
    modificado = false;
}

function toggleArquivo() {
    $("#panel_arquivo").hide();
    $("#panel_envio").show();

    enviaArquivo = true;
    $('#enviaArquivo').val(enviaArquivo);
}

function validar() {
    var mensagem = "";

    if ($("#descricao").val() === "") {
        mensagem += "<li> A descrição do documento em anexo é obrigatório.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if ($("#data").val() === "") {
        mensagem += "<li> A data do documento em anexo é obrigatório.</li>";
        $("label[for='data']").css("color", "red");
    } else {
        $("label[for='data']").css("color", "#aaa");
    }

    if (enviaArquivo) {
        if (document.getElementById("arquivo").files.length == 0) {
            mensagem += "<li> É obrigatório informar o arquivo edital em anexo.</li>";
            $("label[for='arquivo']").css("color", "red");
        } else {
            $("label[for='arquivo']").css("color", "#aaa");
        }
    }

    if (mensagem == "") {
        $("button[type='submit']").prop('disabled', true);
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
