<article <?php echo post_class(); ?>>
	<p class="post-meta"><?php montblanc_post_date(); ?> <a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" title="<?php the_title(); ?>"><?php echo get_the_date(); ?></a> <?php montblanc_author(); ?> <?php montblanc_cat(); ?></p>
	<div class="post-content">
		<?php $opt = get_theme_mod('show_post_content'); ?>
		<?php if($opt == 'content'): ?>
			<?php the_content(); ?>
		<?php else: ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
	</div>
</article>