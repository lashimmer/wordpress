<?php
define( 'CB_VER', '1.3' );
/************* LOAD NEEDED FILES ***************/

require_once get_template_directory() . '/library/core.php';
require_once get_template_directory() . '/library/translation/translation.php';
require_once get_template_directory() . '/library/admin/Tax-meta-class/cb-class-config.php';
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_post_formats', '__return_true' );
add_theme_support( 'woocommerce' );

load_template( get_template_directory() . '/option-tree/ot-loader.php' );
load_template( get_template_directory() . '/library/admin/cb-meta-boxes.php' );
load_template( get_template_directory() . '/library/admin/cb-to.php' );
require_once get_template_directory() . '/library/cb-tgm.php'; 

/************* THUMBNAIL SIZE OPTIONS *************/

add_image_size( 'cb-32-32', 32, 32, true ); // Next/Previous Posts in Menu
add_image_size( 'cb-1400-580', 1400, 580, true ); // Blog Style Row 1
add_image_size( 'cb-800-550', 800, 550, true ); // Blog Style Row 2
add_image_size( 'cb-550-430', 550, 430, true ); // Blog Style Row 3
add_image_size( 'cb-x-800', '', 800, true ); // Gallery Post Type Slider
add_image_size( 'cb-1600-900', 1600, 900, true ); // Homepage Feature Slider + Full-background Featured Image Style 
add_image_size( 'cb-1500-320', 1500, 320, true ); // Category Cover Image

// Content Width
if ( ! isset( $content_width ) ) {
    $content_width = 800;
}

/*********************
SCRIPTS & ENQUEUEING
*********************/
add_action('after_setup_theme','cb_script_loaders', 15);

if ( ! function_exists( 'cb_script_loaders' ) ) {
    function cb_script_loaders() {
        // enqueue base scripts and styles
        add_action('wp_enqueue_scripts', 'cb_scripts_and_styles', 999);
        // enqueue admin scripts and styles
        add_action('admin_enqueue_scripts', 'cb_post_admin_scripts_and_styles', 999);
        // ie conditional wrapper
        add_filter( 'style_loader_tag', 'cb_ie_conditional', 10, 2 );
    }
}

if ( ! function_exists( 'cb_scripts_and_styles' ) ) {
    function cb_scripts_and_styles() {
      if ( !is_admin() ) {
        // Modernizr (without media query polyfill)
        wp_register_script( 'cb-modernizr',  get_template_directory_uri() . '/library/js/modernizr.custom.min.js', array(), '2.6.2', false );
        wp_enqueue_script('cb-modernizr'); // enqueue it
        $cb_responsive_style = ot_get_option('cb_responsive_onoff', 'on');
        
        if ( $cb_responsive_style == 'on' ) {
            if ( is_rtl() ) {
                $cb_style_name = 'style-rtl';
            } else {
                $cb_style_name = 'style';
            }
        } else {
            if ( is_rtl() ) {
                $cb_style_name = 'style-rtl-unres';
            } else {
                $cb_style_name = 'style-unres';
            }
        }
        // Register main stylesheet
        wp_register_style( 'cb-main-stylesheet',  get_template_directory_uri() . '/library/css/' . $cb_style_name . '.css', array(), CB_VER, 'all' );
        wp_enqueue_style('cb-main-stylesheet'); // enqueue it
        // Register fonts
        $cb_font = cb_fonts();
        wp_register_style( 'cb-font-stylesheet',  $cb_font[0], array(), CB_VER, 'all' );
        wp_enqueue_style('cb-font-stylesheet'); // enqueue it
        // register font awesome stylesheet
        wp_register_style('fontawesome',  get_template_directory_uri(). '/library/css/font-awesome-4.3.0/css/font-awesome.min.css', array(), '4.3.0', 'all');
        wp_enqueue_style('fontawesome'); // enqueue it
        // ie-only stylesheet
        wp_register_style( 'cb-ie-only',  get_template_directory_uri(). '/library/css/ie.css', array(), CB_VER );
        wp_enqueue_style('cb-ie-only'); // enqueue it
        // comment reply script for threaded comments
        if ( is_singular() && comments_open() && (get_option('thread_comments') == 1)) { global $wp_scripts; $wp_scripts->add_data('comment-reply', 'group', 1 ); wp_enqueue_script( 'comment-reply' );}
        if ( is_single() == true) {
            // Load Cookie
            wp_register_script( 'cb-cookie',  get_template_directory_uri() . '/library/js/cookie.min.js', array( 'jquery' ),'', true);
            wp_enqueue_script( 'cb-cookie' ); // enqueue it
        }
        // Load lightbox
        $cb_lightbox_onoff = ot_get_option('cb_lightbox_onoff', 'on');
        if ( $cb_lightbox_onoff != 'off' ) {
            wp_register_script( 'cb-lightbox',  get_template_directory_uri() . '/library/js/jquery.fs.boxer.min.js', array( 'jquery' ), CB_VER, true);
            wp_enqueue_script( 'cb-lightbox' ); // enqueue it
        }
        // Load Extra Needed scripts
        wp_register_script( 'cb-js-ext',  cb_file_location( 'library/js/cb-ext.js' ), array( 'jquery' ),CB_VER, true);
        wp_enqueue_script( 'cb-js-ext' ); // enqueue it
        // Load scripts
        wp_register_script( 'cb-js',  cb_file_location( 'library/js/cb-scripts.js' ), array( 'jquery' ),CB_VER, true);
        wp_enqueue_script( 'cb-js' ); // enqueue it
      }
    }
}

