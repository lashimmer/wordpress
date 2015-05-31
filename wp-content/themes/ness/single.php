<?php
	$cb_post_id = $post->ID;
    $cb_featured_image_style = get_post_meta( $cb_post_id, 'cb_featured_image_style', 'full-background' );
    $cb_post_format = get_post_format();
    $cb_comments_onoff = ot_get_option( 'cb_comments_onoff', 'on' );
    $cb_related_onoff = ot_get_option( 'cb_related_onoff', 'on' );
    $cb_sidebar_position = cb_get_sidebar_setting();
    $cb_ad_after_content = ot_get_option( 'cb_posts_ad_below', NULL );
    $cb_post_class = ' wrap cb-article-content';
	get_header();
	echo cb_post_featured_image( $cb_post_id );

?>
	<div id="main" class="clearfix cb-static" role="main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php if ( $cb_sidebar_position != 'nosidebar' ) { 
				$cb_post_class = ' cb-article-content-sidebar';
				echo '<div class="wrap cb-sidebar-wrap clearfix">';
			} 
		?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' . $cb_post_class ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<section class="entry-content clearfix" itemprop="articleBody">
					<?php the_content();  ?>
					<?php wp_link_pages('before=<div class="cb-pagination clearfix">&after=</div>&next_or_number=number&pagelink=<span class="cb-page">%</span>'); ?>
					<?php echo cb_get_byline( $post ); ?>
				</section>

				<footer class="article-footer">

					<?php

						cb_like_block( $cb_post_id );
						if ( $cb_ad_after_content != NULL ) { echo '<div class="cb-post-block-after cb-post-footer-block clearfix">' . do_shortcode( $cb_ad_after_content ) . '</div>'; }
						cb_sharing_block( $post );
						cb_the_tags( $cb_post_id );
					?>

				</footer>

			</article>

		<?php endwhile; ?>
		<?php endif; ?>

		<?php 
			if ( $cb_sidebar_position != 'nosidebar' ) { 
				get_sidebar(); 
				echo '</div>';
			} 
		?>

	</div>

	<?php if ( $cb_related_onoff == 'on' ) { cb_related_posts_block( $cb_post_id ); } ?>
	<?php if ( $cb_comments_onoff == 'on' ) { ?>
		<div id="cb-comment-block" class="wrap clearfix"><?php comments_template(); ?></div>
	<?php } ?>




<?php get_footer(); ?>