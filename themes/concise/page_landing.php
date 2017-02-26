<?php
/*
Template Name: Landing Page
*/

//* Remove the header.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_nav' );

//* Force full width (cause that's awesome)
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the footer
remove_action( 'genesis_before_footer', 'cm_footer_widget' );

//* Add custom body class to the head
add_filter( 'body_class', 'cm_landing_body_class' );
function cm_landing_body_class( $classes ) {
	
	$classes[] = 'landing';
	return $classes;
	
}

genesis();