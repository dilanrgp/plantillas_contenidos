
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		bgs				= {
							'TEMPLATE-1' : 'carralero-templates/templates/config-oferta_1.jpg',
							'TEMPLATE-2' : 'carralero-templates/templates/config-oferta_2.jpg',
							'TEMPLATE-3' : 'carralero-templates/templates/config-descripcion.jpg',
							'TEMPLATE-4' : 'carralero-templates/templates/config-mensaje.jpg',
							},
		fields			= [
							['TITLE*', 'DESCRIPCION', 'SUBDESCRIPCION', 'OFERTA*', 'SUBOFERTA', 'LEGAL', 'IMG*'],
							['TITLE*', 'DESCRIPCION', 'OFERTA*', 'SUBOFERTA', 'LEGAL', 'IMG*'],
							['TITLE*', 'IMG_CHANGER', 'IMG'],
							['TITLE', 'IMG_CHANGER', 'IMG', 'TEETH', 'TEETH_CONFIG', 'NUM_DIENTES'],
							],
		templateConfig		= $('.template-config'),
		fieldsOfertas 		= $('.fields-ofertas'),
		fieldsDientes		= $('.fields-dientes'),
		fieldsConfigDesc	= $('.fields-desc_config'),
		imgChanger			= $('.img_changer'),
		imgLabel			= $('label[for=CAMBIO_IMG]'),
		numDientes			= $('#NUM_DIENTES'),
		imgFileSelector		= $('#IMG'),
		submitBtn			= $('#SUBMIT'),
		activeTemplate		= templates.filter('[checked]').val();

	changeForm( activeTemplate );
	showTeeth();
	numDientes.on('change', showTeeth);

	templates.on('change', function(e) {
		activeTemplate = $(this).val();

		clearValidation();
		changeForm( activeTemplate );
	});


	$('.img-preview').on('click', function(e) {
		imgFileSelector.trigger('click');
	});

	$('.img-border').on('click', function(e) {
		imgFileSelector.trigger('click');
	});

	imgFileSelector.on('change', function(e) {
		readURL(this, $('.bg-image, .img-preview'));
	});

	$('#CAMBIO_IMG').on('change', function(e){
		if ($(this).is(":checked")) {
			templateConfig.removeClass('no_img');
			imgFileSelector.show();
			$('.img-preview').show();
		} else {
			templateConfig.addClass('no_img');
			imgFileSelector.hide();
			$('.img-preview').hide();
		}
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

	function changeForm ( template ) {
		var newBG = bgs[template],
			templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		templateConfig.removeClass('offer offer_1 offer_2 description message no_img');

		fieldsOfertas.show();
		fieldsDientes.hide();
		fieldsConfigDesc.hide();
		imgChanger.hide();

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				templateConfig.addClass('offer offer_1');
				$('.img-preview').show();
				imgFileSelector.show();
				break;

			// Oferta 2
			case 2:
				templateConfig.addClass('offer offer_2');
				$('.img-preview').show();
				imgFileSelector.show();
				break;

			// Descripción
			case 3:
				templateConfig.addClass('description no_img');
				fieldsOfertas.hide();
				fieldsDientes.show();
				fieldsConfigDesc.show();
				imgChanger.show();
				imgLabel.html('¿Cambiar fondo?');
				imgFileSelector.hide();
				$('.img-preview').hide();
				if ($('#CAMBIO_IMG').is(":checked")) $('#CAMBIO_IMG').trigger('click');
				break;
				
				// Mensaje
			case 4:
				templateConfig.addClass('message no_img');
				fieldsOfertas.hide();
				imgChanger.show();
				imgLabel.html('¿Con imagen?');
				imgFileSelector.hide();
				$('.img-preview').hide();
				if ($('#CAMBIO_IMG').is(":checked")) $('#CAMBIO_IMG').trigger('click');
				break;
				
			default:
				$('#CONFIG').slideUp();
		}

		if(!(template === undefined)) $('#CONFIG').slideDown();

		templateConfig.css('background-image', 'url(' + newBG + ')');
	}

	function showTeeth() {
		var teeth = parseInt(numDientes.val());
		$('.fields-dientes .column').hide();
		for(var i = 0; i < teeth/2; i++) {
			$('.fields-dientes .column').eq(i).show();
		}
	}

	function validateForm ( template ) {
		var fields = {
				'name'		: $('#TITLE').val().trim(),
				'desc'		: $('#DESCRIPCION').val().trim(),
				'subdesc'	: $('#SUBDESCRIPCION').val().trim(),
				'price'		: $('#PRICE').val().trim(),
				'subprice'	: $('#SUBPRICE').val().trim(),
				'legal'		: $('#LEGAL').val().trim(),
				'imgChange'	: $('#CAMBIO_IMG').val(),
				'img'		: $('#IMG').val(),
				'numDientes': $('#NUM_DIENTES').val(),
				'diente_1'	: $('#DIENTE_1').val().trim(),
				'diente_2'	: $('#DIENTE_2').val().trim(),
				'diente_3'	: $('#DIENTE_3').val().trim(),
				'diente_4'	: $('#DIENTE_4').val().trim(),
				'diente_5'	: $('#DIENTE_5').val().trim(),
				'diente_6'	: $('#DIENTE_6').val().trim(),
				'diente_7'	: $('#DIENTE_7').val().trim(),
				'diente_8'	: $('#DIENTE_8').val().trim()
			},
			templateNumber	= parseInt( template.charAt(template.length-1), 10),
			validationMsg	= '';

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				validationMsg += addMsg( fields['name'], 'el nombre de la oferta' );
				validationMsg += addMsg( fields['img'], 'la imagen' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;
				
			// Oferta 2
			case 2:
				validationMsg += addMsg( fields['name'], 'el nombre de la oferta' );
				validationMsg += addMsg( fields['img'], 'la imagen' );
				validationMsg += addMsg( fields['price'], 'el precio u oferta' );
				break;
				
			// Descripción
			case 3:
				break;

			// Mensaje
			case 4:
				validationMsg += addMsg( fields['name'], 'el mensaje' );
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
				container.css('background-size', 'cover');
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function addMsg ( myVal, text ) {
		return !myVal ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}

	$(document).ready(function() {
		activeTemplate		= $('input[name="TEMPLATE"]:checked').val();
		changeForm( activeTemplate );
	});
})(jQuery);