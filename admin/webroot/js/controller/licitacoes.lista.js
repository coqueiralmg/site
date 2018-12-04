$(function () {
    $('#data_publicacao_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#data_publicacao_final').datepicker({
        language: 'pt-BR'
    });

    $('#data_sessao_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#data_sessao_final').datepicker({
        language: 'pt-BR'
    });

    $('#numprocesso').mask('000/0000');
    $('#data_publicacao_inicial').mask('00/00/0000');
    $('#data_publicacao_final').mask('00/00/0000');
    $('#data_sessao_inicial').mask('00/00/0000');
    $('#data_sessao_final').mask('00/00/0000');
});

function validar() {
    var mensagem = "";
    var dataPublicacaoInicial = $('#data_publicacao_inicial').val();
    var dataPublicacaoFinal = $('#data_publicacao_final').val();
    var dataSessaoInicial = $('#data_sessao_inicial').val();
    var dataSessaoFinal = $('#data_sessao_final').val();

    if (dataPublicacaoInicial != "" || dataPublicacaoFinal != "") {
        if (dataPublicacaoInicial == "") {
            mensagem += "<li>Favor, informe a data da publicação inicial para efetuar a busca por data da publicação.</li>";
            $("label[for='data-inicial']").css("color", "red");
        } else {
            $("label[for='data-inicial']").css("color", "#aaa");
        }

        if (dataPublicacaoFinal == "") {
            mensagem += "<li>Favor, informe a data da publicação final para efetuar a busca por data da publicação.</li>";
            $("label[for='data-final']").css("color", "red");
        } else {
            $("label[for='data-final']").css("color", "#aaa");
        }

        if (dataPublicacaoInicial != "" && dataPublicacaoFinal != "") {
            var inicial = new Date(dataPublicacaoInicial.split('/').reverse().join('/'));
            var final = new Date(dataPublicacaoFinal.split('/').reverse().join('/'));

            if (inicial > final) {
                mensagem += "<li>A data da publicação inicial é maior do que a data da publicação final.</li>";
                $("label[for='data-inicial']").css("color", "red");
                $("label[for='data-final']").css("color", "red");
            } else {
                $("label[for='data-inicial']").css("color", "#aaa");
                $("label[for='data-final']").css("color", "#aaa");
            }
        }
    }

    if (dataSessaoInicial != "" || dataSessaoFinal != "") {
        if (dataSessaoInicial == "") {
            mensagem += "<li>Favor, informe a data da sessão inicial para efetuar a busca por data da sessão.</li>";
            $("label[for='data-inicial']").css("color", "red");
        } else {
            $("label[for='data-inicial']").css("color", "#aaa");
        }

        if (dataSessaoFinal == "") {
            mensagem += "<li>Favor, informe a data da sessão final para efetuar a busca por data da publicação.</li>";
            $("label[for='data-final']").css("color", "red");
        } else {
            $("label[for='data-final']").css("color", "#aaa");
        }

        if (dataSessaoInicial != "" && dataSessaoFinal != "") {
            var inicial = new Date(dataSessaoInicial.split('/').reverse().join('/'));
            var final = new Date(dataSessaoFinal.split('/').reverse().join('/'));

            if (inicial > final) {
                mensagem += "<li>A data da sessão inicial é maior do que a data da sessão final.</li>";
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

function excluirLicitacao(id, titulo) {
    swal({
        title: "Deseja excluir esta licitação?",
        html: "A exclusão da licitação com o título <b> " + titulo + "</b> irá tornar a operação irreversível.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        window.location = '/admin/licitacoes/delete/' + id;
    });
}
