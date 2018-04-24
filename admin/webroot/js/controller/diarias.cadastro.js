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
});

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
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
