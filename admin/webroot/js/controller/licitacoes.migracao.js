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

    $('.arqdata').datepicker({
        language: 'pt-BR'
    });

    $('#data_publicacao').mask('00/00/0000');
    $('#data_sessao').mask('00/00/0000');
    $('#data_fim').mask('00/00/0000');
    $('.arqdata').mask('00/00/0000');

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
        ajustarModalidade($(this).val());
    });

    $("#assuntos").select2({
        placeholder: "Clique e digite aqui para selecionar ou adicionar novo assunto.",
        tokenSeparators: [','],
        tags: true
    });

    if (idLicitacao > 0) {
        var data = $("#assuntos").select2('data');

        for (var d = 0; d < data.length; d++) {
            var info = data[d];

            var assunto = {
                id: validarIdAssunto(info),
                nome: info.text
            };

            assuntos.push(assunto);
            $("#lassuntos").val(JSON.stringify(assuntos));
        }

        var modalidade = $('#modalidade').val();
        ajustarModalidade(modalidade);
    }

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

    if (hasCache('migracaoLicitacao', idLicitacao)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function ajustarModalidade(modalidade) {

    if (modalidade == "CC" ||
        modalidade == "CN" ||
        modalidade == "CR" ||
        modalidade == "CO" ||
        modalidade == "PE" ||
        modalidade == "LE") {
        $("label[for='data-sessao']").html("Data Início");
        $("label[for='hora-sessao']").html("Hora Início");
    } else {
        $("label[for='data-sessao']").html("Data da Sessão");
        $("label[for='hora-sessao']").html("Hora da Sessão");
    }

    if (modalidade == "DI" ||
        modalidade == "IN") {
        $("#data_sessao").val("");
        $("#hora_sessao").val("");
        $("#data_fim").val("");
        $("#hora_fim").val("");

        $("#data_sessao").prop('disabled', true);
        $("#hora_sessao").prop('disabled', true);
        $("#data_fim").prop('disabled', true);
        $("#hora_fim").prop('disabled', true);
    } else {
        $("#data_sessao").prop('disabled', false);
        $("#hora_sessao").prop('disabled', false);

        if (modalidade == "PP" ||
            modalidade == "TP") {
            $("#data_fim").val("");
            $("#hora_fim").val("");

            $("#data_fim").prop('disabled', true);
            $("#hora_fim").prop('disabled', true);
        } else {
            $("#data_fim").prop('disabled', false);
            $("#hora_fim").prop('disabled', false);
        }
    }
}

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
    var data = getDataCache('migracaoLicitacao', idLicitacao);

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

        restaurarListaArquivos(data.object.arquivos);
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
            assuntos: $("#lassuntos").val() == "" ? [] : JSON.parse($("#lassuntos").val()),
            arquivos: obterListaArquivos()
        }
    };

    cacheSave('migracaoLicitacao', data);
    modificado = true;
}

function removeCache() {
    removeData('migracaoLicitacao', idLicitacao);
    modificado = false;
}

function obterListaArquivos() {
    var tabela = document.getElementById("tblArquivos");
    var arquivos = Array();
    var i = 1;

    while (i < tabela.rows.length) {
        var linha = tabela.rows[i];
        var campos = linha.getElementsByTagName("input");

        var arquivo = {
            data: campos.arquivo_data.value,
            numero: campos.arquivo_numero.value,
            nome: campos.arquivo_nome.value,
            arquivo: campos.arquivo_arquivo.value,
            tipo: campos.arquivo_tipo.value,
            valido: campos.arquivo_valido.value == "1"
        };

        arquivos.push(arquivo);
        i++;
    }

    return arquivos;
}

