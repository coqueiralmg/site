var modificado = false;

$(function () {
    $("input").change(function () {
        autosave();
        modificado = true;
    });

    if (hasCache('grupoUsuario', idGrupoUsuario)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function autosave() {
    var data = {
        id: idGrupoUsuario,
        object: {
            id: idGrupoUsuario,
            nome: $("#nome").val(),
            funcoes: coletarFuncoes(),
            ativo: $("#ativo").is(':checked'),
            integrado: $("#integrado").is(':checked'),
            administrativo: $("#administrativo").is(':checked')
        }
    };

    cacheSave('grupoUsuario', data);
}

function restaurar() {
    var data = getDataCache('grupoUsuario', idGrupoUsuario);

    if (data != null) {
        $("#nome").val(data.object.nome);
        $("#ativo").prop("checked", data.object.ativo);
        $("#integrado").prop("checked", data.object.integrado);
        $("#administrativo").prop("checked", data.object.administrativo);
        restaurarFuncoes(data.object.funcoes);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success");
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning");
}

function removeCache() {
    removeData('grupoUsuario', idGrupoUsuario);
    modificado = false;
}

function coletarFuncoes() {
    var funcoes = new Object();

    $("#funcoes input").each(function () {
        var name = $(this).prop("name");
        var active = $(this).is(':checked');
        funcoes[name] = active;
    });

    return funcoes;
}

function restaurarFuncoes(funcoes) {
    $("#funcoes input").each(function () {
        var name = $(this).prop("name");

        if (funcoes.hasOwnProperty(name)) {
            $(this).prop("checked", funcoes[name]);
        }
    });
}

function marcarTodos() {
    $("#funcoes input").each(function () {
        $(this).prop("checked", true);
    });

    autosave();
}

function desmarcarTodos() {
    $("#funcoes input").each(function () {
        $(this).prop("checked", false);
    });

    autosave();
}

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome do grupo usuário é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
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
