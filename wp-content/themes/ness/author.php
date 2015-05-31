<?php

    get_header();
    $cb_blog_style = ot_get_option( 'cb_misc_author_pl', '2' );
    $cb_cover_image_src = $cb_author_social = $cb_cover_image = NULL;
    $cb_classes = 'cb-cover';
    $i = 0;

    if ( $post == NULL ) {
        $cb_author_id = $author;
    } else {
        $cb_author = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $cb_author_id = $cb_author->ID;
    }
    
    $cb_author_name = get_the_author_meta('display_name', $cb_author_id);
    $cb_author_tw = get_the_author_meta('twitter', $cb_author_id);
    $cb_author_fa = get_the_author_meta('facebook', $cb_author_id);
    $cb_author_yt = get_the_author_meta('youtube', $cb_author_id);
    $cb_author_in = get_the_author_meta('instagram', $cb_author_id);

    $cb_networks = array_filter( array( 'instagram' => $cb_author_in, 'facebook' => $cb_author_fa, 'twitter' => $cb_author_tw, 'youtube' => $cb_author_yt ) );

    if ( $cb_networks != NULL ) {

        $cb_author_social = '<div class="cb-social-media-icons cb-white cb-small">';
        foreach ( $cb_networks as $cb_key => $cb_network ) {

            $i++;
            $cb_author_social .= '<a href="' . esc_url( $cb_network ) .'" target="_blank" class="cb-' . $cb_key . ' cb-icon-' . $i . '"></a>';

        }
        $cb_author_social .= '</div>';
    }

    $cb_title = __( 'Written by', 'cubell' ) . ' ' . $cb_author_name . $cb_author_social;

    $cb_args = array( 'posts_per_page' => 5, 'author' => $cb_author_id, 'orderby' => 'rand' );
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