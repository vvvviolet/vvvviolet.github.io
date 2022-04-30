<?php 
/**
* Author Page
* @package montblanc
* @author Titouanc
* @since 1.0
*/

get_header(); ?>

<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

<div class="container">

  <div class="row">

    <div class="col-sm-12 blog-main">
      <?php $user_id = the_author_meta('ID', true); ?>
      <div class="post author-bio text-center" style="overflow: hidden;">
        <?php $author_name = get_the_author(); ?>
        <?php $author_name = ucfirst($author_name); ?>
        <?php echo get_avatar( get_the_author_meta( 'ID' )); ?>
        <h4><?php echo $author_name; ?></h4>
        <?php $vbio = get_the_author_meta('description'); ?>
        <?php if(empty($vbio)): ?>
        <p><?php echo __('This author hasn\'t added his/her bio.', 'montblanc'); ?></p>
      <?php else: ?>
      <p class="bio"><?php echo get_the_author_meta( 'description' ); ?></p>
    <?php endif; ?>
  </div>

  <?php get_template_part('templates/content', 'author'); ?>

</div> <!-- blog-main -->
</div> <!-- row -->
</div> <!-- container -->

<?php get_footer(); ?>