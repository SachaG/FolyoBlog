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
		<li id="must-read" class="widget-container">	
			<h3 class="widget-title"><span>Read This First</span></h3>
				<ul>
				<li><a href="http://folyo.me/guides/how_to_pick_a_great_designer" title="How to Pick a Great Designer">How to Pick a Great Designer</a></li>
				<li><a href="http://folyo.me/guides/how_to_write_a_good_job_description" title="How to Write a Good Job Description">How to Write a Good Job Description</a></li>
				<li><a href="/how-much-does-a-website-cost-and-other-pricing-questions/" title="How Much Does a Website Cost?">How Much Does a Website Cost?</a></li>
				</ul>
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
	</ul>

	<?php
		// A second sidebar for widgets, just because.
		if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

				<ul class="xoxo">
					<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
				</ul>

	<?php endif; ?>
	
</div>