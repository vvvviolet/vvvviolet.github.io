<?php 
/**
* 404
* @package montblanc
* @author Titouanc
* @since 1.0
*/

get_header(); ?>

<div class="container">

  <div class="row">

    <div class="col-sm-12 blog-main">

      <article class="blog-post">
        <div class="notfound">
          <h1><?php echo __('404', 'montblanc'); ?></h1>
          <p><?php echo __('Nothing\'s here.', 'montblanc'); ?></p>
          <?php get_search_form(); ?>
        </div>
      </article>

    </div> <!-- blog-main -->
  </div> <!-- row -->
</div> <!-- container -->

<?php get_footer(); ?>