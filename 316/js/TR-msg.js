
(function($) {
	var textWrappers = $('.msg');

	$.each(textWrappers, function(i, value) {
		var txt = textWrappers.eq(i)[0],
			words = txt.innerHTML.split(' '),
			sentence = '';

		for(var w in words) {
			console.log( words[w] );
			var word = words[w].replace(/\S/g, "<span class='letter'>$&</span>");
			console.log( word )

			sentence += '<div class="word">' + word + '</div>';
		}

		console.log( sentence )

		txt.innerHTML = sentence;
	});

	anime.timeline({loop: false})
	  .add({
	    targets: '.msg .letter',
	    translateY: [20,0],
	    scale: [0,1],
	    opacity: [0,1],
	    easing: "easeOutExpo",
	    duration: 1000,
	    delay: (el, i) => 1500 + 30 * i
	  })
})(jQuery);