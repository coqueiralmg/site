var novoManifestante = false;

$(function () {
    $("#tipo").change(function () {
        tratarTipoManifestacao($(this).val());
    });

    $("#manifestante").select2();
});

function tratarTipoManifestacao(tipo) {
    if (novoManifestante) {
        if (tipo == 'IP') {
            $("#panel_novo_geral").hide();
            $("#panel_novo_iluminacao").show();
        } else if (tipo == 'GR') {
            $("#panel_novo_iluminacao").hide();
            $("#panel_novo_geral").show();
        } else {
            $("#panel_novo_iluminacao").hide();
            $("#panel_novo_geral").hide();
            $("#panel_escolha").show();
            novoManifestante = false;
        }
    }
}

function toggleManifestante() {
    var tipo = $("#tipo").val();

    if (novoManifestante) {
        $("#panel_novo_iluminacao").hide();
        $("#panel_novo_geral").hide();
        $("#panel_escolha").show();
        novoManifestante = false;
    } else {
        if (tipo == 'IP') {
            $("#panel_escolha").hide();
            $("#panel_novo_iluminacao").show();
            novoManifestante = true
        } else if (tipo == 'GR') {
            $("#panel_escolha").hide();
            $("#panel_novo_geral").show();
            novoManifestante = true
        } else {
            tratarTipoManifestacaoCadastro();
        }
    }
}

function tratarTipoManifestacaoCadastro() {
    swal({
        title: "Qual é o tipo de ouvidoria?",
        html: "Antes de cadastrar o novo manifestante, primeiro precisa selecionar o tipo de ouvidoria. Selecione o opção abaixo. Caso queira apenas selecionar um manifestante, clique em cancelar e escolha um manifestante.",
        type: 'warning',
        input: 'select',
        inputOptions: {
            'GR': 'Geral',
            'IP': 'Iluminação Pública'
        },
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancelar'
    }).then(function (result) {
        $("#tipo").val(result);
        toggleManifestante();
    });
}

function validar() {
    var mensagem = "";

    if ($("#assunto").val() === "") {
        mensagem += "<li> O assunto da manifestação é obrigatório.</li>";
        $("label[for='assunto']").css("color", "red");
    } else {
        $("label[for='assunto']").css("color", "#aaa");
    }

    if ($("#prioridade").val() === "") {
        mensagem += "<li> A prioridade da manifestação é obrigatória.</li>";
        $("label[for='prioridade']").css("color", "red");
    } else {
        $("label[for='prioridade']").css("color", "#aaa");
    }

    if ($("#tipo").val() === "") {
        mensagem += "<li> O tipo da manifestação é obrigatório.</li>";
        $("label[for='tipo']").css("color", "red");
    } else {
        $("label[for='tipo']").css("color", "#aaa");
    }

    if ($("#mensagem").val() === "") {
        mensagem += "<li> É necessário informar o texto da mensagem da manifestação.</li>";
        $("label[for='mensagem']").css("color", "red");
    } else {
        $("label[for='mensagem']").css("color", "#aaa");
    }

    if (novoManifestante) {
        var tipo = $("#tipo").val();

        if (tipo == "GR") {
            if ($("#nome").val() === "") {
                mensagem += "<li> O nome do manifestante é obrigatório.</li>";
                $("label[for='nome']").css("color", "red");
            } else {
                $("label[for='nome']").css("color", "#aaa");
            }
        } else if (tipo == "IP") {
            if ($("#nome").val() === "") {
                mensagem += "<li> O nome do manifestante é obrigatório.</li>";
                $("label[for='nome']").css("color", "red");
            } else {
                $("label[for='nome']").css("color", "#aaa");
            }

            if ($("#endereco").val() === "") {
                mensagem += "<li> O endereco do manifestante é obrigatório.</li>";
                $("label[for='endereco']").css("color", "red");
            } else {
                $("label[for='endereco']").css("color", "#aaa");
            }

            if ($("#numero").val() === "") {
                mensagem += "<li> O numero da residência do manifestante é obrigatório.</li>";
                $("label[for='numero']").css("color", "red");
            } else {
                $("label[for='numero']").css("color", "#aaa");
            }

            if ($("#bairro").val() === "") {
                mensagem += "<li> O bairro da residência do manifestante é obrigatório.</li>";
                $("label[for='bairro']").css("color", "red");
            } else {
                $("label[for='bairro']").css("color", "#aaa");
            }
        }
    } else {
        if ($("#manifestante").val() === "") {
            mensagem += "<li> É necessário selecionar o nome do manifestante para esta manifestação. Caso não esteja cadastrado, clique em 'Novo Manifestante'.</li>";
            $("label[for='manifestante']").css("color", "red");
        } else {
            $("label[for='manifestante']").css("color", "#aaa");
        }
    }

    if (mensagem == "") {
        $("button[type='submit']").prop('disabled', true);
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
