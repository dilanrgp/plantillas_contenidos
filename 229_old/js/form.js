(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		activeTemplate	= templates.filter('[checked]').val(),
		templateConfig	= $('.template-config'),
		blocks			= {
							'producto2'	: $('#PRODUCTO_2'),
							'price'		: $('.field-price'),
							'extras'	: $('.extra-fields'),
							'img_preview'	: $('.img-preview')
						},
		fields			= {
							'DESCRIPCION'	: $('#DESCRIPCION'),
							'SUBDESCRIPCION'	: $('#SUBDESCRIPCION'),
							'PRICE'			: $('#PRICE'),
							'LEGAL'			: $('#LEGAL'),
							'imagenamostrar': $('#imagenamostrar'),
							'IMG'			: $('#IMG')
						},
		orientation		= $('#ORIENTATION'),
		multiproduct	= $('#MULTIPRODUCT'),
		bgs_h			= {
							'TEMPLATE-1' : 'img/templates/config-oferta_1.jpg',
							'TEMPLATE-2' : 'img/templates/config-oferta_2.jpg',
							'TEMPLATE-3' : 'img/templates/config-mensaje.jpg',
						},
		bgs_v			= {
							'TEMPLATE-1' : 'img/templates/config-oferta_1_V.jpg',
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

	orientation.on('change', checkPreviewOrientation);
	multiproduct.on('change', toggleProduct);

	blocks['img_preview'].on('click', function(e) {
		fields['IMG'].trigger('click');
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

	function checkPreviewOrientation() {
		if( orientation.is(':checked') ) {
			$('.config-container').addClass('vertical');
		} else {
			$('.config-container').removeClass('vertical');
		}

		setBG( activeTemplate );
	}

	function toggleProduct() {
		if( multiproduct.is(':checked') ) {
			blocks['producto2'].show();
			$('.fields-ofertas').addClass('product__2');
		} else {
			blocks['producto2'].hide();
			$('.fields-ofertas').removeClass('product__2');
		}
	}

	function setBG( template ) {
		bg = orientation.is(':checked') ? bgs_v[ template ] : bgs_h[ template ];

		templateConfig.css('background-image', 'url(' + bg + ')');
	}

	function changeForm ( template ) {
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		clearValidation();
		checkPreviewOrientation();
		toggleProduct();

		templateConfig.removeClass('offer offer_1 offer_2 no_claim message');

		setBG( template );

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				templateConfig.addClass('offer offer_1');
				blocks['price'].show();
				blocks['extras'].show();
				blocks['img_preview'].show();
				fields['LEGAL'].show();
				break;

			// Oferta 2
			case 2:
				templateConfig.addClass('offer offer_2');
				blocks['price'].show();
				blocks['extras'].show();
				blocks['img_preview'].show();
				fields['LEGAL'].show();
				break;

			// Mensaje
			case 3:
				templateConfig.addClass('message');
				blocks['producto2'].hide();
				blocks['price'].hide();
				blocks['extras'].hide();
				blocks['img_preview'].hide();
				fields['LEGAL'].hide();
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
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['imagenamostrar'], 'la imagen' );
				break;

			// Oferta 2
			case 2:
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['imagenamostrar'], 'la imagen' );
				break;

			// Mensaje
			case 3:
				validationMsg += addMsg( fields['SUBDESCRIPCION'], 'el mensaje' );
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
			$(container).val(input.files[0].name);
		}
	}

	function addMsg ( myVal, text ) {
		return !myVal.val().trim() ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);