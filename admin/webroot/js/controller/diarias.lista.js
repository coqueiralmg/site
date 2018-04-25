$(function () {
    $('#data_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#data_final').datepicker({
        language: 'pt-BR'
    });

    $('#placa').blur(function (e) {
        this.value = this.value.toUpperCase();
    });

    $('#data_inicial').mask('00/00/0000');
    $('#data_final').mask('00/00/0000');
    $('#placa').mask('SSS 0000');
});

function validar() {
    var mensagem = "";
    var dataInicial = $('#data_inicial').val();
    var dataFinal = $('#data_final').val();

    if (dataInicial != "" || dataFinal != "") {
        if (dataInicial == "") {
            mensagem += "<li>Favor, informe a data inicial para efetuar a busca por data.</li>";
            $("label[for='data-inicial']").css("color", "red");
        } else {
            $("label[for='data-inicial']").css("color", "#aaa");
        }

        if (dataFinal == "") {
            mensagem += "<li>Favor, informe a data final para efetuar a busca por data.</li>";
            $("label[for='data-final']").css("color", "red");
        } else {
            $("label[for='data-final']").css("color", "#aaa");
        }

        if (dataInicial != "" && dataFinal != "") {
            var inicial = new Date(dataInicial.split('/').reverse().join('/'));
            var final = new Date(dataFinal.split('/').reverse().join('/'));

            if (inicial > final) {
                mensagem += "<li>A data inicial é maior do que a data final.</li>";
                $("label[for='data-inicial']").css("color", "red");
                $("label[for='data-final']").css("color", "red");
            } else {
                $("label[for='data-inicial']").css("color", "#aaa");
                $("label[for='data-final']").css("color", "#aaa");
            }
        }
    }

    if (mensagem == "") {
        return true;
    } else {
        $("#lista_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}

function excluirRegistro(id, beneficiario) {
    swal({
        title: "Deseja excluir este relatório de diárias de viagem?",
        html: "A exclusão do relatório de diária de viagens para o beneficiário <b> " + beneficiario + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/diarias/delete/' + id;
    });
}
