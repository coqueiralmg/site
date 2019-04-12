var modificado = false;

$(function () {
    CKEDITOR.replace('descricao');

    $('#telefone').mask('(00)0000-00000');

    $("input, textarea").change(function () {
        autosave();
    });

    CKEDITOR.instances.descricao.on('change', function () {
        autosave();
    });

    if (hasCache('secretaria', idSecretaria)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('secretaria', idSecretaria);

    if (data != null) {
        $("#nome").val(data.object.nome);
        $("#responsavel").val(data.object.responsavel);
        $("#endereco").val(data.object.endereco);
        $("#telefone").val(data.object.telefone);
        $("#email").val(data.object.email);
        $("#descricao_responsavel").val(data.object.sobreResponsavel);
        $("#expediente").val(data.object.expediente);
        $("#ativo").prop("checked", data.object.ativo);

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
        id: idSecretaria,
        object: {
            id: idSecretaria,
            nome: $("#nome").val(),
            responsavel: $("#responsavel").val(),
            endereco: $("#endereco").val(),
            telefone: $("#telefone").val(),
            email: $("#email").val(),
            sobreResponsavel: $("#descricao_responsavel").val(),
            expediente: $("#expediente").val(),
            descricao: CKEDITOR.instances.descricao.getData(),
            ativo: $("#ativo").is(':checked')
        }
    };

    cacheSave('secretaria', data);
    modificado = true;
}

function removeCache() {
    removeData('secretaria', idSecretaria);
    modificado = false;
}

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
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
