<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Letter' );
define( 'CHILD_THEME_URL', 'http://www.calvinkoepke.com/free-themes' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Enqueue Custom Scripts and Fonts
add_action( 'wp_enqueue_scripts', 'ck_sample_google_fonts' );
function ck_sample_google_fonts() {

	//* Custom Scripts
	wp_enqueue_script( 'ck-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), CHILD_THEME_VERSION );

	//* Google Fonts and Icon Pack
	wp_enqueue_style( 'ck-google-fonts', '//fonts.googleapis.com/css?family=Alice|Lora|Oswald:400', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ck-ionicons', 'http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Custom image sizes
add_image_size( 'featured-image', 1700, 800, TRUE );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 13 );

//* Add responsive menu toggle
add_action( 'genesis_header', 'ck_responsive_toggle', 12 );
function ck_responsive_toggle() {
  
	//* Create our addition menu item (this example uses the Dashicons library from WordPress)
	echo '<button id="menu-toggle"><i class="ionicon ion-navicon-round"></i></button>';
  
}

//* Remove the secondary navigation
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

//* Force full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove unused layouts
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove widget area
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Filter and move the entry header info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 6 );
add_filter( 'genesis_post_info', 'ck_custom_entry_info' );
function ck_custom_entry_info( $post_info ) {

	$post_info = 'Written on [post_date]';
	return $post_info;

}

//* Remove the entry footer meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta');

//* Filter read more link
add_filter( 'get_the_content_more_link', 'ck_more_link' );
add_filter( 'the_content_more_link', 'ck_more_link' );
function ck_more_link() {

	return '...<br/> <a href="' . get_permalink() . '" title="' . the_title_attribute("echo=0") . '" class="more-link">Read Full Entry</a>';

}

//* Add featured image
add_action( 'genesis_entry_content', 'ck_featured_image', 8 );
function ck_featured_image() {

	//* Don't output the featured image on the homepage (return early)
	if ( is_home() )
		return;

	//* If the post has a thumbnail, show it
	if ( has_post_thumbnail() )
		the_post_thumbnail( 'featured-image', array( "class" => "featured-image" ) );
}

//* Customize footer credits
add_filter( 'genesis_footer_creds_text', 'ck_footer_credits' );
function ck_footer_credits() {

	return '<a href="' . CHILD_THEME_URL . '">' . CHILD_THEME_NAME . '</a> is a free theme by <a href="http://www.calvinkoepke.com" target="_blank">Calvin Koepke</a> • Built on the <a href="http://genesistheme.com">Genesis Framework</a> • Folllow on Twitter: <a href="http://www.twitter.com/cjkoepke" target="_blank">@cjkoepke</a>';

}