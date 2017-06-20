$(function(){

	var $btnCancelar = $('#btn-cancelar');

	$btnCancelar.on('click', function(e){
		e.preventDefault();
		var cancelarOperacao = confirm('Deseja sair desta tela? Todos os dados serão perdidos!');
		if(cancelarOperacao)
			window.location.href = $(this).attr('href');
	});

	// deletar geral
	$('body').on('click', '#btn-deletar', function(e){
		e.preventDefault();
		var deletarRegistro = confirm('Deseja deletar este registro?');
		if(deletarRegistro){
			var $this = $(this);
			$.ajax({
				url: $this.attr('href'),
				type: 'DELETE',
				dataType: 'json',
				success: function(data){
					if(data === 'deletou'){
						// pega o tr relativo ao botão clicado
						var $tr = $this.closest('tr');
						// faz manipulação DOM para mostrar mensagem
						$tr.closest('table').siblings('div#saida').children($this.attr('data-element')).attr('class', 'alert alert-success').html(ucFirst($this.attr('data-reference')) + ' deletado com sucesso!').fadeIn(500).delay(4000).fadeOut(500);
						// verifica se o registro que está sendo deletado é o último, se for insere mensagem adequada
						var $tbody = $tr.parent('tbody');
						var qtdVerificar = ($tbody.attr('data-location') === 'listar') ? 1 : 2;
						
						if($tbody.children('tr').length == qtdVerificar){
							// pega qtd de tds na linha para setar o colspan
							var qtdTds = $tr.children('td').length;
							$tr.parent('tbody').html('<tr><td colspan="' + qtdTds + '" align="center">Nenhum(a) ' + $this.attr('data-reference') + ' cadastrado(a)!</td></tr>');
						}else
							$tr.remove();
												
					}else{
						$this.closest('table').siblings('div#saida').children($this.attr('data-element')).attr('class', 'alert alert-danger').html('Erro ao deletar ' + $this.attr('data-reference') + '!').fadeIn(500).delay(4000).fadeOut(500);
						console.log(data);
					}
				}
			});
		}
	});


	// limite de paginacao geral
	$('body div#limitar-registros select').on('change', function(e){
		$this = $(this);
		/*var page;
		try{
			page = /page\/[0-9]+/.exec(window.location.href)[0].split('/')[1];
		}catch(e){
			page = 1;
		}
		window.location.href = siteUrl() + $this.parent().parent().attr('data-url') + '/page/' + page + '/limit/' + $this.val();*/
		window.location.href = siteUrl() + $this.parent().parent().attr('data-url') + '/page/1/limit/' + $this.val();
	});

	// mascara data geral
	$('body .date').mask('99/99/9999');

	// mascara data geral
	$('body .date-hour').mask('99/99/9999 99:99:99');

	// editor de texto
	/*$('body #editor-texto').closest('form').on('submit', function(e){
		e.preventDefault();
		var $this = $(this);
		var $editorTexto = $this.find('div#editor-texto');
		// pega o html do tinyMCE
		var texto = tinyMCE.activeEditor.getContent();
		// seta o texto para o input hidden
		$editorTexto.siblings($editorTexto.attr('data-input')).val(texto);
		$this.submit();
	});*/

});