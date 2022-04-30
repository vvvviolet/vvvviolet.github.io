<?php get_header();
if(get_option('montblanc_blog_layout_opt') == 'left'):
  $montblanc_sidebar_float = 'style="float:left"';
  $montblanc_content_float = 'style="float:right"';
  $montblanc_md = 9;
  $montblanc_sm = 8;
elseif(get_option('montblanc_blog_layout_opt') == 'full_width'):
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

      <div class="posts">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php get_template_part('templates/content', get_post_format()); ?>

      <?php endwhile; else: ?>
      <article class="post">
        <div class="notfound">
          <h1><?php echo __('404', 'montblanc'); ?></h1>
          <p><?php echo __('Nothing\'s here.', 'montblanc'); ?></p>
          <?php get_search_form(); ?>
        </div>
      </article>
    <?php endif; ?>
  </div>

  <nav class="pagination" role="navigation">
    <span class="page-number">
      <?php if( get_query_var('paged') ) : ?> 
        <?php echo __('Page', 'montblanc'); ?> <?php echo intval(get_query_var('paged')); ?> <?php echo __('of', 'montblanc'); ?> <?php echo  intval($wp_query->max_num_pages); 
          endif; ?> 
    </span>
      <?php previous_posts_link('<i class="fa fa-angle-left"></i> Previous Entries') ?>
      <?php next_posts_link('Next Entries <i class="fa fa-angle-right"></i>','') ?>
  </nav>

</main><!-- /.blog-main -->


<aside class="col-md-3 col-sm-4 col-xs-12 sidebar" <?php echo $montblanc_sidebar_float; ?>>
        <?php dynamic_sidebar('sidebar-1'); ?>
</aside><!-- /.blog-sidebar -->

</div><!-- /.row -->

</div><!-- /.container -->

<?php get_footer(); ?>