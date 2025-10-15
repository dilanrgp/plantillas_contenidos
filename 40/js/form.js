(function($) {
	var templates 		= $('input[name="TEMPLATE"]'),
		activeTemplate	= templates.filter('[checked]').val(),
		selectedImg		= '';

	changeForm( activeTemplate );

	templates.on('change', function(e) {
		activeTemplate = $(this).val();

		changeForm( activeTemplate );
	});

	$('#OFFER_IMG').on('change', function(e) {
		readURL(this, $('#OFERTA'));
	});

	function changeForm ( template ) {
		var templateNumber	= !(template === undefined) ? parseInt( template.charAt(template.length-1), 10) : 0;

		switch( templateNumber ) {
			// Oferta básica
			case 1:
				$('#MENUBOARD').hide();
				$('#OFERTA').show();
				$('#CONFIG').slideDown();
				break;

			// Menuboard
			case 2:
				$('#MENUBOARD').show();
				$('#OFERTA').hide();
				$('#CONFIG').slideDown();
				break;

			default:
				$('#CONFIG').slideUp();
		}
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
})(jQuery);