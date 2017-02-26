<?php

//* Podcast Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'ck_theme_defaults' );
function ck_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive_limit']     = 200;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['posts_nav']                 = 'paged';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* Author Theme Setup
add_action( 'after_switch_theme', 'ck_theme_settings_defaults' );
function ck_theme_settings_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive_limit'     => 200,
			'content_archive_thumbnail' => 0,
			'posts_nav'                 => 'paged',
			'site_layout'              	=> 'full-width-content'
		) );
	}
}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'ck_social_default_styles' );
function ck_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#5E5E5E',
		'background_color_hover' => '#5E5E5E',
		'border_radius'          => 35,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 35,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}
