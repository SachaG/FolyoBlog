<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
<div id="sidebar">

	<ul class="widgets">
		<li class="widget-container widget_tagline"><h3><span>About</span></h3>
		<p id="tagline">Hi! I’m Sacha Greif, a designer, coder, and entrepreneur living in Paris. This is my blog, and <a href="http://twitter.com/SachaGreif">I'm on Twitter</a>, too.</p>
		</li>
				
		<li class="widget-container widget_fusion">
			<h3><span>Supported By</span></h3>
			<div id="fusion_ad">
				<a class="fusion-link" href="http://fusionads.net">Powered by Fusion</a>
			</div>			
		</li>

	<?php
		/* When we call the dynamic_sidebar() function, it'll spit out
		 * the widgets for that widget area. If it instead returns false,
		 * then the sidebar simply doesn't exist, so we'll hard-code in
		 * some default sidebar stuff just in case.
		 */
		if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
	
				<li>
					<?php get_search_form(); ?>
				</li>

				<li>
					<h3><?php _e( 'Archives', 'boilerplate' ); ?></h3>
					<ul>
						<?php wp_get_archives( 'type=monthly' ); ?>
					</ul>
				</li>

				<li>
					<h3><?php _e( 'Meta', 'boilerplate' ); ?></h3>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</li>

			<?php endif; // end primary widget area ?>
			<li class="widget-container widget_social social clearfix">
				<h3><span>Elsewhere</span></h3>
			<ul class="clearfix">
				<li class="twitter"><a href="http://twitter.com/SachaGreif">Twitter</a></li>
				<li class="dribbble"><a href="http://dribbble.com/sacha">Dribbble</a></li>
				<li class="quora"><a href="http://quora.com/Sacha-Greif">Quora</a></li>
				<!-- <li class="zerply"><a href="http://zerply.com/SachaGreif">Zerply</a></li> -->
				<li class="blank"></li>
				<li class="blank"></li>
				<li class="blank"></li>
			</ul>
			</li>

			<li class="widget-container widget_folyo">
				<h3><span>My Startup</span></h3>
			<a href="http://folyo.me"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/folyo-ad-240b.png" alt="Folyo"/></a>
			<p>Need a designer? <a href="http://folyo.me">Folyo</a> helps companies find great, vetted freelance designers.</p>
			</li>
						
			<li class="widget-container widget_smashing">
							<h3><span>Part Of The</span></h3>
				<a href="http://www.smashingmagazine.com/the-smashing-network/"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/smashing-network-s.png"/></a><br/>
			</li>
				</ul>

	<?php
		// A second sidebar for widgets, just because.
		if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

				<ul class="xoxo">
					<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
				</ul>

	<?php endif; ?>
	
</div>