<?php

    get_header();
    $cb_blog_style = ot_get_option( 'cb_blog_style', 'excerpt1' );
    $cb_hp_infinite = ot_get_option( 'cb_hp_infinite', 'infinite-load' );
    $cb_hp_ad = ot_get_option( 'cb_hp_ad_below', NULL );

    if ( is_home() == true ) {
        $cb_hp_slider = ot_get_option( 'cb_hp_slider',  'on' );

        if ( $cb_hp_slider == 'on' ) {
            include( locate_template('cb-hp-slider.php') );
        } else {
            $cb_cover_image = ot_get_option( 'cb_homepage_cover',  NULL );
            if ( $cb_cover_image != NULL ) {

                echo '<div class="cb-cover">';
                echo '<script type="text/javascript">jQuery(document).ready(function($){$(".cb-cover").backstretch("' . $cb_cover_image . '", {fade: 1200}); });</script>';
                echo '</div>';
               
            }
        }
    }
?>

    <div id="main" class="cb-home clearfix" role="main">
    
        <?php  if ( $cb_hp_ad != NULL ) { echo '<div class="cb-category-top">' . do_shortcode( $cb_hp_ad ) . '</div>'; } ?>
        <?php include( locate_template( 'cb-blog-style.php' ) ); ?>

    </div> <!-- end #main -->

<?php get_footer(); ?>