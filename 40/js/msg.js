
(function($) {
	var textWrappers = $('.msg');

	$.each(textWrappers, function(i, value) {
		var txt = textWrappers.eq(i)[0],
			words = txt.innerHTML.split(' '),
			sentence = '';

		for(var w in words) {
			var word = words[w].replace(/\S/g, "<span class='letter'>$&</span>");

			sentence += '<div class="word">' + word + '</div>';
		}

		txt.innerHTML = sentence;
	});

	anime.timeline({loop: false})
	  .add({
	    targets: '.msg_1 .letter',
	    translateY: [-80,0],
	    scale: [0,1],
	    opacity: [0,1],
	    easing: "easeOutExpo",
	    duration: 1000,
	    delay: (el, i) => 500 + 30 * i
	  })

	anime.timeline({loop: false})
	  .add({
	    targets: '.msg_2 .letter',
	    translateY: [80,0],
	    scale: [0,1],
	    opacity: [0,1],
	    easing: "easeOutExpo",
	    duration: 1000,
	    delay: (el, i) => 800 + 30 * i
	  })
})(jQuery);