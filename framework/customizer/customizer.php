<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/customize_register
 * @since Mont Blanc 1.0.2
 */
class MontBlanc_Customize {
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @since Mont Blanc 1.0.2
    */
    public static function register ( $wp_customize ) {

    global $wp_version;

    /**
    * Panels
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */

    // Layout Panel
    $wp_customize->add_panel( 'montblanc_layout_panel', array(
    'priority'       => 50,
    'capability'     => 'edit_theme_options',
    'title'          => __('Layout', 'montblanc'),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Sections
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */

    // General
    $wp_customize->add_section( 'montblanc_general' , array(
        'title'      => __( 'General', 'montblanc' ),
        'priority'   => 30,
    ));
    // -----------------------------------------------------------------------------

    // Header
    $wp_customize->add_section( 'montblanc_header_section' , array(
        'title'      => __( 'Header', 'montblanc' ),
        'priority'   => 40,
        'description' => '',
    ));
    // -----------------------------------------------------------------------------

    // Meta
    $wp_customize->add_section( 'montblanc_meta' , array(
        'title'      => __( 'Post Options', 'montblanc' ),
        'priority'   => 60,
    ));
    // -----------------------------------------------------------------------------

    // Font Options
    $wp_customize->add_section( 'montblanc_fonts' , array(
        'title'      => __( 'Font Options', 'montblanc' ),
        'priority'   => 70,
    ));
    // -----------------------------------------------------------------------------

    // Colors
    $wp_customize->add_section( 'colors' , array(
        'title'      => __( 'Colors', 'montblanc' ),
        'priority'   => 80,
        'description' => __('Change your websites colors.', 'montblanc'),
    ));
    // -----------------------------------------------------------------------------

    // Logo
    $wp_customize->add_section( 'montblanc_logo_section' , array(
        'title'      => __( 'Logo', 'montblanc' ),
        'priority'   => 100,
        'description' => __('Upload a logo to replace the default site name in header', 'montblanc'),
    ));
    // -----------------------------------------------------------------------------

    // Favicon
    $wp_customize->add_section( 'montblanc_favicon_section', array(
      'priority'       => 110,
      'capability'     => 'edit_theme_options',
      'title'          => __('Favicon', 'montblanc'),
    ));
    // -----------------------------------------------------------------------------

    // Site Layout
    $wp_customize->add_section( 'montblanc_site_layout', array(
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'title'          => __('Layout', 'montblanc'),
    'panel'          => 'montblanc_layout_panel'
    ));
    // -----------------------------------------------------------------------------

    // Blog Layout
    $wp_customize->add_section( 'montblanc_blog_layout', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'title'          => __('Blog Layout', 'montblanc'),
    'panel'          => 'montblanc_layout_panel'
    ));
    // -----------------------------------------------------------------------------

    // Post Layout
    $wp_customize->add_section( 'montblanc_post_layout', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'title'          => __('Post Layout', 'montblanc'),
    'panel'          => 'montblanc_layout_panel'
    ));
    // -----------------------------------------------------------------------------

    // Page Layout
    $wp_customize->add_section( 'montblanc_page_layout', array(
    'priority'       => 40,
    'capability'     => 'edit_theme_options',
    'title'          => __('Page Layout', 'montblanc'),
    'panel'          => 'montblanc_layout_panel'
    ) );
     // -----------------------------------------------------------------------------
    
    /**
    * Show/Hide categories on posts
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_show_cat', array(
        'sanitize_callback' => 'montblanc_sanitize_checkbox',
    ));

    $wp_customize->add_control(
      'montblanc_show_cat',
      array(
        'description' => __('Show categories on posts?', 'montblanc'),
        'type' => 'checkbox',
        'label' => __('Show categories', 'montblanc'),
        'section' => 'montblanc_meta',
        'std' => '0'
        ));
    // -----------------------------------------------------------------------------

    /**
    * Show/Hide author on posts
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_show_author', array(
        'sanitize_callback' => 'montblanc_sanitize_checkbox',
    ));

    $wp_customize->add_control(
      'montblanc_show_author',
      array(
        'description' => __('Show the post author on articles?', 'montblanc'),
        'type' => 'checkbox',
        'label' => __('Show post author', 'montblanc'),
        'section' => 'montblanc_meta',
        'std' => '1'
        ));
    // -----------------------------------------------------------------------------

    /**
    * Change text preceding date
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('montblanc_meta_posted', array(
        'default'        => __('Posted on', 'montblanc'),
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'transport'      => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
        ));

    $wp_customize->add_control('montblanc_meta_posted', array(
        'label'      => __('Posted on', 'montblanc'),
        'section'    => 'montblanc_meta',
        'settings'   => 'montblanc_meta_posted',
        'description' => __('Change the text preceding the post date. Set to <b>"posted on"</b> by default.', 'montblanc')
        ));
    // -----------------------------------------------------------------------------

    /**
    * Title color
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting( 'blog_title_color' , array(
        'default'     => '#FFF',
        'transport'   => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
        ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blog_title_color', array(
        'label'        => __( 'Blog Title Color', 'montblanc' ),
        'section'    => 'colors',
        'settings'   => 'blog_title_color',
    )));
    // -----------------------------------------------------------------------------

    /**
    * Primary color
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting( 'primary_color' , array(
        'default'     => '#4671fb',
        'transport'   => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
        ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
        'label'        => __( 'Primary Color', 'montblanc' ),
        'section'    => 'colors',
        'settings'   => 'primary_color',
    )));
    // -----------------------------------------------------------------------------

    /**
    * Excerpt or content
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('show_post_content', array(
        'default'        => 'excerpt',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'montblanc_sanitize_content',
        ));

    $wp_customize->add_control('show_post_content', array(
        'label'      => __('Post Content', 'montblanc'),
        'section'    => 'montblanc_general',
        'settings'   => 'show_post_content',
        'description' => __('<b>Show content</b> will show the whole post content while <b>show excerpt</b> will only show the first few lines', 'montblanc'),
        'type'       => 'radio',
        'choices'    => array(
            'content' => __('Show content', 'montblanc'),
            'excerpt' => __('Show excerpt', 'montblanc')
            ),
        ));
    // -----------------------------------------------------------------------------

    /**
    * Container width
    * @author Frenchtastic
    * @since Mont Blanc 3.1
    */
    $wp_customize->add_setting('header_background_position', array(
        'default'        => 'fixed',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'montblanc_sanitize_background_attachment',
        ));

    $wp_customize->add_control('montblanc_header_background_position', array(
        'label'      => __('Background Position', 'montblanc'),
        'section'    => 'montblanc_header_section',
        'settings'   => 'header_background_position',
        'type'       => 'radio',
        'choices'    => array(
            'fixed' => __('Fixed', 'montblanc'),
            'scroll' => __('Static', 'montblanc')
            ),
        ));
    // -----------------------------------------------------------------------------

    /**
    * Header Color
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('header_color', array(
      'default'        => 'blue',
      'capability'     => 'edit_theme_options',
      'type'           => 'theme_mod',
      'sanitize_callback' => 'montblanc_sanitize_header_color',
      ));

    $wp_customize->add_control('header_color', array(
      'label'      => __('Header Color', 'montblanc'),
      'section'    => 'montblanc_header_section',
      'settings'   => 'header_color',
      'type'       => 'select',
      'choices'    => array(
        'turquoise' => __('Turquoise', 'montblanc'),
        'blue' => __('Blue', 'montblanc'),
        'red' => __('Red', 'montblanc'),
        'yellow' => __('Yellow', 'montblanc'),
        'green' => __('Green', 'montblanc'),
        'pink' => __('Pink', 'montblanc'),
        'purple' => __('Purple', 'montblanc'),
        'beige' => __('Beige', 'montblanc'),
        'gray' => __('Gray', 'montblanc')
        ),
      ));
    // -----------------------------------------------------------------------------

    /**
    * Header Transparency
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    if ( $wp_version >= 4.0 ) {
    $wp_customize->add_setting('mb_opacity_range', array(
      'default'        => 90,
      'capability'     => 'edit_theme_options',
      'type'           => 'theme_mod',
      'transport'      => 'refresh',
      'sanitize_callback' => 'montblanc_sanitize_opacity',
      ));

    $wp_customize->add_control( 'mb_opacity_range', array(
      'type'        => 'range',
      'priority'    => 10,
      'section'     => 'montblanc_header_section',
      'label'       => __('Header Transperancy', 'montblanc'),
      'description' => __('Change header transparency.', 'montblanc'),
      'input_attrs' => array(
        'min'   => 40,
        'max'   => 99,
        'step'  => 1,
        'class' => 'test-class test'
        ),
      ));
    }
    // -----------------------------------------------------------------------------

    /**
    * Header Overlay
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('header_overlay', array(
        'default'        => 'yes',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'montblanc_sanitize_header_overlay',
        ));

    $wp_customize->add_control('header_overlay', array(
        'label'      => __('Color Overlay', 'montblanc'),
        'section'    => 'montblanc_header_section',
        'settings'   => 'header_overlay',
        'description' => __('Color overlay on header', 'montblanc'),
        'type'       => 'select',
        'choices'    => array(
            'yes' => __('Yes', 'montblanc'),
            'no' => __('No', 'montblanc')
        ),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Menu on single post pages
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('single_menu_header', array(
        'default'        => 'no',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'montblanc_sanitize_menusingle',
        ));

    $wp_customize->add_control('single_menu_header', array(
        'label'      => __('Display menu on single post pages', 'montblanc'),
        'section'    => 'montblanc_menu_section',
        'settings'   => 'single_menu_header',
        'description' => __('Display menu on single post pages instead of post navigation and comment count.', 'montblanc'),
        'type'       => 'select',
        'choices'    => array(
            'yes'=> __('Yes', 'montblanc'),
            'no' => __('No', 'montblanc')
        ),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Logo
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_logo', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
    'label'    => __( 'Logo', 'montblanc' ),
    'section'  => 'montblanc_logo_section',
    'settings' => 'montblanc_logo',
    )));
    // -----------------------------------------------------------------------------

    /**
    * Container width
    * @author Frenchtastic
    * @since Mont Blanc 3.1
    */
    $wp_customize->add_setting('container_style', array(
        'default'        => 'full_width',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'montblanc_sanitize_container_style',
        ));

    $wp_customize->add_control('montblanc_option_container_style', array(
        'label'      => __('Style', 'montblanc'),
        'section'    => 'montblanc_site_layout',
        'settings'   => 'container_style',
        'type'       => 'radio',
        'choices'    => array(
            'full_width' => 'Full Width',
            'boxed' => 'Boxed'
            ),
        ));
    // -----------------------------------------------------------------------------

    /*
    * Link Color
    */ 
    $wp_customize->add_setting( 'outer_background_color', array(
            'default' => '#EEE', 
            'type' => 'theme_mod', 
            'capability' => 'edit_theme_options', 
            'transport' => 'postMessage', 
            'sanitize_callback' => 'sanitize_hex_color',
            ));           

    $wp_customize->add_control( new WP_Customize_Color_Control(  $wp_customize, 'montblanc_outer_background_color', array(
            'label' => __( 'Background Color', 'montblanc' ), 
            'section' => 'montblanc_site_layout', 
            'settings' => 'outer_background_color', 
            ) 
        ));
    // -----------------------------------------------------------------------------

    /**
    * Blog Layout
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('montblanc_page_layout_opt', array(
        'default'        => 'right',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'montblanc_sanitize_layout',
    ));

    $wp_customize->add_control('montblanc_page_layout_opt', array(
        'label'      => __('Sidebar', 'montblanc'),
        'section'    => 'montblanc_page_layout',
        'settings'   => 'montblanc_page_layout_opt',
        'description' => '',
        'type'       => 'radio',
        'choices'    => array(
            'left' => __('Left', 'montblanc'),
            'full_width' => __('Content Full Width / No sidebar', 'montblanc'),
            'right'   => __('Right', 'montblanc')
            ),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Blog Layout
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('montblanc_blog_layout_opt', array(
        'default'        => 'right',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'montblanc_sanitize_layout',
    ));

    $wp_customize->add_control('montblanc_blog_layout_opt', array(
        'label'      => __('Sidebar', 'montblanc'),
        'section'    => 'montblanc_blog_layout',
        'settings'   => 'montblanc_blog_layout_opt',
        'description' => '',
        'type'       => 'radio',
        'choices'    => array(
            'left' => __('Left', 'montblanc'),
            'full_width' => __('Content Full Width / No sidebar', 'montblanc'),
            'right'   => __('Right', 'montblanc')
            ),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Post Layout
    * @author Frenchtastic.eu
    * @since Mont Blanc 1.0
    */
    $wp_customize->add_setting('montblanc_post_layout_opt', array(
        'default'        => 'right',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'montblanc_sanitize_layout',
    ));

    $wp_customize->add_control('montblanc_post_layout_opt', array(
        'label'      => __('Sidebar', 'montblanc'),
        'section'    => 'montblanc_post_layout',
        'settings'   => 'montblanc_post_layout_opt',
        'description' => '',
        'type'       => 'radio',
        'choices'    => array(
            'left' => __('Left', 'montblanc'),
            'full_width' => __('Content Full Width / No sidebar', 'montblanc'),
            'right'   => __('Right', 'montblanc')
            ),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Body Font
    * @author Frenchtastic
    * @since Mont Blanc 1.0.8
    */
    $wp_customize->add_setting('body_font', array(
        'default'        => 'Helvetica Neue',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
        'sanitize_callback' => 'montblanc_sanitize_fontfamily',
    ));

    $wp_customize->add_control('montblanc_body_font', array(
        'label'      => __('Body Font', 'montblanc'),
        'section'    => 'montblanc_fonts',
        'settings'   => 'body_font',
        'description' => 'Pick a font for body text. Default is Roboto',
        'type'       => 'select',
        'choices'    => array(
            'Roboto' => 'Roboto, sans-serif',
            'Helvetica Neue' => 'Helvetica Neue',
            'Open Sans' => 'Open Sans',
            'Arial' => 'Arial',
            'Comic Sans MS' => 'Comic Sans MS',
            'Times New Roman' => 'Times New Roman',
            'Verdana' => 'Verdana',
            'Fantasy' => 'Fantasy',
            'Monospace' => 'Monospace',
            'Cursive' => 'Cursive',
            'Serif' => 'Serif',
            'Courier' => 'Courier',
            'Monaco' => 'Monaco'
        ),
    ));
    // -----------------------------------------------------------------------------

    /**
    * Headings
    * @author Frenchtastic
    * @since Mont Blanc 1.0.8
    */
    $wp_customize->add_setting('headings_font', array(
        'default'        => 'Helvetica Neue',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
        'sanitize_callback' => 'montblanc_sanitize_fontfamily',
    ));

    $wp_customize->add_control('montblanc_headings_font', array(
        'label'      => __('Heading Font', 'montblanc'),
        'section'    => 'montblanc_fonts',
        'settings'   => 'headings_font',
        'description' => 'Pick a font for all headings. Default is Helvetica Neue',
        'type'       => 'select',
        'choices'    => array(
            'Helvetica Neue' => 'Helvetica Neue',
            'Roboto' => 'Roboto, sans-serif',
            'Open Sans' => 'Open Sans',
            'Arial' => 'Arial',
            'Comic Sans MS' => 'Comic Sans MS',
            'Times New Roman' => 'Times New Roman',
            'Verdana' => 'Verdana',
            'Fantasy' => 'Fantasy',
            'Monospace' => 'Monospace',
            'Cursive' => 'Cursive',
            'Serif' => 'Serif',
            'Courier' => 'Courier',
            'Monaco' => 'Monaco'
        ),
    ));
    // -----------------------------------------------------------------------------

    global $wp_version;
    if(version_compare($wp_version, '4.3', '<')):

    /**
    * Favicon
    * @author Frenchtastic
    * @since Montblanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_favicon', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'montblanc_favicon_option', array(
      'label'    => __( 'Favicon', 'montblanc' ),
      'section'  => 'montblanc_favicon_section',
      'settings' => 'montblanc_favicon',
      'description' => __('Change your site\'s favicon, <b>Image must be <u>16x16px</u> or <u>32x32px</u>, format must be <u>.png</u></b>', 'montblanc'),
    )));

    // -----------------------------------------------------------------------------

    /**
    * Apple bookmark for iPhones
    * @author Frenchtastic
    * @since Montblanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_bookmark_iphone', array(
      'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'montblanc_bookmark_iphone_option', array(
      'label'    => __( 'Retina iPhone Bookmark', 'montblanc' ),
      'section'  => 'montblanc_favicon_section',
      'settings' => 'montblanc_bookmark_iphone',
      'description' => __('Upload image to be used as bookmark on iPhones with retina screen. <b>Size must be <u>120x120</u> and format <u>.png</u></b>', 'montblanc'),
    )));

    // -----------------------------------------------------------------------------

    /**
    * Apple bookmark for iPads
    * @author Frenchtastic
    * @since Montblanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_bookmark_ipad', array(
      'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'montblanc_bookmark_ipad_option', array(
      'label'    => __( 'Retina iPad Bookmark', 'montblanc' ),
      'section'  => 'montblanc_favicon_section',
      'settings' => 'montblanc_bookmark_ipad',
      'description' => __('Upload image to be used as bookmark on iPads with retina screen. <b>Size must be <u>152x152</u> and format <u>.png</u></b>', 'montblanc'),
    )));

    // -----------------------------------------------------------------------------

    /**
    * Apple bookmark for iPads
    * @author Frenchtastic
    * @since Montblanc 1.0
    */
    $wp_customize->add_setting( 'montblanc_bookmark_other', array(
      'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'montblanc_bookmark_other_option', array(
      'label'    => __( 'Bookmark Icon', 'montblanc' ),
      'section'  => 'montblanc_favicon_section',
      'settings' => 'montblanc_bookmark_other',
      'description' => __('Upload image to be used as bookmark icon on other Apple devices. <b>Size must be <u>76x76px</u> and format <u>.png</u></b>', 'montblanc'),
    )));

    endif;

    // -----------------------------------------------------------------------------
        
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
      $wp_customize->get_setting( 'headings_font' )->transport = 'postMessage';
      $wp_customize->get_setting( 'body_font' )->transport = 'postMessage';
    }

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * 
    * Used by hook: 'wp_head'
    * 
    * @see add_action('wp_head',$func)
    * @since Mont Blanc 1.0.2
    */
   public static function header_output() {

    $mb_tr_range = get_theme_mod('mb_opacity_range', 9);

    $mb_header_overlay = get_theme_mod( 'header_overlay', 'yes' );
    
    if(get_theme_mod('header_color') == 'turquoise' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(118, 240, 253, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'red' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(255, 78, 91, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'yellow' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(245, 208, 42, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'green' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(127, 240, 147, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'blue' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(70, 113, 251, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'beige' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(236, 230, 215, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'purple' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(180, 60, 187, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'pink' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(233, 30, 99, 0.'. $mb_tr_range .')';
    } elseif(get_theme_mod('header_color') == 'gray' && $mb_header_overlay == 'yes'){
        $mb_header_color = 'rgba(177, 174, 174, 0.'. $mb_tr_range .')';
    } elseif($mb_header_overlay != 'yes') {
        $mb_header_color = 'transparent';
    } else{
        $mb_header_color = 'none';
    }

    $var_primary_color = get_theme_mod('primary_color');
    $var_blog_title_color = get_theme_mod('blog_title_color');

    if(!empty($var_primary_color)){
        $primary = $var_primary_color;
    } else {
        $primary = '#4671fb';
    }
    if(!empty($var_blog_title_color)){
        $title_color = $var_blog_title_color;
    } else {
        $title_color = '#FFF';
    }
    ?>
    <!--Customizer CSS--> 
    <style type="text/css">
        <?php self::generate_css('h1 a, .h1 a, h2 a, .h2 a, h3 a, .h3 a, h4 a, .h4 a, h5 a, .h5 a, h6 a, .h6 a, h1, .h1, h2, .h2, h3, .h3, 
    h4, .h4, h5, .h5, h6, .h6, .blog-description', 'font-family', 'headings_font'); ?>
        <?php self::generate_css('body', 'font-family', 'body_font'); ?>
        .transparency::before{
        background-color: <?php echo $mb_header_color; ?> !important;
        }
        .site-title a{
        color: <?php echo $title_color; ?> !important;
        }
        a, a:visited {
        color: <?php echo $primary; ?>;
        }
        a:hover, a:active {
        border-color: <?php echo $primary; ?>;
        }
        .bypostauthor .media-heading{
        background-color: <?php echo $primary; ?>;
        }
        .form-control:focus {
        border-color: <?php echo $primary; ?>;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
        background-color: <?php echo $primary; ?>;
        border-color: <?php echo $primary; ?>;
        }
        .btn-primary{
        background-color: <?php echo $primary; ?>;
        border-color: <?php echo $primary; ?>;
        }
        .search-field:focus {
        border-color: <?php echo $primary; ?>;
        }
        .format-chat .post-content p:nth-child(odd) {
        border-left-color: <?php echo $primary; ?>;
        }

        <?php if(get_theme_mod('container_style', 'full_width') == 'boxed'): ?>
            body {
                background: <?php echo get_theme_mod('outer_background_color', '#EEE'); ?>
            }
            @media(min-width:1170px){
                #wrap {
                    max-width: 1300px;
                    width: calc(100% - 200px);
                    margin: 0px auto;
                    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.125);
                }
                .container {
                  max-width: calc(100% - 80px);
                  width: 1170px;
              }
          }
          @media (max-width:1170px) and (min-width: 1000px) {
            #wrap {
                width: calc(100% - 100px);
                margin: 0px auto;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.125);
            }
            .container {
              max-width: calc(100% - 100px);
          }
        }
        <?php endif; ?>

        </style>
    
        
      <!--/Customizer CSS-->
      <?php
   }
   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since Mont Blanc 1.0.2
    */
   public static function live_preview() {
      wp_enqueue_script( 
           'montblanc-themecustomizer', 
           get_template_directory_uri() . '/framework/js/theme-customizer.js',
           array(  'jquery', 'customize-preview' ),
           '',
           true // Specify whether to put in footer (leave this true)
      );
   }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since Mont Blanc 1.0.2
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'MontBlanc_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'MontBlanc_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'MontBlanc_Customize' , 'live_preview' ) );