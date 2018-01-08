function banirManifestante(id, referencia){
    var url = "/admin/manifestante/get/" + id + ".json";
    
    swal({
        text: 'Aguarde, carregando!',
        onOpen: function () {
            var s = swal;
            s.showLoading();
            $.get(url, function(data){
                s.close();
                
                var manifestante = data.manifestante;
                var nome = manifestante.nome;
        
                swal({
                    html: "Você tem certeza que deseja bloquear o manifestante <b>" + nome + "</b>?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then(function () {
                    swal.resetDefaults();
                    var url ="/admin/manifestante/ban.json";

                    $.post(url, {
                        id: id
                    }, function(data){
                        if(data.sucesso){
                            var mensagem = 'Você bloqueou a manifestante ' + nome + ' com sucesso!';

                            if(referencia == 'manifestante'){
                                var destino = referencia + "::" + id;
                                window.location = '/admin/ouvidoria/update/' + destino + '::' + mensagem;
                            } else {
                                var destino = referencia;
                                window.location = '/admin/ouvidoria/refresh/' + destino + '::' + mensagem;
                            }
                        }                        
                    }).fail(function (){
                        swal({
                            title: "Erro!",
                            html: 'Ocorreu um erro ao desbloquear o manifestante de ouvidoria.',
                            type: 'error'
                        });
                    });
                });
            });
        }
    });
}

function desbloquearManifestante(id, referencia){
    var url = "/admin/manifestante/get/" + id + ".json";
    
    swal({
        text: 'Aguarde, carregando!',
        onOpen: function () {
            var s = swal;
            s.showLoading();
            $.get(url, function(data){
                s.close();
                
                var manifestante = data.manifestante;
                var nome = manifestante.nome;
        
                swal({
                    html: "Você tem certeza que deseja desbloquear o manifestante <b>" + nome + "</b>?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then(function () {
                    swal.resetDefaults();
                    var url ="/admin/manifestante/release.json";

                    $.post(url, {
                        id: id
                    }, function(data){
                        if(data.sucesso){
                            var mensagem = 'Você desbloqueou a manifestante ' + nome + ' com sucesso!';

                            if(referencia == 'manifestante'){
                                var destino = referencia + "::" + id;
                                window.location = '/admin/ouvidoria/update/' + destino + '::' + mensagem;
                            } else {
                                var destino = referencia;
                                window.location = '/admin/ouvidoria/refresh/' + destino + '::' + mensagem;
                            }
                        }                        
                    }).fail(function (){
                        swal({
                            title: "Erro!",
                            html: 'Ocorreu um erro ao desbloquear o manifestante de ouvidoria.',
                            type: 'error'
                        });
                    });
                });
            });
        }
    });
}