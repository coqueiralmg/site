$(function(){

	// form pesquisar
	$('#pesquisar-legislacao #btn-pesquisar').on('click', function(e){
		e.preventDefault();
		var busca = $(this).siblings("#pesquisa").val();
		if(busca !== ''){
			LE.info('O usuário buscou ' + busca + ' entre as licitações no site.');
            ga('send', 'event', 'Licitações', 'Busca', busca);
			window.location.href = "/licitacoes/page/1/limit/10/search/" + busca;
		}else{
			alert('Digite sua busca!');
		}
	});

	// paginacao redirecionar com busca
	$('div#legislacoes div div#paginacao nav ul li a').on('click', function(e){
		e.preventDefault();
		var href = window.location.href;
		var split = href.split('search/');
		var linkPagination = $(this).attr('href');
		if(split.length === 2){
			window.location.href = linkPagination + "/search/" + split[1];
		}else{
			window.location.href = linkPagination;
		}
	});

});