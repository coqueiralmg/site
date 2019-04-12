var modificado = false;

$(function () {
    $('#inscricao_inicio').datepicker({
        language: 'pt-BR'
    });

    $('#inscricao_fim').datepicker({
        language: 'pt-BR'
    });

    $('#data_prova').datepicker({
        language: 'pt-BR'
    });

    $('#inscricao_inicio').mask('00/00/0000');
    $('#inscricao_fim').mask('00/00/0000');
    $('#data_prova').mask('00/00/0000');

    CKEDITOR.replace('descricao', {
        height: 300
    });

    CKEDITOR.replace('observacoes', {
        height: 150
    });

    $("input, select").change(function () {
        autosave();
    });

    CKEDITOR.instances.descricao.on('change', function () {
        autosave();
    });

    CKEDITOR.instances.observacoes.on('change', function () {
        autosave();
    });

    if (hasCache('concurso', idConcurso)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('concurso', idConcurso);

    if (data != null) {
        $("#numero").val(data.object.numero);
        $("#titulo").val(data.object.titulo);
        $("#tipo").val(data.object.tipo);
        $("#inscricao_inicio").val(data.object.inscricaoInicio);
        $("#inscricao_fim").val(data.object.inscricaoFim);
        $("#data_prova").val(data.object.dataProva);
        $("#banca").val(data.object.banca);
        $("#siteBanca").val(data.object.siteBanca);
        $("#status").val(data.object.status);
        $("#ativo").prop("checked", data.object.ativo);

        CKEDITOR.instances.descricao.setData(data.object.descricao);
        CKEDITOR.instances.observacoes.setData(data.object.observacoes);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idConcurso,
        object: {
            id: idConcurso,
            numero: $("#numero").val(),
            titulo: $("#titulo").val(),
            tipo: $("#tipo").val(),
            inscricaoInicio: $("#inscricao_inicio").val(),
            inscricaoFim: $("#inscricao_fim").val(),
            dataProva: $("#data_prova").val(),
            banca: $("#banca").val(),
            siteBanca: $("#siteBanca").val(),
            status: $("#status").val(),
            descricao: CKEDITOR.instances.descricao.getData(),
            observacoes: CKEDITOR.instances.observacoes.getData(),
            ativo: $("#ativo").is(':checked'),
        }
    };

    cacheSave('concurso', data);
    modificado = true;
}

function removeCache() {
    removeData('concurso', idConcurso);
    modificado = false;
}

function validar() {
    var mensagem = "";

    if ($("#numero").val() === "") {
        mensagem += "<li> O número do concurso público ou processo seletivo é obrigatório.</li>";
        $("label[for='numero']").css("color", "red");
    } else {
        $("label[for='numero']").css("color", "#aaa");
    }

    if ($("#titulo").val() === "") {
        mensagem += "<li> O título do concurso público ou processo seletivo é obrigatório.</li>";
        $("label[for='titulo']").css("color", "red");
    } else {
        $("label[for='titulo']").css("color", "#aaa");
    }

    if ($("#tipo").val() === "") {
        mensagem += "<li> O tipo do concurso público ou processo seletivo é obrigatório.</li>";
        $("label[for='tipo']").css("color", "red");
    } else {
        $("label[for='tipo']").css("color", "#aaa");
    }

    if ($("#inscricao_inicio").val() === "") {
        mensagem += "<li> É obrigatório informar a data de início das inscrições para o concurso público ou processo seletivo.</li>";
        $("label[for='inscricao-inicio']").css("color", "red");
    } else {
        $("label[for='inscricao-inicio']").css("color", "#aaa");
    }

    if ($("#inscricao_fim").val() === "") {
        mensagem += "<li> É obrigatório informar a data final das inscrições para o concurso público ou processo seletivo.</li>";
        $("label[for='inscricao-fim']").css("color", "red");
    } else {
        $("label[for='inscricao-fim']").css("color", "#aaa");
    }

    if ($("#data_prova").val() === "") {
        mensagem += "<li> É obrigatório informar a data da prova do concurso público ou processo seletivo.</li>";
        $("label[for='data-prova']").css("color", "red");
    } else {
        $("label[for='data-prova']").css("color", "#aaa");
    }

    if (CKEDITOR.instances.descricao.getData() === "") {
        mensagem += "<li> É obrigatório informar a descrição do concurso público ou processo seletivo.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if ($("#banca").val() === "") {
        mensagem += "<li> O nome da banca do concurso público ou processo seletivo é obrigatório. Caso não tenha, favor informar a própria prefeitura.</li>";
        $("label[for='banca']").css("color", "red");
    } else {
        $("label[for='banca']").css("color", "#aaa");
    }

    if ($("#status").val() === "") {
        mensagem += "<li> É obrigatório informar o status do concurso público.</li>";
        $("label[for='status']").css("color", "red");
    } else {
        $("label[for='status']").css("color", "#aaa");
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
