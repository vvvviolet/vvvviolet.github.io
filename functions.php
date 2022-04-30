<?php
/**
 * MontBlanc functions
 * 
 * @package MontBlanc
 * @author Frenchtastic.eu
 */

// Setup
if ( ! function_exists( 'montblanc_setup' ) ) :
function montblanc_setup(){
    
    // Add Localization
    load_theme_textdomain('montblanc', get_template_directory() . '/framework/languages');

    // Add Automatic RSS Support
    add_theme_support('automatic-feed-links');

    // Add Thumbnail Size
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 924, 360, true );
    add_image_size('large-image', 9999, 9999, false);

    // Custom Header
    $montblanc_header_args = array(
      'default-image' => get_template_directory_uri() . '/framework/img/montblanc.png',
      'flex-width'    => true,
      'width'         => 1920,
      'flex-height'    => true,
      'height'        => 1100,
      'random-default' => false,
      'header-text'   => false,
      'uploads'       => true,
    );
    add_theme_support( 'custom-header', $montblanc_header_args);

    // Navigation Menus
    register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'montblanc' ),
    ) );
    register_nav_menus( array(
    'mobile' => __( 'Mobile menu', 'montblanc' ),
    ) );

    // Add Post Formats
    add_theme_support('post-formats', array(
      'quote', 
      'image', 
      'chat'
    ));

    // HTML5 Support
    add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
      ) );

    // Content Width
    global $content_width;
    if(!isset($content_width)) $content_width = 908;

}
endif; // montblanc_setup
add_action( 'after_setup_theme', 'montblanc_setup' );

/**
 * Enqueue scripts and styles.
 */
function montblanc_scripts() {

	global $wp_styles;

    // Google Font
    wp_enqueue_style( 'g-fonts', montblanc_fonts_url(), array(), null );

	// CSS
	wp_enqueue_style('bootstrap', get_template_directory_uri() . "/framework/css/bootstrap.min.css", array(), '0.1', 'screen');
	wp_enqueue_style('blog', get_template_directory_uri() . "/framework/css/blog.css", array(), '0.1', 'screen');

	// Font Awesome
	wp_enqueue_style('font_awesome_css',
		get_template_directory_uri()."/framework/css/font-awesome.min.css", array(), '0.1', 'screen' );

	// montblanc JS
	wp_enqueue_script('montblanc_js', get_template_directory_uri() . "/framework/js/montblanc.js", array('jquery'));

	// JavaScript
	wp_enqueue_script('bootstrap-js', get_template_directory_uri()."/framework/js/bootstrap.min.js", array('jquery'));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
    }

    // Conditional (if lt IE 9 )
    wp_enqueue_style( 'html5-shiv', get_stylesheet_directory_uri() . "/framework/js/html5shiv.min.js", array()  );
    $wp_styles->add_data( 'html5-shiv', 'conditional', 'lt IE 9' );

    // Conditional (if lt IE 9 )
    wp_enqueue_style( 'respond-js', get_stylesheet_directory_uri() . "/framework/js/respond.min.js", array()  );
    $wp_styles->add_data( 'respond-js', 'conditional', 'lt IE 9' );

}

add_action('wp_enqueue_scripts','montblanc_scripts');

/**
 * Enqueue script for custom customize control.
 */
function montblanc_custom_customize_enqueue() {
  wp_enqueue_script('admin_js', get_template_directory_uri() . "/framework/js/admin-js.js", array( 'jquery', 'customize-controls' ), false, true);
  wp_enqueue_style( 'custom-customize-css', get_stylesheet_directory_uri() . "/framework/css/custom.customize.css", array()  );
}
add_action( 'customize_controls_enqueue_scripts', 'montblanc_custom_customize_enqueue' );

// montblanc Includes
require_once get_template_directory() . '/framework/customizer/customizer.php';
require_once get_template_directory() . '/framework/customizer/customizer-sanitize.php';
require_once get_template_directory() . '/framework/customizer/customizer-reset.php';

require_once get_template_directory() . '/framework/general.php';
require_once get_template_directory() . '/comments.php';
require_once get_template_directory() . '/framework/wp_bootstrap_navwalker.php';