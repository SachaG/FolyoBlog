<?php
$featured_post_id = 9;
// $featured_post = get_post($featured_post_id, ARRAY_A);
query_posts("p=9");

// The Loop
while ( have_posts() ) : the_post();
?>
<div class="featured-post post">
	<?php
	if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
		?>
		<div class="entry-image">
			<a href="<?php the_permalink() ?>">
				<?php the_post_thumbnail('full'); ?>
			</a>
		</div>
	<?php
	}
	?>
	<div class="post-content">
		<a href="<?php the_permalink() ?>" class="entry-date">
			<span class="month"><?php echo get_the_date("M"); ?></span>
			<span class="day"><?php echo get_the_date("j"); ?></span>
			<span class="full-date"><?php echo get_the_date("Y/m/d \a\\t g:i a"); ?></span>
		</a>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'boilerplate' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<div class="entry-summary"><?php the_excerpt(); ?></div>
	</div>
</div>
<?php 
	endwhile; 
	wp_reset_query();
?>