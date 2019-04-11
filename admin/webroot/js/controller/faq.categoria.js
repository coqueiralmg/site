var modificado = false;

$(function () {
    $("input, textarea").change(function () {
        autosave();
    });

    if (hasCache('categoriaPerguntas', idCategoriaPergunta)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('categoriaPerguntas', idCategoriaPergunta);

    if (data != null) {
        $("#nome").val(data.object.nome);
        $("#descricao").val(data.object.descricao);
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
        id: idCategoriaPergunta,
        object: {
            id: idCategoriaPergunta,
            nome: $("#nome").val(),
            descricao: $("#descricao").val(),
            ativo: $("#ativo").is(':checked')
        }
    };

    cacheSave('categoriaPerguntas', data);
    modificado = true;
}

function removeCache() {
    removeData('categoriaPerguntas', idCategoriaPergunta);
    modificado = false;
}

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome da categoria de perguntas é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
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
