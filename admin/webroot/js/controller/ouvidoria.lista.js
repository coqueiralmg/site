var pointer = "http://localhost/admin";

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
    var url = pointer + "/manifestacao/get/" + id + ".json";

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
                        readonly: true,
                        rows: 10
                    },
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Aceitar',
                    cancelButtonText: 'Recusar'
                }).then(function () {
                    alert('Aceito');
                }, function(dismiss){
                    if (dismiss === 'cancel') {
                        alert('Recusado');
                    }
                });
        
            });
        }
    });
}

function recusarManifestacao(id){
    var url = pointer + "/manifestacao/get/" + id + ".json";
    
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
                        readonly: true,
                        rows: 10
                    },
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then(function () {
                    alert('Recusado');
                });
            });
        }
    });
}

function fecharManifestacao(id){
    var url = pointer + "/manifestacao/get/" + id + ".json";
    
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
                    alert('Fechado');
                });
            });
        }
    });
}

function exibirManifestante(id){
    var url = pointer + "/manifestante/get/" + id + ".json";
    
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
            });
        }
    });
}

function zeroPad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
  }