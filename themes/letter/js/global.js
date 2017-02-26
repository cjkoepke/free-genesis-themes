(function($) {

	$( document ).ready( function() {
		
		//* Set variables
		var body 		= $( 'body' ),
			menuToggle 	= $( '#menu-toggle' ),
			icon 		= menuToggle.find( 'i' ),
			closeClass 	= 'ion-close-round',
			menuClass 	= 'ion-navicon-round';

		//* Execute a function when the menu toggle button is clicked
		menuToggle.click( function() {

			// Toggle the .nav-visible class depending on whether it's present in the body tag
			body.toggleClass( 'nav-visible' );

			// If it is present, replace menu button class with a close button class
			if ( icon.hasClass( menuClass ) ) {
				icon.removeClass( menuClass );
				icon.addClass( closeClass );

			// else do the opposite
			} else {
				icon.addClass( menuClass );
				icon.removeClass( closeClass );
			}

		});
	
	});

	//* Shrink Header on scroll
	$( window ).scroll(function() {

		// Get the scroll height
		var scrollHeight = $( window ).scrollTop();

		// If its more or equal to 100
		if ( scrollHeight >= 100 ) {

			// Add the .header-slim class
			$( 'body' ).addClass( 'header-slim' );

		} else {

			// Remove the .header-slim class
			$( 'body' ).removeClass( 'header-slim' );
			
		}

	});

})(jQuery);