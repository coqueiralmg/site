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
    });;

}
