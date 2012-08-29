<?php
/**
 * Template Name: Quiz Results
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( is_front_page() ) { ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php } else { ?>	
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } ?>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php
						$result="";
						$score="";
							if(isset($_GET['result'])){
								$result=htmlentities($_GET['result']);
							}
							if(isset($_GET['score'])){
								$score=htmlentities($_GET['score']);
							}
							switch ($result) {
								case 'bad':
								$mention="Bad";
$message=<<<STR
<p>Sorry, you didn't do great on the quiz... it seems your portfolio could use some more work!</p>
<p>For starters, you could check out this article on <a href="http://blog.folyo.me/common-portfolio-mistakes-and-how-to-fix-them/">common portfolio mistakes</a>, and how to fix them.</p>
STR;
									break;
								case 'decent':
								$mention="Decent";
$message=<<<STR
<p>Your portfolio doesn't have too many major flaws, but it's probably not helping you out as much as it could.</p>
<p>So to make it even better, check out this article on <a href="http://blog.folyo.me/common-portfolio-mistakes-and-how-to-fix-them/">common portfolio mistakes</a>, and how to fix them.</p>
STR;
									break;
								case 'good':
								$mention="Good";
$message=<<<STR
<p>You have a good, solid portfolio. Not saying it couldn't be even better, but at this point it's mostly nit-picking.</p>
<p>Still, to make it even better, check out this article on <a href="http://blog.folyo.me/common-portfolio-mistakes-and-how-to-fix-them/">common portfolio mistakes</a> and how to fix them.</p>
STR;
									break;
								case 'great':
								$mention="Great!";
$message=<<<STR
<p>Your portfolio is awesome! I don't think I have anything to teach you!</p>
<p>Why not leave a comment here with a link to your portfolio and enlighten the masses?</p>
STR;
									break;
								default:
									# code...
									break;
							}
						?>
							<div class="result">
								<div class="score">
								<div class="scored">
								<p>You Scored:</p>
								<h4><strong><?php echo $score; ?></strong>/100 <span></span></h4>
								</div>
								<div class="share">
									<p>Share your result:</p>
								<div class="tweet">
								<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://blog.folyo.me/how-good-is-your-portfolio" data-text="My portfolio scored <?php echo $score; ?>/100 on the Folyo Evaluation. Take it too and find out how you compare!" data-via="YoFolyo" data-size="large" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								</div>
								</div>
								</div>
								<div class="message"><?php echo $message ?></div>
							</div>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->

<?php endwhile; ?>
<?php get_footer(); ?>