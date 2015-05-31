<?php
		$cb_container_classes = 'clearfix';
		$cb_body_classes = NULL;
		$cb_nav_style = ot_get_option( 'cb_menu_style', 'cb-light' );
        $cb_favicon = ot_get_option( 'cb_favicon_url', NULL );
        $cb_hp_slider = ot_get_option( 'cb_hp_slider',  'off' );
        $cb_sticky_nav = ot_get_option( 'cb_sticky_nav', 'off' );
        $cb_cover_image = ot_get_option( 'cb_homepage_cover',  NULL );
        $cb_sidebar_position = cb_get_sidebar_setting();

        $cb_mobile = new Mobile_Detect;
        $cb_phone = $cb_mobile->isMobile();
        $cb_tablet = $cb_mobile->isTablet();

        if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
            $cb_is_mobile = true;
        } else {
            $cb_is_mobile = false;
        }

        if ( $cb_nav_style == 'cb-light' ) {
            $cb_body_classes = 'cb-light-style';
        } else {
             $cb_body_classes = 'cb-dark-style';
        }

		$cb_main_nav_classes = 'clearfix';

		if ( ( is_404() == true ) || ( ( is_home() == true ) && ( $cb_hp_slider == 'off' ) && ( $cb_cover_image == NULL ) ) || ( cb_woocommerce_check() == true ) ) {
			$cb_body_classes .= ' cb-non-absolute';

		}		
		if ( $cb_is_mobile == true ) {
			$cb_body_classes .= ' cb-mobile';
		}
		if ( $cb_sticky_nav == 'off' ) {
			$cb_body_classes .= ' stickyoff';
		}

		if ( cb_parallax() != NULL ) {
			$cb_body_classes .= ' cb-parallax-type';
		}

		if ( $cb_sidebar_position != 'nosidebar' ) {
			if ( $cb_sidebar_position == 'sidebar' ) {
				$cb_body_classes .= ' cb-sb cb-sb-right';
			} else {
				$cb_body_classes .= ' cb-sb cb-sb-left';
			}
			
		}
?>
<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<!-- Google Chrome Frame for IE -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->

		<title><?php wp_title(''); ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<?php if ( $cb_favicon != NULL ) { ?>
			<link rel="shortcut icon" href="<?php echo $cb_favicon; ?>">
		<?php } ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>
		
	</head>

	<body <?php body_class( $cb_body_classes ); ?>>

		<div id="cb-outer-container">

			<?php cb_sidebar_modal(); ?>

			<div id="cb-container" class="<?php echo $cb_container_classes; ?>">
				
				<?php cb_navigation_bar(); ?>

				<?php echo cb_parallax(); ?>
				
				<div id="cb-content" class="clearfix">