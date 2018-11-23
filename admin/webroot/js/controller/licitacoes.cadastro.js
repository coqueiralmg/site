var modificado = false;
var assuntos = new Array();

$(function () {
    $('#data_publicacao').datepicker({
        language: 'pt-BR'
    });

    $('#data_sessao').datepicker({
        language: 'pt-BR'
    });

    $('#data_fim').datepicker({
        language: 'pt-BR'
    });

    $('#data_publicacao').mask('00/00/0000');
    $('#data_sessao').mask('00/00/0000');
    $('#data_fim').mask('00/00/0000');

    $('#hora_publicacao').mask('00:00');
    $('#hora_sessao').mask('00:00');
    $('#hora_fim').mask('00:00');

    CKEDITOR.replace('descricao');

    $('#data_publicacao').change(function () {
        var pivot = $('#data_publicacao').val().split('/');

        if (pivot.length == 3) {
            $("#ano").val(pivot[2]);
        }
    });

    $('#modalidade').change(function () {
        var modalidade = $(this).val();

        if (modalidade == "CC" ||
            modalidade == "CN" ||
            modalidade == "LE") {
            $("label[for='data-sessao']").html("Data Início");
            $("label[for='hora-sessao']").html("Hora Início");
        } else {
            $("label[for='data-sessao']").html("Data da Sessão");
            $("label[for='hora-sessao']").html("Hora da Sessão");
        }
    });

    $("#assuntos").select2({
        placeholder: "Clique e digite aqui para selecionar ou adicionar novo assunto.",
        tokenSeparators: [','],
        tags: true
    });

    $("#assuntos").on('select2:select', function (e) {
        var data = e.params.data;

        var assunto = {
            id: validarIdAssunto(data),
            nome: data.text
        };

        assuntos.push(assunto);
        $("#lassuntos").val(JSON.stringify(assuntos));
        autosave();
    });

    $("#assuntos").on('select2:unselect', function (e) {
        var data = e.params.data;
        var idAssunto = obterAssunto(data);

        assuntos.splice(idAssunto, 1);
        $("#lassuntos").val(JSON.stringify(assuntos));
        autosave();
    });

    $("input, select").change(function () {
        autosave();
    });

    CKEDITOR.instances.descricao.on('change', function () {
        autosave();
    });

    if (hasCache('licitacao', idLicitacao)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function obterAssunto(data) {
    var chave = data.text;
    var idAssunto = assuntos.findIndex(function (v) {
        var pivot = null;
        return v.nome == chave;
    });

    return idAssunto;
}

function validarIdAssunto(data) {
    return (data.id != data.text) ? eval(data.id) : -1;
}

function restaurar() {
    var data = getDataCache('licitacao', idLicitacao);

    if (data != null) {
        $("#titulo").val(data.object.titulo);
        $("#modalidade").val(data.object.modalidade);
        $("#numprocesso").val(data.object.numprocesso);
        $("#nummodalidade").val(data.object.nummodalidade);
        $("#numdocumento").val(data.object.numdocumento);
        $("#status").val(data.object.status);
        $("#data_publicacao").val(data.object.dataPublicacao);
        $("#hora_publicacao").val(data.object.horaPublicacao);
        $("#data_sessao").val(data.object.dataSessao);
        $("#hora_sessao").val(data.object.horaSessao);
        $("#data_fim").val(data.object.dataFim);
        $("#hora_fim").val(data.object.horaFim);
        $("#ano").val(data.object.ano);

        $("#destaque").prop("checked", data.object.destaque);
        $("#retificado").prop("checked", data.object.retificado);
        $("#ativo").prop("checked", data.object.ativo);

        CKEDITOR.instances.descricao.setData(data.object.descricao);

        assuntos = data.object.assuntos;
        $("#lassuntos").val(JSON.stringify(data.object.assuntos));
        $("#assuntos").val(null);

        for (var i = 0; i < assuntos.length; i++) {
            var assunto = assuntos[i];
            var option = new Option(assunto.nome, assunto.id, true, true);
            $("#assuntos").append(option);
        }
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
            modalidade: $("#modalidade").val(),
            numprocesso: $("#numprocesso").val(),
            nummodalidade: $("#nummodalidade").val(),
            numdocumento: $("#numdocumento").val(),
            status: $("#status").val(),
            dataPublicacao: $("#data_publicacao").val(),
            horaPublicacao: $("#hora_publicacao").val(),
            dataSessao: $("#data_sessao").val(),
            horaSessao: $("#hora_sessao").val(),
            dataFim: $("#data_fim").val(),
            horaFim: $("#hora_fim").val(),
            ano: $("#ano").val(),
            descricao: CKEDITOR.instances.descricao.getData(),
            destaque: $("#destaque").is(':checked'),
            retificado: $("#retificado").is(':checked'),
            ativo: $("#ativo").is(':checked'),
            assuntos: $("#lassuntos").val() == "" ? [] : JSON.parse($("#lassuntos").val())
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
    var modalidade = $("#modalidade").val();

    if ($("#titulo").val() === "") {
        mensagem += "<li> O título da licitação é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if ($("#modalidade").val() === "") {
        mensagem += "<li> É obrigatório selecionar a modalidade da licitação.</li>";
        $("label[for='modalidade']").css("color", "red");
    } else {
        $("label[for='modalidade']").css("color", "#aaa");
    }

    if ($("#numprocesso").val() === "") {
        mensagem += "<li> O número do processo licitatório é obrigatório.</li>";
        $("label[for='numprocesso']").css("color", "red");
    } else {
        $("label[for='numprocesso']").css("color", "#aaa");
    }

    if ($("#nummodalidade").val() === "") {
        mensagem += "<li> O número da modalidade da licitação é obrigatório.</li>";
        $("label[for='nummodalidade']").css("color", "red");
    } else {
        $("label[for='nummodalidade']").css("color", "#aaa");
    }

    if (modalidade == "PP" ||
        modalidade == "PE" ||
        modalidade == "RP" ||
        modalidade == "CC" ||
        modalidade == "CN" ||
        modalidade == "LE") {

        if ($("#numdocumento").val() === "") {
            mensagem += "<li> O número da modalidade da licitação é obrigatório.</li>";
            $("label[for='numdocumento']").css("color", "red");
        } else {
            $("label[for='numdocumento']").css("color", "#aaa");
        }
    }

    if ($("#status").val() === "") {
        mensagem += "<li> É obrigatório selecionar o status do processo licitatório.</li>";
        $("label[for='status']").css("color", "red");
    } else {
        $("label[for='status']").css("color", "#aaa");
    }

    if (idLicitacao > 0) {
        if ($("#data_publicacao").val() === "") {
            mensagem += "<li> A data de publicação é obrigatória.</li>";
            $("label[for='data-publicacao']").css("color", "red");
        } else {
            $("label[for='data-publicacao']").css("color", "#aaa");
        }

        if ($("#hora_publicacao").val() === "") {
            mensagem += "<li> A hora de publicação é obrigatória.</li>";
            $("label[for='hora-publicacao']").css("color", "red");
        } else {
            $("label[for='hora-publicacao']").css("color", "#aaa");
        }

        if ($("#ano").val() === "") {
            mensagem += "<li> O ano é obrigatório.</li>";
            $("label[for='ano']").css("color", "red");
        } else {
            $("label[for='ano']").css("color", "#aaa");
        }
    }

    if (modalidade == "PP" ||
        modalidade == "PE" ||
        modalidade == "RP" ||
        modalidade == "CC" ||
        modalidade == "CN" ||
        modalidade == "LE") {

        if ($("#data_sessao").val() === "") {
            mensagem += "<li> A data da sessão é obrigatória.</li>";
            $("label[for='data-sessao']").css("color", "red");
        } else {
            $("label[for='data-sessao']").css("color", "#aaa");
        }

        if ($("#hora_sessao").val() === "") {
            mensagem += "<li> A hora da sessão é obrigatória.</li>";
            $("label[for='hora-sessao']").css("color", "red");
        } else {
            $("label[for='hora-sessao']").css("color", "#aaa");
        }
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

        if ($("#hora_termino").val() == "00:00") {
            dataInicio = new Date($("#data_inicio").val().split('/').reverse().join('/'));
            dataTermino = new Date($("#data_termino").val().split('/').reverse().join('/'));
        } else {
            dataInicio = new Date($("#data_inicio").val().split('/').reverse().join('/') + " " + $("#hora_inicio").val());
            dataTermino = new Date($("#data_termino").val().split('/').reverse().join('/') + " " + $("#hora_termino").val());
        }

        if (dataInicio > dataTermino) {
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
