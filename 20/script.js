
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		bgs				= {
							'TEMPLATE-1' : 'templates/templates/config-menu_dia.jpg',
							'TEMPLATE-2' : 'templates/templates/config-menu_semanal.jpg',
							'TEMPLATE-3' : 'templates/templates/config-promocion.jpg',
							'TEMPLATE-4' : false,
							},
		templateConfig	= $('.template-config'),
		imgSelector		= $('#img_path'),
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
		
		msg = ''; // se pone esta linea para impedir que los campos sean obligatorios

		if( msg.length )
			$('.validation').html( msg );
		else
			$('#TEMPLATE_FORM').submit();
	});

	function changeForm ( template ) {
		var newBG = bgs[template],
			templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		switch( templateNumber ) {
			// Menú diario
			case 1:
				$('#CONFIG').slideDown();
				$('.config-content').hide();
				$('#CONFIG_TEMPLATE_' + templateNumber).show();
				break;

			// Menú semanal
			case 2:
				$('#CONFIG').slideDown();
				$('.config-content').hide();
				$('#CONFIG_TEMPLATE_' + templateNumber).show();
				break;

			// Promoción
			case 3:
				$('#CONFIG').slideDown();
				$('.config-content').hide();
				$('#CONFIG_TEMPLATE_' + templateNumber).show();
				break;

			// Producto
			case 4:
				$('#CONFIG').slideDown();
				$('.config-content').hide();
				$('#CONFIG_TEMPLATE_' + templateNumber).show();
				break;

			default:
				$('#CONFIG').slideUp();
		}

		if( newBG )
			templateConfig.css('background-image', 'url(' + newBG + ')');
		else
			templateConfig.css('background-image', 'none');
	}

	function validateForm ( template ) {	
		var fields_dia		= {
				'dia'				: $('#day').val().trim(),
				'primero'			: $('#primero').val().trim(),
				'primero_precio'	: $('#primero_precio').val().trim(),
				'segundo'			: $('#segundo').val().trim(),
				'segundo_precio'	: $('#segundo_precio').val().trim()
			},
			field_semana	= $('#week').val().trim(),
			fields_semanal	= {
				'lunes'		: {
						'primero'			: $('#Lprimero').val().trim(),
						'primero_precio'	: $('#Lprimero_precio').val().trim(),
						'segundo'			: $('#Lsegundo').val().trim(),
						'segundo_precio'	: $('#Lsegundo_precio').val().trim()
				},
				'martes'	: {
						'primero'			: $('#Mprimero').val().trim(),
						'primero_precio'	: $('#Mprimero_precio').val().trim(),
						'segundo'			: $('#Msegundo').val().trim(),
						'segundo_precio'	: $('#Msegundo_precio').val().trim()
				},
				'miercoles'	: {
						'primero'			: $('#Xprimero').val().trim(),
						'primero_precio'	: $('#Xprimero_precio').val().trim(),
						'segundo'			: $('#Xsegundo').val().trim(),
						'segundo_precio'	: $('#Xsegundo_precio').val().trim()
				},
				'jueves'	: {
						'primero'			: $('#Jprimero').val().trim(),
						'primero_precio'	: $('#Jprimero_precio').val().trim(),
						'segundo'			: $('#Jsegundo').val().trim(),
						'segundo_precio'	: $('#Jsegundo_precio').val().trim()
				},
				'viernes'	: {
						'primero'			: $('#Vprimero').val().trim(),
						'primero_precio'	: $('#Vprimero_precio').val().trim(),
						'segundo'			: $('#Vsegundo').val().trim(),
						'segundo_precio'	: $('#Vsegundo_precio').val().trim()
				},
				'sabado'	: {
						'primero'			: $('#Sprimero').val().trim(),
						'primero_precio'	: $('#Sprimero_precio').val().trim(),
						'segundo'			: $('#Ssegundo').val().trim(),
						'segundo_precio'	: $('#Ssegundo_precio').val().trim()
				},
			},
			fields_promo	= {
				'nombre'	: $('#oferta_name').val().trim(),
				'precio'	: $('#oferta').val().trim(),
			},
			fields_product	= {
				'nombre'	: $('#product_name').val().trim(),
				'desc'		: $('#product_desc').val().trim(),
				'euros'		: $('#product_euros').val().trim(),
				'cents'		: $('#product_cents').val().trim(),
				'img'		: $('#img_path').val().trim() || $('#img_path').attr('value').trim()
			},
			templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= '';

		switch( templateNumber ) {
			// Menú diario
			case 1:
				validationMsg += addMsg( fields_dia['dia'], 'el día' );
				validationMsg += addMsg( fields_dia['primero'], 'el primer plato' );
				validationMsg += addMsg( fields_dia['primero_precio'], 'el precio del primer plato' );
				validationMsg += addMsg( fields_dia['segundo'], 'el segundo plato' );
				validationMsg += addMsg( fields_dia['segundo_precio'], 'el precio del segundo plato' );
				break;

			// Menú semanal
			case 2:
				validationMsg += addMsg( field_semana, 'la semana' );
				for(var dia in fields_semanal) {
					var data = fields_semanal[dia];

					validationMsg += addMsg( data['primero'], 'el primer plato del ' + dia );
					validationMsg += addMsg( data['primero_precio'], 'el precio del primer plato del ' + dia );
					validationMsg += addMsg( data['segundo'], 'el segundo plato del ' + dia );
					validationMsg += addMsg( data['segundo_precio'], 'el precio del segundo plato del ' + dia );
				}
				break;

			// Promoción
			case 3:
				validationMsg += addMsg( fields_promo['nombre'], 'el producto en oferta' );
				validationMsg += addMsg( fields_promo['precio'], 'la oferta' );
				break;

			// Producto
			case 4:
				validationMsg += addMsg( fields_product['nombre'], 'el producto' );
				validationMsg += addMsg( fields_product['desc'], 'la descripción del producto' );
				validationMsg += addMsg( fields_product['euros'], 'el precio del producto' );
				validationMsg += addMsg( fields_product['img'], 'la imagen del producto' );
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
		return !myVal ? '<p>Has olvidado definir <span class="error-msg">' + text + '</span>.</p>' : '';
	}
})(jQuery);