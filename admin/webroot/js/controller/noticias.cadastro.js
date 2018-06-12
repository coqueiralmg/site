var enviaArquivo = (idNoticia == 0);
var modificado = false;

$(function () {
    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');
    $('#hora').mask('00:00');

    CKEDITOR.replace('texto');

    $('#enviaArquivo').val(enviaArquivo);

    $("input").change(function(){
        autosave();
    });

    CKEDITOR.instances.texto.on('change', function() {
        autosave();
    });

    if(hasCache('noticia', idNoticia)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('noticia', idNoticia);

    if (data != null) {
        $("#titulo").val(data.object.titulo);
        $("#data").val(data.object.data);
        $("#hora").val(data.object.hora);
        $("#ativo").prop("checked", data.object.ativo);
        $("#destaque").prop("checked", data.object.destaque);

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
            destaque: $("#destaque").is(':checked')
        }
    };

    cacheSave('noticia', data);
    modificado = true;
}

function removeCache() {
    removeData('noticia', idNoticia);
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

    if ($("#titulo").val() === "") {
        mensagem += "<li> O título da notícia é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.texto.getData() === "") {
        mensagem += "<li> É obrigatório informar o texto da notícia.</li>";
        $("label[for='texto']").css("color", "red");
    } else {
        $("label[for='texto']").css("color", "#aaa");
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
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
