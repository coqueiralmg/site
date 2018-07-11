var enviaArquivo = (idLegislacao == 0);
var modificado = false;

$(function () {
    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');
    $('#hora').mask('00:00');

    CKEDITOR.replace('descricao');

    $('#enviaArquivo').val(enviaArquivo);

    $("input").change(function(){
        autosave();
    });

    $('#assuntos').tagsinput({
        freeInput: true,
        allowDuplicates: false,
        trimValue: true,
        tagClass: 'badge tag-success'
     });

    CKEDITOR.instances.descricao.on('change', function() {
        autosave();
    });

    if(hasCache('legislacao', idLegislacao)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('legislacao', idLegislacao);

    if (data != null) {
        $("#numero").val(data.object.numero);
        $("#titulo").val(data.object.titulo);
        $("#data").val(data.object.data);
        $("#hora").val(data.object.hora);
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
        id: idLegislacao,
        object: {
            id: idLegislacao,
            numero: $("#numero").val(),
            titulo: $("#titulo").val(),
            data: $("#data").val(),
            hora: $("#hora").val(),
            descricao: CKEDITOR.instances.descricao.getData(),
            ativo: $("#ativo").is(':checked'),
        }
    };

    cacheSave('legislacao', data);
    modificado = true;
}

function removeCache() {
    removeData('legislacao', idLegislacao);
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

    if ($("#numero").val() === "") {
        mensagem += "<li> O número do documento da legislação é obrigatório.</li>";
        $("label[for='numero']").css("color", "red");
    } else {
        $("label[for='numero']").css("color", "#aaa");
    }

    if ($("#titulo").val() === "") {
        mensagem += "<li> O título do documento da legislação é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if ($("#data").val() === "") {
        mensagem += "<li> A data do documento da legislação é obrigatória.</li>";
        $("label[for='data']").css("color", "red");
    } else {
        $("label[for='data']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.descricao.getData() === "") {
        mensagem += "<li> É obrigatório informar a descrição do documento da legislação.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if (enviaArquivo) {
        if (document.getElementById("arquivo").files.length == 0) {
            mensagem += "<li> É obrigatório informar o arquivo em anexo.</li>";
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
