<?php

//* Output the custom accent color from /lib/customize.php into our document
//* =============================================================== */
add_action( 'wp_enqueue_scripts', 'ck_theme_options_output' );
function ck_theme_options_output() {

	//* Sanatize our child theme name variable and replace it with a dashed version
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : TEXT_DOMAIN;

	//* Set our default accent color
	$color = '#70C1B3';

	//* Set a blank variable as a fallback in case there is no custom color
	$css = '';

	//* Get the custom color assigned in our customize.php file, and set it as a variable
	$custom_color = get_option( 'ck_accent_color', '#70C1B3' );

	//* If our default color is not the same as the accent color...
	if ( $color != $custom_color ) {

		//* Then fill our blank variable with new CSS
		$css .= sprintf( '
			.entry-title a:hover,
			.entry-content a,
			.entry-content a:hover,
			.nav-primary .sub-menu a:hover,
			.entry-title a:hover,
			#email-callout a,
			.content a.sd-button:hover > span,
			.comment-list a:hover
			{
				color: %1$s;
			}

			.sd-content .sd-button span.share-count
			{
				color: %1$s !important;
			}

			a.read-more
			{
				color: #000;
			}

			.home .home-featured .entry > a,
			.featured-img {
				background-color: %1$s;
			}
		', $custom_color );
	}

	//* Add a style tag to the header of our document with the overriding styles for our accent color
	wp_add_inline_style( $handle, $css );
}