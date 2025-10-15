
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		bgs				= {
							'TEMPLATE-1' : 'img/templates/config-producto_S.jpg',
							'TEMPLATE-2' : 'img/templates/config-producto_L_1.jpg',
							'TEMPLATE-3' : 'img/templates/config-producto_L_2.jpg'
							},
		templateConfig	= $('.template-config'),
		fieldsOfertas 	= $('.fields-ofertas'),
		imageField		= $('.field-img'),
		imgSelector		= $('#IMG'),
		submitBtn		= $('#SUBMIT'),
		activeTemplate	= templates.filter('[checked]').val();

	changeForm( activeTemplate );

	templates.on('change', function(e) {
		activeTemplate = $(this).val();

		clearValidation();
		changeForm( activeTemplate );
	});

	$('.img-preview').on('click', function(e) {
		imgSelector.trigger('click');
	});

	imgSelector.on('change', function(e) {
		readURL(this, $('.bg-image, .img-preview'));
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

	function changeForm ( template ) {
		var newBG = bgs[template],
			templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		templateConfig.removeClass('oferta oferta_S oferta_L oferta_L_2');

		fieldsOfertas.show();
		imageField.show();

		switch( templateNumber ) {
			// Oferta sin claim
			case 1:
				templateConfig.addClass('oferta oferta_S');
				break;

			// Oferta con claim
			case 2:
				templateConfig.addClass('oferta oferta_L');
				break;

			// Evento
			case 3:
				templateConfig.addClass('oferta oferta_L oferta_L_2');
				break;
				
			default:
				$('#CONFIG').slideUp();
		}

		if(!(template === undefined)) $('#CONFIG').slideDown();

		templateConfig.css('background-image', 'url(' + newBG + ')');
	}

	function validateForm ( template ) {
		var fields = {
				'name'		: $('#TITLE').val().trim(),
				'desc'		: $('#CONTENT').val().trim(),
				'price'		: $('#PRICE').val().trim(),
				'claim'		: $('#CLAIM').val().trim(),
				'img'		: $('#IMG').val(),
				'facebook'	: $('#FACEBOOK').is(':checked'),
				'twitter'	: $('#TWITTER').is(':checked'),
				'instagram'	: $('#INSTAGRAM').is(':checked'),
				'pinterest'	: $('#PINTEREST').is(':checked'),
				'youtube'	: $('#YOUTUBE').is(':checked'),
				'linkedin'	: $('#LINKEDIN').is(':checked')
			},
			templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= '';

		switch( templateNumber ) {
			// Oferta img S
			case 1:
				validationMsg += addMsg( fields['name'], 'el nombre del producto' );
				validationMsg += addMsg( fields['img'], 'la imagen' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;
				
			// Oferta img L
			case 2:
				validationMsg += addMsg( fields['name'], 'el nombre del producto' );
				validationMsg += addMsg( fields['img'], 'la imagen' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;
				
			// Evento
			case 3:
				validationMsg += addMsg( fields['name'], 'el nombre del producto' );
				validationMsg += addMsg( fields['img'], 'la imagen' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
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
		return !myVal ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);