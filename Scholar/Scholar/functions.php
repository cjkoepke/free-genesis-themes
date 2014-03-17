<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Add HTML5 Support
add_theme_support( 'html5' );

//* Create blue, green, orange and red color style options
add_theme_support( 'genesis-style-selector', array(
	'black-theme'	=> __( 'Black & White', 'themename' ),
	'green-theme'	=> __( 'Olive', 'themename' ),
	'blue-theme'	=> __( 'Sky', 'themename' ),
	'red-theme'	=> __( 'Fire', 'themename' ), 
	'brown-theme'	=> __( 'Book', 'themename' )
) );

// Register responsive menu script
add_action( 'wp_enqueue_scripts', 'prefix_enqueue_scripts' );
/**
 * Enqueue responsive javascript
 * @author Ozzy Rodriguez
 * @todo Change 'prefix' to your theme's prefix
 */
function prefix_enqueue_scripts() {
 	wp_enqueue_style( 'color-themes', get_stylesheet_directory_uri() . '/css/color_themes.min.css' );
 	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700|Droid+Serif:400,400italic,700,700italic|Gilda+Display' );
	wp_enqueue_script( 'scholar-responsive-menu', get_stylesheet_directory_uri() . '/js/mobilemenu.js', array( 'jquery' ), '1.0.0', true ); 
	wp_enqueue_style( 'dashicons', array( 'dashicons' ), '1.0' );
}

// Edit the read more link text
add_filter('get_the_content_more_link', 'custom_read_more_link');
add_filter( 'excerpt_more', 'custom_read_more_link');
add_filter('the_content_more_link', 'custom_read_more_link');
function custom_read_more_link() {
return '... <p><a class="more-link" href="' . get_permalink() . '" rel="nofollow">Read Full Article &raquo;</a></p>'; }

//* Add Viewport meta tag for mobile browsers (requires HTML5 theme support)
add_theme_support( 'genesis-responsive-viewport' );

add_theme_support('custom-background');

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'author_box_gravatar_size' );
function author_box_gravatar_size( $size ) {
	return '120';
}

//* Customize the author box title
add_filter( 'genesis_author_box_title', 'custom_author_box_title' );
function custom_author_box_title() {
	return 'About the Author';
}

//* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( ! is_singular( 'post' ) )  return;
	the_post_thumbnail('post-image');
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );

function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; Crafted by <a href="http://twitter.com/calvinkoepke">Calvin Koepke</a> &middot; Built on the <a href="http://www.shareasale.com/r.cfm?b=460184&u=884099&m=28169&urllink=&afftrack=" title="Genesis Framework">Genesis Framework</a>';
	echo '</p></div>';
}

//* Modify comments title text in comments
add_filter( 'genesis_title_comments', 'sp_genesis_title_comments' );
function sp_genesis_title_comments() {
	$title = '<h3>Thoughts</h3>';
	return $title;
}

//* Modify trackbacks title in comments
add_filter( 'genesis_title_pings', 'sp_title_pings' );
function sp_title_pings() {
echo '<h3>Links to this Article</h3>';
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
	return __( 'Previous Articles', CHILD_DOMAIN ) . g_ent( ' &raquo;' );
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'sp_previous_page_link' );
function sp_previous_page_link ( $text ) {
	return g_ent( '&laquo; ' ) . __( 'Newer Articles', CHILD_DOMAIN );
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/lib/plugins/scholar-plugin-activation.php';
 
add_action( 'tgmpa_register', 'scholar_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function scholar_register_required_plugins() {
 
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		/** This is an example of how to include a plugin from the WordPress Plugin Repository */
		array(
			'name' => 'Simple Social Icons',
			'slug' => 'simple-social-icons',
		),
	);
 
	/** Change this to your theme text domain, used for internationalising strings */
	$theme_text_domain = 'scholar';
 
	/**
	 * Array of configuration settings. Uncomment and amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * uncomment the strings and domain.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       => $theme_text_domain,         // Text domain - likely want to be the same as your theme. 
		'default_path' => '',                         // Default absolute path to pre-packaged plugins 
		'menu'         => 'install-scholar-plugins', // Menu slug 
		'strings'      	 => array(
			'page_title'             => __( 'Install Required Plugins', $theme_text_domain ), // 
			'menu_title'             => __( 'Install Plugins', $theme_text_domain ), // 
			'instructions_install'   => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ), // %1$s = plugin name 
			'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL 
			'button'                 => __( 'Install %s Now', $theme_text_domain ), // %1$s = plugin name 
			'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name 
			'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // 
			'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ), // %1$s = plugin name, %2$s = TGMPA page URL 
			'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name 
			'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL 
			'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name 
			'return'                 => __( 'Return to Required Plugins Installer', $theme_text_domain ), // 
		),
	);
 
	tgmpa( $plugins, $config );
}
?>