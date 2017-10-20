jQuery(function($) {'use strict',

	//#main-slider
	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 5000
		});
	});


	// accordian
	$('.accordion-toggle').on('click', function(){
		$(this).closest('.panel-group').children().each(function(){
		$(this).find('>.panel-heading').removeClass('active');
		 });

	 	$(this).closest('.panel-heading').toggleClass('active');
	});

	//Initiat WOW JS
	new WOW().init();

	// portfolio filter
	$(window).load(function(){'use strict';
		var $portfolio_selectors = $('.portfolio-filter >li>a');
		var $portfolio = $('.portfolio-items');
		$portfolio.isotope({
			itemSelector : '.portfolio-item',
			layoutMode : 'fitRows'
		});
		
		$portfolio_selectors.on('click', function(){
			$portfolio_selectors.removeClass('active');
			$(this).addClass('active');
			var selector = $(this).attr('data-filter');
			$portfolio.isotope({ filter: selector });
			return false;
		});
	});

		
	//goto top
	$('.gototop').click(function(event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: $("body").offset().top
		}, 500);
	});	

	//Pretty Photo
	$("a[rel^='prettyPhoto']").prettyPhoto({
		social_tools: false
	});

	$('[data-toggle="popover"]').popover();
});

function efetuarBusca(e) {
	
	if(e != null && e.keyCode != 13) 
		return true;
	
	if($("#chave-topo").val() === ""){
		swal(
			'Atenção',
			'Por favor, digite a chave de busca.',
			'warning'
		);

	} else {
		if($("#chave-topo").val().length > 3){
			LE.info("O usuário buscou " + $("#busca").val() + " no site.");
			$("#formBusca").submit();

			return true;
		} else {
			swal(
				'Atenção',
				'Recomendamos que a busca tenha mais de 3 caracteres.',
				'warning'
			);	
		}
		
	}

	return false;
}

function enviarMensagem() {
	 var response = grecaptcha.getResponse(); 

	 if(response == null || response == ""){
		swal(
			'Atenção',
			'Por favor, prove à Prefeitura de Coqueiral de que você não é um robô.',
			'warning'
		);	

		return false;
	 }

	 return true;
}

