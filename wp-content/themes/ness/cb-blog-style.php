<?php /* Posts loop */

	if ( is_home() == true ) {

		$cb_offset_size = $cb_offset_size = cb_get_bloghome_offset();
		$cb_paged = get_query_var('paged');

		if ( $cb_paged == false ) {
			$cb_paged = 1;
		}

		if ( $cb_offset_size != NULL ) {
			$cb_offset_loop = 'on';
		} else {
			$cb_offset_loop = NULL;
		}

		$cb_featured_qry = array( 'offset' => $cb_offset_size, 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'cb_offset_loop' => $cb_offset_loop, 'paged' => $cb_paged );
		$cb_qry = new WP_Query( $cb_featured_qry );

	} else {

	  global $wp_query;
	  $cb_qry = $wp_query;

	}

	if ( $cb_blog_style == NULL ) {
		$cb_blog_style = 2;
	}

	$cb_link_overlay = 'on';
	$cb_excerpt = NULL;
	$cb_classes = 'cb-row-article clearfix cb-blog-style';

	if ( $cb_blog_style == 1 ) {

		$cb_posts_per_row = 1;
		$cb_width = '1400';
		$cb_height = '580';
		$cb_classes .= ' cb-row-1';
	} 

	if ( $cb_blog_style == 2 ) {

		$cb_posts_per_row = 2;
		$cb_width = '800';
		$cb_height = '550';
		$cb_classes .= ' cb-row-2';
	} 

	if ( $cb_blog_style == 3 ) {

		$cb_posts_per_row = 3;
		$cb_width = '550';
		$cb_height = '430';
		$cb_classes .= ' cb-row-3';
	}

	if ( $cb_blog_style == 'excerpt1' ) {

		$cb_posts_per_row = 1;
		$cb_width = '1400';
		$cb_height = '580';
		$cb_classes = 'cb-blog-style clearfix cb-row-1 cb-row-1-excerpt';
		$cb_link_overlay = 'off';
		$cb_excerpt = true;
	}


	if ( $cb_qry->have_posts() ) {

		if ( isset( $cb_block_title ) ) {
			echo '<div class="cb-module-header"><div class="cb-module-title cb-header-font">' . $cb_block_title  . '</div></div>';
		}

		while ( $cb_qry->have_posts() ) {

			$cb_qry->the_post();

			$cb_post_id = $post->ID;

			$cb_post_format = cb_get_post_format();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $cb_classes ); ?> role="article">

	<div class="cb-article-area">
		<div class="cb-mask">

			<?php if ( $cb_post_format != NULL ) { echo $cb_post_format; } ?>
			<?php cb_thumbnail( $cb_post_id,  $cb_width, $cb_height ); ?>

		</div>

	    <?php cb_post_meta_wrap( $cb_post_id, $cb_like_count = 'on', $cb_link_overlay, $cb_excerpt ); ?>
	    
	</div>

</article>

<?php
		}

	if ( ! isset( $cb_hp_infinite ) ) { 
		$cb_hp_infinite = 'infinite-load';
	}

	cb_page_navi( $cb_hp_infinite );

	}

?>