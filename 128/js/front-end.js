(function($){
	var template = $('body').attr('class').slice(-1),
		priceContainer = $('#PRICE'),
		offer = priceContainer.text();

	if( template == "1" || template == "2" ) {
		var price = '';
		var coma = Math.max(offer.indexOf('.'), offer.indexOf(','));

		if( coma ) {
			price = offer.substring(0, coma) + '<span class="cents">' + offer.substring(coma) + '</span>';
			priceContainer.html(price);
		}
	}
	if( template == "3" ) {
		var txt = '',
			price = offer.split("**"),
			openedTag = false;

		if(price.length > 1) {
			for (let i = 0; i < price.length; i++) {
				const e = price[i];
				if( i % 2 && !openedTag) {
					txt += '<span class="cents">';
					openedTag = true;
				}
				else if( openedTag ) {
					txt += '</span>';
					openedTag = false;
				}
				txt += e;
			}
		} else {
			txt = offer;
		}
		var currency = txt.indexOf('€');

		if( currency ) {
			var newTxt = txt.substring(0, currency) + '<span class="cents">' + txt.substring(currency) + '</span>';
			priceContainer.html(newTxt);
		}
	}

	/* ANIMATION */
	var masterTL = gsap.timeline();
	var fr = 1 / 30;
	CustomEase.create("smoothEnd", "M0,0 C0.32,0.05 0.27,1 1,1 ");
	CustomEase.create("smoothStart", "M0,0 C0.99,0.02 0.47,0.96 1,1 ");
	CustomEase.create("overshoot", "M0,0 C0.16,1.56 0.43,1 1,1 ");
	/* Se usa tb "sine.inOut" */

	gsap.config({ force3D: true });
	gsap.defaults({ duration: 1, ease: "smoothEnd", delay: 2 });
	
	if( template == "1" ) {
		gsap.defaults({ duration: 30*fr });

		masterTL.from(".bg-price", {x: "+=100vw"});
		masterTL.from(".logo-bg", {xPercent: -100}, 5*fr);
		masterTL.from(".img-bg", {y: "+=100vw"}, .5);
		masterTL.from("#DESCRIPCION", {x: "+=40vw", duration: 1, ease: "sine.inOut"}, 25*fr);
		//masterTL.from(".img", {rotate: -90, scale: 0, duration: 1, ease: "overshoot"}, 31*fr);
		masterTL.from(".img", {scale: 0, duration: 1, ease: "overshoot"}, 31*fr);
		masterTL.from("#PRICE", {scale: 0, duration: 1, ease: "overshoot"}, 33*fr);
		masterTL.from("#SUBDESCRIPCION, #SUBPRICE", {autoAlpha: 0, duration: 1, ease: "linear"}, 48*fr);

		masterTL.to(".img", {scale: "+=.1", repeat: 1, yoyo: true, duration: 25*fr, ease: "sine.inOut"}, 115*fr);
		masterTL.to("#PRICE", {scale: "+=.1", repeat: 1, yoyo: true, duration: 25*fr, ease: "sine.inOut"}, 136*fr);

	}
	else if( template == "2" ) {
		masterTL.from(".rayo-bg", {y: "-=60vw", x: "+=45vw"});
		masterTL.from(".data-ofertas", {clipPath: "polygon(100% 100%, 100% 100%, 100% 100%, 100% 100%, 100% 100%)"}, 5*fr);
		masterTL.from(".logo-bg", {xPercent: -100, y: "-=8vw"}, 15*fr);
		masterTL.from(".img", {x: "-=64vw", y: "+=48vw"}, 20*fr);
		masterTL.from("#DESCRIPCION", {y: "+=12vw"}, 30*fr);
		masterTL.from("#SUBDESCRIPCION", {y: "+=12vw"}, 36*fr);
		masterTL.from("#PRICE", {x: "+=32vw", ease: "overshoot"}, 45*fr);
		masterTL.from("#SUBPRICE", {autoAlpha: 0, ease: "linear"}, 60*fr);
		masterTL.from("#DETAILS", {scale: 0, ease: "overshoot"}, 75*fr);

		masterTL.to(".img", {scale: "+=.1", repeat: 1, yoyo: true, duration: 25*fr, ease: "sine.inOut"}, 140*fr);
		masterTL.to("#PRICE", {scale: "+=.1", repeat: 1, yoyo: true, duration: 25*fr, ease: "sine.inOut"}, 157*fr);
	}
	else if( template == "3" ) {
		masterTL.from(".title-bg", {yPercent: 60});
		masterTL.from(".img", {scale: 0, ease: "smoothStart"}, 10*fr);
		masterTL.from("#PRETITLE", {x: "+=68vw"}, 15*fr);
		masterTL.from("#PRETITLE", {paddingLeft: "+=6vw", duration: 23*fr}, 22*fr);
		masterTL.from("#PRICE", {scale: 0, ease: "smoothStart"}, 20*fr);
		masterTL.from("#TITLE", {yPercent: 110}, 25*fr);
		masterTL.from(".details-bg", {x: "-=27.7vw", y: "-=15vw"}, 46*fr);
		masterTL.from("#DETAILS p", {scale: 0}, 51*fr);
		masterTL.from("#DESCRIPCION", {y: "+=12vw"}, 60*fr);
		masterTL.from("#SUBDESCRIPCION", {autoAlpha: 0, ease: "linear"}, 75*fr);

		masterTL.to(".img", {scale: "+=.1", repeat: 1, yoyo: true, duration: 25*fr, ease: "sine.inOut"}, 128*fr);
		masterTL.to("#PRICE", {scale: "+=.1", repeat: 1, yoyo: true, duration: 25*fr, ease: "sine.inOut"}, 138*fr);
	}


})(jQuery);