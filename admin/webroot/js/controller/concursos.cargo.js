var modificado = false;

$(function () {

    $('#vencimento').mask("#.##0,00", {
        reverse: true
    });
    $('#taxaInscricao').mask("#.##0,00", {
        reverse: true
    });

    CKEDITOR.replace('atribuicoes', {
        height: 300
    });

    CKEDITOR.replace('observacoes', {
        height: 150
    });

    $("input").change(function () {
        autosave();
    });

    CKEDITOR.instances.atribuicoes.on('change', function () {
        autosave();
    });

    CKEDITOR.instances.observacoes.on('change', function () {
        autosave();
    });

    if (hasCache('cargoConcurso', idCargoConcurso)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function () {
        if (modificado) {
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('cargoConcurso', idCargoConcurso);

    if (data != null) {
        $("#nome").val(data.object.nome);
        $("#requisito").val(data.object.requisito);
        $("#vagasTotal").val(data.object.vagasTotal);
        $("#vagaspcd").val(data.object.vagasPCD);
        $("#cargaHoraria").val(data.object.cargaHoraria);
        $("#vencimento").val(data.object.vencimento);
        $("#taxaInscricao").val(data.object.taxaInscricao);

        $("#reserva").prop("checked", data.object.reserva);
        $("#ativo").prop("checked", data.object.ativo);

        CKEDITOR.instances.atribuicoes.setData(data.object.atribuicoes);
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
        id: idCargoConcurso,
        object: {
            id: idCargoConcurso,
            nome: $("#nome").val(),
            requisito: $("#requisito").val(),
            vagasTotal: $("#vagasTotal").val(),
            vagasPCD: $("#vagaspcd").val(),
            cargaHoraria: $("#cargaHoraria").val(),
            vencimento: $("#vencimento").val(),
            taxaInscricao: $("#taxaInscricao").val(),
            atribuicoes: CKEDITOR.instances.atribuicoes.getData(),
            observacoes: CKEDITOR.instances.observacoes.getData(),
            reserva: $("#reserva").is(':checked'),
            ativo: $("#ativo").is(':checked')
        }
    };

    cacheSave('cargoConcurso', data);
    modificado = true;
}

function removeCache() {
    removeData('cargoConcurso', idCargoConcurso);
    modificado = false;
}

function validar() {
    var mensagem = "";
    var cadastroReserva = $("#reserva").is(':checked');

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome do cargo a ser provido é obrigatório.</li>";
        $("label[for='nome']").css("color", "red");
    } else {
        $("label[for='nome']").css("color", "#aaa");
    }

    if ($("#requisito").val() === "") {
        mensagem += "<li> É obigatório informar requisitos para a investidura do cargo a ser provido.</li>";
        $("label[for='requisito']").css("color", "red");
    } else {
        $("label[for='requisito']").css("color", "#aaa");
    }

    if (!cadastroReserva) {
        if ($("#vagasTotal").val() === "") {
            mensagem += "<li> É obigatório informar a quantidade total de vagas disponíveis para o cargo a ser provido. Caso seja cadastro de reserva, favor marcar a opção de que este cargo é um cadastro de reserva.</li>";
            $("label[for='vagastotal']").css("color", "red");
        } else {
            $("label[for='vagastotal']").css("color", "#aaa");
        }
    } else {
        $("label[for='vagastotal']").css("color", "#aaa");
    }

    if ($("#cargaHoraria").val() === "") {
        mensagem += "<li> É obigatório informar a carga horária para o cargo a ser provido.</li>";
        $("label[for='cargahoraria']").css("color", "red");
    } else {
        $("label[for='cargahoraria']").css("color", "#aaa");
    }

    if ($("#vencimento").val() === "") {
        mensagem += "<li> É obigatório informar o vencimento/salário do cargo a ser provido.</li>";
        $("label[for='vencimento']").css("color", "red");
    } else {
        $("label[for='vencimento']").css("color", "#aaa");
    }

    if ($("#taxaInscricao").val() === "") {
        mensagem += "<li> É obigatório informar a taxa de inscrição para o candidato concorrer ao cargo a ser provido.</li>";
        $("label[for='taxainscricao']").css("color", "red");
    } else {
        $("label[for='taxainscricao']").css("color", "#aaa");
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
