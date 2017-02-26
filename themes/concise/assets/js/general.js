jQuery(document).ready(function($) {

	// Smooth scroll to div placements on screen
	$('a[href*="#"]:not([href="#"])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top
	        }, 400);
	        return false;
	      }
	    }
	});

	//* Set our home top widget area to fit the window height
	var headerHeight = $(".site-header").height(),
		windowHeight = $(window).height(),
		homeTopHeight = windowHeight - headerHeight - 60;

	//* Only set height if viewing on screens wider than 960
	if ( $(window).width() > 960 ) {
		$(".home-top").css("height", homeTopHeight);
	}
});