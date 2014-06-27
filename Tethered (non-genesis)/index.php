<?php get_header() ?>

<section id="content" class="span8">
<?php while ( have_posts() ) : the_post() ?>
	<article class="post-home">
		<h2 class="post-title"><a class="title-link" href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>' )  ); ?>
		<p class="meta"><?php _e('Posted by '); ?> <a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s' ), $authordata->display_name ); ?>"><?php the_author(); ?></a> <?php _e('on '); ?><span class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?> | <?php _e( 'Posted in ' ); ?><?php echo get_the_category_list(', '); ?> | <?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
                        <span class="comments-link"><?php comments_popup_link( __( 'Comment' ), __( '1 Comment' ), __( '% Comments' ) ) ?></span>
                        <?php edit_post_link( __( 'Edit' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?></p>
	</article>
<?php endwhile; ?>
<?php tethered_content_nav( 'nav-below' ); ?>
</section>
<?php get_sidebar() ?>
<?php get_footer() ?>