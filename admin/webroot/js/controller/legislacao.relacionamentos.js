$(function () {
    $('#documento').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/admin/legislacao/list.json',
                dataType: 'json',
                data: {
                    chave: request.term
                },
                beforeSend: function () {
                    $("#aviso_aguarde").show('fade');
                },
                success: function (data) {
                    $("#aviso_aguarde").hide('fade');
                    response(data.resultado);
                }
            });
        },
        focus: function (event, ui) {
            $('#documento').val(ui.item.titulo.trim());
            return false;
        },
        select: function (event, ui) {
            relacionarLegislacao(ui.item.id, true);
        },
        minLength: 3,
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span>' + item.titulo.trim() + '</span>')
            .appendTo(ul);
    };

    $('#modal_relacionamento_legislacao #buscar').click(function (e) {
        buscarLegislacaoRelacionada();
    });
});

function cortarRelacionamento(id, titulo) {
    swal({
        title: "Deseja cortar a ligação com este documento da legislação?",
        html: "Este documento da legislação não estará mais relacionado com o documento da legislação com o título <b> " + titulo + "</b>.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        desligarLegislacao(id, true);
    });
}

function relacionarLegislacao(idRelacionada, bidirecional) {
    var url = "/admin/legislacao/link.json";

    if (idLegislacao == idRelacionada) {
        var mensagem = "Não é permitido fazer relacionamento com próprio documento da legislação (auto-relacionamento)";

        $("#cadastro_erro").show('shake');
        $("#details").html("<p>" + mensagem + "</p>");

        return false;
    }

    $.post(url, {
        documento: idLegislacao,
        relacionada: idRelacionada,
        bidirecional: bidirecional
    }, function (data) {
        var destino = 'relacionamentos/' + idLegislacao;
        $("#aviso_aguarde").hide('fade');

        if (data.sucesso) {
            var mensagem = "O relacionamento foi criado com sucesso!";
            window.location = '/admin/legislacao/refresh?destino=relacionamentos&codigo=' + idLegislacao + "&&mensagem=" + mensagem;
        } else {
            var mensagem = data.mensagem;
            window.location = '/admin/legislacao/rollback?destino=relacionamentos&codigo=' + idLegislacao + "&&mensagem=" + mensagem;
        }
    }).fail(function () {
        $("#aviso_aguarde").hide('fade');

        swal({
            title: "Erro!",
            html: 'Ocorreu um erro ao fazer ligação entre documentos da legislação',
            type: 'error'
        });
    });

    $("#aviso_aguarde").show('fade');
}

function desligarLegislacao(idRelacionada, bidirecional) {
    var url = "/admin/legislacao/unlink.json";

    $.post(url, {
        documento: idLegislacao,
        relacionada: idRelacionada,
        bidirecional: bidirecional
    }, function (data) {
        var destino = 'relacionamentos/' + idLegislacao;

        if (data.sucesso) {
            var mensagem = "O relacionamento foi excluído com sucesso!";
            window.location = '/admin/legislacao/refresh?destino=relacionamentos&codigo=' + idLegislacao + "&&mensagem=" + mensagem;
        } else {
            var mensagem = data.mensagem;
            window.location = '/admin/legislacao/rollback?destino=relacionamentos&codigo=' + idLegislacao + "&&mensagem=" + mensagem;
        }
    }).fail(function () {
        $("#aviso_aguarde").hide('fade');

        swal({
            title: "Erro!",
            html: 'Ocorreu um erro ao desfazer ligação entre documentos da ouvidoria',
            type: 'error'
        });
    });

    $("#aviso_aguarde").show('fade');
}

function buscarLegislacaoRelacionada() {
    var titulo = $('#modal_relacionamento_legislacao #titulo').val();

    $.ajax({
        url: '/admin/legislacao/list.json',
        dataType: 'json',
        data: {
            chave: titulo
        },
        beforeSend: function () {
            $("#modal_relacionamento_legislacao .category").empty();
            $("#modal_relacionamento_legislacao .category").html("Efetuando busca. Aguarde!");

            if ($("#modal_relacionamento_legislacao .category").hasClass("text-danger")) {
                $("#modal_relacionamento_legislacao .category").removeClass("text-danger");
            }
        },
        success: function (data) {
            atualizarTabela(data.resultado);
        },
        error: function () {
            $("#modal_relacionamento_legislacao .category").empty();
            $("#modal_relacionamento_legislacao .category").html("Ocorreu um erro ao efetuar a busca");
            $("#modal_relacionamento_legislacao .category").addClass("text-danger");
        }
    });
}

function atualizarTabela(data) {
    var tabela = $("#modal_relacionamento_legislacao #tabela");
    var pivot = $("#modal_relacionamento_legislacao #tabela tbody#pivot tr:first");
    var vazio = $("#modal_relacionamento_legislacao #tabela tbody#pivot tr:last");
    var dados = $("#modal_relacionamento_legislacao #tabela tbody#data");

    dados.empty();

    $("#modal_relacionamento_legislacao .category").empty();

    if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            var linha = pivot.clone();
            var dado = data[i];

            linha.find('#numero').html(dado.numero);
            linha.find('#titulo').html(dado.titulo);
            linha.find('#data').html(formatarDataHoraView(dado.data));

            linha.attr("id", dado.id);

            dados.append(linha);
        }
    } else {
        dados.append(vazio);

        $("#modal_relacionamento_legislacao .category").html("Nenhum item encontrado.");
    }
}

function relacionar(o) {
    var linha = o.parentNode.parentNode;
    var id = linha.getAttribute("id");
    relacionarLegislacao(id, true);
}
