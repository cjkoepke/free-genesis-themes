jQuery(document).ready(function($){
	var menuButton = $("#menu-btn"),
		nav  = $(".nav-primary"),
		open = false;


	menuButton.on("click", function() {
		nav.slideToggle();
	})
})