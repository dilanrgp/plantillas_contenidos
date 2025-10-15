(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		activeTemplate		= templates.filter('[checked]').val(),
		templateConfig		= $('.template-config'),
		blocks			= {
							'ofertas' 	: $('.fields-ofertas'),
							'opciones'	: $('.fields-desc_config'),
							'imagen'	: $('.fields-img'),
							'img_preview'	: $('.img-preview')
						},
		fields			= {
							'DESCRIPCION'	: $('#DESCRIPCION'), 
							'SUBDESCRIPCION'	: $('#SUBDESCRIPCION'), 
							'PRICE'			: $('#PRICE'), 
							'SUBPRICE'		: $('#SUBPRICE'), 
							'CLAIM'			: $('#CLAIM'), 
							'LEGAL'			: $('#LEGAL'), 
							'IMG'			: $('#IMG')
						},
		options			= {
							'ppu'	: $('#CON_UD'),
							'claim'	: $('#CON_CLAIM'),
							'orientation'	: $('#ORIENTATION')
						},
		bgs_h			= {
							'TEMPLATE-1' : 'img/templates/config-oferta_1.jpg',
							'TEMPLATE-1B' : 'img/templates/config-oferta_1_b.jpg',
							'TEMPLATE-2' : 'img/templates/config-oferta_2.jpg',
							'TEMPLATE-3' : 'img/templates/config-mensaje.jpg',
						},
		bgs_v			= {
							'TEMPLATE-1' : 'img/templates/config-oferta_1_V.jpg',
							'TEMPLATE-1B' : 'img/templates/config-oferta_1_b_V.jpg',
							'TEMPLATE-2' : 'img/templates/config-oferta_2_V.jpg',
							'TEMPLATE-3' : 'img/templates/config-mensaje_V.jpg',
						},
		submitBtn		= $('#SUBMIT'),
		bg;


	changeForm( activeTemplate );

	templates.on('change', function(e) {
		activeTemplate = $(this).val();
		changeForm( activeTemplate );
	});

	options['orientation'].on('change', checkPreviewOrientation);

	blocks['img_preview'].on('click', function(e) {
		fields['IMG'].trigger('click');
	});

	fields['IMG'].on('change', function(e) {
		readURL(this, $('.bg-image, .img-preview'));
	});

	options['ppu'].on('change', function(e) {
		checkPPU();
	});

	options['claim'].on('change', function(e) {
		checkClaim();
	});

	submitBtn.on('click', function(e) {
		e.preventDefault();
		clearValidation();

		var msg = validateForm( activeTemplate );

		if( msg.length )
			$('.validation').html( msg );
		else
			$('#TEMPLATE_FORM').submit();
	});

	$('.cerrar').on('click', function(e) {
		parent.postMessage({message: "close"}, "*");
	});
	function checkPreviewOrientation() {
		if( options['orientation'].is(':checked') ) {
			$('.config-container').addClass('vertical');
		} else {
			$('.config-container').removeClass('vertical');
		}

		setBG( activeTemplate );
		if( activeTemplate === 'TEMPLATE-1') checkClaim();
	}

	function checkPPU() {
		options['ppu'].is(':checked') ? $('.ud').show() : $('.ud').hide();
	}

	function checkClaim() {
		var template = '';

		if( options['claim'].is(':checked') ) {
			fields['CLAIM'].show();
			template = activeTemplate;
			templateConfig.removeClass('no_claim');
		} else {
			fields['CLAIM'].hide();
			template = 'TEMPLATE-1B';
			templateConfig.addClass('no_claim');
		}

		setBG( template );
	}
	
	function setBG( template ) {
		bg = options['orientation'].is(':checked') ? bgs_v[ template ] : bgs_h[ template ];

		templateConfig.css('background-image', 'url(' + bg + ')');
	}

	function changeForm ( template ) {
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		clearValidation();
		checkPreviewOrientation();

		templateConfig.removeClass('offer offer_1 offer_2 no_claim message');
		
		setBG( template );		

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				templateConfig.addClass('offer offer_1');
				blocks['ofertas'].show();
				blocks['opciones'].show();
					options['claim'].parent().show();
					checkClaim();
					checkPPU();
				blocks['imagen'].show();
				blocks['img_preview'].show();
				fields['LEGAL'].show();
				break;

			// Oferta 2
			case 2:
				templateConfig.addClass('offer offer_2');
				blocks['ofertas'].show();
				blocks['opciones'].show();
					options['claim'].parent().hide();
					checkPPU();
				blocks['imagen'].show();
				blocks['img_preview'].show();
				fields['LEGAL'].show();
				break;

			// Mensaje
			case 3:
				templateConfig.addClass('message');
				blocks['ofertas'].hide();
				blocks['opciones'].hide();
				blocks['imagen'].hide();
				blocks['img_preview'].hide();
				fields['LEGAL'].hide();
				fields['CLAIM'].show();
				break;
								
			default:
				$('#CONFIG').slideUp();
		}
		
		if(!(template === undefined)) $('#CONFIG').slideDown();
	}

	function validateForm ( template ) {
		var templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= '';


		switch( templateNumber ) {
			// Oferta 1
			case 1:
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				// validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += options['claim'].is(':checked') ? addMsg( fields['CLAIM'], 'el mensaje' ) : '';
				validationMsg += addMsg( fields['IMG'], 'la imagen' );
				break;
				
			// Oferta 2
			case 2:
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				// validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['IMG'], 'la imagen' );
				break;
				
			// Mensaje
			case 3:
				validationMsg += addMsg( fields['CLAIM'], 'el mensaje' );
				break;

			default:
				validationMsg = '<p>Si ves esto es que has hecho trampa!!!</p>';
		}

		return validationMsg;
	}

	function clearValidation () {
		$('.validation').html('');
	}

	function readURL(input, container) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            container.css('background-image', 'url(' + e.target.result + ')');
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function addMsg ( myVal, text ) {
		return !myVal.val().trim() ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}

	$(document).ready(function() {
		activeTemplate		= $('input[name="TEMPLATE"]:checked').val();
		changeForm( activeTemplate );
	});
})(jQuery);