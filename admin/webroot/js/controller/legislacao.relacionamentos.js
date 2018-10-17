$(function () {
    $('#documento').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/admin/legislacao/list.json',
                dataType: 'json',
                data: {
                    chave: request.term
                },
                success: function (data) {
                    response(data.resultado);
                }
            });
        },
        select: function (event, ui) {
            //criarRelacaoBidirecional(ui.item);
            relacionarLegislacao(ui.item.id, true);
        },
        minLength: 3,
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span>' + item.titulo.trim() + '</span>')
            .appendTo(ul);
    };
});

function criarRelacaoBidirecional(relacionada) {
    var chave = createKeyDataConfig("legislacao.bidirecional");
    var valor = getCookie(chave);

    if (valor === "") {

        var padrao;

        swal({
            title: "Criar Relação Bidirecional?",
            html: "Deseja que o relacionamento entre a legislação atual e a legislação com título <b>" + relacionada.titulo + "<b> seja bidirecional?",
            type: 'question',
            input: 'checkbox',
            inputValue: 0,
            inputPlaceholder: ' Tornar esta decisão como padrão.',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then((result) => {
            if (result.value) {
                console.log(result.log);
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {

            }
        });
    } else {
        relacionarLegislacao(relacionada.id, valor);
    }

}

function definirBidirecionalPadrao(bidirecional) {
    bidirecional = (bidirecional == 1);
    setCookie(chave, bidirecional);
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
        var destino = 'relacionamentos';
        var mensagem = data.mensagem;

        if (data.sucesso) {
            window.location = '/admin/legislacao/refresh/' + destino + "::" + mensagem;
        } else {
            window.location = '/admin/legislacao/rollback/' + destino + "::" + mensagem;
        }
    }).fail(function () {
        swal({
            title: "Erro!",
            html: 'Ocorreu um erro ao fazer ligação entre documentos da ouvidoria',
            type: 'error'
        });
    });
}

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (120 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires;
}

