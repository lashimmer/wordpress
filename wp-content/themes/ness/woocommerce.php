<?php
        get_header();
        $cb_woocommerce_comments_onoff = ot_get_option('cb_woocommerce_comments_onoff', 'off');

?>
		<div id="cb-content" class="wrap clearfix">

            <div class="cb-cat-header wrap cb-woocommerce-page">

                <h1 id="cb-cat-title" >
                    <?php
                        if ( is_shop() == true ) {
                            woocommerce_page_title();
                        } elseif ( ( is_product_category() == true ) || ( is_product_tag() == true ) ) {

                            global $wp_query;
                            $cb_current_object = $wp_query->get_queried_object();
                            echo $cb_current_object->name;

                        } else {
                            the_title();
                        }
                    ?>
                </h1>

            </div>

				<div id="main" class="entry-content clearfix" role="main">

					<?php woocommerce_content(); ?>

                    <?php
                            if ( $cb_woocommerce_comments_onoff != 'off' ) {

                                if ( $cb_woocommerce_comments_onoff == 'cb_disqus_comments_on' ) {

                                    cb_disqus_woocommerce( $post );

                                } else {

                                    comments_template();
                                }
                            }
                    ?>

				</div> <!-- end #main -->

		</div> <!-- end #cb-content -->

<?php get_footer(); ?>