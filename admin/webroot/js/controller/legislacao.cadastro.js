var enviaArquivo = (idLegislacao == 0);
var modificado = false;
var assuntos = new Array();

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

    $("#assuntos").select2({
        placeholder: "Clique e digite aqui para selecionar ou adicionar novo assunto.",
        tokenSeparators: [','],
        tags: true
    });

    $("#assuntos").on('select2:select', function(e){
        var data = e.params.data;

        var assunto = {
            id: validarIdAssunto(data),
            nome: data.text
        };

        assuntos.push(assunto);
        $("#lassuntos").val(JSON.stringify(assuntos));
    });

    $("#assuntos").on('select2:unselect', function(e){
        var data = e.params.data;
        var idAssunto = obterAssunto(data);

        assuntos.splice(idAssunto, 1);
        $("#lassuntos").val(JSON.stringify(assuntos));
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

function obterAssunto(data) {
    var chave = data.text;
    var idAssunto = assuntos.findIndex(function(v){
        var pivot = null;
        return v.nome == chave;
    });

    return idAssunto;
}

function validarIdAssunto(data) {
    return (data.id != data.text) ? eval(data.id) : -1;
}

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

    if($("#tipo").val() == "") {
        mensagem += "<li> É obrigatório informar o tipo do documento da legislação.</li>";
        $("label[for='tipo']").css("color", "red");
    } else {
        $("label[for='tipo']").css("color", "#aaa");
    }

    if($("#assuntos").select2('data').length == 0) {
        mensagem += "<li> O documento da legislação precisa estar enquadrado em algum assunto. Favor selecionar pelo menos um assunto.</li>";
        $("label[for='assuntos']").css("color", "red");
    } else {
        $("label[for='assuntos']").css("color", "#aaa");
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
