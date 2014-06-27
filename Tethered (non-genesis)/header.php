<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" >
	<?php wp_head(); ?>
</head>

<body  <?php body_class(); ?>>
	<div class="container">
		<header>
			<div id="twitter-follow">
				<a href="https://twitter.com/calvinkoepke" class="twitter-follow-button" data-show-count="false">Follow @calvinkoepke</a>
			</div>
			<h1><a id="site-title" title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a></h1>
			<p id="site-description"><?php bloginfo( 'description' ); ?></p>
			<nav role="navigation">			
					<?php
						if(function_exists('wp_nav_menu')):
							wp_nav_menu(
								array(
								'menu' =>'primary_nav',
								'container'=>'',
								'depth' => 3,
								'menu_id' => 'menu' )
							);
						else:
					?>
						<ul id="menu">
							<?php wp_list_pages('title_li=&depth=1'); ?>
						</ul>
					<?php
						endif;
					?>
			</nav>
		</header>
		<div class="row-fluid">