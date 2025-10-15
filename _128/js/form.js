(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		activeTemplate	= $('input[name="TEMPLATE"]:checked').val(),
		templateConfig	= $('.template-config'),
		infoOffer		=  $('.config-info'),
		fields			= {
							'DESCRIPCION'	: $('#DESCRIPCION'), 
							'SUBDESCRIPCION'	: $('#SUBDESCRIPCION'), 
							'PRICE'			: $('#PRICE'),
							'SUBPRICE'		: $('#SUBPRICE'),
							'PRETITLE'		: $('#PRETITLE'),
							'TITLE'			: $('#TITLE'),
							'DETAILS'		: $('#DETAILS'),
							'IMG'			: $('#IMG')
						},
		bgs				= {
							'TEMPLATE-1' : 'img/templates/config-template_1.jpg',
							'TEMPLATE-2' : 'img/templates/config-template_2.jpg',
							'TEMPLATE-3' : 'img/templates/config-template_3.jpg',
						},
		submitBtn		= $('#SUBMIT'),
		bg;


	setTimeout(function() {
		var index = $('input[name="TEMPLATE"]:checked').val();
		changeForm(index);

		var input = document.getElementById("IMG");
		readURL(input, $('.bg-image, .img-preview'));
	}, 500);
	

	templates.on('change', function(e) {
		activeTemplate = $(this).val();
		changeForm( activeTemplate );
	});

	$('.img-preview').on('click', function(e) {
		console.log('click');
		fields['IMG'].trigger('click');
	});

	fields['IMG'].on('change', function(e) {
		readURL(this, $('.bg-image, .img-preview'));
	});

	submitBtn.on('click', function(e) {
		e.preventDefault();
		clearValidation();

/* 		
		POR PETICIÓN DEL CLIENTE, NINGÚN CAMPO ES OBLIGATORIO. 
		
		var msg = validateForm( activeTemplate );

		if( msg.length )
			$('.validation').html( msg );
		else
			$('#TEMPLATE_FORM').submit();
*/

		$('#TEMPLATE_FORM').submit();
	});
	
	function setBG( template ) {
		bg = bgs[ template ];

		templateConfig.css('background-image', 'url(' + bg + ')');
	}

	function changeForm ( template ) {
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		clearValidation();

		templateConfig.removeClass('offer_1 offer_2 offer_3');
		
		setBG( template );		

		switch( templateNumber ) {
			// Oferta 1
			case 1:
				templateConfig.addClass('offer_1');
				infoOffer.hide();
				break;

			// Oferta 2
			case 2:
				templateConfig.addClass('offer_2');
				infoOffer.hide();
				break;

			// Oferta 3
			case 3:
				templateConfig.addClass('offer_3');
				infoOffer.show();
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
				validationMsg += addMsg( fields['IMG'], 'la imagen' );
				break;
				
			// Oferta 2
			case 2:
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['IMG'], 'la imagen' );
				break;
				
			// Mensaje
			case 3:
				validationMsg += addMsg( fields['PRETITLE'], 'la frase superior' );
				validationMsg += addMsg( fields['TITLE'], 'el título' );
				validationMsg += addMsg( fields['DESCRIPCION'], 'el nombre del producto' );
				validationMsg += addMsg( fields['PRICE'], 'el precio u oferta' );
				validationMsg += addMsg( fields['IMG'], 'la imagen' );
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
		console.log(input, input.files);
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            container.css('background-image', 'url(' + e.target.result + ')');
	            container.css('background-color', 'transparent');
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function addMsg ( myVal, text ) {
		return !myVal.val().trim() ? '<p>Has olvidado definir ' + text + '.</p>' : '';
	}
})(jQuery);