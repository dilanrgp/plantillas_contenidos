
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		bgs				= {
							'TEMPLATE-1' : 'templates/templates/config-producto_S.jpg',
							'TEMPLATE-2' : 'templates/templates/config-producto_L.jpg',
							'TEMPLATE-3' : 'templates/templates/config-evento.jpg',
							'TEMPLATE-4' : 'templates/templates/config-horarios.jpg',
							},
		templateConfig	= $('.template-config'),
		fieldsHorarios 	= $('.fields-horarios'),
		fieldsOfertas 	= $('.fields-ofertas'),
		imageField		= $('.field-img'),
		imgSelector		= $('#IMG'),
		submitBtn		= $('#SUBMIT'),
		activeTemplate	= templates.filter('[checked]').val();
		selectedImg		= '';

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

		templateConfig.removeClass('oferta oferta_L evento horarios');

		fieldsOfertas.show();
		fieldsHorarios.hide();
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
				templateConfig.addClass('oferta oferta_L evento');
				break;

			// Horarios
			case 4:
				fieldsHorarios.show();
				fieldsOfertas.hide();
				imageField.hide();
				templateConfig.addClass('horarios');
				break;
				
			default:
				$('#CONFIG').slideUp();
		}

		if(!(template === undefined)) $('#CONFIG').slideDown();

		templateConfig.css('background-image', 'url(' + newBG + ')');
	}

	function validateForm ( template ) {
		var fields = {
				'farmacia'	: $('#NOMBRE_FARMACIA').val().trim(),
				'name'		: $('#TITLE').val().trim(),
				'desc'		: $('#CONTENT').val().trim(),
				'price'		: $('#PRICE').val().trim(),
				'claim'		: $('#CLAIM').val().trim(),
				'img'		: $('#IMG').val(),
				'horario_1'	: $('#HORARIO_1').val().trim(),
				'horario_2'	: $('#HORARIO_2').val().trim(),
				'horario_3'	: $('#HORARIO_3').val().trim(),
				'tel'		: $('#TEL').val().trim(),
				'facebook'	: $('#FACEBOOK').is(':checked'),
				'twitter'	: $('#TWITTER').is(':checked'),
				'instagram'	: $('#INSTAGRAM').is(':checked'),
				'pinterest'	: $('#PINTEREST').is(':checked'),
				'youtube'	: $('#YOUTUBE').is(':checked'),
				'linkedin'	: $('#LINKEDIN').is(':checked')
			},
			templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= addMsg( fields['farmacia'], 'el nombre de la farmacia' );

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
				validationMsg += addMsg( fields['name'], 'el nombre del evento' );
				validationMsg += addMsg( fields['img'], 'la imagen' );
				validationMsg += addMsg( fields['price'], 'la fecha del evento' );
				break;

			// Horarios
			case 4:
				if( !fields['horario_1'] && !fields['horario_2'] && !fields['horario_3'] )
					validationMsg += '<p>Tienes que rellenar al menos una línea de horarios.</p>';
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
				selectedImg = e.target.result;
	            container.css('background-image', 'url(' + e.target.result + ')');
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function addMsg ( myVal, text ) {
		return !myVal ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);