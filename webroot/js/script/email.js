$(function(){

    // form falar com vereador
	$('#btn-enviar').on('click', function(e){
		e.preventDefault();
        
        var $this = $(this);
        var $form = $('form' + $this.attr('data-form'));
		var $mensagem = $form.find('div#mensagem-form');

		var verificaForm = verificarCamposForm($form);
        if (verificaForm.existeCampoVazio) {
            $mensagem.html(verificaForm.mensagem);
        } else {

        	$.ajax({
        		url: $form.attr('action'),
        		type: 'POST',
        		dataType: 'json',
        		data: $form.serialize(),
        		beforeSend: function(){
        			$mensagem.html('<img src="' + siteUrl() + 'public/img/ajax-loader.gif" /> Aguarde, enviando mensagem...');
        		},
        		success: function(data){
        			if(data === 'enviou'){
        				$mensagem.html('Mensagem enviada com sucesso! <br /> ' + $this.attr('data-msg'));
        			}else if(data === 'nenviou'){
        				$mensagem.html('Erro ao enviar mensagem!');
        			}else if(data === 'nemail'){
        				$mensagem.html('Digite um e-mail válido!');
        			}else{
        				$mensagem.html('Ocorreu um erro inesperado, tente novamente!');
        			}
        		}
        	});
        }

	});

});