if ( ! function_exists( 'cb_post_admin_scripts_and_styles' ) ) {
    function cb_post_admin_scripts_and_styles($hook) {

        // loading admin styles only on edit + posts + new posts
        if( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'profile.php' || $hook == 'appearance_page_ot-theme-options' || $hook == 'user-edit.php' || $hook == 'edit-tags.php' ) {

            wp_register_script( 'admin-js',  get_template_directory_uri() . '/library/admin/js/cb-admin.js', array(), CB_VER, true);
            wp_enqueue_script( 'admin-js' ); // enqueue it
            wp_register_style('fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3', 'all');
            wp_enqueue_style('fontawesome'); // enqueue it
            wp_enqueue_script( 'suggest' ); // enqueue it

        }
    }
}

// adding the conditional wrapper around ie8 stylesheet
// source: Gary Jones - http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
// GPLv2 or newer license
if ( ! function_exists( 'cb_ie_conditional' ) ) {
    function cb_ie_conditional( $tag, $handle ) {
        if ( ( 'cb-ie-only' == $handle ) || ( 'cb-select' == $handle ) ) {
            $tag = '<!--[if lt IE 10]>' . "\n" . $tag . '<![endif]-->' . "\n";
        }
        return $tag;
    }
}

// Sidebars & Widgetizes Areas
if ( ! function_exists( 'cb_register_sidebars' ) ) {
    function cb_register_sidebars() {

         // Main Sidebar
        register_sidebar(array(
            'name' => 'Global Sidebar',
            'id' => 'sidebar-global',
            'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title"><span>',
            'after_title' => '</span></h3>'
        ));

        $cb_footer_layout = ot_get_option('cb_footer_layout', 'cb-footer-2');

        // Footer Widget Area 1
        register_sidebar(array(
            'name' => 'Footer 1',
            'id' => 'footer-1',
            'before_widget' => '<div id="%1$s" class="cb-footer-widget cb-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-widget-title-footer cb-widget-title"><span>',
            'after_title' => '</span></h3>'
        ));

        if ( ( $cb_footer_layout == 'cb-footer-2' ) || ( $cb_footer_layout == 'cb-footer-3' ) ) {

             // Footer Widget Area 2
            register_sidebar(array(
                'name' => 'Footer 2',
                'id' => 'footer-2',
                'before_widget' => '<div id="%1$s" class="cb-footer-widget cb-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-widget-title-footer cb-widget-title"><span>',
                'after_title' => '</span></h3>'
            ));

        }

        if (  $cb_footer_layout == 'cb-footer-3' ) {

            // Footer Widget Area 3
            register_sidebar(array(
                'name' => 'Footer 3',
                'id' => 'footer-3',
                'before_widget' => '<div id="%1$s" class="cb-footer-widget cb-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-widget-title-footer cb-widget-title"><span>',
                'after_title' => '</span></h3>'
            ));

        }
    }
}
add_action( 'widgets_init', 'cb_register_sidebars' );

if ( ! function_exists( 'cb_widgets' ) ) {
    function cb_widgets() {

        require_once cb_file_location( 'library/widgets/cb-recent-posts-slider-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-widget-social-media.php' );
        require_once cb_file_location( 'library/widgets/cb-single-image-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-facebook-like-widget.php' );
        require_once cb_file_location( 'library/widgets/cb-google-follow-widget.php' );
    }
}

add_action( 'after_setup_theme', 'cb_widgets' );

?>