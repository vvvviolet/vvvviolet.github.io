<?php

/**
* Comment form
* @author titouanc 
* @since 1.0
* @link http://codex.wordpress.org/Function_Reference/comment_form
*/

if (post_password_required()) {
  return;
}

if (have_comments()) : ?>
<section id="comments">
  <h3 class="h-header" title="<?php echo __('View Comments', 'montblanc'); ?>"><a class="comment-toggle" href="#comment_count" onclick="toggle()" data-placement="top" rel="tooltip" title="Show Comments"><?php printf(_n('1 Comment', '%1$s Comments', get_comments_number(), 'montblanc'), number_format_i18n(get_comments_number()), get_the_title()); ?></a></h3>
  <ol id="commentreveal" class="media-list" style="display:none;">
    <?php wp_list_comments(array('walker' => new Roots_Walker_Comment)); ?>
  </ol>

  <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
  <nav>
    <ul class="pager">
      <?php if (get_previous_comments_link()) : ?>
      <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'montblanc')); ?></li>
    <?php endif; ?>
    <?php if (get_next_comments_link()) : ?>
    <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'montblanc')); ?></li>
  <?php endif; ?>
</ul>
</nav>
<?php endif; ?>

<?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
  <div class="alert alert-warning">
    <?php _e('Comments are closed.', 'montblanc'); ?>
  </div>
<?php endif; ?>
</section><!-- /#comments -->
<?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
  <section id="comments">
    <div class="alert alert-warning">
      <?php _e('Comments are closed.', 'montblanc'); ?>
    </div>
  </section><!-- /#comments -->
<?php endif; ?>

<?php if (comments_open()) : ?>
  <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
  <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'montblanc'), wp_login_url(get_permalink())); ?></p>
<?php else : ?>
  <?php
  $commenter = wp_get_current_commenter();
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true' required" : '' );

  $args = array(

    'label_submit'      => __( 'Submit Comment', 'montblanc' ),

    'comment_field' =>  '<div class="form-group"><textarea name="comment" id="comment" class="form-control" rows="5" placeholder="' . __('Comment', 'montblanc') . '" required></textarea></div>',

    'comment_notes_before' => '',

    'comment_notes_after' => '',

    'fields' => apply_filters( 'comment_form_default_fields', array(

      'author' =>
      '<div class="row"><div class="col-sm-4"><div class="form-group"><input type="text" class="form-control" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="22" placeholder="' . __('Name', 'montblanc') . '"' . $aria_req . '></div></div>',

      'email' =>
      '<div class="col-sm-4"><div class="form-group"><input type="email" class="form-control" name="email" id="email" value="' . esc_attr($comment_author_email) .
      '" size="22" placeholder="' . __('Email (will not be published)', 'montblanc') . '"' . $aria_req . '></div></div>',

      'url' =>
      '<div class="col-sm-4"><div class="form-group"><input type="url" class="form-control" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" size="22" placeholder="' . __('Website', 'montblanc') . '"></div></div></div>'
      )
    ),
    ); ?>
    <?php comment_form($args); ?>
    <?php comment_id_fields(); ?>
  <?php endif; ?>
<?php endif; ?>