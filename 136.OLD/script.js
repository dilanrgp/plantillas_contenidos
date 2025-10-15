
(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		templateConfig	= $('.template-config'),
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
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		templateConfig.removeClass('oferta oferta_S oferta_L evento horarios');

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
				templateConfig.addClass('oferta oferta_L evento');
				break;
				
			default:
				$('#CONFIG').slideUp();
		}

		if(!(template === undefined)) $('#CONFIG').slideDown();
	}

	function validateForm ( template ) {
		var fields = {
				'name'		: $('#TITLE').val().trim(),
				'desc'		: $('#CONTENT').val().trim(),
				'price'		: $('#PRICE').val().trim(),
				'claim'		: $('#CLAIM').val().trim(),
				'img'		: $('#IMG').val()
			},
			validationMsg	= '';

			validationMsg += addMsg( fields['name'], 'el nombre del producto' );
			validationMsg += addMsg( fields['img'], 'la imagen' );
			validationMsg += addMsg( fields['price'], 'el precio u oferta' );

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