<?php

//* Widgetized Front Page
//* =============================================================== */

	//* Only widgetize if there are widgets in the right widget areas
	if( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-feature-1') || is_active_sidebar( 'home-feature-2' ) || is_active_sidebar( 'home-feature-3' ) || is_active_sidebar( 'home-feature-full' ) ) {

		//* Force full-width-content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove default loop (this is a widgetized homepage)
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add our widgets to the homepage
		add_action( 'genesis_after_header', 'ck_home_top' );
		add_action( 'genesis_after_header', 'ck_home_one' );
		add_action( 'genesis_after_header', 'ck_home_two' );
		add_action( 'genesis_after_header', 'ck_home_three' );
		add_action( 'genesis_after_header', 'ck_home_full' );

	}


	function ck_home_top() {
		
		genesis_widget_area( 'home-top', array(
			'before'	=>	'<div class="home-top"><div class="home-top-content"><div class="wrap">',
			'after'		=>	'</div></div></div>'
		));

	}

	function ck_home_one() {
	
		genesis_widget_area( 'home-feature-one', array(
			'before'	=>	'<div class="home-featured"><div class="wrap"><div class="one-third first"><div class="content home-middle-widget one">',
			'after'		=>	'</div></div>'
		));
	
	}

	function ck_home_two() {
	
		genesis_widget_area( 'home-feature-two', array(
			'before'	=>	'<div class="one-third"><div class="content home-middle-widget two">',
			'after'		=>	'</div></div>'
		));
	
	}

	function ck_home_three() {
	
		genesis_widget_area( 'home-feature-three', array(
			'before'	=>	'<div class="one-third"><div class="content home-middle-widget three">',
			'after'		=>	'</div></div></div></div>'
		));
	
	}

	function ck_home_full() {
	
		genesis_widget_area( 'home-feature-full', array(
			'before'	=>	'<div class="home-full-widget">',
			'after'		=>	'</div></div>'
		));
	
	}
	
genesis();