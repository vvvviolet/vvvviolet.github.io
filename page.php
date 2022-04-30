<?php 
/**
* Single Pots
* @package montblanc
* @author Titouanc
* @since 1.0
*/
get_header();
if(get_option('montblanc_page_layout_opt') == 'left'):
	$montblanc_sidebar_float = 'style="float:left"';
	$montblanc_content_float = 'style="float:right"';
	$montblanc_md = 9;
	$montblanc_sm = 8;
elseif(get_option('montblanc_page_layout_opt') == 'full_width'):
	$montblanc_sidebar_float = 'style="display:none"';
	$montblanc_content_float = '';
	$montblanc_md = 12;
	$montblanc_sm = 12;
else:
	$montblanc_sidebar_float = 'style="float:right"';
	$montblanc_content_float = 'style="float:left"';
	$montblanc_md = 9;
	$montblanc_sm = 8;
endif; ?>
<div class="container">

	<div class="row">

		<main class="col-md-<?php echo $montblanc_md; ?> col-sm-<?php echo $montblanc_sm; ?> blog-main" <?php echo $montblanc_content_float; ?>>
			
			<?php while ( have_posts() ) : the_post();	?>

			<?php get_template_part('templates/content', 'page'); ?>
			
			<?php if ( comments_open() || get_comments_number() ) { ?>
			<div id="com_container" class="comment-container">
				<?php comments_template('/framework/comments.php'); ?>
			</div>
			<?php } ?>

		<?php endwhile; ?>

	</main> <!-- blog-main -->

	<aside class="col-md-3 col-sm-4 col-xs-12 sidebar" <?php echo $montblanc_sidebar_float; ?>>
		<?php dynamic_sidebar('sidebar-1'); ?>
	</aside><!-- /.blog-sidebar -->
</div> <!-- row -->
</div> <!-- container -->

<?php get_footer(); ?>