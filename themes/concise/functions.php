<?php

//* Start the engine
//* - This basically includes all the functions we need to do our magic below
//* =============================================================== */

	include_once( get_template_directory() . '/lib/init.php' );


//* Define Child Theme Constants
//* - These can be used throughout the rest of the child theme as variables
//* =============================================================== */

	define( 'CHILD_THEME_NAME', 'Concise' );
	define( 'CHILD_THEME_AUTHOR', 'Calvin Koepke' );
	define( 'CHILD_THEME_AUTHOR_URL', 'https://github.com/cjkoepke/free-genesis-themes' );
	define( 'CHILD_THEME_URL', 'https://calvinkoepke.com/' );
	define( 'CHILD_THEME_VERSION', '2.0.1' );
	define( 'TEXT_DOMAIN', 'ck' );


//* Include required files from other directories inside our child theme
//* =============================================================== */

	//* Theme Defaults (setup the defaults on theme install or theme switch automatically)
	include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

	//* Customizer files
	include_once( get_stylesheet_directory() . '/lib/customize.php');
	include_once( get_stylesheet_directory() . '/lib/output.php');


//* Add Standard Theme Support
//* =============================================================== */

	//* Enable HTML5 Support
	add_theme_support( 'html5' );

	//* Add viewport meta tag
	add_theme_support( 'genesis-responsive-viewport' );

	//* Use the default Genesis After Entry widget area (faster than stating it below)
	add_theme_support( 'genesis-after-entry-widget-area' );


//* Execute our default Genesis child theme setup functions
//* - Remove and/or reposition certain default elements in Genesis
//* =============================================================== */

	//* Reposition Secondary Nav
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'genesis_before', 'genesis_do_subnav', 16 );

	//* Reposition primary menu
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_before', 'genesis_do_nav', 13 );

	//* Remove Site Description
	remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

	//* Unregister unnecessary layouts
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	//* Remove sidebars
	unregister_sidebar( 'sidebar-alt' );
	unregister_sidebar( 'header-right' );

	//* Move entire site header to before the .site-content div
	remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
	remove_action( 'genesis_header', 'genesis_do_header' );
	remove_action( 'genesis_header', 'genesis_header_markup_close', 15 ) ;
	add_action( 'genesis_before', 'genesis_header_markup_open', 5 );
	add_action( 'genesis_before', 'genesis_do_header' );
	add_action( 'genesis_before', 'genesis_header_markup_close', 15 );


