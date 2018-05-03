var enviaArquivo = (idDiaria == 0);

$(function () {
    $('#dataAutorizacao').datepicker({
        language: 'pt-BR'
    });

    $('#periodoInicio').datepicker({
        language: 'pt-BR'
    });

    $('#periodoFim').datepicker({
        language: 'pt-BR'
    });

    $('#placa').blur(function (e) {
        this.value = this.value.toUpperCase();
    });

    $('#dataAutorizacao').mask('00/00/0000');
    $('#periodoInicio').mask('00/00/0000');
    $('#periodoFim').mask('00/00/0000');
    $('#placa').mask('SSS 0000');
    $('#valor').mask("#.##0,00", {reverse: true});

    $("input, textarea").change(function(){
        autosave();
    });

    if(hasCache('diaria', idDiaria)) {
        $("#cadastro_info").show('fade');
    }
});

function restaurar() {
    var data = getDataCache('diaria', idDiaria);

    if (data != null) {
        $("#beneficiario").val(data.object.beneficiario);
        $("#valor").val(data.object.valor);
        $("#dataAutorizacao").val(data.object.dataAutorizacao);
        $("#destino").val(data.object.destino);
        $("#periodoInicio").val(data.object.periodoInicio);
        $("#periodoFim").val(data.object.periodoFim);
        $("#objetivo").val(data.object.objetivo);
        $("#veiculo").val(data.object.veiculo);
        $("#placa").val(data.object.placa);
        $("#ativo").prop("checked", data.object.ativo);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idDiaria,
        object: {
            id: idDiaria,
            beneficiario: $("#beneficiario").val(),
            valor: $("#valor").val(),
            dataAutorizacao: $("#dataAutorizacao").val(),
            destino: $("#destino").val(),
            periodoInicio: $("#periodoInicio").val(),
            periodoFim: $("#periodoFim").val(),
            objetivo: $("#objetivo").val(),
            veiculo: $("#veiculo").val(),
            placa: $("#placa").val(),
            ativo: $("#ativo").is(':checked')
        }
    };

    cacheSave('diaria', data);
}

function removeCache() {
    removeData('diaria', idDiaria);
}

function toggleArquivo() {
    $("#panel_arquivo").hide();
    $("#panel_envio").show();

    enviaArquivo = true;
    $('#enviaArquivo').val(enviaArquivo);
}

function validar() {
    var mensagem = "";

    if ($("#beneficiario").val() === "") {
        mensagem += "<li> É obrigatório informar o nome do beneficiário da diária.</li>";
        $("label[for='beneficiario']").css("color", "red");
    } else {
        $("label[for='beneficiario']").css("color", "#aaa");
    }

    if ($("#valor").val() === "") {
        mensagem += "<li> É obrigatório informar o valor das diárias concedidas a beneficiário.</li>";
        $("label[for='valor']").css("color", "red");
    } else {
        $("label[for='valor']").css("color", "#aaa");
    }

    if ($("#destino").val() === "") {
        mensagem += "<li> É obrigatório informar o destino para onde o beneficiário irá viajar.</li>";
        $("label[for='destino']").css("color", "red");
    } else {
        $("label[for='destino']").css("color", "#aaa");
    }

    if ($("#periodoInicio").val() === "") {
        mensagem += "<li> É obrigatório informar o período inicial de benefício de diária.</li>";
        $("label[for='periodoinicio']").css("color", "red");
    } else {
        $("label[for='periodoinicio']").css("color", "#aaa");
    }

    if ($("#periodoFim").val() === "") {
        mensagem += "<li> É obrigatório informar o período final de benefício de diária.</li>";
        $("label[for='periodofim']").css("color", "red");
    } else {
        $("label[for='periodofim']").css("color", "#aaa");
    }

    if ($("#periodoInicio").val() !== "" && $("#periodoFim").val() !== "") {
        var periodoInicio = new Date($("#periodoInicio").val().split('/').reverse().join('/'));
        var periodoFim = new Date($("#periodoFim").val().split('/').reverse().join('/'));;

        if(periodoInicio > periodoFim){
            mensagem += "<li>A data de período inicial da diária é maior que a data de período final da diária.</li>";
            $("label[for='periodoinicio']").css("color", "red");
            $("label[for='periodofim']").css("color", "red");
        } else {
            $("label[for='periodoinicio']").css("color", "#aaa");
            $("label[for='periodofim']").css("color", "#aaa");
        }
    }

    if ($("#objetivo").val() === "") {
        mensagem += "<li> É obrigatório informar o objetivo do uso da diária.</li>";
        $("label[for='objetivo']").css("color", "red");
    } else {
        $("label[for='objetivo']").css("color", "#aaa");
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
