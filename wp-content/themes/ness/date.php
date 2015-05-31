<?php

    get_header();
    $cb_blog_style = ot_get_option( 'cb_misc_archives_pl',  '2' );
    $cb_cover_image_src = $cb_year = $cb_month = $cb_day = $cb_cover_image = NULL;
    $cb_classes = 'cb-cover';

    if ( is_day() == true) { 

        $cb_year = get_the_date( 'Y' );
        $cb_month = get_the_date( 'F' );
        $cb_day = get_the_date( 'd' );
        $cb_title = __('Daily Archives:', 'cubell') . ' ' . get_the_date();

    } elseif ( is_month() == true ) {

        $cb_year = get_the_date( 'Y' );
        $cb_month = get_the_date( 'F' );
        $cb_title = __('Monthly Archives:', 'cubell') . ' ' .  get_the_date( 'F Y' );

    } elseif ( is_year() == true ) {

        $cb_year = get_the_date( 'Y' );
        $cb_title = __('Yearly Archives:', 'cubell') . ' ' . $cb_year;

    }

    $cb_args = array( 'posts_per_page' => 5, 'orderby' => 'rand', 'date_query' => array( array( 'year' => $cb_year, 'month' => $cb_month, 'day' => $cb_day ), ), );
    $cb_random_post = new WP_Query( $cb_args );

    while ( $cb_random_post->have_posts() ) {
        $cb_random_post->the_post();

        $cb_post_id = $post->ID;

        if ( has_post_thumbnail( $cb_post_id ) ) {
            $cb_featured_image_id = get_post_thumbnail_id( $cb_post_id );
            $cb_cover_image_src = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-1500-320' );
            $cb_cover_image = true;
            break;
        }

    }

    wp_reset_postdata();

     if ( $cb_cover_image == NULL ) {
        $cb_classes .= ' cb-no-image';
    }

    echo '<div class="' . $cb_classes . '">';
    echo '<div class="cb-cat-header"><div class="cb-cat-title cb-header-font">' . $cb_title  . '</div>';

    echo '</div>';

    if ( $cb_cover_image != NULL ) {

        if ( $cb_cover_image_src == NULL ) {
            $cb_cover_image_src = wp_get_attachment_image_src( $cb_cover_image['id'], 'cb-1500-320');
        }

        echo '<script type="text/javascript">jQuery(document).ready(function($){$(".cb-cover").backstretch("' . $cb_cover_image_src[0] . '", {fade: 1200}); });</script>';

    }

    echo '</div>';
?>

    <div id="main" class="cb-home clearfix" role="main">

        <?php include( locate_template( 'cb-blog-style.php' ) ); ?>

    </div> <!-- end #main -->


<?php get_footer(); ?>