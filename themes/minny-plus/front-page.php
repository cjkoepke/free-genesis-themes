<?php

//* Widgetized Front Page
//* =============================================================== */

	//* Only widgetize if there are widgets in the right widget areas
	if ( is_active_sidebar( 'home-featured' ) || is_active_sidebar( 'home-middle-feed' ) ) {

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Run the widget loop ( see the loop below )
		add_action( 'genesis_loop', 'ck_widget_loop' );

	}

	function ck_widget_loop() {

		//* Define our widget areas and add them to array
		$widgets = array(
			'home-featured',
			'home-middle-feed'
		);

		//* Run a foreach loop based on the array of widgets. This lets us avoid coding the same function more than once
		foreach( $widgets as $widget ) {

			genesis_widget_area( $widget, array(
				'before' => '<div class="' . $widget . ' widget-area"><div class="wrap">',
				'after'  => '</div></div>',
		    ) );

		}
	}

genesis();