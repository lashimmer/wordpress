<?php 
    get_header();
    $cb_blog_style = ot_get_option( 'cb_misc_search_pl',  'excerpt1' );
    $cb_cover_image = ot_get_option( 'cb_search_cover',  NULL );
    $cb_classes = 'cb-cover';
    if ( $cb_cover_image == NULL ) {
        $cb_classes .= ' cb-no-image';
    }
    
    if ( have_posts() ) { 

        echo '<div class="' . $cb_classes . '">';
        echo '<div class="cb-cat-header">';

        echo  '<div class="cb-cat-subtitle">';
        _e('Search Results for:', 'cubell');
        echo '</div>';

        echo '<div class="cb-cat-title cb-header-font">' . esc_attr( get_search_query() )  . '</div></div>';

        if ( $cb_cover_image != NULL ) {

            echo '<script type="text/javascript">jQuery(document).ready(function($){$(".cb-cover").backstretch("' . $cb_cover_image . '", {fade: 1200}); });</script>';

        }

        echo '</div>';
?>
    <div id="main" class="cb-home clearfix" role="main">
<?php 

        include( locate_template( 'cb-blog-style.php' ) );
    
    } else { 

        echo '<div class="' . $cb_classes . '">';
        echo '<div class="cb-cat-header">';
        echo  '<div class="cb-cat-subtitle">';
        _e('Sorry, nothing found.', 'cubell');
        echo '</div>';
        echo '<div class="cb-cat-title cb-header-font">' . esc_attr( get_search_query() )  . '</div></div>';

        if ( $cb_cover_image != NULL ) {

            echo '<script type="text/javascript">jQuery(document).ready(function($){$(".cb-cover").backstretch("' . $cb_cover_image . '", {fade: 1200}); });</script>';

        }

        echo '</div>';
?>
    <div id="main" class="wrap clearfix" role="main">

        <span class="cb-search-subtitle"><?php _e('Try searching with other keywords', 'cubell'); ?></span>
        <span  class="cb-search-nr-form"><?php echo get_search_form(false); ?></span>
    
<?php } ?>        

    </div> <!-- end #main -->


<?php get_footer(); ?>