<?php
/**
 * The header
 *
 * Displays all of the <head> section and everything up till <main id="content">
 *
 * @package Mont Blanc
 * @author Frenchtastic
 */
$montblanc_favicon = get_theme_mod( 'montblanc_favicon');
$montblanc_bookmark_other = get_theme_mod( 'montblanc_bookmark_other');
$montblanc_bookmark_iphone = get_theme_mod( 'montblanc_bookmark_iphone');
$montblanc_bookmark_ipad = get_theme_mod( 'montblanc_bookmark_ipad');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <?php if(!empty($montblanc_favicon)): ?>
  <link rel="shortcut icon" href="<?php echo esc_url( get_theme_mod( 'montblanc_favicon' ) ); ?>" type="image/png" />
<?php endif; ?>

<?php if(!empty($montblanc_bookmark_other)): ?>
  <link rel="apple-touch-icon" href="<?php echo esc_url( get_theme_mod( 'montblanc_bookmark_other' ) ); ?>">
<?php endif; ?>

<?php if(!empty($montblanc_bookmark_iphone)): ?>
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url( get_theme_mod( 'montblanc_bookmark_iphone' ) ); ?>">
<?php endif; ?>

<?php if(!empty($montblanc_bookmark_ipad)): ?>
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url( get_theme_mod( 'montblanc_bookmark_ipad' ) ); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="wrap">

    <div class="row">
      <div class="col-sm-12">
        <header class="header-content transparency">

          <?php if (get_header_image() != ''): ?>
          <div class="header-background-box" style="background-image: url('<?php header_image(); ?>'); background-attachment: <?php echo get_theme_mod('header_background_position', 'fixed'); ?>;"></div>
        <?php else: ?>
        <div class="header-background-box" style="background-image: url('<?php echo get_template_directory_uri() . '/framework/img/montblanc.png' ?>'); background-attachment: <?php echo get_theme_mod('header_background_position', 'fixed'); ?>;"></div>
      <?php endif; ?>

      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <?php if ( get_theme_mod( 'montblanc_logo' ) ) : ?>
            <div class="site-logo">
              <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'montblanc_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
            </div>
            <h4 class="blog-description"><?php echo get_bloginfo( 'description', 'raw' ); ?></h4>
          <?php else: ?>
          <h1 class="site-title"><a class="#site-title" href="<?php echo esc_url( home_url() ) ?>"><?php bloginfo('name'); ?></a></h1>
          <h4 class="blog-description"><?php echo get_bloginfo( 'description', 'raw' ); ?></h4>
        <?php endif; ?>
      </div>
    </div>
  </div>

</header>
</div>
</div>

      <nav class="navbar navbar-default" role="navigation">
        <div class="container">

          <ul id="menu-menu-1" class="nav navbar-nav">
            <li class="home-link menu-item menu-item-type-post_type menu-item-object-page">
              <a id="search_toggle" href="#fake"><i class="fa fa-search"></i></a>
            </li>
            <li class="search-box" style="display:none">
              <?php get_search_form(); ?>
            </li>
          </ul>
          <?php
          wp_nav_menu( array(
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'bs-example-navbar-collapse-1',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
          );
          ?>
        </div>
      </nav>
      <nav class="navbar navbar-default mobile-menu" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="mobile-search">
            <?php get_search_form(); ?>
          </div>
          <div class="mobile-toggle navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
              <span class="sr-only"><?php echo __('Toggle navigation', 'montblanc'); ?></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <?php
          wp_nav_menu( array(
            'theme_location'    => 'mobile',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'bs-example-navbar-collapse-2',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
          );
          ?>
        </div>
      </nav>