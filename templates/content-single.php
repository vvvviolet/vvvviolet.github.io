<?php while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?>>
		<header>
			<h2 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="post-meta"><?php montblanc_post_date(); ?> <a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" title="<?php the_title(); ?>"><?php echo get_the_date(); ?></a> <?php montblanc_author(); ?> <?php montblanc_cat(); ?></p>

			<?php if(has_post_thumbnail()): ?>
			<a href="<?php echo the_permalink(); ?>">
				<div class="thumbnail-frame post-thumbnail"><?php the_post_thumbnail(); ?></div>
			</a>
			<?php endif; ?>
	</header>
	<div class="post-content">
		<?php the_content(); ?>
	</div>
	<p class="post-tags"><?php the_tags(); ?></p>
	<?php  wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
</article>
<?php endwhile; ?>