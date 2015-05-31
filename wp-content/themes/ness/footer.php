<?php

    $cb_footer_copyright = ot_get_option( 'cb_footer_copyright', NULL );
    $cb_footer_layout = ot_get_option( 'cb_footer_layout', 'cb-footer-1' );
    $cb_to_top = ot_get_option( 'cb_to_top', 'on' );

    if ( ( $cb_footer_layout == 'cb-footer-2' ) || ( $cb_footer_layout == 'cb-footer-3' ) ) {
        $cb_footer_layout_enable = true;
    } else {
        $cb_footer_layout_enable = false;
    }
?>
</div> <!-- end #cb-content -->

				<footer id="cb-footer"  role="contentinfo">

                        <?php echo apply_filters( 'cb_footer_background_start', '' ); ?>

                        <?php if ( ( is_active_sidebar( 'footer-1' ) ) || ( is_active_sidebar( 'footer-2' ) ) || ( is_active_sidebar( 'footer-3' ) ) || ( is_active_sidebar( 'footer-4' ) ) ) { ?>

                            <div id="cb-widgets" class="<?php echo $cb_footer_layout; ?> wrap clearfix">

                                <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
                                    <div class="cb-one cb-column clearfix">
                                        <?php dynamic_sidebar('footer-1'); ?>
                                    </div>
                                <?php } ?>
                                <?php if ( is_active_sidebar( 'footer-2' ) && ( $cb_footer_layout_enable == true ) ) { ?>
                                    <div class="cb-two cb-column clearfix">
                                        <?php dynamic_sidebar('footer-2'); ?>
                                    </div>
                                <?php } ?>
                                <?php if ( is_active_sidebar( 'footer-3' ) && ( $cb_footer_layout == 'cb-footer-3' ) ) { ?>
                                    <div class="cb-three cb-column clearfix">
                                        <?php dynamic_sidebar('footer-3'); ?>
                                    </div>
                                <?php } ?>

                            </div>

                        <?php } ?>

                        <?php if ( is_active_sidebar( 'footer-lower' ) ) { ?>
                            <div class="cb-four cb-column clearfix">
                                <?php dynamic_sidebar('footer-lower'); ?>
                            </div>
                        <?php } ?>

                        <?php if ( $cb_to_top == 'on' ) { ?>
                            <div class="cb-to-top wrap"><a href="#" id="cb-to-top"><i class="fa fa-angle-up cb-circle"></i></a></div>
                        <?php } ?>

                        <?php if ( $cb_footer_copyright != NULL ) { ?>
                            <div class="cb-credit wrap"><?php echo $cb_footer_copyright; ?></div>
                        <?php } ?>

                        <?php echo apply_filters( 'cb_footer_background_end', '' ); ?>

				</footer>

			</div> <!-- end #cb-container -->

		</div> <!-- end #cb-outer-container -->

		<?php wp_footer(); ?>

	</body>

</html>