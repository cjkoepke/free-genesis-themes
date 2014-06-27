<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php bloginfo( 'name' ); ?></title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" >
	<?php wp_head(); ?>
</head>

<body  <?php body_class(); ?>>
	<div class="container single-nav-container">
		<div class="row-fluid">
			<div class="span12">
				<nav id="single-nav">
					<p><a title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">&larr; Home</a></p>
				</nav>
			</div>
		</div>
	</div>
	<div class="container" id="landing">
		<div class="row-fluid">
			<section class="span12 single-post-title">
			<?php while ( have_posts() ) : the_post() ?>
				<h1><?php the_title(); ?></h1>
				<p class="meta"><?php _e('Posted by '); ?> <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s' ), $authordata->display_name ); ?>"><?php the_author(); ?></a> <?php _e('on '); ?><span class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?> | <span class="comments-link"><?php comments_popup_link( __( 'Comment' ), __( '1 Comment' ), __( '% Comments' ) ) ?></span></p>
			</section>
			</div>
			<div class="row-fluid">
			<section id="content" class="span8">
				<article id="post-single">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>' )  ); ?>
				</article>
			<p class="meta"><?php _e( 'Posted in ' ); ?><?php echo get_the_category_list(', '); ?> | <?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?><?php edit_post_link( __( '| Edit' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?></p>
			<?php endwhile; ?>
			<div id="comments-wrap">
				<?php
					if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
				?>
			</div>
			</section>
			<?php get_sidebar( 'single' ) ?>
			<?php get_footer() ?>