 <?php /* Homepage Featured Slider */

$cb_filter = ot_get_option( 'cb_hp_slider_filter', 'latest' );

$cb_cat_id = $cb_tag_id = NULL;

if ( $cb_filter == 'latest' ) {

} elseif ( $cb_filter == 'cat' ) {

    $cb_cat_id = ot_get_option( 'cb_hp_slider_cat', NULL );

    if ( $cb_cat_id != NULL ) {
        $cb_cat_id = implode(',', $cb_cat_id);
    }

} elseif ( $cb_filter == 'tags' ) {
    
    $cb_filter_tags = ot_get_option( 'tags_cb', NULL );
    $cb_tag_names = array_filter( explode( ',', $cb_filter_tags ) );
    $cb_tag_id = array();

    foreach ( $cb_tag_names as $cb_tag ) {
        $cb_tag_term = get_term_by( 'name', $cb_tag, 'post_tag' );
        $cb_tag_id[] = $cb_tag_term->term_id;
    }

}

$cb_posts_per_page = ot_get_option( 'cb_hp_slider_count', '6' );

$cb_qry = new WP_Query( array( 'posts_per_page' => $cb_posts_per_page, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );


if ( is_rtl() ) {
    $cb_slider_ltr_rtl = ' style="direction:ltr;"';
} else {
    $cb_slider_ltr_rtl = NULL;
}

$cb_output = NULL;
$cb_slider_type = 'flexslider-2';

if ( $cb_qry->have_posts() ) {

    $cb_output .= '<div id="cb-hp-slider" class="cb-slider clearfix"' . $cb_slider_ltr_rtl . '><ul class="slides">';

    while ( $cb_qry->have_posts() ) {

        $cb_qry->the_post();

        $cb_post_id = $post->ID;

        $cb_output .= '<li>';

        $cb_output .= cb_get_thumbnail( $cb_post_id, '1600', '900', true );

        $cb_output .= cb_get_post_meta_wrap( $cb_post_id, $cb_like_count = 'on' );

        $cb_output .= '</li>';

    }

    $cb_output .= '</ul></div>';

    echo $cb_output;
}

wp_reset_postdata();

?>