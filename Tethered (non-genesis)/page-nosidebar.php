<?php
/*
Template Name: Page - No Sidebar
*/
?>

<?php get_header() ?>

<section id="content" class="span12">
<?php while ( have_posts() ) : the_post() ?>
	<article class="post">
		<h2 class="post-title"><a class="title-link" href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>' )  ); ?>
		<p class="meta"><?php edit_post_link( __( 'Edit' ) ) ?></p>
	</article>
<?php endwhile; ?>
</section>
<?php get_footer() ?>