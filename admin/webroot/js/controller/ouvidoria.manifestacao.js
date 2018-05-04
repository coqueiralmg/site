var modificado = false;

$(function () {
    $("input, select, textarea").change(function(){
        autosave();
    });

    if(hasCache('manifestacaoOuvidoria', idManifestacao)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('manifestacaoOuvidoria', idManifestacao);

    if (data != null) {
        $("#resposta").val(data.object.resposta);
        $("#acao").val(data.object.acao);
        $("#prioridade").val(data.object.prioridade);
        $("#notificar").prop("checked", data.object.notificar);

        CKEDITOR.instances.descricao.setData(data.object.descricao);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idManifestacao,
        object: {
            id: idManifestacao,
            resposta: $("#resposta").val(),
            acao: $("#acao").val(),
            prioridade: $("#prioridade").val(),
            notificar: $("#notificar").is(':checked'),
        }
    };

    cacheSave('manifestacaoOuvidoria', data);
    modificado = true;
}

function removeCache() {
    removeData('manifestacaoOuvidoria', idManifestacao);
    modificado = false;
}

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
