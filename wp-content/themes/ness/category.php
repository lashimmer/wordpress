<?php

    get_header();
    $cb_blog_style = ot_get_option( 'cb_blog_style', '1' );
    $cb_cat_title = single_cat_title( '', false );
    $cb_cat_id = get_query_var('cat');
    $cb_cat_desc = category_description( $cb_cat_id );
    $cb_cover_image_src = $cb_cover_image = NULL;
    $cb_classes = 'cb-cover';

    if ( function_exists('get_tax_meta') ) {

        $cb_blog_style = get_tax_meta( $cb_cat_id, 'cb_cat_style_field_id' );
        $cb_category_style = get_tax_meta( $cb_cat_id, 'cb_cat_style_field_id' );
        $cb_category_color_style = get_tax_meta( $cb_cat_id, 'cb_cat_style_color' );
        $cb_cover_image = get_tax_meta( $cb_cat_id, 'cb_bg_image_field_id' );
        $cb_category_ad = get_tax_meta_strip( $cb_cat_id, 'cb_cat_ad' );
        $cb_hp_infinite = get_tax_meta_strip( $cb_cat_id, 'cb_cat_infinite' );

    } 

    if ( $cb_cover_image == NULL ) {

        $cb_args = array( 'posts_per_page' => 5, 'category' => $cb_cat_id, 'orderby' => 'rand' );
        $cb_random_post = get_posts( $cb_args );

        foreach ( $cb_random_post as $cb_post ) {

            setup_postdata( $cb_post );
            $cb_post_id = $cb_post->ID;

            if ( has_post_thumbnail( $cb_post_id ) ) {
                $cb_featured_image_id = get_post_thumbnail_id( $cb_post_id );
                $cb_cover_image_src = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-1500-320' );
                $cb_cover_image = true;
                break;
            }

        }
        
        wp_reset_postdata(); 

    }

     if ( $cb_cover_image == NULL ) {
        $cb_classes .= ' cb-no-image';
    }

    echo '<div class="' . $cb_classes . '">';
    echo '<div class="cb-cat-header"><div class="cb-cat-title cb-header-font">' . $cb_cat_title  . '</div>';

    if ( $cb_cat_desc != NULL ) {
        echo  '<div class="cb-cat-subtitle">' . $cb_cat_desc . '</div>';
    }

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

        <?php  if ( $cb_category_ad != NULL ) { echo '<div class="cb-category-top">' . do_shortcode( $cb_category_ad ) . '</div>'; } ?>
        <?php include( locate_template( 'cb-blog-style.php' ) ); ?>

    </div> <!-- end #main -->


<?php get_footer(); ?>