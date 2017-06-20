$(function(){

	var $form 		= $("div.container div.row form");
	var $mensagem 	= $("div#mensagem");

	$form.on('click', '#btn-entrar', function(e){
		e.preventDefault();

		var verificaForm = verificarCamposForm($form);
        if (verificaForm.existeCampoVazio) {
            $mensagem.html('<span>' + verificaForm.mensagem + '</span>');
        }else{

	    	$.ajax({
				url: '/admin/logar',
				type: 'post',
				dataType: 'json',
				data: $form.serialize(),
				beforeSend: function(){
					$mensagem.html('<span><img src="./public/img/ajax-loader.gif" /> Efetuando login...</span>');
				},
				success: function(data){
					if(data === 'logou'){
						$mensagem.html('<span><img src="./public/img/ajax-loader.gif" /> Entrando...</span>');
						window.location.href = '/admin/painel';
					}else if(data === 'nlogou'){
						$mensagem.html('<span>Usuário ou senha inválidos!</span>');
					}else if(data === 'nsessao'){
						$mensagem.html('<span>Erro ao iniciar sessão!</span>');
					}else{
						$mensagem.html('<span>Erro inesperado, tente novamente!</span>');
					}
				}
			});

        }

	});

});