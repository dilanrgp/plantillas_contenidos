
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		bgs				= {
							'TEMPLATE-1' : 'templates/templates/config-oferta_A.jpg',    // TUSUPER
							'TEMPLATE-2' : 'templates/templates/config-oferta_B.jpg',    // SUPERDESCUENTO
							'TEMPLATE-3' : 'templates/templates/config-oferta_C.png',    // SUPERDESCUENTO 3X2
							'TEMPLATE-4' : 'templates/templates/config-oferta_D.png',    // SUPEROFERTA
							'TEMPLATE-5' : 'templates/templates/config-evento.png',      // SUPEROFERTA HOY
							'TEMPLATE-6' : 'templates/templates/config-horarios.jpg',    // HORARIOS
							},
		templateConfig	= $('.template-config'),
		fieldsHorarios 	= $('.fields-horarios'),
		fieldsOfertas 	= $('.fields-ofertas'),
		priceField		= $('.field-price'),
		pricecentsField	= $('.field-price-cents'),		
		claimField		= $('.field-detail'),
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
//////////////////////////////////////////////////////////////
	function changeForm ( template ) {
		var newBG = bgs[template],
			templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		switch( templateNumber ) {
			case 1:
				fieldsHorarios.hide();
				claimField.hide();
				priceField.show();
				pricecentsField.show();				
				fieldsOfertas.show();
				templateConfig.addClass('oferta');
				templateConfig.removeClass('oferta_con_claim oferta_con_bg evento horarios oferta_nueva superdescuento');
				$('#CONFIG').slideDown();
				break;

			case 2:
				fieldsHorarios.hide();
				claimField.show();
				priceField.show();
				pricecentsField.show();					
				fieldsOfertas.show();
				templateConfig.addClass('oferta oferta_con_claim superdescuento');
				templateConfig.removeClass('oferta_con_bg evento horarios oferta_nueva');
				$('#CONFIG').slideDown();
				break;

			case 3:
				fieldsHorarios.hide();
				claimField.show();
				priceField.show();
				pricecentsField.show();					
				fieldsOfertas.show();
				templateConfig.addClass('oferta oferta_nueva');
				templateConfig.removeClass('oferta_con_claim superdescuento evento horarios');
				templateConfig.removeClass('superdescuento');
				$('#CONFIG').slideDown();
				break;

			case 4:
				fieldsHorarios.hide();
				claimField.show();
				priceField.show();
				pricecentsField.show();					
				fieldsOfertas.show();
				templateConfig.addClass('oferta oferta_con_bg oferta_con_claim');
				templateConfig.removeClass('evento horarios oferta_nueva superdescuento');
				$('#CONFIG').slideDown();
				break;

			case 5:
				fieldsHorarios.hide();
				claimField.show();
				priceField.show();
				pricecentsField.show();					
				fieldsOfertas.show();
				templateConfig.addClass('evento oferta_con_bg');
				templateConfig.removeClass('oferta oferta_con_claim horarios oferta_nueva superdescuento');
				templateConfig.removeClass('superdescuento');
				$('#CONFIG').slideDown();
				break;

			case 6:
				fieldsHorarios.show();
				fieldsOfertas.hide();				
				templateConfig.addClass('horarios');
				templateConfig.removeClass('oferta oferta_con_claim oferta_con_bg evento superdescuento');
				templateConfig.removeClass('superdescuento');
				templateConfig.removeClass('oferta_nueva');
				$('#CONFIG').slideDown();
				break;

			default:
				$('#CONFIG').slideUp();
		}

		templateConfig.css('background-image', 'url(' + newBG + ')');
	}
//////////////////////////////////////////////////////////////
	function validateForm ( template ) {
		var fields = {
				'name'		: $('#TITLE').val().trim(),
				'desc'		: $('#CONTENT').val().trim(),
				'price'		: $('#PRICE').val().trim(),
				'price-cents': $('#PRICE-CENTS').val().trim(),				
				'img'		: $('#IMG').val(),
				'horario_1'	: $('#HORARIO_1').val().trim(),
				'horario_2'	: $('#HORARIO_2').val().trim(),
				'horario_3'	: $('#HORARIO_3').val().trim(),	
				'discount'		: $('#DISCOUNT').val().trim(),
				'detail'		: $('#DETAIL').val().trim(),
				'oldprice'		: $('#OLDPRICE').val().trim(),
				'oldprice_cents': $('#OLDPRICE-CENTS').val().trim(),
				'title_superdescuento_uno': $('#TITLE-SUPERDESCUENTO-UNO').val().trim(),
				'title_superdescuento_dos': $('#TITLE-SUPERDESCUENTO-DOS').val().trim()						
			},
			templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= "";

		switch( templateNumber ) {
			case 1:
				validationMsg += addMsg( fields['name'], 'el nombre del producto' );
				validationMsg += addMsg( fields['desc'], 'la descripción del producto' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;

			case 2:
				validationMsg += addMsg( fields['name'],  'el nombre del producto' );
				validationMsg += addMsg( fields['desc'],  'la descripción del producto' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta de la segunda unidad' );
				validationMsg += addMsg( fields['discount'], 'descuento de la segunda unidad' );				
				validationMsg += addMsg( fields['detail'], 'precios de 1 o 2 unidades' );
				break;

			case 3:
				validationMsg += addMsg( fields['name'], 'el nombre de la oferta' );
				validationMsg += addMsg( fields['desc'], 'la descripción de la oferta' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );			
				validationMsg += addMsg( fields['detail'], 'precios segun unidades' );				
				break;

			case 4:
				validationMsg += addMsg( fields['name'], 'el nombre de la oferta' );
				validationMsg += addMsg( fields['desc'], 'la descripción de la oferta' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				validationMsg += addMsg( fields['oldprice'], 'precio anterior' );
				break;

			case 5:
				validationMsg += addMsg( fields['name'], 'el nombre del evento' );
				validationMsg += addMsg( fields['desc'], 'la descripción del evento' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;

			case 6:
				if( !fields['horario_1'] && !fields['horario_2'] && !fields['horario_3'] )
					validationMsg += '<p>Tienes que rellenar al menos una línea de horarios.</p>';
				break;

			default:
				validationMsg = '<p>Este mensaje no se debe visualizar!!!</p>';
		}

		return validationMsg;
	}
//////////////////////////////////////////////////////////////
	function clearValidation () {
		$('.validation').html('');
	}
//////////////////////////////////////////////////////////////
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
//////////////////////////////////////////////////////////////
	function addMsg ( myVal, text ) {
		return !myVal ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);