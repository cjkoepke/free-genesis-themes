<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Add HTML5 Support
add_theme_support( 'html5' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Unregister content/sidebar layout setting
genesis_unregister_layout( 'content-sidebar' );
 
//* Unregister sidebar/content layout setting
genesis_unregister_layout( 'sidebar-content' );
 
//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );
 
//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );
 
//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove Genesis Layout Settings
remove_theme_support( 'genesis-inpost-layouts' );

//* Disable the superfish script
add_action( 'custom_disable_superfish', 'sp_disable_superfish' );
function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'child_viewport_meta_tag' );
function child_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

//* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
	if ( has_post_thumbnail() ) {
		echo '<a href="',
		the_permalink(),
		'" title="',
		the_title(),
		'">',
		'<div class="featured-img">';
		the_post_thumbnail('post-image');
		echo '</div></a>';
	}
}

add_action( 'wp_enqueue_scripts', 'script_managment', 99);
/**
 * Change the location of jQuery.
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function script_managment() {
	  wp_deregister_script( 'jquery' );
	  wp_deregister_script( 'jquery-ui' );
	  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' );
	  wp_register_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js' );
	  wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', array( 'jquery' ), '4.0', false );
	  wp_enqueue_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', array( 'jquery' ), '1.8.16' );
}

//* Register after post widget area
genesis_register_sidebar( array(
	'id'            => 'social-networks',
	'name'          => __( 'Social Networks', 'profile' ),
	'description'   => __( 'This area is meant to be used with the Simple Social Icons plugin.', 'profile' ),
) );

add_action( 'genesis_before_header', 'social_networks' );
function social_networks() {
	genesis_widget_area( 'social-networks', array(
		'before' => '<div class="before-header widget-area">',
		'after' => '</div>',
	) );
}

//* Add support for post formats
add_theme_support( 'post-formats', array(
	'image',
	'link',
	'quote'
) );

add_theme_support( 'genesis-post-format-images' );

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

// //* Remove the author box on single posts HTML5 Themes
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );

function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://twitter.com/calvinkoepke">Crafted by Calvin Koepke</a> &middot; Built on the <a href="http://www.shareasale.com/r.cfm?b=460184&u=884099&m=28169&urllink=&afftrack=" title="Genesis Framework">Genesis Framework</a>';
	echo '</p></div>';
}

//* Modify trackbacks title in comments
add_filter( 'genesis_title_pings', 'sp_title_pings' );
function sp_title_pings() {
echo '<h3>Links to this Article</h3>';
}
?>