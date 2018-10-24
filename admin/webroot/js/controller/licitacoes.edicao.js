var enviaArquivo = (idLicitacao == 0);
var modificado = false;

$(function () {
    $('#data_inicio').datepicker({
        language: 'pt-BR'
    });

    $('#data_termino').datepicker({
        language: 'pt-BR'
    });

    $('#data_inicio').mask('00/00/0000');
    $('#data_termino').mask('00/00/0000');

    $('#hora_inicio').mask('00:00');
    $('#hora_termino').mask('00:00');

    CKEDITOR.replace('descricao');

    $('#enviaArquivo').val(enviaArquivo);

    $("input").change(function(){
        autosave();
    });

    CKEDITOR.instances.descricao.on('change', function() {
        autosave();
    });

    if(hasCache('licitacao', idLicitacao)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('licitacao', idLicitacao);

    if (data != null) {
        $("#titulo").val(data.object.titulo);
        $("#data_inicio").val(data.object.dataInicio);
        $("#hora_inicio").val(data.object.horaInicio);
        $("#data_termino").val(data.object.dataTermino);
        $("#hora_termino").val(data.object.horaTermino);
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
        id: idLicitacao,
        object: {
            id: idLicitacao,
            titulo: $("#titulo").val(),
            dataInicio: $("#data_inicio").val(),
            horaInicio: $("#hora_inicio").val(),
            dataTermino: $("#data_termino").val(),
            horaTermino: $("#hora_termino").val(),
            descricao: CKEDITOR.instances.descricao.getData(),
            ativo: $("#ativo").is(':checked'),
        }
    };

    cacheSave('licitacao', data);
    modificado = true;
}

function removeCache() {
    removeData('licitacao', idLicitacao);
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
        mensagem += "<li> O título da licitação é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if ($("#data_inicio").val() === "") {
        mensagem += "<li> A data do início da licitação é obrigatória.</li>";
        $("label[for='data-inicio']").css("color", "red");
    } else {
        $("label[for='data-inicio']").css("color", "#aaa");
    }

    if ($("#hora_inicio").val() === "") {
        mensagem += "<li> A hora do início da licitação é obrigatória.</li>";
        $("label[for='hora-inicio']").css("color", "red");
    } else {
        $("label[for='hora-inicio']").css("color", "#aaa");
    }

    if ($("#data_termino").val() === "") {
        mensagem += "<li> A data do término da licitação é obrigatória.</li>";
        $("label[for='data-termino']").css("color", "red");
    } else {
        $("label[for='data-termino']").css("color", "#aaa");
    }

    if ($("#hora_termino").val() === "") {
        mensagem += "<li> A hora do término da licitação é obrigatória.</li>";
        $("label[for='hora-termino']").css("color", "red");
    } else {
        $("label[for='hora-termino']").css("color", "#aaa");
    }

    if ($("#data_inicio").val() !== "" && $("#hora_inicio").val() !== "" && $("#data_termino").val() !== "" && $("#hora_termino").val() !== "") {

        var dataInicio = null;
        var dataTermino = null;

        if($("#hora_termino").val() == "00:00"){
            dataInicio = new Date($("#data_inicio").val().split('/').reverse().join('/'));
            dataTermino = new Date($("#data_termino").val().split('/').reverse().join('/'));
        } else {
            dataInicio = new Date($("#data_inicio").val().split('/').reverse().join('/') + " " + $("#hora_inicio").val());
            dataTermino = new Date($("#data_termino").val().split('/').reverse().join('/') + " " + $("#hora_termino").val());
        }

        if(dataInicio > dataTermino){
            mensagem += "<li> A data e a hora de início informada é maior que a data e a hora de término.</li>";
            $("label[for='data-inicio']").css("color", "red");
            $("label[for='hora-inicio']").css("color", "red");
            $("label[for='data-termino']").css("color", "red");
            $("label[for='hora-termino']").css("color", "red");
        } else {
            $("label[for='data-inicio']").css("color", "#aaa");
            $("label[for='hora-inicio']").css("color", "#aaa");
            $("label[for='data-termino']").css("color", "#aaa");
            $("label[for='hora-termino']").css("color", "#aaa");
        }
    }

    if (CKEDITOR.instances.descricao.getData() === "") {
        mensagem += "<li> É obrigatório informar a descrição da licitação.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
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
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
