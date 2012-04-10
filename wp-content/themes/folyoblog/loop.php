<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'boilerplate' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'boilerplate' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<div class="posts-river">
	<?php while ( have_posts() ) : the_post(); ?>

	
	<?php /* How to display posts in the asides category */ ?>

		<?php if ( in_category( _x('asides', 'asides category slug', 'boilerplate') ) ) : ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class("clearfix"); ?>>

			<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php else : ?>
				<div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boilerplate' ) ); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>

	<?php /* 
				<footer class="entry-utility">
									<?php boilerplate_posted_on(); ?>
									|
									<?php comments_popup_link( __( 'Leave a comment', 'boilerplate' ), __( '1 Comment', 'boilerplate' ), __( '% Comments', 'boilerplate' ) ); ?>
									<?php edit_post_link( __( 'Edit', 'boilerplate' ), '| ', '' ); ?>
								</footer><!-- .entry-utility -->
			</article><!-- #post-## -->
	*/ ?>

	<?php /* How to display all other posts. */ ?>

		<?php else : ?>
			<?php 
			$imageClass="";
			if ( has_post_thumbnail() ) $imageClass=" has-thumbnail";
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class("clearfix".$imageClass); ?>>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'boilerplate' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
					?>
					<div class="entry-image">
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('medium'); ?>
						</a>
					</div>
				<?php
				}
				?>


	
				<a href="<?php the_permalink() ?>" class="entry-date">
					<span class="month"><?php echo get_the_date("M"); ?></span>
					<span class="day"><?php echo get_the_date("j"); ?></span>
					<span class="full-date"><?php echo get_the_date("Y/m/d \a\\t g:i a"); ?></span>
				</a>

				<div class="entry-meta">
					<?php if ( comments_open() ) comments_popup_link( __( 'Leave a comment', 'boilerplate' ), __( '1 Comment', 'boilerplate' ), __( '% Comments', 'boilerplate' ) ); ?>
				</div><!-- .entry-meta -->

				<div class="entry-summary">
					<?php //the_content('<span class="read-more">…</span>'); ?>
					<?php the_excerpt('<span class="read-more">…</span>'); ?>

				</div>
				
		


	<?php /*
				<footer class="entry-utility">
					<?php if ( count( get_the_category() ) ) : ?>
						<?php printf( __( 'Posted in %2$s', 'boilerplate' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
						|
					<?php endif; ?>
					<?php
						$tags_list = get_the_tag_list( '', ', ' );
						if ( $tags_list ):
					?>
						<?php printf( __( 'Tagged %2$s', 'boilerplate' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
						|
					<?php endif; ?>
					<?php comments_popup_link( __( 'Leave a comment', 'boilerplate' ), __( '1 Comment', 'boilerplate' ), __( '% Comments', 'boilerplate' ) ); ?>
					<?php edit_post_link( __( 'Edit', 'boilerplate' ), '| ', '' ); ?>
				</footer><!-- .entry-utility -->
				*/?>
			</article><!-- #post-## -->

			<?php comments_template( '', true ); ?>

		<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

	<?php endwhile; // End the loop. Whew. ?>
</div>
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-below" class="navigation">
		<div class="nav-previous">
			<?php next_posts_link( __( 'Older posts', 'boilerplate' ) ); ?>
		</div>
		<div class="nav-next">
			<?php previous_posts_link( __( 'Newer posts', 'boilerplate' ) ); ?>
		</div>
	</nav><!-- #nav-below -->
<?php endif; ?>