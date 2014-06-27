<section id="sidebar" class="span4" role="complementary">
		<?php if ( !dynamic_sidebar() ) : ?>
			<?php dynamic_sidebar( 'right-sidebar' ); ?>
		<?php endif; ?>
	</section>
</div>