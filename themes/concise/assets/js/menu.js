jQuery( document ).ready(function( $ ) {

	// Variables
	var open 			 = false, // Set the state of the menu on load (false = closed)
		body             = $('body'),
		siteContainer    = $('.site-container'),
		toggleButtons    = $('#menu-toggle, .site-overlay'); // Also select menu links to cause a trigger when navigating

	// Function to open the menu
	function openMenu() {
		body.addClass('off-canvas-active');
		siteContainer.css({"overflow-x": "hidden"}); // IE Bug
	}

	// Function to close the menu
	function closeMenu() {
		body.removeClass('off-canvas-active');
		siteContainer.css({"overflow-x": ""}); // IE Bug
	}

	/** 
		This is our main function. It checks the "open" variable to see 
		whether our menu is open or not. Depending on the response, we either
		open or close the menu.
	**/
	function animateMenu() {
		if (open) {
			closeMenu();
			open = false;
		} else {
			openMenu();
			open = true;
		}
	}

	/** 
		Listen for clicks of any of the toggle buttons set at the top, 
		and initiate the animateMenu() function.
	**/
	toggleButtons.click(function(event) {
		
		// Prevent the default action of clicking a link
		event.preventDefault();

		// Run the main function
		animateMenu();
	});
});