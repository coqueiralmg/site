$(function () {
    $('#documento').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/admin/faq/list.json',
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
        select: function (event, ui) {
            relacionarPergunta(ui.item.id);
        },
        minLength: 3,
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span>' + item.questao.trim() + '</span>')
            .appendTo(ul);
    };
});

function cortarRelacionamento(id, titulo) {
    swal({
        title: "Deseja desfazer a ligação com esta pergunta?",
        html: "Esta pergunta não estará mais relacionada com a pergunta <b> " + titulo + "</b>.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(function () {
        desfazerRelacao(id);
    });
}

function relacionarPergunta(idRelacionada) {
    var url = "/admin/faq/link.json";

    if (idPergunta == idRelacionada) {
        var mensagem = "Não é permitido fazer relacionamento com a mesma pergunta (auto-relacionamento)";

        $("#cadastro_erro").show('shake');
        $("#details").html("<p>" + mensagem + "</p>");

        return false;
    }

    $.post(url, {
        origem: idPergunta,
        relacionada: idRelacionada
    }, function (data) {
        $("#aviso_aguarde").hide('fade');

        if (data.sucesso) {
            var mensagem = "O relacionamento foi criado com sucesso!";
            window.location = '/admin/faq/refresh?destino=relacionamentos&codigo=' + idPergunta + "&&mensagem=" + mensagem;
        } else {
            var mensagem = data.mensagem;
            window.location = '/admin/faq/rollback?destino=relacionamentos&codigo=' + idPergunta + "&&mensagem=" + mensagem;
        }
    }).fail(function () {
        $("#aviso_aguarde").hide('fade');

        swal({
            title: "Erro!",
            html: 'Ocorreu um erro ao fazer ligação entre perguntas',
            type: 'error'
        });
    });

    $("#aviso_aguarde").show('fade');
}

function desfazerRelacao(idRelacionada) {
    var url = "/admin/faq/unlink.json";

    $.post(url, {
        origem: idPergunta,
        relacionada: idRelacionada,
    }, function (data) {
        var destino = 'relacionamentos/' + idPergunta;

        if (data.sucesso) {
            var mensagem = "O relacionamento foi desfeito com sucesso!";
            window.location = '/admin/faq/refresh?destino=relacionamentos&codigo=' + idPergunta + "&&mensagem=" + mensagem;
        } else {
            var mensagem = data.mensagem;
            window.location = '/admin/faq/rollback?destino=relacionamentos&codigo=' + idPergunta + "&&mensagem=" + mensagem;
        }
    }).fail(function () {
        $("#aviso_aguarde").hide('fade');

        swal({
            title: "Erro!",
            html: 'Ocorreu um erro ao desfazer ligação entre as perguntas',
            type: 'error'
        });
    });

    $("#aviso_aguarde").show('fade');
}