//* Execute custom functions
//* - Filter or hook our custom functions to their respective parents
//* =============================================================== */

	add_action( 'wp_enqueue_scripts', 'ck_theme_scripts' );
	function ck_theme_scripts() {

		//* Load fonts from Google
		wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:700,400|Merriweather:400,400italic,700)', array(), CHILD_THEME_VERSION );

		//* Load our custom JavaScript
		wp_enqueue_script('menu', get_stylesheet_directory_uri() . '/assets/js/menu.js', array( 'jquery' ), CHILD_THEME_VERSION );
		wp_enqueue_script('general', get_stylesheet_directory_uri() . '/assets/js/general.js', array( 'jquery' ), CHILD_THEME_VERSION );

		//* Load WordPress icon font for our menu
		wp_enqueue_style( 'dashicons' );

	}

	//* Add avatar
	add_filter( 'genesis_seo_title', 'ck_site_title_avatar' );
	function ck_site_title_avatar( $inside ) {

		$avatar = get_avatar( get_option( 'admin_email' ), 100 );

		return $avatar . $inside;

	}

	//* Modify the post info in the entry header
	add_filter( 'genesis_post_info', 'ck_post_info_filter' );
	function ck_post_info_filter( $post_info ) {

		$post_info = '[post_date before="Posted on " format="F d, Y"] [post_comments before=""] [post_edit]';

		return $post_info;

	}

	//* Modify the post meta in the entry footer
	add_filter( 'genesis_post_meta', 'ck_post_meta_filter' );
	function ck_post_meta_filter( $post_meta ) {

		$post_meta = '[post_categories sep="" before=""]';

		return $post_meta;

	}

	//* Modify size of gravatars in comments section
	add_filter( 'genesis_comment_list_args', 'ck_comments_gravatar' );
	function ck_comments_gravatar( $args ) {

		$args['avatar_size'] = 60;

		return $args;

	}

	//* Add custom classes to our body tag
	add_filter( 'body_class', 'ck_body_class' );
	function ck_body_class( $classes ) {

		$classes[] = 'calvinmakes';

		//* If we're on the home page (blog feed) or the Genesis Blog Template
		if ( is_home() || is_page_template( 'page_blog.php' ) )
			$classes[] = 'blog';

		return $classes;

	}

	//* Add a menu toggle button to the header for mobile screen sizes
	add_action( 'genesis_before', 'ck_responsive_menu', 14 );
	function ck_responsive_menu() {

		$button = '<a href="" id="menu-toggle"><span class="dashicons dashicons-menu"></span></a>';

		echo $button;

	}

	//* Add featured image to a single post
	add_action( 'genesis_before_entry_content', 'ck_display_featured_img' );
	function ck_display_featured_img() {

		//* If the current post has a thumbnail and the current view is a single post
		if ( has_post_thumbnail() && is_singular( 'post' ) )
			echo '<div class="featured-img">',
				 the_post_thumbnail(),
			 	 '</div>';

	}

	//* Add the site overlay for when the mobile menu is active
	add_action( 'genesis_before', 'ck_site_overlay', 2 );
	function ck_site_overlay() {

		echo '<div class="site-overlay"></div>';

	}

	//* Add Read More Link to Excerpts
	add_filter('excerpt_more', 'ck_get_read_more_link');
	add_filter( 'the_content_more_link', 'ck_get_read_more_link' );
	function ck_get_read_more_link() {

		return '... <a href="' . get_permalink() . '">Read More</a>';

	}

//* Register Our Widget Areas
//* =============================================================== */

	//* Footer
	genesis_register_sidebar( array(
		'id'          => 'footer',
		'name'        => __( 'Footer', TEXT_DOMAIN ),
		'description' => __( 'This is the footer section of the site.', TEXT_DOMAIN )
	));

	//* Home Top
	genesis_register_sidebar( array(
		'id'          => 'home-top',
		'name'        => __( 'Home Top', TEXT_DOMAIN ),
		'description' => __( 'This is the main home top section.', TEXT_DOMAIN )
	));

	//* Home Featured One
	genesis_register_sidebar( array(
		'id'          => 'home-feature-one',
		'name'        => __( 'Home Feature One', TEXT_DOMAIN ),
		'description' => __( 'This featured section on the homepage, #1', TEXT_DOMAIN )
	));

	//* Home Featured Two
	genesis_register_sidebar( array(
		'id'          => 'home-feature-two',
		'name'        => __( 'Home Feature Two', TEXT_DOMAIN ),
		'description' => __( 'This featured section on the homepage, #2', TEXT_DOMAIN )
	));

	//* Home Featured Three
	genesis_register_sidebar( array(
		'id'          => 'home-feature-three',
		'name'        => __( 'Home Feature Three', TEXT_DOMAIN ),
		'description' => __( 'This featured section on the homepage, #3', TEXT_DOMAIN )
	));

	//* Home Featured Full
	genesis_register_sidebar( array(
		'id'          => 'home-feature-full',
		'name'        => __( 'Home Feature Full', TEXT_DOMAIN ),
		'description' => __( 'This is a full width feature section.', TEXT_DOMAIN )
	));


//* Display Widget Areas
//* =============================================================== */

	//* Footer Widget
	add_action( 'genesis_before_footer', 'ck_footer_widget' );
	function ck_footer_widget() {

		genesis_widget_area( 'footer', array(
			'before'	=>	'<div class="footer-widgets"><div class="wrap">',
			'after'		=>	'</div></div>'
		));

	}
