<?php

//* Start the engine
//* - This basically includes all the functions we need to do our magic below
//* =============================================================== */

	include_once( get_template_directory() . '/lib/init.php' );


//* Define Child Theme Constants
//* - These can be used throughout the rest of the child theme as variables
//* =============================================================== */

	define( 'CHILD_THEME_NAME', 'Minny Plus' );
	define( 'CHILD_THEME_AUTHOR', 'Calvin Koepke' );
	define( 'CHILD_THEME_AUTHOR_URL', 'https://github.com/cjkoepke/free-genesis-themes' );
	define( 'CHILD_THEME_URL', 'https://calvinkoepke.com/resources' );
	define( 'CHILD_THEME_VERSION', '2.0' );
	define( 'TEXT_DOMAIN', 'ck' );


//* Include required files from other directories inside our child theme
//* =============================================================== */

	//* Customizer files from the /lib/ directory
	include_once( get_stylesheet_directory() . '/lib/customize.php');
	include_once( get_stylesheet_directory() . '/lib/output.php');


//* Add Standard Theme Support
//* =============================================================== */

	//* Add HTML5 Support
	add_theme_support( 'html5' );

	//* Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	//* Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'site-inner',
		'footer-widgets',
		'footer'
	));

	//* Add support for custom header
	add_theme_support( 'custom-header', array(
		'default-image'   => get_stylesheet_directory_uri() . '/images/logo.png',
		'header-selector' => '.site-title a',
		'header-text'     => false,
		'height'          => 200,
		'width'           => 500,
	));

	//* Add Image Sizes
	add_image_size( 'ck-full-width', 1200, 800, TRUE );
	add_image_size( 'ck-home-featured', 1200, 400, TRUE );


//* Execute our default Genesis child theme setup functions
//* - Remove and/or reposition certain default elements in Genesis
//* =============================================================== */

	//* Unregister layout settings
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );

	//* Remove Unecessary Sidebars
	unregister_sidebar( 'sidebar' );
	unregister_sidebar( 'sidebar-alt' );
	unregister_sidebar( 'header-right' );

	//* Remove the Post Meta in Entry Footers
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	//* Remove breadcrumbs
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

	//* Remove author bio after posts
	add_filter( 'get_the_author_genesis_author_box_single', '__return_false' );


//* Execute custom functions
//* - Filter or hook our custom functions to their respective parents
//* =============================================================== */


	//* Customize the credits
	add_filter( 'genesis_footer_creds_text', 'ck_footer_creds_text' );
	function ck_footer_creds_text() {

		//* Return our custom credits
		return '<p>Copyright &copy; ' . date('Y') . ' &middot; <a href="' . CHILD_THEME_URL . '" target="_blank">' . CHILD_THEME_NAME . '</a> &middot; Made for you by <a href="' . CHILD_THEME_AUTHOR_URL . '" target="_blank">' . CHILD_THEME_AUTHOR . '</a> &middot; Built on the <a target="_blank" href="http://www.genesistheme.com">Genesis Framework</a></p>';

	}

	//* Enqueue Google Fonts
	add_action( 'wp_enqueue_scripts', 'ck_custom_scripts' );
	function ck_custom_scripts() {

		//* Custom jQuery for our theme
		wp_enqueue_script( 'ck-main-scripts', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery' ), CHILD_THEME_VERSION );

		//* Custom theme fonts from Google
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Droid+Sans:400,700,400italic|Crimson+Text:700italic' );

		//* Default WordPress icon library
		wp_enqueue_style( 'dashicons' );

	}

	//* Customize the entry meta in the entry header
	add_filter( 'genesis_post_info', 'ck_post_info_filter' );
	function ck_post_info_filter( $post_info ) {

		$post_info = '[post_date] in [post_categories before=""] with [post_comments zero="0 Comments" one="1 Comment" more="% Comments"] [post_edit]';

		return $post_info;

	}

	//* Code to Display Featured Image on top of the post
	add_action( 'genesis_before_entry', 'ck_featured_post_image', 8 );
	function ck_featured_post_image() {

		//* If the current post has a thumbnail, AND is a single post...
		if ( has_post_thumbnail() && is_singular( 'post' ) ) {

			//* Then print out the featured image
			echo '<div class="featured-img">';
				the_post_thumbnail('ck-full-width');
			echo '</div>';
		}

	}

	//* Customize Read More Link
	add_filter('get_the_content_more_link', 'ck_excerpt_more');
	add_filter('excerpt_more', 'ck_excerpt_more');
	function ck_excerpt_more( $more ) {
		return '... <p style="text-align: center;"><a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a></p>';
	}

	//* Body Classes
	add_filter( 'body_class', 'ck_body_class' );
	function ck_body_class( $classes ) {

		$classes[] = 'minny-plus';

		if ( is_home() || is_page_template( 'page_blog.php' )) {
			$classes[] .= 'blog';
		}

		return $classes;

	}

	//* Menu Button
	add_action( 'genesis_after_header', 'ck_menu_button', 1 );
	function ck_menu_button() {
		echo '<a href="#" id="menu-btn"><span class="dashicons dashicons-menu"></span></a>';
	}


//* Register Our Widget Areas
//* =============================================================== */

	//* Social Networks
	genesis_register_sidebar( array(
		'id'            => 'social-networks',
		'name'          => __( 'Social Networks', 'minny-plus' ),
		'description'   => __( 'This area is meant to be used with the Simple Social Icons plugin.', 'minny-plus' ),
	) );

	//* Email Callout
	genesis_register_sidebar( array(
		'id'          => 'email-callout',
		'name'        => __( 'Email Callout', 'minny-plus' ),
		'description' => __( 'This is the email callout section after the entry.', 'minny-plus' ),
	) );

	//* Home - Featured
	genesis_register_sidebar( array(
		'id'          => 'home-featured',
		'name'        => __( 'Home Featured', 'minny-plus' ),
		'description' => __( 'This is for a featured section, ideally the eNews Extended Widget.', 'minny-plus' ),
	) );

	//* Home - Middle
	genesis_register_sidebar( array(
		'id'          => 'home-middle-feed',
		'name'        => __( 'Home Middle', 'minny-plus' ),
		'description' => __( 'This is for your normal feed.', 'minny-plus' ),
	) );


//* Display Widget Areas
//* =============================================================== */

	//* Social Networks
	add_action( 'genesis_before', 'ck_social_networks' );
	function ck_social_networks() {

		genesis_widget_area( 'social-networks', array(
			'before' => '<div class="before-header widget-area">',
			'after' => '</div>',
		));

	}

	//* Email Callout (after entry)
	add_action( 'genesis_entry_footer', 'ck_after_entry_widget'  );
	function ck_after_entry_widget() {

	    if ( ! is_singular( 'post' ) )
	    	return;

	    genesis_widget_area( 'email-callout', array(
			'before' => '<div class="after-entry widget-area" id="email-callout"><div class="wrap">',
			'after'  => '</div></div>',
	    ));

	}