function restaurarListaArquivos(arquivos) {
    var tabela = document.getElementById("tblArquivos");
    var i = 1;

    while (i < tabela.rows.length) {
        var linha = tabela.rows[i];
        var arquivo = arquivos[i - 1];
        var campos = linha.getElementsByTagName("input");

        campos.arquivo_data.value = arquivo.data;
        campos.arquivo_numero.value = arquivo.numero;
        campos.arquivo_nome.value = arquivo.nome;

        i++;
    }
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
        modalidade == "TP" ||
        modalidade == "CC" ||
        modalidade == "CN" ||
        modalidade == "LE") {

        if ($("#numdocumento").val() === "") {
            mensagem += "<li> O número do documento da licitação é obrigatório.</li>";
            $("label[for='numdocumento']").css("color", "red");
        } else {
            $("label[for='numdocumento']").css("color", "#aaa");
        }
    } else {
        $("label[for='numdocumento']").css("color", "#aaa");
    }

    if ($("#status").val() === "") {
        mensagem += "<li> É obrigatório selecionar o status do processo licitatório.</li>";
        $("label[for='status']").css("color", "red");
    } else {
        $("label[for='status']").css("color", "#aaa");
    }

    if ($("#numdocumento").val() !== "") {
        if ($("#documento").val() === "") {
            mensagem += "<li> O nome ou o tipo do documento (principal) da licitação é obrigatório.</li>";
            $("label[for='documento']").css("color", "red");
        } else {
            $("label[for='documento']").css("color", "#aaa");
        }
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
        modalidade == "TP" ||
        modalidade == "CC" ||
        modalidade == "CN" ||
        modalidade == "CO" ||
        modalidade == "LE") {

        if ($("#data_sessao").val() === "") {
            mensagem += "<li> A data do início da sessão é obrigatória.</li>";
            $("label[for='data-sessao']").css("color", "red");
        } else {
            $("label[for='data-sessao']").css("color", "#aaa");
        }

        if ($("#hora_sessao").val() === "") {
            mensagem += "<li> A hora do início da sessão é obrigatória.</li>";
            $("label[for='hora-sessao']").css("color", "red");
        } else {
            $("label[for='hora-sessao']").css("color", "#aaa");
        }
    } else {
        $("label[for='data-sessao']").css("color", "#aaa");
        $("label[for='hora-sessao']").css("color", "#aaa");
    }

    if (modalidade == "PE" ||
        modalidade == "CC" ||
        modalidade == "CN" ||
        modalidade == "CO" ||
        modalidade == "CR" ||
        modalidade == "LE") {

        if ($("#data_fim").val() === "") {
            mensagem += "<li> A data final é obrigatória.</li>";
            $("label[for='data-fim']").css("color", "red");
        } else {
            $("label[for='data-fim']").css("color", "#aaa");
        }

        if ($("#hora_fim").val() === "") {
            mensagem += "<li> A hora final é obrigatória.</li>";
            $("label[for='hora-fim']").css("color", "red");
        } else {
            $("label[for='hora-fim']").css("color", "#aaa");
        }
    } else {
        $("label[for='data-fim']").css("color", "#aaa");
        $("label[for='hora-fim']").css("color", "#aaa");
    }

    if ($("#data_sessao").val() !== "" && $("#hora_sessao").val() !== "" && $("#data_fim").val() !== "" && $("#hora_fim").val() !== "") {

        var dataInicio = null;
        var dataTermino = null;

        if ($("#hora_fim").val() == "00:00") {
            dataInicio = new Date($("#data_sessao").val().split('/').reverse().join('/'));
            dataTermino = new Date($("#data_fim").val().split('/').reverse().join('/'));
        } else {
            dataInicio = new Date($("#data_sessao").val().split('/').reverse().join('/') + " " + $("#hora_sessao").val());
            dataTermino = new Date($("#data_fim").val().split('/').reverse().join('/') + " " + $("#hora_fim").val());
        }

        if (dataInicio > dataTermino) {
            mensagem += "<li> A data e a hora de início da sessão informada é maior que a data e a hora de fim.</li>";
            $("label[for='data-sessao']").css("color", "red");
            $("label[for='hora-sessao']").css("color", "red");
            $("label[for='data-fim']").css("color", "red");
            $("label[for='hora-fim']").css("color", "red");
        } else {
            $("label[for='data-sessao']").css("color", "#aaa");
            $("label[for='hora-sessao']").css("color", "#aaa");
            $("label[for='data-fim']").css("color", "#aaa");
            $("label[for='hora-fim']").css("color", "#aaa");
        }
    }

    if (CKEDITOR.instances.descricao.getData() === "") {
        mensagem += "<li> É obrigatório informar a descrição da licitação.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if ($("#assuntos").select2('data').length == 0) {
        mensagem += "<li> A licitação precisa estar enquadrada em algum assunto. Favor selecionar pelo menos um assunto.</li>";
        $("label[for='assuntos']").css("color", "red");
    } else {
        $("label[for='assuntos']").css("color", "#aaa");
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

function mostrarDetalhesErroArquivo(arquivo, mensagem) {
    swal({
        html: "Ocorreu um erro do sistema ao capturar o arquivo <b>" + arquivo + "</b>, de acordo com detalhes abaixo.",
        type: 'error',
        input: "textarea",
        inputValue: mensagem,
        inputAttributes: {
            rows: 10
        }
    });
}
