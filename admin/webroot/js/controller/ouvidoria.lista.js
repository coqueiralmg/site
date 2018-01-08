$(function () {
    $('#data_inicial').datepicker({
        language: 'pt-BR'
    });

    $('#data_final').datepicker({
        language: 'pt-BR'
    });

    $('#data_inicial').mask('00/00/0000');
    $('#data_final').mask('00/00/0000');
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

function verificarManifestacao(id){
    var url = "/admin/manifestacao/get/" + id + ".json";

    swal({
        text: 'Aguarde, carregando!',
        onOpen: function () {
            var s = swal;
            s.showLoading();
            $.get(url, function(data){
                s.close();
                
                var manifestacao = data.manifestacao;
                var numeroPad = zeroPad(id, 7);
                var assunto = manifestacao.assunto;
                var texto = manifestacao.texto;
        
                swal({
                    html: "Você deseja atender a manifestação <b>" + numeroPad + "</b <b>, com o assunto " + assunto + "</b>? Veja a mensagem da manifestação abaixo, para tirar conclusões. A recusa tornará a operação irreversível.",
                    type: 'question',
                    input: "textarea",
                    inputValue: texto,
                    inputAttributes: {
                        rows: 10
                    },
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Aceitar',
                    cancelButtonText: 'Recusar'
                }).then(function () {
                    var url ="/admin/manifestacao/aceitar.json";

                    $.post(url, {
                        id: id
                    }, function(data){

                        if(data.sucesso){
                            var destino = 'index';
                            var mensagem = 'Você aceitou com sucesso, a manifestação ' + numeroPad;
                            window.location = '/admin/ouvidoria/refresh/' + destino + "::" + mensagem;
                        }

                        
                    }).fail(function (){
                        swal({
                            title: "Erro!",
                            html: 'Ocorreu um erro ao aceitar a manifestação de ouvidoria',
                            type: 'error'
                        });
                    });

                }, function(dismiss){
                    if (dismiss === 'cancel') {
                        swal.resetDefaults();
                        exibirMotivoRecusaManifestacao(id);
                    }
                });
        
            }).fail(function(){
                swal({
                    title: "Erro!",
                    html: 'Ocorreu um erro ao carregar os dados de manifestação',
                    type: 'error'
                });
            });
        }
    });
}

function recusarManifestacao(id){
    var url = "/admin/manifestacao/get/" + id + ".json";
    
    swal({
        text: 'Aguarde, carregando!',
        onOpen: function () {
            var s = swal;
            s.showLoading();
            $.get(url, function(data){
                s.close();
                
                var manifestacao = data.manifestacao;
                var numeroPad = zeroPad(id, 7);
                var assunto = manifestacao.assunto;
                var texto = manifestacao.texto;
        
                swal({
                    html: "Você tem certeza que deseja recusar a manifestação <b>" + numeroPad + "</b <b>, com o assunto " + assunto + "</b>? Veja a mensagem da manifestação abaixo. A recusa tornará a operação irreversível.",
                    type: 'warning',
                    input: "textarea",
                    inputValue: texto,
                    inputAttributes: {
                        rows: 10
                    },
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then(function () {
                    swal.resetDefaults();
                    exibirMotivoRecusaManifestacao(id);
                });
            });
        }
    });
}

function exibirMotivoRecusaManifestacao(id){
    swal({
        title: "Por que você quer recusar esta manifestação?",
        html: "Digite abaixo com todos os detalhes possíveis, o motivo da recusa de atendimento a este manifesto e clique em Finalizar. A justificativa estará disponível para consulta, pelo manifestante.",
        type: 'warning',
        input: "textarea",
        inputAttributes: {
            rows: 10,
            name: 'justificativa'
        },
        inputValidator: function(result){
            return new Promise(function(resolve, reject){
                if(result){
                    resolve();
                } else {
                    reject("Você precisa informar o motivo da recusa do atendimento.");
                }
            });
        },
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Finalizar',
        cancelButtonText: 'Cancelar'
    }).then(function (justificativa) {
        var url ="/admin/manifestacao/recusar.json";
        
        $.post(url, {
            id: id,
            justificativa: justificativa
        }, function(data){
            if(data.sucesso){
                var numeroPad = zeroPad(id, 7);
                var destino = 'index';
                var mensagem = 'Você rejeitou a manifestação ' + numeroPad;
                window.location = '/admin/ouvidoria/refresh/' + destino + '::' + mensagem;
            }
            
        }).fail(function (){
            swal({
                title: "Erro!",
                html: 'Ocorreu um erro ao rejeitar a manifestação de ouvidoria',
                type: 'error'
            });
        });
    });
}

function fecharManifestacao(id){
    var url = "/admin/manifestacao/get/" + id + ".json";
    
    swal({
        text: 'Aguarde, carregando!',
        onOpen: function () {
            var s = swal;
            s.showLoading();
            $.get(url, function(data){
                s.close();
                
                var manifestacao = data.manifestacao;
                var numeroPad = zeroPad(id, 7);
                var assunto = manifestacao.assunto;
        
                swal({
                    html: "Você tem certeza que deseja fechar a manifestação <b>" + numeroPad + "</b <b>, com o assunto " + assunto + "</b>? O fechamento desta manifestação, tornará a operação irreversível.",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then(function () {
                    var url ="/admin/manifestacao/fechar.json";
                    
                    $.post(url, {
                        id: id
                    }, function(data){
                        if(data.sucesso){
                            var numeroPad = zeroPad(id, 7);
                            var destino = 'index';
                            var mensagem = 'A manifestação ' + numeroPad + " foi fechada com sucesso!";
                            window.location = '/admin/ouvidoria/refresh/' + destino + "::" +  mensagem;
                        }
                        
                    }).fail(function (){
                        swal({
                            title: "Erro!",
                            html: 'Ocorreu um erro ao fechar a manifestação de ouvidoria',
                            type: 'error'
                        });
                    });
                });
            }).fail(function(){
                swal({
                    title: "Erro!",
                    html: 'Ocorreu um erro ao carregar os dados de manifestação',
                    type: 'error'
                });
            });
        }
    });
}

function exibirManifestante(id){
    var url = "/admin/manifestante/get/" + id + ".json";
    
    swal({
        text: 'Aguarde, carregando!',
        onOpen: function () {
            var s = swal;
            s.showLoading();
            $.get(url, function(data){
                s.close();

                var manifestante = data.manifestante;
                
                var conteudo = "<b>Nome: </b>" + manifestante.nome + "<br/>";
                conteudo = conteudo + "<b>E-mail: </b>" + manifestante.email + "<br/>";
                conteudo = conteudo + "<b>Telefone: </b>" + manifestante.telefone + "<br/>";
                conteudo = conteudo + "<b>Endereço: </b>" + manifestante.endereco + "<br/>";
                conteudo = conteudo + "<b>Bloqueado: </b>" + (manifestante.bloqueado ? "Sim" : "Não") + "<br/>";
        
                swal({
                    title: "Dados do manifestante",
                    html: conteudo,
                    type: 'info'
                });
            }).fail(function(){
                swal({
                    title: "Erro!",
                    html: 'Ocorreu um erro ao carregar os dados do manifestante.',
                    type: 'error'
                });
            });
        }
    });
}

function zeroPad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
  }