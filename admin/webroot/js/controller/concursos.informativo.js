var modificado = false;

$(function () {
    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');
    $('#hora').mask('00:00');
    $('#info').show();

    CKEDITOR.replace('texto');

    $("input").change(function () {
        autosave();
    });

    CKEDITOR.instances.texto.on('change', function () {
        autosave();
    });

    if (hasCache('noticiaConcurso', idNoticia)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('noticiaConcurso', idNoticia);

    if (data != null) {
        $("#titulo").val(data.object.titulo);
        $("#data").val(data.object.data);
        $("#hora").val(data.object.hora);
        $("#ativo").prop("checked", data.object.ativo);

        CKEDITOR.instances.texto.setData(data.object.texto);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idNoticia,
        object: {
            id: idNoticia,
            titulo: $("#titulo").val(),
            data: $("#data").val(),
            hora: $("#hora").val(),
            texto: CKEDITOR.instances.texto.getData(),
            ativo: $("#ativo").is(':checked'),
        }
    };

    cacheSave('noticiaConcurso', data);
    modificado = true;
}

function removeCache() {
    removeData('noticiaConcurso', idNoticia);
    modificado = false;
}

function validar() {
    var mensagem = "";

    if ($("#titulo").val() === "") {
        mensagem += "<li> O título do informativo é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.texto.getData() === "") {
        mensagem += "<li> É obrigatório informar o texto do informativo.</li>";
        $("label[for='texto']").css("color", "red");
    } else {
        $("label[for='texto']").css("color", "#aaa");
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
