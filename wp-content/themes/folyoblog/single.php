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
				<?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
					?>
					<div class="featured-image">
						<div class="entry-image">
								<?php the_post_thumbnail('full'); ?>
								<?php 
								$thumbnail=get_post( get_post_thumbnail_id() );
								if($thumbnail->post_excerpt){
									?>
								<p class="credit">Photo credit: <a target="_blank" href="<?php echo $thumbnail->post_content ?>"><?php echo $thumbnail->post_excerpt ?></a></p>
								<?php } ?>
						</div>
					</div>
				<?php
				}
				?>
				<a href="<?php the_permalink() ?>" class="entry-date">
					<span class="month"><?php echo get_the_date("M"); ?></span>
					<span class="day"><?php echo get_the_date("j"); ?></span>
					<span class="full-date"><?php echo get_the_date("Y/m/d \a\\t g:i a"); ?></span>
				</a>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php if(false){ ?>
					<!-- <div class="entry-share">
						<h4>Share:</h4>
						<div class="share-option" id="twitter">		
						</div>
						<div class="share-option" id="facebook">			
						</div>
						<div class="share-option" id="googleplus">
						</div>
					</div>

					<div class="entry-social">
						<div class="twitter">
							<a href="https://twitter.com/share" class="twitter-share-button" data-via="YoFolyo" data-count="vertical">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
						</div>
						<div class="facebook">
							<div class="fb-like" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false"></div>
						</div>
						<div class="google">
							<g:plusone size="tall"></g:plusone>
						</div>
						<div class="instapaper">
							<iframe border="0" scrolling="no" width="78" height="17" allowtransparency="true" frameborder="0"
							 style="margin-bottom: -3px; z-index: 1338; border: 0px; background-color: transparent; overflow: hidden;"
							 src="http://www.instapaper.com/e2?url=____&title=____&description=____"
							></iframe>
						</div>
					</div>
					<div class="entry-meta">
						<span class="full-date"><?php echo get_the_date("F jS, Y"); ?></span>
						<?php if ( comments_open() ) comments_popup_link( __( 'Leave a comment', 'boilerplate' ), __( '1 Comment', 'boilerplate' ), __( '% Comments', 'boilerplate' ) , "comments-link"); ?>
					</div> -->
					<?php } ?>
			



					<div class="entry-meta clearfix">
						<div class="left">
							<?php
								if ( count( get_the_category() ) ){
									printf( __( '<span class="entry-category">Posted in %2$s</span>', 'boilerplate' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) );
								}		
								if ( comments_open() ){
									comments_popup_link( __( 'Leave a comment', 'boilerplate' ), __( '1 Comment', 'boilerplate' ), __( '% Comments', 'boilerplate' ) );
								}
							?>
						</div>
						<div class="entry-social">
							<div class="twitter">
								<a href="https://twitter.com/share" class="twitter-share-button" data-via="YoFolyo" >Tweet</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							</div>
							<div class="facebook">
								<div class="fb-like" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false"></div>
							</div>
						</div>
					</div>
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<?php /* 
					<div class="entry-instapaper">
						<iframe border="0" scrolling="no" width="78" height="17" allowtransparency="true" frameborder="0"
						 style="margin-bottom: -3px; z-index: 1338; border: 0px; background-color: transparent; overflow: hidden;"
						 src="http://www.instapaper.com/e2?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&description=<?php the_excerpt(); ?>"></iframe>
					</div>
					*/ ?>
					
					
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
						<p>Enjoyed the post? Then you should <span class="follow-twitter"><a href="https://twitter.com/YoFolyo" class="twitter-follow-button" data-show-count="false">Follow Folyo on Twitter</a></span> or <a href="<?php bloginfo('atom_url'); ?>">subscribe to the RSS feed</a>.</p>
					</footer>
		
					<footer class="entry-utility">
						<?php boilerplate_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'boilerplate' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-utility -->
				</article><!-- #post-## -->
				<nav id="nav-below" class="navigation">
					<div class="nav-previous">
						<?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'boilerplate' ) . '</span> %title' ); ?>
					</div>
					<div class="nav-next">
						<?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'boilerplate' ) . '</span>' ); ?>
					</div>
				</nav><!-- #nav-below -->
				<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
