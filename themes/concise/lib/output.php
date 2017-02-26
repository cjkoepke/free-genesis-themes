<?php

//* Output the custom accent color from /lib/customize.php into our document
//* =============================================================== */

	add_action( 'wp_enqueue_scripts', 'ck_theme_options_output' );
	function ck_theme_options_output() {

		//* Sanatize our child theme name variable and replace it with a dashed version (if has spaces)
		$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'concise';

		//* Set our default accent color
		$color = '#02D4FF';

		//* Set a blank variable as a fallback in case there is no custom color
		$css = '';

		//* Get the custom color assigned in our customize.php file, and set it as a variable
		$custom_color = get_option( 'ck_accent_color', '#02D4FF' );

		//* If our default color is not the same as the accent color...
		if ( $color != $custom_color ) {

			//* Then fill our blank variable with new CSS
			$css .= sprintf( '
				a:hover,
				.button.button-cta,
				input[type="button"].button-cta,
				input[type="reset"].button-cta,
				input[type="submit"].button-cta,
				.button.button-cta,
				.entry-content a.button.button-cta,
				.blog .entry:hover .entry-title a,
				.category .entry:hover .entry-title a,
				.entry-content a,
				.home .entry:hover .entry-title a:hover,
				.home-middle-widget .dashicons,
				#menu-toggle:hover,
				.off-canvas-active #menu-toggle,
				.nav-primary .genesis-nav-menu .menu-item.button-cta > a:hover,
				.nav-primary .genesis-nav-menu .current-menu-item > a,
				.nav-primary .genesis-nav-menu a:hover,
				.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a:hover,
				.nav-primary .genesis-nav-menu .sub-menu a:hover,
				h1.highlight,
				h2.highlight,
				h3.highlight,
				h4.highlight,
				h5.highlight,
				h6.highlight
				{
					color: %1$s;
				}

				.comment-list .children > li.bypostauthor > article .avatar,
				button.button-cta,
				input[type="button"].button-cta,
				input[type="reset"].button-cta,
				input[type="submit"].button-cta,
				.button.button-cta,
				.entry-content a.button.button-cta,
				.title-area:hover img,
				.nav-primary .genesis-nav-menu .menu-item.button-cta > a:hover,
				.after-post,
				.after-post .email-callout-entry,
				blockquote
				{
					border-color: %1$s;
				}

				.footer-widgets .simple-social-icons a:hover
				{
					border-color: %1$s !important;
				}

				p.entry-meta .entry-categories a:hover,
				.archive-pagination li a:hover,
				.archive-pagination .active a,
				button.button-cta:hover,
				input[type="button"].button-cta:hover,
				input[type="reset"].button-cta:hover,
				input[type="submit"].button-cta:hover,
				.button.button-cta:hover,
				.entry-content a.button.button-cta:hover
				{
					background-color: %1$s;
				}
			', $custom_color );
		}

		//* Add a style tag to the header of our document with the overriding styles for our accent color
		wp_add_inline_style( $handle, $css );
	}