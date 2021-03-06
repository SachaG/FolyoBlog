<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 * We filter the output of wp_title() a bit -- see
			 * boilerplate_filter_wp_title() in functions.php.
			 */
			wp_title( '|', true, 'right' );
		?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory' ); ?>/favicon.ico" />
		
		<!--
		<script type="text/javascript" src="http://use.typekit.com/kdx2dsb.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		-->

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:100,400italic,700italic,400,700' rel='stylesheet' type='text/css'>		
<?php
			
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
		<?php 
		if ( is_singular())
			echo '<a class="back-to-home" href="/">Back to blog home</a>';
		?>
		<div class="container clearfix">
		<header>
			<h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<div class="tagline">
				<p>I'm <a href="http://sachagreif.com" target="_blank">Sacha Greif</a>, a designer &amp; entrepreneur living in Kyoto. </p>
				<p>These are my notes about running <a href="http://folyo.me">Folyo</a>, a private job board that helps startups find great hand-picked designers.</p>
			</div>
			<nav id="navigation" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<a id="skip" href="#content" title="<?php esc_attr_e( 'Skip to content', 'boilerplate' ); ?>"><?php _e( 'Skip to content', 'boilerplate' ); ?></a>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
				
				<?php select_menu(); ?>
			</nav>
		</header>
		<section id="content" role="main">
			<div class="inner">
