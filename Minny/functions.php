<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Minny Theme' );
define( 'CHILD_THEME_URL', 'http://demo.calvinkoepke.com/minny/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Add HTML5 Support
add_theme_support( 'html5' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for post formats
add_theme_support( 'genesis-post-format-images' );

//* Add support for post formats
add_theme_support( 'post-formats', array(
	'image',
	'link',
	'quote'
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Remove inpost layout options
remove_theme_support( 'genesis-inpost-layouts' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove Unecessary Sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

//* Enqueue Theme Styles & Imports
add_action( 'wp_enqueue_scripts', 'minny_styles' );
function minny_styles() {
	// Enqueue Google Fonts (Better performance when executing as a stylesheet, instead of @import)
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' );

}

//* Hooks above content
add_action( 'genesis_before_header', 'minny_social_networks' );
function minny_social_networks() {
	genesis_widget_area( 'social-networks', array(
		'before' => '<div class="before-header widget-area">',
		'after' => '</div>',
	) );
}

//* Hooks after-entry widget area to single posts
add_action( 'genesis_entry_footer', 'minny_after_entry_widget'  );
function minny_after_entry_widget() {

    if ( ! is_singular( 'post' ) )
    	return;

    genesis_widget_area( 'email-callout', array(
		'before' => '<div class="after-entry widget-area" id="email-callout"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}

// //* Remove the author box on single posts HTML5 Themes
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'minny_footer_creds_text' );

function minny_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="'. CHILD_THEME_URL .'" target="_blank" title="'. CHILD_THEME_NAME .'">'. CHILD_THEME_NAME .'</a> &middot; Inspired by <a href="http://matmm.me/typesense" target="_blank" follow="nofollow">Typesense</a> &middot; Built on the <a target="_blank" href="http://calvinkoepke.com/go/genesis-framework/" title="Genesis Framework">Genesis Framework</a> &middot; <a href="http://plus.google.com/+CalvinKoepke" rel="author" target="_blank">Google+</a>';
	echo '</p></div>';
}

//* Modify trackbacks title in comments
add_filter( 'genesis_title_pings', 'minny_title_pings' );
function minny_title_pings() {
	echo '<h3>Links to this Article</h3>';
}

//* Remove Post Meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'minny_post_info_filter' );
function minny_post_info_filter($post_info) {
	$post_info = '[post_date] in [post_categories before=""] with [post_comments zero="0 Comments" one="1 Comment" more="% Comments"] [post_edit]';
	return $post_info;
}

//* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'minny_featured_post_image', 8 );
function minny_featured_post_image() {
	if ( has_post_thumbnail() && is_singular( 'post' ) ) {
		echo '<a href="'. get_the_permalink() .'" title="'. get_the_title() .'">';
			echo '<div class="featured-img">';
				the_post_thumbnail('post-image');
			echo '</div>';
		echo' </a>';
		add_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

//* Filter open graph tags to use Genesis doctitle and meta description instead
//* @author Brian Gardner
add_filter( 'jetpack_open_graph_tags', 'minny_jetpack_open_graph_tags_filter' );
function minny_jetpack_open_graph_tags_filter( $tags ) {

	// Do nothing if not a single post
	if ( ! is_singular() )
		return $tags;

	// Pull from custom fields
	$title = genesis_get_custom_field( '_genesis_title' );
	$description = genesis_get_custom_field( '_genesis_description' );

	// Set new values for title and description
	$tags['og:title'] = $title ? $title : $tags['og:title'];
	$tags['og:description']	= $description ? $description : $tags['og:description'];

	return $tags;

}

//* Customize Read More Link
add_filter('excerpt_more', 'minny_excerpt_more');
function minny_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}

//* Register Widget Areas
genesis_register_sidebar( array(
	'id'            => 'social-networks',
	'name'          => __( 'Social Networks', 'profile' ),
	'description'   => __( 'This area is meant to be used with the Simple Social Icons plugin.', 'profile' ),
) );

genesis_register_sidebar( array(
	'id'          => 'email-callout',
	'name'        => __( 'Email Callout', 'minny' ),
	'description' => __( 'This is the email callout section after the entry.', 'minny' ),
) );
