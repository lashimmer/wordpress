<?php

    get_header();
    $cb_blog_style = ot_get_option( 'cb_misc_archives_pl',  'excerpt1' );
    $cb_title = single_cat_title( '', false );

    echo '<div class="cb-cover cb-no-image">';
    echo '<div class="cb-cat-header"><div class="cb-cat-title cb-header-font">' . $cb_title  . '</div>';

    echo '</div>';
    echo '</div>';
?>

    <div id="main" class="cb-home clearfix" role="main">

        <?php include( locate_template( 'cb-blog-style.php' ) ); ?>

    </div> <!-- end #main -->


<?php get_footer(); ?>