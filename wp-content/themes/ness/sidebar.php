<?php

    $cb_sidebar_id = NULL;

    if ( is_single() && ( is_attachment() == false ) ) {
        
        $cb_cat = get_the_category( $post->ID );
        $cb_cat_name = sanitize_title( $cb_cat[0]->category_nicename );
        $cb_cat_check = $cb_cat[0];
        $cb_sidebar_id =  $cb_cat_name . '-sidebar';
        
        if ( ( is_active_sidebar( $cb_sidebar_id ) == false ) && ( $cb_cat_check->parent != 0 ) ) {
            $cb_cat = get_category($cb_cat_check->parent);
            $cb_cat_name = sanitize_title( $cb_cat->category_nicename );
            $cb_sidebar_id =  $cb_cat_name . '-sidebar';
        }

        $cb_sidebar_select =  get_post_meta( $post->ID, 'cb_sidebar_select', true );
        if ( $cb_sidebar_select != NULL ) {
            $cb_sidebar_id = $cb_sidebar_select;
        }
    }

	if ( is_active_sidebar( $cb_sidebar_id ) == true ) {

        echo '<aside class="cb-sidebar clearfix" role="complementary">';
  		dynamic_sidebar( $cb_sidebar_id );
        echo '</aside>';
            
	} elseif ( is_active_sidebar( 'sidebar-global' ) ) {

		echo '<aside class="cb-sidebar clearfix" role="complementary">';
		dynamic_sidebar( 'sidebar-global' );
        echo '</aside>';
	} 
?>