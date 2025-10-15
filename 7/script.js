
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		bgs				= {
							'TEMPLATE-1' : 'templates/templates/config-oferta_A.jpg',
							'TEMPLATE-2' : 'templates/templates/config-oferta_B.jpg',
							'TEMPLATE-3' : 'templates/templates/config-oferta_C.png',
							'TEMPLATE-4' : 'templates/templates/config-oferta_D.png',
							'TEMPLATE-5' : 'templates/templates/config-evento.png',
							'TEMPLATE-6' : 'templates/templates/config-horarios.jpg',
							},
		templateConfig	= $('.template-config'),
		fieldsHorarios 	= $('.fields-horarios'),
		fieldsOfertas 	= $('.fields-ofertas'),
		priceField		= $('.field-price'),
		claimField		= $('.field-claim'),
		imgSelector		= $('#IMG'),
		submitBtn		= $('#SUBMIT'),
		activeTemplate	= templates.filter('[checked]').val(),
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

		switch( templateNumber ) {
			// Oferta sin claim
			case 1:
				fieldsHorarios.hide();
					claimField.hide();
					priceField.show();
				fieldsOfertas.show();
				templateConfig.addClass('oferta');
				templateConfig.removeClass('oferta_con_claim oferta_con_bg evento horarios');
				$('#CONFIG').slideDown();
				break;

			// Oferta con claim
			case 2:
				fieldsHorarios.hide();
					claimField.show();
					priceField.show();
				fieldsOfertas.show();
				templateConfig.addClass('oferta oferta_con_claim');
				templateConfig.removeClass('oferta_con_bg evento horarios');
				$('#CONFIG').slideDown();
				break;

			// Oferta sin claim y bg img
			case 3:
				fieldsHorarios.hide();
					claimField.hide();
					priceField.show();
				fieldsOfertas.show();
				templateConfig.addClass('oferta oferta_con_bg');
				templateConfig.removeClass('oferta_con_claim evento horarios');
				$('#CONFIG').slideDown();
				break;

			// Oferta con claim y bg img
			case 4:
				fieldsHorarios.hide();
					claimField.show();
					priceField.show();
				fieldsOfertas.show();
				templateConfig.addClass('oferta oferta_con_bg oferta_con_claim');
				templateConfig.removeClass('evento horarios');
				$('#CONFIG').slideDown();
				break;

			// Evento
			case 5:
				fieldsHorarios.hide();
					claimField.show();
					priceField.hide();
				fieldsOfertas.show();
				templateConfig.addClass('evento oferta_con_bg');
				templateConfig.removeClass('oferta oferta_con_claim horarios');
				$('#CONFIG').slideDown();
				break;

			// Horarios
			case 6:
				fieldsHorarios.show();
				fieldsOfertas.hide();
				templateConfig.addClass('horarios');
				templateConfig.removeClass('oferta oferta_con_claim oferta_con_bg evento');
				$('#CONFIG').slideDown();
				break;

			default:
				$('#CONFIG').slideUp();
		}

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
				'facebook'	: $('#FACEBOOK').is(':checked'),
				'twitter'	: $('#TWITTER').is(':checked'),
				'pinterest'	: $('#PINTEREST').is(':checked'),
				'youtube'	: $('#YOUTUBE').is(':checked'),
				'linkedin'	: $('#LINKEDIN').is(':checked')
			},
			templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= addMsg( fields['farmacia'], 'el nombre de la farmacia' );

		switch( templateNumber ) {
			// Oferta sin claim
			case 1:
				validationMsg += addMsg( fields['name'], 'el nombre del producto' );
				validationMsg += addMsg( fields['desc'], 'la descripción del producto' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;

			// Oferta con claim
			case 2:
				validationMsg += addMsg( fields['name'], 'el nombre del producto' );
				validationMsg += addMsg( fields['desc'], 'la descripción del producto' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				validationMsg += addMsg( fields['claim'], 'el eslogan' );
				break;

			// Oferta sin claim y bg img
			case 3:
				validationMsg += addMsg( fields['name'], 'el nombre de la oferta' );
				validationMsg += addMsg( fields['desc'], 'la descripción de la oferta' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;

			// Oferta con claim y bg img
			case 4:
				validationMsg += addMsg( fields['name'], 'el nombre de la oferta' );
				validationMsg += addMsg( fields['desc'], 'la descripción de la oferta' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				validationMsg += addMsg( fields['claim'], 'el eslogan' );
				break;

			// Evento
			case 5:
				validationMsg += addMsg( fields['name'], 'el nombre del evento' );
				validationMsg += addMsg( fields['desc'], 'la descripción del evento' );
				validationMsg += addMsg( fields['claim'], 'la fecha del evento' );
				break;

			// Horarios
			case 6:
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
				container.css('background-size', 'contain');
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function addMsg ( myVal, text ) {
		return !myVal ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);