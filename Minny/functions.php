<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Add HTML5 Support
add_theme_support( 'html5' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
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

//* Remove Post Meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] in [post_categories before=""] with [post_comments zero="0 Comments" one="1 Comment" more="% Comments"] [post_edit]';
	return $post_info;
}

//* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
	if ( has_post_thumbnail() && is_singular( 'post' ) ) {
		echo '<a href="',
		the_permalink(),
		'" title="',
		the_title(),
		'">',
		'<div class="featured-img">';
		the_post_thumbnail('post-image');
		echo '</div></a>';
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

//* Replace Twitter OG handle to @calvinkoepke
//* @author Brian Gardner
add_filter( 'jetpack_open_graph_tags', 'minny_jetpack_twitter_username', 11 );
function minny_jetpack_twitter_username( $og_tags ) {

	$og_tags['twitter:site'] = '@calvinkoepke';
	return $og_tags;

}

//* Customize Read More Link
function new_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

//* Enqueue Theme Styles & Imports
function minny_styles() {
	// Enqueue Google Fonts (Better performance when executing as a stylesheet, instead of @import)
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' );
}
add_action( 'wp_enqueue_scripts', 'minny_styles', 99);

//* Remove Unecessary Sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );


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

//* Hooks above content
add_action( 'genesis_before_header', 'social_networks' );
function social_networks() {
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
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

add_filter( 'genesis_author_box', 'minny_author_box' );
function minny_author_box() {
 
	// Author's Gravatar image
	$gravatar_size = apply_filters( 'genesis_author_box_gravatar_size', 100 );
	$gravatar      = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );
 
	// Author's name
	$name = get_the_author();
	$title = get_the_author_meta( 'title' );
	if( !empty( $title ) )
		$name .= ', ' . $title;
 
	// Author's Biographical info
	$description   = wpautop( get_the_author_meta( 'description' ) );
 
	// Build Author box output
	$output = '';
	$output .= '<section class="author-box" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author">';
	$output .= $gravatar;
	$output .= '<div class="author-box-title"><span class="sub-author-box-title">Written by</span> <span itemprop="name">' . $name .'</span></div>';
	$output .= '<div itemprop="description" class="author-box-content">' . $description . '</div>';
	$output .= '</section>';
	return $output;
 
}

remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
add_action( 'genesis_entry_content', 'genesis_do_author_box_single', 8 );


//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );

function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://demo.calvinkoepke.com/minny/" target="_blank" title="Minny Theme">Minny Theme</a> &middot; Inspired by <a href="http://matmm.me/typesense" target="_blank" follow="nofollow">Typesense</a> &middot; Built on the <a target="_blank" href="http://calvinkoepke.com/go/genesis-framework/" title="Genesis Framework">Genesis Framework</a> &middot; <a href="http://plus.google.com/+CalvinKoepke" rel="author" target="_blank">Google+</a>';
	echo '</p></div>';
}

//* Modify trackbacks title in comments
add_filter( 'genesis_title_pings', 'sp_title_pings' );
function sp_title_pings() {
echo '<h3>Links to this Article</h3>';
}
?>