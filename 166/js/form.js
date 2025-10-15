(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		activeTemplate		= $('input[name="TEMPLATE"]:checked').val(),
		templateConfig		= $('.template-config'),
		colors			= $('input[name="COLOR"]'),
		activeColor		= colors.filter('[checked]').val(),
		blocks			= {
							'color'			: $('.fields-color'),
							'imagen'		: $('.fields-img'),
							'img_preview'	: $('.img-preview')
						},
		fields			= {
							'TITLE'			: $('#TITLE'),
							'DESCRIPCION'	: $('#DESCRIPCION'),
							'SUBDESCRIPCION'	: $('#SUBDESCRIPCION'),
							'LEGAL'			: $('#LEGAL'),
							'ORIENTATION'	: $('#ORIENTATION'),
							'IMG'			: $('#IMG')
						},
		submitBtn		= $('#SUBMIT'),
		bg;


	changeForm( activeTemplate );
	checkPreviewOrientation();

	templates.on('change', function(e) {
		activeTemplate = $(this).val();
		changeForm( activeTemplate );
	});

	colors.on('change', function(e) {
		activeColor = $(this).val();
		changeBGColor( activeColor );
	});

	fields['ORIENTATION'].on('change', checkPreviewOrientation);

	blocks['img_preview'].on('click', function(e) {
		fields['IMG'].trigger('click');
	});

	fields['IMG'].on('change', function(e) {
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

	function checkPreviewOrientation() {
		if( fields['ORIENTATION'].is(':checked') || $('#ORIENTATION_CENTRO').value == 'vertical' ) {
			$('.config-container').addClass('vertical');
		} else {
			$('.config-container').removeClass('vertical');
		}
	}

	function changeBGColor(c) {
		if(c != undefined)
			templateConfig.css('background-color', c);
		else
			templateConfig.css('background-color', '');
	}

	function changeForm ( template ) {
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		clearValidation();

		blocks['color'].hide();
		blocks['imagen'].hide();
		blocks['img_preview'].hide();
		fields['TITLE'].show();
		fields['LEGAL'].hide();

		changeBGColor();

		templateConfig.removeClass('offer message horarios');

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				templateConfig.addClass('offer');
				blocks['color'].show();
				blocks['imagen'].show();
				blocks['img_preview'].show();
				fields['TITLE'].hide();
				fields['LEGAL'].show();

				changeBGColor( activeColor );
				break;

			// Oferta 2
			case 2:
				templateConfig.addClass('message');
				break;

			// Mensaje
			case 3:
				templateConfig.addClass('message horarios');
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
				validationMsg += addMsg( fields['DESCRIPCION'], 'el mensaje' );
				validationMsg += addMsg( fields['IMG'], 'la imagen' );
				break;

			// Oferta 2
			case 2:
				validationMsg += addMsg( fields['DESCRIPCION'], 'el mensaje' );
				break;

			// Mensaje
			case 3:
				validationMsg += addMsg( fields['DESCRIPCION'], 'los horarios' );
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