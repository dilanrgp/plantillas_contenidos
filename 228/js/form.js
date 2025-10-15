(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		activeTemplate		= templates.filter('[checked]').val(),
		templateConfig		= $('.template-config'),
		promosConfig		= $('.config-container'),
		pricesConfig		= $('.config_precios-container'),			
		blocks			= {
							'ofertas' 	: $('.fields-ofertas'),
							'info2'		: $('#INFO_2'),
							'imagen'	: $('.fields-img'),
							'img_preview'	: $('.img-preview')
						},
		fields			= {
							'SUBPRICE'		: $('#SUBPRICE'),
							'PRICE'			: $('#PRICE'),
							'DESCRIPCION'	: $('#DESCRIPCION'),
							'SUBDESCRIPCION': $('#SUBDESCRIPCION'),
							'CLAIM'			: $('#CLAIM'),
							'LEGAL'			: $('#LEGAL'),
							'IMG'			: $('#IMG'),
							'imagenamostrar': $('#imagenamostrar'),
							'DIESEL'		: $('#PRICE_DIESEL'),
							'GASOLINA'		: $('#PRICE_GASOLINA')							
						},
		bgs_h			= {
							'TEMPLATE-5' : 'img/bg_price.png',			
							'TEMPLATE-1' : 'img/templates/config-oferta_1.jpg',
							'TEMPLATE-2' : 'img/templates/config-oferta_2.jpg',
							'TEMPLATE-3' : 'img/templates/config-oferta_3.jpg',
							'TEMPLATE-4' : 'img/templates/config-mensaje.jpg',
						},
		submitBtn		= $('#SUBMIT'),
		bg;

		
	changeForm( activeTemplate );

	templates.on('change', function(e) {
		activeTemplate = $(this).val();
		changeForm( activeTemplate );
	});

	blocks['img_preview'].on('click', function(e) {
		fields['IMG'].trigger('click');
	});
	
	blocks['img_preview'].on('change', function(e) {
		readURL(this, '.bg-image, .img-preview');
	});

	fields['IMG'].on('change', function(e) {
		readURL(this, '.bg-image, .img-preview');
		readURL(this, '#imagenamostrar');
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

	function setBG( template ) {
		bg = bgs_h[ template ];

		templateConfig.css('background-image', 'url(' + bg + ')');
	}

	function changeForm ( template ) {
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		clearValidation();

		templateConfig.removeClass('offer offer_1 offer_2 offer_3 message');
		promosConfig.show();
		pricesConfig.hide();
		setBG( template );

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				templateConfig.addClass('offer offer_1');
				blocks['ofertas'].show();
				blocks['info2'].hide();
				blocks['img_preview'].show();
				blocks['imagen'].show();
				break;

			// Oferta 2
			case 2:
				templateConfig.addClass('offer offer_2');
				blocks['ofertas'].show();
				blocks['info2'].hide();
				blocks['img_preview'].show();
				blocks['imagen'].show();
				break;
			// Oferta 2
			case 3:
				templateConfig.addClass('offer offer_3');
				blocks['ofertas'].show();
				blocks['info2'].show();
				blocks['img_preview'].show();
				blocks['imagen'].show();
				break;

			// Mensaje
			case 4:
				templateConfig.addClass('message');
				blocks['ofertas'].hide();
				blocks['info2'].hide();
				blocks['img_preview'].hide();
				blocks['imagen'].hide();
				break;
			// Precios
			case 5:
				promosConfig.hide();
				pricesConfig.show();
				blocks['imagen'].hide();
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
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				validationMsg += addMsg( fields['imagenamostrar'], 'la imagen' );
				break;

			// Oferta 2
			case 2:
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				validationMsg += addMsg( fields['imagenamostrar'], 'la imagen' );
				break;

			// Oferta 3
			case 3:
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				validationMsg += addMsg( fields['imagenamostrar'], 'la imagen' );
				break;

			// Mensaje
			case 4:
				validationMsg += addMsg( fields['CLAIM'], 'el mensaje' );
				break;

			// Precios gasolina
			case 5:
				validationMsg += addMsg( fields['DIESEL'], 'el precio del diesel' );
				validationMsg += addMsg( fields['GASOLINA'], 'el precio de la gasolina' );
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
	    if (input.files && input.files[0] && container !== '#imagenamostrar') {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $(container).css('background-image', 'url(' + e.target.result + ')');
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else if (input.files && input.files[0] && container === '#imagenamostrar') {
			console.log(input.files[0])
			$(container).val(input.files[0].name)
		}
	}

	function addMsg ( myVal, text ) {
		return !myVal.val().trim() ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);