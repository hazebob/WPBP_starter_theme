<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package WPBP
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=yes,width=device-width,height=device-height" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php WPBP_favicon_display(); ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'open' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-inner">
			<div class="site-branding logo">
				<h1 class="site-title">
					<a href="<?php echo home_url('/'); ?>" rel="home">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
					</a>
				</h1>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation gnb cf" role="navigation">
				<span class="tog">
					<i class="xe xi-bars"></i>
				</span>
				<?php
					wp_nav_menu( array( 'menu' => 'gnb' ) );
				?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content cf">
