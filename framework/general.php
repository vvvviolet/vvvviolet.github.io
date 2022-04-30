<?php

function montblanc_fonts_url() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Roboto, translate this to 'off'. Do not translate
    * into your own language.
    */
    $roboto = _x( 'on', 'Roboto font: on or off', 'mont-blanc' );
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Serif, translate this to 'off'. Do not translate
    * into your own language.
    */
    $pt_serif = _x( 'on', 'PT Serif font: on or off', 'mont-blanc' );
 
    if ( 'off' !== $roboto || 'off' !== $pt_serif ) {
        $font_families = array();
 
        if ( 'off' !== $roboto ) {
            $font_families[] = 'Roboto:400,300';
        }
 
        if ( 'off' !== $pt_serif ) {
            $font_families[] = 'PT+Serif:400,400italic';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function montblanc_wp_title( $title, $sep ) {
  if ( is_feed() ) {
    return $title;
  }

  global $page, $paged;

  // Add the blog name
  $title .= get_bloginfo( 'name', 'display' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " $sep $site_description";
  }

  // Add a page number if necessary:
  if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
    $title .= " $sep " . sprintf( __( 'Page %s', 'montblanc' ), max( $paged, $page ) );
  }

  return $title;
}
add_filter( 'wp_title', 'montblanc_wp_title', 10, 2 );

/**
* Register three widget areas
* & one sidebar
* @author Frenchtastic.eu
* @since Mont Blanc 1.0
*/
function montblanc_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'montblanc' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the right.', 'montblanc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		));

  register_sidebar( array(
    'name'          => __( 'Primary Widget Area', 'montblanc' ),
    'id'            => 'widget-1',
    'description'   => __( 'Appears first in the footer section. This option will override the default widgets.', 'montblanc' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Secondary Widget Area', 'montblanc' ),
    'id'            => 'widget-2',
    'description'   => __( 'Appears second in the footer section. This option will override the default widgets.', 'montblanc' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Third Widget Area', 'montblanc' ),
    'id'            => 'widget-3',
    'description'   => __( 'Appears third in the footer section. This option will override the default widgets.', 'montblanc' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
}
add_action('widgets_init', 'montblanc_widgets_init');

function montblanc_next_posts_link_attributes(){
  return 'class="older-posts"';
}
add_filter('next_posts_link_attributes', 'montblanc_next_posts_link_attributes');

function montblanc_previous_posts_link_attributes(){
  return 'class="newer-posts"';
}
add_filter('previous_posts_link_attributes', 'montblanc_previous_posts_link_attributes');

function montblanc_commentCount(){
  global $post;
  $montblanc_the_id = $post->ID;
  $montblanc_thepost= get_post($id= $montblanc_the_id);
  $montblanc_comment_count = $montblanc_thepost->comment_count;

  echo '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="#com_container" data-placement="bottom" rel="tooltip" title="' . __('Show Comments', 'montblanc') . '"><i class="fa fa-comment-o"></i> ' .$montblanc_comment_count.'</a></li>';
}

function montblanc_previousPost() {
  $montblanc_prev_post = get_previous_post();
  if(!empty($montblanc_prev_post)){
    echo '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'.get_permalink( $montblanc_prev_post->ID).'"><i class="fa fa-angle-down"></i> '. __('Previous Post', 'montblanc') .'</a></li>';
  }
}

function montblanc_nextPost() {
  $montblanc_next_post = get_next_post();
  if(!empty($montblanc_next_post)){
    echo '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'.get_permalink( $montblanc_next_post->ID).'">'. __('Next Post', 'montblanc') .' <i class="fa fa-angle-up"></i></a></li>';
  }
}

function montblanc_authorLink(){
  global $post;
  $montblanc_author_id = $post->post_author;
  $montblanc_author_name = get_the_author_meta( 'display_name', $montblanc_author_id );
  $montblanc_author_name = ucfirst($montblanc_author_name);
  $montblanc_author_url = get_author_posts_url( $post->post_author );

  echo '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'.$montblanc_author_url.'" data-placement="bottom" rel="tooltip" title="' . __('Author\'s profile', 'montblanc') . '">'.$montblanc_author_name.'</a></li>';
}


/**
* Shows post author link if set to in settings
* @author Frenchtastic
* @since montblanc 1.7
*/
function montblanc_author(){
  global $post;
  $montblanc_author_id = $post->post_author;
  $montblanc_author_name = get_the_author_meta( 'display_name', $montblanc_author_id );
  $montblanc_author_name = ucfirst($montblanc_author_name);
  $montblanc_author_url = get_author_posts_url( $post->post_author );

  if (get_theme_mod( 'montblanc_show_author' ) == '1'){
    echo __('by', 'montblanc'), '<a href="'.$montblanc_author_url.'"> '.$montblanc_author_name.'</a>';
  }
}

/**
* Changes text preceding the post date
* @author Frenchtastic
* @since montblanc 1.7
*/
function montblanc_post_date(){
  $montblanc_meta = get_theme_mod('montblanc_meta_posted');

  if (empty($montblanc_meta)){
    echo __('Posted on', 'montblanc');
  } else {
    echo esc_html( $montblanc_meta );
  }
}

/**
* Displays categories if set to do so in settings
* @author Frenchtastic
* @since montblanc 1.7
*/
function montblanc_cat(){
      global $post;
      $categories = get_the_category($post->ID);
      $separator = ', ';
      $output = 'in ';
      if($categories && get_theme_mod( 'montblanc_show_cat' ) == '1'){
        foreach($categories as $category) {
          $output .= ' <a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'montblanc' ), $category->name ) ) . '"> '.$category->cat_name.'</a>'.$separator;
        }
        echo trim($output, $separator);
      }
}

/**
* Excerpt length
* @since montblanc 1.0
*/
function montblanc_excerpt_length( $length ) {
  return 73;
}
add_filter( 'excerpt_length', 'montblanc_excerpt_length', 999 );

/**
* Read more link
* @since montblanc 1.0
*/
function montblanc_read_more( $more ) {
  return '.. <a class="read-more-link" href="'.get_permalink( get_the_ID() ).'">'.__('Read More', 'montblanc').'</a>';
}
add_filter('excerpt_more', 'montblanc_read_more');

add_filter('wp_list_categories', 'montblanc_count_span');
function montblanc_count_span($links) {
  $links = str_replace('</a> (', '</a> <span class="cat-count">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}