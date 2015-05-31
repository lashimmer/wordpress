<?php
	$cb_post_id = $post->ID;
    $cb_comments_onoff = ot_get_option( 'cb_comments_onoff', 'on' );
	get_header();
	echo cb_post_featured_image( $cb_post_id );
	$cb_attachment = wp_get_attachment_image_src( $cb_post_id, 'cb-800-550' );

?>
	<div id="main" class="clearfix cb-static" role="main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix wrap cb-article-content' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<section class="entry-content clearfix" itemprop="articleBody">
					<img src="<?php echo $cb_attachment[0]; ?>" alt="<?php the_title(); ?>">
					<?php the_content(); ?>
					<?php wp_link_pages('before=<div class="cb-pagination clearfix">&after=</div>&next_or_number=number&pagelink=<span class="cb-page">%</span>'); ?>

				</section>

				<footer class="article-footer">

					<?php
						cb_like_block( $cb_post_id );
						cb_sharing_block( $post );
						cb_the_tags( $cb_post_id );
					?>

				</footer>

			</article>

		<?php endwhile; ?>
		<?php endif; ?>

	</div>

	<?php if ( $cb_comments_onoff == 'on' ) { ?>
		<div id="cb-comment-block" class="wrap clearfix"><?php comments_template(); ?></div>
	<?php } ?>

<?php get_footer(); ?>