<article class="post">
		<header>
			<h2 class="page-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<?php if(has_post_thumbnail()): ?>
			<a href="<?php echo the_permalink(); ?>">
				<div class="thumbnail-frame post-thumbnail"><?php the_post_thumbnail(); ?></div>
			</a>
			<?php endif; ?>
	</header>
	<div class="bio post-content">
		<?php the_content(); ?>
	</div>
</article>