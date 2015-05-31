<?php 

	get_header(); 
	$cb_page_id = get_the_ID();
	$cb_featured_image_style = get_post_meta( $cb_page_id, 'cb_featured_image_style', 'full-background' );
	$cb_page_comments = get_post_meta( $cb_page_id, 'cb_page_comments', 'off' );

	echo cb_post_featured_image( $cb_page_id, true );
?>

<div id="main" class="clearfix" role="main">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix wrap cb-article-content' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

			<section class="entry-content clearfix" itemprop="articleBody">

				<?php the_content(); ?>
				<?php wp_link_pages('before=<div class="cb-pagination clearfix">&after=</div>&next_or_number=number&pagelink=<span class="cb-page">%</span>'); ?>

			</section>

		</article>

	<?php endwhile; ?>
	<?php endif; ?>

</div>


<?php if ( $cb_page_comments == 'on' ) { ?>
	<div id="cb-comment-block" class="wrap clearfix"><?php comments_template(); ?></div>
<?php } ?>

<?php get_footer(); ?>