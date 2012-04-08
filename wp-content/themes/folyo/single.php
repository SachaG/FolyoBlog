<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); 

?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<a href="<?php the_permalink() ?>" class="entry-date">
						<span class="month"><?php echo get_the_date("M"); ?></span>
						<span class="day"><?php echo get_the_date("j"); ?></span>
						<span class="full-date"><?php echo get_the_date("Y/m/d \a\\t g:i a"); ?></span>
					</a>
					<?php /* 
					<div class="entry-instapaper">
						<iframe border="0" scrolling="no" width="78" height="17" allowtransparency="true" frameborder="0"
						 style="margin-bottom: -3px; z-index: 1338; border: 0px; background-color: transparent; overflow: hidden;"
						 src="http://www.instapaper.com/e2?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&description=<?php the_excerpt(); ?>"></iframe>
					</div>
					*/ ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
					<?php
					if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						?>
						<div class="entry-image">
								<?php the_post_thumbnail('full'); ?>
								<?php 
								$thumbnail=get_post( get_post_thumbnail_id() );
								if($thumbnail->post_excerpt){
									?>
								<p class="credit">Photo credit: <a target="_blank" href="<?php echo $thumbnail->post_content ?>"><?php echo $thumbnail->post_excerpt ?></a></p>
								<?php } ?>
						</div>
					<?php
					}
					?>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'boilerplate' ), 'after' => '' ) ); ?>
					</div><!-- .entry-content -->
<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<footer id="entry-author-info">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'boilerplate_author_bio_avatar_size', 60 ) ); ?>
						<h2><?php printf( esc_attr__( 'About %s', 'boilerplate' ), get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php printf( __( 'View all posts by %s &rarr;', 'boilerplate' ), get_the_author() ); ?>
						</a>
					</footer><!-- #entry-author-info -->
<?php endif; ?>
					<footer class="entry-follow">
						<h4>Enjoyed the post? Then you should <a href="http://twitter.com/SachaGreif">follow me on Twitter</a> or <a href="<?php bloginfo('atom_url'); ?>">subscribe to the RSS feed</a>.</h4>
					</footer>
					<footer class="entry-share">
						<h4>Share:</h4>
						<div class="share-option" id="twitter">		
						</div>
						<div class="share-option" id="facebook">			
						</div>
						<div class="share-option" id="googleplus">
						</div>
					</footer>
					<footer class="entry-utility">
						<?php boilerplate_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'boilerplate' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-utility -->
				</article><!-- #post-## -->
				<div class="read-next">
				<nav id="nav-below" class="navigation">
					<div class="post-preview nav-previous">
						<?php
						$prev_post=get_previous_post();
						if($prev_post){
							sg_post_thumbnail($prev_post->ID);
							?>
							<h4>Previous Post</h4>							
							<?php
						}else{
							?>
							<div class="entry-image blank"></div>
							<?php
						}
						?>
						<?php //previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'boilerplate' ) . '</span> %title' ); ?>
					</div>
					<div class="post-preview nav-current">
						<?php 
						sg_post_thumbnail(get_the_ID(), "#");
						?>
						<h4>Back to Top</h4>						
					</div>
					<div class="post-preview nav-next">
						<?php
						$next_post=get_next_post();
						if($next_post){
							sg_post_thumbnail($next_post->ID);
							?>
							<h4>Next Post</h4>	
							<?php
						}else{
							?>
							<div class="entry-image blank"></div>
							<?php
						}
						?>									
						<?php //next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'boilerplate' ) . '</span>' ); ?>
						</div>
				</nav><!-- #nav-below -->
				</div>
				<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
