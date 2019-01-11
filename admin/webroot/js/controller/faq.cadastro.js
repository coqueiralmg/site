var modificado = false;

$(function () {
    CKEDITOR.replace('resposta');

    $("input, select").change(function () {
        autosave();
    });

    CKEDITOR.instances.resposta.on('change', function () {
        autosave();
    });

    if (hasCache('pergunta', idPergunta)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('pergunta', idPergunta);

    if (data != null) {
        $("#questao").val(data.object.questao);
        $("#categoria").val(data.object.categoria);
        $("#tipo_ouvidoria").val(data.object.gatilho);
        $("#destaque").prop("checked", data.object.destaque);
        $("#ativo").prop("checked", data.object.ativo);

        CKEDITOR.instances.resposta.setData(data.object.resposta);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idPergunta,
        object: {
            id: idPergunta,
            questao: $("#questao").val(),
            resposta: CKEDITOR.instances.resposta.getData(),
            categoria: $("#categoria").val(),
            gatilho: $("#tipo_ouvidoria").val(),
            destaque: $("#destaque").is(':checked'),
            ativo: $("#ativo").is(':checked')
        }
    };

    cacheSave('pergunta', data);
    modificado = true;
}

function removeCache() {
    removeData('pergunta', idPergunta);
    modificado = false;
}

function validar() {
    var mensagem = "";

    if ($("#questao").val() === "") {
        mensagem += "<li> O título da questao da pergunta é obrigatório.</li>";
        $("label[for='questao']").css("color", "red");
    } else {
        $("label[for='questao']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.resposta.getData() === "") {
        mensagem += "<li> É obrigatório informar o texto de resposta da questão.</li>";
        $("label[for='resposta']").css("color", "red");
    } else {
        $("label[for='resposta']").css("color", "#aaa");
    }

    if ($("#categoria").val() === "") {
        mensagem += "<li> A categoria da pergunta é obrigatória.</li>";
        $("label[for='categoria']").css("color", "red");
    } else {
        $("label[for='categoria']").css("color", "#aaa");
    }

    if ($("#tipo_ouvidoria").val() === "NN" && mensagem == "") {
        notificarUsuario("Vale ressaltar que é importante que se escolha o tipo de gatilho de ouvidoria, que fará com que o site leve o usuário a um determinado formulário de ouvidoria. Caso salve como \"Nenhum\", o site levará para página inicial de \"Fale Com a Prefeitura\".", "warning")
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
