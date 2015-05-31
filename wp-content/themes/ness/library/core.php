<?php

// Ahoy! All engines ready, let's fire up!
if ( ! function_exists( 'cb_start' ) ) {
    function cb_start() {
        cb_theme_support();
    }
}
add_action('after_setup_theme','cb_start', 16);

/*********************
THEME SUPPORT
*********************/
// Adding Functions & Theme Support
if ( ! function_exists( 'cb_theme_support' ) ) {
    function cb_theme_support() {

        // wp thumbnails
        add_theme_support('post-thumbnails');
        // default thumb size
        set_post_thumbnail_size(125, 125, true);
        // RSS
        add_theme_support('automatic-feed-links');
        // custom header/background
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        // adding post format support
        add_theme_support( 'post-formats',
            array(
                'video',
                'audio',
                'gallery',
            )
        );
        // wp menus
        add_theme_support( 'menus' );
        // registering menus
        register_nav_menus(
            array(
                'cb_main' => 'Main Navigation Menu',
            )
        );
    }
}

// cb_main Navigation bar
if ( ! function_exists( 'cb_main_nav' ) ) {
    function cb_main_nav() {
        wp_nav_menu(
            array(
                'container' => 'nav',
                'container_id' => 'cb-main-nav-container',
                'container_class' => 'cb-main-nav clearfix',
                'menu' => 'Main Nav',
                'menu_class' => 'nav',
                'theme_location' => 'cb_main',
                'depth' => 0,
                'fallback_cb' => 'none',
            )
        );
    }
}

/*********************
IMAGE ID
*********************/
if ( ! function_exists( 'cb_get_image_id' ) ) {
    function cb_get_image_id( $cb_image ) {

        global $wpdb;
        $cb_image_id = $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE guid = '$cb_image'" );
        return $cb_image_id;

    }
}

// Load Mobile Detection Class
require_once get_template_directory().'/library/mobile-detect-class.php';

/*********************
CLEAN BYLINE
*********************/
if ( ! function_exists( 'cb_get_byline' ) ) {
    function cb_get_byline( $post ) {

        $cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
        $cb_byline_author = ot_get_option('cb_byline_author', 'on');
        $cb_byline_date = ot_get_option('cb_byline_date', 'on');
        $cb_byline_category = ot_get_option('cb_byline_category', 'on');
        $cb_prefix =  __('Written by', 'cubell');
        $cb_byline_author_prefix = ot_get_option('cb_byline_author_prefix', 'Written by' );

        if ( $cb_byline_author_prefix != 'Written by' ) {
            $cb_prefix = $cb_byline_author_prefix;
        }

        $cb_byline_sep = '<span class="cb-separator">' . ot_get_option('cb_byline_separator', '<i class="fa fa-times"></i>') . '</span>';
        $cb_byline = $cb_cat_output = $cb_date = $cb_author = NULL;
        $cb_post_id = $post->ID;
        
        if ( $cb_byline_author != 'off' ) {

            $cb_author = '<span class="cb-author">' . $cb_prefix;

            if ( function_exists( 'coauthors_posts_links' ) ) {
                $cb_author .= ' ' . coauthors_posts_links( null, null, null, null, false );
            } else {
               $cb_author .= ' <a href="' .  esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>';
            }

            $cb_author .= '</span>';

            if ( ( $cb_byline_category != 'off' ) || ( $cb_byline_date != 'off' ) ) {
                $cb_author .= $cb_byline_sep;
            }
        }

        if ( $cb_byline_date != 'off' ) {

            $cb_date = '<span class="cb-date"><time class="updated" datetime="'. get_the_time('Y-m-d', $cb_post_id).'">'. date_i18n( get_option('date_format'), strtotime(get_the_time("Y-m-d", $cb_post_id )) ) .'</time></span>';
            if ( $cb_byline_category != 'off' ) {
                $cb_date .= $cb_byline_sep;
            }
        }

        if ( $cb_byline_category != 'off' ) {

            $cb_cats = get_the_category($cb_post_id);

            if ( isset( $cb_cats ) ) {
                $cb_cat_output = ' <span class="cb-category">';
                $i = 1;

                foreach( $cb_cats as $cb_cat ) {

                    if ( $i != 1 ) { $cb_cat_output .= ', '; }
                    $cb_cat_output .= ' <a href="' .  esc_url( get_category_link( $cb_cat->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "cubell" ), $cb_cat->name ) ) . '">' . $cb_cat->cat_name . '</a>';
                    $i++;
                }

                $cb_cat_output .= '</span>';
            }

        }


        if ( $cb_meta_onoff == 'on' ) {
            $cb_byline = '<div class="cb-byline">' . $cb_author . $cb_date . $cb_cat_output . '</div>';
        }

        return $cb_byline;
    }
}

/*********************
AUTHOR META
*********************/
if ( ! function_exists( 'cb_contact_data' ) ) {
    function cb_contact_data( $cb_contacts ) {

        unset( $cb_contacts['aim'] );
        unset( $cb_contacts['yim'] );
        unset( $cb_contacts['jabber'] );
        $cb_contacts['facebook'] = 'Facebook (Entire URL)';
        $cb_contacts['youtube'] = 'YouTube (Entire URL)';
        $cb_contacts['twitter'] = 'Twitter (Entire URL)';
        $cb_contacts['instagram'] = 'Instagram (Entire URL)';

        return $cb_contacts;
    }
}
add_filter( 'user_contactmethods', 'cb_contact_data' );

/*********************
LOAD CUSTOM CODE
*********************/
if ( ! function_exists( 'cb_custom_code' ) ) {
    function cb_custom_code(){

            $cb_custom_head = ot_get_option('cb_custom_head', NULL);
            $cb_custom_css = ot_get_option('cb_custom_css', NULL);
            $cb_custom_a_css = ot_get_option('cb_links_color', NULL);
            $cb_custom_post_body_css = ot_get_option('cb_body_text_style', array());
            $cb_custom_post_body_css_output = NULL;

            foreach ( $cb_custom_post_body_css as $cb_key => $cb_value ) {

                if ( $cb_value != NULL ) {

                    if ( $cb_key == 'font-family' ) { 
                        
                        if ( $cb_value == 'other' ) {
                            $cb_value = ot_get_option( 'cb_user_post_font', NULL );
                        }

                        $cb_custom_post_body_css_output .= 'font-family:' . $cb_value;
                        
                    } else {
                         $cb_custom_post_body_css_output .= $cb_key . ': ' . $cb_value . '; ';
                    }
                    
                }

            }

            if ( $cb_custom_head != NULL ) { echo $cb_custom_head; }
            if ( $cb_custom_post_body_css != NULL ) { $cb_custom_css .= '.entry-content { ' . $cb_custom_post_body_css_output . ' }'; } 
            if ( $cb_custom_a_css != NULL ) { $cb_custom_css .= 'a {color: ' . $cb_custom_a_css . '; }'; }
            if ( $cb_custom_css != NULL ) { echo '<style type="text/css">' . $cb_custom_css . '</style><!-- end custom css -->'; }
    }
}
add_action( 'wp_head', 'cb_custom_code' );

/*********************
LOAD CUSTOM FOOTER CODE
*********************/
if ( ! function_exists( 'cb_custom_footer_code' ) ) {
    function cb_custom_footer_code() {

            $cb_footer_code = ot_get_option('cb_custom_footer', NULL);

            if ( $cb_footer_code != NULL ) { echo $cb_footer_code; }
    }
}
add_action('wp_footer', 'cb_custom_footer_code');

/*********************
FEATURED IMAGE THUMBNAILS
*********************/
if ( ! function_exists( 'cb_thumbnail' ) ) {
    function cb_thumbnail( $cb_post_id, $cb_width, $cb_height, $cb_css = false, $cb_image_style = 'cb-square' ) {

        echo cb_get_thumbnail( $cb_post_id, $cb_width, $cb_height, $cb_css, $cb_image_style );
    }
}

/*********************
GET FEATURED IMAGE THUMBNAILS
*********************/
if ( ! function_exists( 'cb_get_thumbnail' ) ) {
    function cb_get_thumbnail( $cb_post_id, $cb_width, $cb_height, $cb_css = false, $cb_image_style = 'cb-square' ) {

        $cb_output = NULL;
        $cb_image_style .= ' clearfix';

        if ( $cb_css == false ) {

            $cb_output = '<a href="' . esc_url( get_permalink() ) . '">';

                if  ( has_post_thumbnail() ) {
                    $cb_featured_image = get_the_post_thumbnail( $cb_post_id, 'cb-' . $cb_width . '-' . $cb_height, array( 'class' => $cb_image_style ) );
                    $cb_output .= $cb_featured_image;
                } else {
                    $cb_thumbnail = get_template_directory_uri() . '/library/images/thumbnail-' . $cb_width . 'x'. $cb_height . '.png';
                    $cb_retina_thumbnail = get_template_directory_uri() . '/library/images/thumbnail-' . $cb_width .'x' . $cb_height . '@2x.png';
                    $cb_output .= '<img src="' .  esc_url( $cb_thumbnail ) . '" alt="article placeholder" class="cb-no-fi-placeholder" data-src-retina="' .  esc_url( $cb_retina_thumbnail ) .'" data-src="'.  esc_url( $cb_thumbnail ) .'">';
                }

            $cb_output .= '</a>';

        } else {

            $cb_featured_image_id = get_post_thumbnail_id( $cb_post_id );
            $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-' . $cb_width . '-' . $cb_height );

            $cb_output .= '<div class="cb-featured-image" style="background-image: url( ' . $cb_featured_image_url[0] . ');"></div>';
        }

        return $cb_output;
    }
}


/*********************
NUMERIC PAGE NAVI
*********************/
if ( ! function_exists( 'cb_page_navi' ) ) {
    function cb_page_navi( $cb_pagination_type = 'infinite-load' ) {

        $cb_no_more_articles = __('No more articles', 'cubell');

        if ( $cb_pagination_type == 'infinite-load' ) {

            if (  get_next_posts_link() != NULL ) {
                $cb_load_more_text = __('Load More', 'cubell');
                echo '<nav id="cb-blog-infinite-load" class="cb-pagination cb-infinite-scroll cb-infinite-load">' . get_next_posts_link( $cb_load_more_text ) . '</nav>';
            } else {
                echo '<div class="cb-no-more-posts cb-infinite-load"><span>' . $cb_no_more_articles . '</span></div>';
            }

        } elseif ( $cb_pagination_type == 'infinite-scroll' ) {

            if (  get_next_posts_link() != NULL ) {

                echo '<nav id="cb-blog-infinite-scroll" class="cb-pagination cb-infinite-scroll cb-hidden">' . get_next_posts_link() . '</nav>';
            } else {
                echo '<div class="cb-no-more-posts cb-infinite-load"><span>' . $cb_no_more_articles . '</span></div>';
            }

        } else {

            global $wpdb, $wp_query;
            $cb_posts_per_page = intval( get_query_var( 'posts_per_page' ) );
            $cb_paged = intval( get_query_var( 'paged' ) );
            $cb_number_posts = $wp_query->found_posts;
            $cb_max_num_pages = $wp_query->max_num_pages;


            if ( $cb_number_posts <= $cb_posts_per_page ) { return; }

            if ( empty( $cb_paged ) || $cb_paged == 0 ) {
                $cb_paged = 1;
            }

            $cb_first_page = $cb_paged - 3;

            if ( $cb_first_page <= 0 ) { $cb_first_page = 1; }

            $cb_last_page = $cb_paged + 3;

            if ( ( $cb_last_page - $cb_first_page ) != 6) {
                $cb_last_page = $cb_first_page + 6;
            }

            if ( $cb_last_page > $cb_max_num_pages ) {
                $cb_first_page = $cb_max_num_pages - 6;
                $cb_last_page = $cb_max_num_pages;
            }

            if ( $cb_first_page <= 0 ) {
                $cb_first_page = 1;
            }
            echo '<nav class="cb-pagination cb-list-pagination"><ol class="cb-page-navi clearfix">'."";

            for ( $i = $cb_first_page; $i <= $cb_last_page; $i++ ) {
                if ( $i == $cb_paged ) {
                    echo '<li class="cb-current">' . $i . '</li>';
                } else {
                    echo '<li><a href="' .  esc_url( get_pagenum_link( $i ) ) . '">' . $i . '</a></li>';
                }
            }
            if (  get_previous_posts_link() != NULL ) {
                echo '<li class="cb-prev-link">';
                previous_posts_link('<i class="icon-long-arrow-left"></i>');
                echo '</li>';
            }

            if ( get_next_posts_link() != NULL ) {
                echo '<li class="cb-next-link">';
                next_posts_link('<i class="icon-long-arrow-right"></i>');
                echo '</li></ol></nav>';
            }
        }
    }
}

/*********************
LOAD USER FONT
*********************/
if ( ! function_exists( 'cb_fonts' ) ) {
    function cb_fonts() {

        $cb_header_font = ot_get_option('cb_header_font', "'Raleway', sans-serif;");
        $cb_user_header_font = ot_get_option('cb_user_header_font', NULL);
        $cb_body_font = ot_get_option('cb_body_font', "'Raleway', sans-serif;");
        $cb_user_body_font = ot_get_option('cb_user_body_font', NULL);
        $cb_post_font = ot_get_option('cb_body_text_style', 'off');
        $cb_user_post_font = ot_get_option( 'cb_user_post_font', NULL );
        $cb_font_latin = ot_get_option('cb_font_ext_lat', 'off');
        $cb_font_cyr = ot_get_option('cb_font_cyr', 'off');
        $cb_return = array();
        $cb_font_ext = $cb_font_cyr = NULL;

        if ( ( $cb_header_font == 'other' ) && ( $cb_user_header_font != NULL ) ) {
            $cb_header_font = $cb_user_header_font;
        }

        if ( ( $cb_body_font == 'other' ) && ( $cb_user_body_font != NULL ) ) {
            $cb_body_font = $cb_user_body_font;
        }

        if ( (array) $cb_post_font !== $cb_post_font ) { 

            $cb_post_font = 'off';

        } else { 

             if ( array_key_exists( 'font-family', $cb_post_font ) ) {

                $cb_post_font = $cb_post_font['font-family'];

            } else {
                $cb_post_font = 'off';
            }
        }

        if ( ( $cb_post_font != 'off' ) && ( $cb_user_post_font != NULL ) ) {
            $cb_post_font = $cb_user_post_font;
        }

        if ( ( $cb_font_latin == 'on' ) && ( $cb_font_cyr == 'on' ) ) {

            $cb_font_ext = '&subset=latin,latin-ext,cyrillic,cyrillic-ext';

        } elseif ( $cb_font_latin == 'on' ) {

            $cb_font_ext = '&subset=latin,latin-ext';

        } elseif ( $cb_font_cyr == 'on' ) {

            $cb_font_ext = '&subset=cyrillic,cyrillic-ext';
        }

        $cb_header_font_clean =  substr( $cb_header_font, 0, strpos($cb_header_font, ',' ) );
        $cb_header_font_clean = str_replace( "'", '', $cb_header_font_clean );
        $cb_header_font_clean = str_replace( " ", '+', $cb_header_font_clean );
        $cb_body_font_clean =  substr( $cb_body_font, 0, strpos( $cb_body_font, ',' ) );
        $cb_body_font_clean = str_replace( "'", '', $cb_body_font_clean );
        $cb_body_font_clean = str_replace( " ", '+', $cb_body_font_clean );
        
        if ( ( is_singular() == true) && ( $cb_post_font != 'off' ) ) { 

            $cb_post_font_clean =  substr( $cb_post_font, 0, strpos( $cb_post_font, ',' ) );
            $cb_post_font_clean = str_replace( "'", '', $cb_post_font_clean );
            $cb_post_font_clean = str_replace( " ", '+', $cb_post_font_clean );

            $cb_return[] = '//fonts.googleapis.com/css?family=' . $cb_header_font_clean . ':300,400,700' . $cb_font_ext . '|' . $cb_body_font_clean . ':300,400,700,400italic' . $cb_font_ext . '|' . $cb_post_font_clean . ':300,400,700,400italic' . $cb_font_ext;

        } else {
            $cb_return[] = '//fonts.googleapis.com/css?family=' . $cb_header_font_clean . ':300,400,700' . $cb_font_ext . '|' . $cb_body_font_clean . ':300,400,700,400italic' . $cb_font_ext;
            $cb_post_font_clean = $cb_body_font;

        }

        $cb_return[] = '<style type="text/css">
                            body, #respond, h2.cb-body-font, h3.cb-body-font, h3.comment-reply-title, html, button, input, select, textarea { font-family: ' . $cb_body_font . ' }
                            body .entry-content { font-family: ' . $cb_post_font_clean . ' }
                            .cb-header-font, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, #cb-main-nav-container .cb-main-nav li a, #submit, .cb-block-title .cb-title { font-family:' . $cb_header_font . ' }
                     </style>';
        return $cb_return;
    }
}

if ( ! function_exists( 'cb_font_styler' ) ) {
    function cb_font_styler() {

       $cb_output = cb_fonts();
       echo $cb_output[1];

    }
}
add_action('wp_head', 'cb_font_styler');


/*********************
FEATURED IMAGES
*********************/
if ( ! function_exists( 'cb_post_featured_image' ) ) {
    function cb_post_featured_image( $cb_post_id, $cb_page = false ) {

        $cb_featured_image_style = get_post_meta( $cb_post_id, 'cb_featured_image_style', true );
        $cb_featured_image_style_override_onoff = ot_get_option('cb_post_style_override_onoff', 'off');
        $cb_featured_image_style_override_style = ot_get_option('cb_post_style_override', 'full-background');
        $cb_featured_image_style_override_post_onoff = get_post_meta( $cb_post_id, 'cb_featured_image_style_override', true );
        $cb_output = $cb_gallery_post_images = $cb_post_format_media = NULL;

        $cb_mobile = new Mobile_Detect;
        $cb_phone = $cb_mobile->isMobile();
        $cb_tablet = $cb_mobile->isTablet();

        if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
            $cb_is_mobile = true;
        } else {
            $cb_is_mobile = false;
        }

        if ( $cb_featured_image_style == NULL ) {
            $cb_featured_image_style = 'full-background';
        }

        if ( ( $cb_featured_image_style_override_onoff == 'on' ) && ( $cb_featured_image_style_override_post_onoff != 'on') ) {
           $cb_featured_image_style = $cb_featured_image_style_override_style;
        }

        if ( has_post_thumbnail() == false ) {
            $cb_featured_image_style = 'off';
        }

        if ( $cb_page == false ) {

            $cb_title = '<div class="cb-meta-data"><h1 class="cb-post-title">' . get_the_title( $cb_post_id ) . '</h1>' . cb_get_like_count( $cb_post_id ) . '</div><span class="cb-link-overlay"></span>';

            $cb_post_format = get_post_format($cb_post_id);
            if ( $cb_post_format == 'video' ) {
                $cb_post_format_media = cb_get_post_format_data( $cb_post_id, 'video' );
            }

            if ( $cb_post_format == 'audio' ) {
                $cb_post_format_media = cb_get_post_format_data( $cb_post_id, 'audio' );
            }

        } else {

            $cb_title = '<div class="cb-meta-data cb-page-featured-image"><h1 class="cb-post-title">' . get_the_title( $cb_post_id ) . '</h1></div><span class="cb-link-overlay"></span>';
            $cb_post_format = NULL;

        }

        $cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_gallery_post_images', true );
        
        if ( ( $cb_post_format == 'gallery' ) && ( $cb_gallery_post_images != NULL ) ) {

             echo cb_get_post_format_data( $cb_post_id, 'gallery' );

        } elseif ( $cb_featured_image_style == 'full-background' ) {

            $cb_featured_image_id = get_post_thumbnail_id( $cb_post_id );
            $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-1600-900' );

            if ( $cb_featured_image_url != NULL ) {

                $cb_output = '<div id="cb-featured-image" class="cb-post-featured-image cb-background-preload cb-' . $cb_featured_image_style . '">';
                $cb_output .= $cb_title;
                $cb_output .= cb_get_arrow_down();
                $cb_output .= '<script type="text/javascript">jQuery(document).ready(function($){
                            cbPostFeaturedImage.backstretch("' . $cb_featured_image_url[0] . '", {fade: 1200});
                            });  </script>';
                $cb_output .= $cb_post_format_media;
                $cb_output .= '</div>';
            }

        } elseif ( $cb_featured_image_style == 'background-slideshow' ) {

            $cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_post_background_slideshow', true );

            if ( $cb_gallery_post_images != NULL ) {

                $cb_gallery_images = cb_get_gallery_images( $cb_post_id, $cb_gallery_post_images );
                    $cb_output = '<div id="cb-featured-image" class="cb-post-featured-image cb-background-preload cb-' . $cb_featured_image_style . '">';
                $cb_output .= $cb_title;
                $cb_output .= cb_get_arrow_down();
                $cb_output .= '<script type="text/javascript">jQuery(document).ready(function($){
                            cbPostFeaturedImage.backstretch(';

                $cb_output .= '[';
                foreach ( $cb_gallery_images as $cb_slide ) {
                    $cb_output .= '"' . $cb_slide['cb-url'] . '", ';
                }
                $cb_output .= '],  {fade: 1000, duration: 3500});
                        });  </script>';
                $cb_output .= '</div>';
            }

        } elseif ( $cb_featured_image_style == 'parallax' ) {

            $cb_featured_image_id = get_post_thumbnail_id( $cb_post_id );
            $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'full' );

            if ( $cb_featured_image_url != NULL ) {

                if (  $cb_is_mobile == true ) {
                    $cb_output = '<div id="cb-featured-image" class="cb-post-featured-image cb-background-preload cb-full-background cb-' . $cb_featured_image_style . '">';
                    $cb_output .= $cb_title;
                    $cb_output .= cb_get_arrow_down();
                    $cb_output .= '<script type="text/javascript">jQuery(document).ready(function($){
                                cbPostFeaturedImage.backstretch("' . $cb_featured_image_url[0] . '", {fade: 1200}).css("z-index", "1");
                                $(".backstretch").css("position", "fixed");
                                $("#cb-content").find("> div").css({"background": "white", "position": "relative", "z-index": "3" });
                                $("#cb-footer").css("z-index", "3");

                                });  </script>';
                    $cb_output .= $cb_post_format_media;
                    $cb_output .= '</div>';
                } else {
                    $cb_output = '<div id="cb-featured-image" class="cb-post-featured-image cb-' . $cb_featured_image_style . '">';
                    $cb_output .= $cb_title;
                    $cb_output .= cb_get_arrow_down();
                    $cb_output .= $cb_post_format_media;
                    $cb_output .= '</div>';
                }
                
            }

        } elseif ( $cb_featured_image_style == 'off' ) {
            
            $cb_output = '<div class="cb-cover cb-no-image">';
            $cb_output .= '<div class="cb-cat-header"><div class="cb-cat-title cb-header-font">' . get_the_title( $cb_post_id ) . '</div>';
            $cb_output .= '</div></div>';
        }

        return $cb_output;

    }
}

/*********************
PARALLAX OUTPUT
*********************/
if ( ! function_exists( 'cb_parallax' ) ) {
    function cb_parallax() {

        if ( is_single() ) {
            global $post;
            $cb_post_id = $post->ID;

            $cb_featured_image_style = get_post_meta( $cb_post_id, 'cb_featured_image_style', true );
            $cb_featured_image_style_override_onoff = ot_get_option('cb_post_style_override_onoff', 'off');
            $cb_featured_image_style_override_style = ot_get_option('cb_post_style_override', 'full-background');
            $cb_featured_image_style_override_post_onoff = get_post_meta( $cb_post_id, 'cb_featured_image_style_override', true );
            if ( ( $cb_featured_image_style_override_onoff == 'on' ) && ( $cb_featured_image_style_override_post_onoff != 'on') ) {
               $cb_featured_image_style = $cb_featured_image_style_override_style;
            }

            $cb_mobile = new Mobile_Detect;
            $cb_phone = $cb_mobile->isMobile();
            $cb_tablet = $cb_mobile->isTablet();

            if ( ( $cb_tablet == true ) || ( $cb_phone == true ) ) {
                $cb_is_mobile = true;
            } else {
                $cb_is_mobile = false;
            }

            if ( ( $cb_featured_image_style == 'parallax' ) && ( $cb_is_mobile == false ) ) {
                $cb_featured_image_id = get_post_thumbnail_id( $cb_post_id );
                $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'full' );
                return '<div id="cb-par-wrap"><img class="cb-image" src="' . $cb_featured_image_url[0] .'" alt=""></div>';
            }
           
        }
        

    }
}

/*********************
GET SIDEBAR POSITION
*********************/
if ( ! function_exists( 'cb_get_sidebar_setting' ) ) {
    function cb_get_sidebar_setting() {
        
        $cb_sidebar = NULL;

        if ( is_single() ) {
            global $post;
            $cb_sidebar = get_post_meta( $post->ID, 'cb_full_width_post', true );
        }

        if ( $cb_sidebar == NULL ) {
            $cb_sidebar = 'nosidebar';
        }

        return $cb_sidebar;
    }
}


/*********************
POST META WRAP
*********************/
if ( ! function_exists( 'cb_post_meta_wrap' ) ) {
    function cb_post_meta_wrap( $cb_post_id = NULL, $cb_like_count = 'on', $cb_link_overlay = 'on', $cb_excerpt = NULL ) {

        echo cb_get_post_meta_wrap( $cb_post_id, $cb_like_count, $cb_link_overlay, $cb_excerpt );

    }
}


/*********************
GET POST META WRAP
*********************/
if ( ! function_exists( 'cb_get_post_meta_wrap' ) ) {
    function cb_get_post_meta_wrap( $cb_post_id = NULL, $cb_like_count = 'on', $cb_link_overlay = 'on', $cb_excerpt = NULL ) {    

        $cb_output = '<div class="cb-meta-data">';

        $cb_output .= '<h2 class="cb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h2>';

        if ( $cb_like_count == 'on' ) {

            $cb_output .= '<a href="' . esc_url( get_the_permalink() ) . '">' . cb_get_like_count( $cb_post_id ) . '</a>';

        }

        $cb_output .= '</div>';

        if ( $cb_link_overlay == 'on' ) {

            $cb_output .= '<a href="' . esc_url( get_the_permalink() ) .'" class="cb-link-overlay"></a>';
        }


        if ( $cb_excerpt != NULL ) {
            $cb_output .= cb_clean_excerpt();
        }

        return $cb_output;
    }
}


/*********************
GET POST FORMAT
*********************/
if ( ! function_exists( 'cb_get_post_format' ) ) {
    function cb_get_post_format( $cb_post_id = NULL ) {   

        $cb_post_format = get_post_format( $cb_post_id );

        if ( $cb_post_format == 'video' ) {
            $cb_output = '<a href="' . esc_url( get_permalink( $cb_post_id ) ) . '"><span class="cb-post-format cb-circle"><i class="fa fa-play"></i></span></a>';
        } elseif ( $cb_post_format == 'audio' ) {
            $cb_output = '<a href="' . esc_url( get_permalink( $cb_post_id ) ) . '"><span class="cb-post-format cb-circle"><i class="fa fa-headphones"></i></span></a>';
        } elseif ( $cb_post_format == 'gallery' ) {
            $cb_output = '<a href="' . esc_url( get_permalink( $cb_post_id ) ) . '"><span class="cb-post-format cb-circle"><i class="fa fa-camera"></i></span></a>';
        } else {
            $cb_output = NULL;
        }

        return $cb_output;
    }
}

/*********************
FILE LOCATION CHECK
*********************/
if ( ! function_exists( 'cb_file_location' ) ) {
    function cb_file_location( $cb_file_name ) {

        $cb_file_name_ext = substr( $cb_file_name, -3 );

        if ( $cb_file_name_ext == 'php' ) {

            $cb_get_stylesheet = get_stylesheet_directory();
            $cb_get_template = get_template_directory();

        } else {

            $cb_get_stylesheet = get_stylesheet_directory_uri();
            $cb_get_template = get_template_directory_uri();
        }

        if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $cb_file_name ) ) {

            $cb_file_url = trailingslashit( $cb_get_stylesheet ) . $cb_file_name;

        } elseif ( file_exists( trailingslashit( get_template_directory() ) . $cb_file_name ) ) {

            $cb_file_url = trailingslashit( $cb_get_template ) . $cb_file_name;

        }

        return $cb_file_url;

    }
}


/*********************
GET LOGO
*********************/
if ( ! function_exists( 'cb_get_logo' ) ) {
    function cb_get_logo() {

        $cb_logo_url = ot_get_option( 'cb_logo_url', NULL );
        $cb_logo_retina = ot_get_option( 'cb_logo_url_retina', NULL );
        $cb_nav_logo_url = ot_get_option( 'cb_sticky_menu_logo', NULL );
        $cb_nav_logo_url_retina = ot_get_option( 'cb_sticky_menu_logo_retina', NULL );
        $cb_output = NULL;

        if ( $cb_logo_retina != NULL ) {
            $cb_logo_retina = 'data-retina-src="' . esc_url( $cb_logo_retina ) .'"';
        }

        if ( $cb_nav_logo_url_retina != NULL ) {
            $cb_nav_logo_url_retina = 'data-retina-src="' . esc_url( $cb_nav_logo_url_retina ).'"';
        }

        if ( $cb_logo_url != NULL ) {
            $cb_logo_src = wp_get_attachment_image_src( cb_get_image_id( $cb_logo_url ), 'full' );
            $cb_logo_size = 'width="' . $cb_logo_src[1] .'" height="'. $cb_logo_src[2] . '"';
            $cb_output = '<a href="' . esc_url( get_home_url() ) . '" class="cb-logo-img"><img src="' .  esc_url( $cb_logo_src[0] ) .'" alt="' . get_bloginfo( 'name' ) . ' logo" ' . $cb_logo_size . ' ' . $cb_logo_retina . '></a>';
        }

        if ( $cb_nav_logo_url != NULL ) {
            $cb_logo_src = wp_get_attachment_image_src( cb_get_image_id( $cb_nav_logo_url ), 'full' );
            $cb_logo_size = 'width="' . $cb_logo_src[1] .'" height="'. $cb_logo_src[2] . '"';
            $cb_output .= '<a href="' . esc_url( get_home_url() ) . '" class="cb-nav-logo-img"><img src="' .  esc_url( $cb_logo_src[0] ) .'" alt="' . get_bloginfo( 'name' ) . ' logo" ' . $cb_logo_size . ' ' . $cb_nav_logo_url_retina . '></a>';
        }

        return $cb_output;

    }
}

/*********************
NAVIGATION BAR
*********************/
if ( ! function_exists( 'cb_navigation_bar' ) ) {
    function cb_navigation_bar() {

        $cb_navigation_style = ot_get_option( 'cb_menu_style', 'cb-light' );
        $cb_logo_url = ot_get_option( 'cb_logo_url', NULL );
        $cb_menu_type = ot_get_option( 'cb_menu_type', 'cb-slide' );

        if ( ( $cb_logo_url != NULL ) || ( has_nav_menu( 'cb_main' ) != false ) ) {
        
?>
            <nav id="cb-navigation" role="navigation" class="clearfix">

                <div class="cb-menu">
                    <div class="cb-left cb-column">
                        <div id="cb-logo">
                            <?php echo cb_get_logo(); ?>
                        </div>
                    </div>
<?php if ( $cb_menu_type == 'cb-slide' ) { ?>
                    <div class="cb-middle cb-column">
                        <?php if ( is_single() == true ) { ?>
                            <div id="cb-dynamic-area" class="cb-hidden">
                                <?php cb_read_progress(); ?>
                                <?php cb_next_previous_slide( 'cb-post-menu-block' ); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cb-right cb-column">
                        <div class="cb-nav">
                            <?php if ( has_nav_menu( 'cb_main' ) ) { ?>
                            <a href="#" id="cb-sidebar-open" class="cb-link">
                                <i class="fa fa-bars"></i>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
<?php } else { ?>
                     <div class="cb-reg-menu cb-column">
                        <div class="cb-nav">
                            <?php if ( has_nav_menu( 'cb_main' ) ) { ?>
                                <a href="#" id="cb-sidebar-open" class="cb-link">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <?php wp_nav_menu( array( 'theme_location' => 'cb_main' ) ); ?>
                            <?php } ?>
                        </div>
                    </div>
<?php } ?>

                </div>

            </nav>
<?php
        }
    }
}

/*********************
SIDEBAR MODAL
*********************/
if ( ! function_exists( 'cb_sidebar_modal' ) ) {
    function cb_sidebar_modal() {
?>

        <div id="cb-sidebar-modal" class="clearfix">

            <div class="clearfix cb-sidebar-menu">
                <a href="#" id="cb-sidebar-close" class="cb-link">
                    <i class="fa fa-times"></i>
                </a>
                <?php if ( has_nav_menu( 'cb_main' ) ) { cb_main_nav(); } ?>

            </div>

            <div class="cb-sidebar-post">
                <div class="cb-content-area">
                    <?php cb_sidebar_post(); ?>
                </div>

            </div>

        </div>

<?php
    }
}
/*********************
READ PROGRESS
*********************/
if ( ! function_exists( 'cb_read_progress' ) ) {
    function cb_read_progress() {

        $cb_read_progress = ot_get_option( 'cb_progress_bar_onoff', 'on' );

        if ( ( is_attachment() == false ) && ( is_single() == true ) && ( $cb_read_progress == 'on' ) ) {

            $cb_output = '<div id="cb-read-progress" class="cb-ani-fade-in-1s">';

            $cb_output .= '<div class="cb-text"><span id="cb-read-progress-percent">0%</span> ' . __('Read', 'cubell') . '</div><progress max="100" value="0" id="cb-progress-bar"><div class="progress-bar"><span style="width: 80%;">Progress: 80%</span></div>
    </progress>';
            $cb_output .= '</div>';

            echo $cb_output;
        }
    }
}


/*********************
POST FORMAT DATA
*********************/
if ( ! function_exists( 'cb_get_post_format_data' ) ) {
    function cb_get_post_format_data( $cb_post_id, $cb_post_format_type = NULL ) {

        $cb_output = $cb_audio_source = NULL;

        if ( $cb_post_format_type == 'gallery' ) {

            $cb_gallery_post_images = get_post_meta( $cb_post_id, 'cb_gallery_post_images', true );
            $cb_post_gallery = cb_get_gallery_images( $cb_post_id, $cb_gallery_post_images, 'cb-x-800', $cb_captions = true );

            if ( $cb_post_gallery != NULL ) {

                $cb_like_article = ot_get_option( 'cb_like_article', NULL );

                $cb_output = '<div id="cb-featured-image" class="cb-slider clearfix cb-gallery-post cb-background-preload"><ul class="slides">';

                foreach ( $cb_post_gallery as $cb_image ) {

                     if ( trim( $cb_image['cb-caption'] ) != '' ) {
                        $cb_image['cb-caption'] = '<span class="cb-caption">' . $cb_image['cb-caption'] . '</span>';
                    }

                    $cb_output .= '<li><img src="' . esc_url( $cb_image['cb-url'] ) . '">' .  $cb_image['cb-caption'] . '</li>';

                }

                $cb_output .= '</ul>';

                $cb_output .= '<span class="cb-link-overlay"><div class="cb-meta-data">';
                $cb_output .= '<h2 class="cb-post-title">' . get_the_title() . '</h2>';
                if ( $cb_like_article == 'on' ) { $cb_output .= cb_get_like_count( $cb_post_id ); }
                $cb_output .= '</div></span>';

                $cb_output .= '</div>';

            }

        }

        if ( $cb_post_format_type == 'video' ) {

            $cb_play_pause_buttons = '<i id="cb-play-button" class="cb-circle fa fa-play"></i><i id="cb-close-button" class="cb-circle fa fa-times"></i>';
            $cb_video_url = get_post_meta( $cb_post_id, 'cb_video_post_url', true );
            $cb_output = '<div class="cb-media-embed">';

            if ( strpos( $cb_video_url, 'yout' ) !== false ) {
                preg_match( '([-\w]{11})', $cb_video_url, $cb_youtube_id );
                $cb_video_url = '<div id="cbplayer">' . $cb_youtube_id[0] . '</div>';
            }

            $cb_output .= '<div id="cb-media-embed-url">' . $cb_video_url . '</div>';
            $cb_output .= '</div>' . $cb_play_pause_buttons;

        }

        if ( $cb_post_format_type == 'audio' ) {

            $cb_audio_post_select = get_post_meta( $cb_post_id, 'cb_audio_post_select', true );
            $cb_play_pause_buttons = '<i id="cb-play-button" class="cb-circle fa fa-headphones"></i><i id="cb-close-button" class="cb-circle fa fa-times"></i>';

            if ( $cb_audio_post_select == 'external' ) {

                $cb_audio_url = get_post_meta( $cb_post_id, 'cb_audio_post_url', true );
                $cb_output = '<div class="cb-media-embed">';
                $cb_output .= '<div id="cb-media-embed-url" class="cb-audio-embed">' . $cb_audio_url . '</div>';
                $cb_output .= '</div>' . $cb_play_pause_buttons;

            } elseif ( $cb_audio_post_select == 'selfhosted' ) {

                $cb_audio_source_mp3 = get_post_meta( $cb_post_id, 'cb_audio_post_selfhosted_mp3', true );
                $cb_audio_source_ogg = get_post_meta( $cb_post_id, 'cb_audio_post_selfhosted_ogg', true );

                if ( ( $cb_audio_source_mp3 != NULL ) || ( $cb_audio_source_mp3 != NULL ) ) {

                    $cb_audio_source = '<audio controls="controls">';

                    if ( $cb_audio_source_mp3 != NULL ) {
                        $cb_audio_source .= '<source src="' . esc_url( $cb_audio_source_mp3 ) . '" type="audio/mpeg" />';
                    }

                    if ( $cb_audio_source_ogg != NULL ) {
                        $cb_audio_source .= '<source src="' . esc_url( $cb_audio_source_ogg ) . '" type="audio/ogg" />';
                    }

                    $cb_audio_source .= '</audio>';

                }

                $cb_output = '<div class="cb-media-embed">';
                $cb_output .= '<div id="cb-media-embed-url">' . $cb_audio_source . '</div>';
                $cb_output .= '</div>' . $cb_play_pause_buttons;
            }
        }
        return $cb_output;
    }
}


/*********************
GALLERY POST FORMAT
*********************/
if ( ! function_exists( 'cb_get_gallery_images' ) ) {
    function cb_get_gallery_images( $cb_post_id, $cb_gallery_post_images, $cb_image_size = 'cb-1200-520', $cb_captions = false ) {

        $cb_gallery_post_images = explode( ',', $cb_gallery_post_images );

        $cb_output = array();
        $cb_caption = NULL;

        foreach ( $cb_gallery_post_images as $cb_each_image ) {
            $cb_image = wp_get_attachment_image_src( $cb_each_image, $cb_image_size );
            if ( $cb_captions == true ) {
                $cb_caption = get_post($cb_each_image)->post_excerpt;
            }

            $cb_output[] = array( 'cb-url' => $cb_image[0], 'cb-caption' => $cb_caption );
        }

        return $cb_output;
    }
}



/*********************
NEXT/PREVIOUS POST SLIDE IN
*********************/
if ( ! function_exists( 'cb_next_previous_slide' ) ) {
    function cb_next_previous_slide( $cb_location ) {

        global $post;

        $cb_next_post = get_next_post();
        $cb_previous_post = get_previous_post();
        $cb_previous_next_onoff = ot_get_option( 'cb_previous_next_onoff', 'on' );

        $cb_next_post_output = $cb_previous_post_output = $cb_previous_featured_image_output = $cb_next_featured_image_output = $cb_output = NULL;

        if ( ( ( $cb_previous_post != NULL ) || ( $cb_next_post != NULL ) ) && ( $cb_previous_next_onoff == 'on' ) ) {

            $cb_output = '<div id="cb-next-previous-posts" class="cb-next-previous clearfix cb-ani-fade-in-0-5s '. $cb_location . '">';

            if ( $cb_next_post != NULL ) {

                $cb_next_id = $cb_next_post->ID;
                $cb_next_featured_image = get_the_post_thumbnail( $cb_next_id, 'cb-32-32', array('class' => 'cb-rounded') );
                $cb_next_title = $cb_next_post->post_title;
                $cb_next_permalink = get_permalink( $cb_next_id );

                if ( $cb_next_featured_image != NULL ) {
                    $cb_next_featured_image_output = '<a href="' . esc_url( $cb_next_permalink ) . '" class="cb-featured-image">' . $cb_next_featured_image . '</a>';
                }

                $cb_next_post_output = '<div class="cb-next-post cb-next-previous-block">';

                $cb_next_post_output .= $cb_next_featured_image_output;
                $cb_next_post_output .= '<span class="cb-read-next-title cb-read-title"><a href="' . esc_url( $cb_next_permalink ) . '">' . __( 'Next Article', 'cubell' ) . '</a></span>';
                $cb_next_post_output .= '<a href="' . esc_url( $cb_next_permalink ) . '" class="cb-next-title cb-title">' . $cb_next_title . '</a>';

                $cb_next_post_output .= '</div>';
            } else {
                $cb_next_post_output = '<div class="cb-next-post cb-next-previous-block cb-empty"><span class="cb-read-previous-title cb-read-title">' . __('No Newer Articles', 'cubell') . '</span></div>';
            }

            if ( $cb_previous_post != NULL ) {

                $cb_previous_id = $cb_previous_post->ID;
                $cb_previous_featured_image = get_the_post_thumbnail( $cb_previous_id, 'cb-32-32', array('class' => 'cb-rounded') );
                $cb_previous_title = $cb_previous_post->post_title;
                $cb_previous_permalink = get_permalink( $cb_previous_id );

                if ( $cb_previous_featured_image != NULL ) {
                    $cb_previous_featured_image_output = '<a href="' . esc_url( $cb_previous_permalink ) . '" class="cb-featured-image">' . $cb_previous_featured_image . '</a>';
                }

                $cb_previous_post_output = '<div class="cb-previous-post cb-next-previous-block">';
                $cb_previous_post_output .= $cb_previous_featured_image_output;
                $cb_previous_post_output .= '<span class="cb-read-previous-title cb-read-title"><a href="' . esc_url( $cb_previous_permalink ) . '">' . __( 'Previous Article', 'cubell' ) . '</a></span>';
                $cb_previous_post_output .= '<a href="' . esc_url( $cb_previous_permalink ) . '" class="cb-previous-title cb-title">' . $cb_previous_title . '</a>';

                $cb_previous_post_output .= '</div>';
            } else {
                $cb_previous_post_output = '<div class="cb-previous-post cb-next-previous-block cb-empty"><span class="cb-read-previous-title cb-read-title">' . __('No Older Articles', 'cubell') . '</span></div>';
            }

            $cb_output .= $cb_previous_post_output . $cb_next_post_output;

            $cb_output .= '</div>';

        }

        echo $cb_output;

    }
}

/*********************
SHARING BLOCK
*********************/
if ( ! function_exists( 'cb_sharing_block' ) ) {
    function cb_sharing_block( $post ) {

        $cb_social_sharing = ot_get_option( 'cb_social_sharing', 'on' );

        if ( $cb_social_sharing != 'off' ) {

            $cb_post_url = esc_url( get_permalink( $post->ID ) );

            $cb_output = '<div class="cb-sharing-block cb-post-footer-block">';
            $cb_output .= '<h3 class="cb-sharing-title cb-footer-title cb-body-font">' . __('Share This Article', 'cubell' ) . '</h3>';
            $cb_output .= '<div class="cb-social-networks">';
            $cb_output .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $cb_post_url . '" target="_blank">Facebook</a>';
            $cb_output .= '<a href="//www.pinterest.com/pin/create/button/?url=' . $cb_post_url . '" target="_blank">Pinterest</a>';
            $cb_output .= '<a href="https://twitter.com/share?url=' . $cb_post_url . '" target="_blank">Twitter</a>';
            $cb_output .= '<a href="https://plus.google.com/share?url=' . $cb_post_url . '" target="_blank">Google+</a>';
            $cb_output .= '<a href="http://www.stumbleupon.com/submit?url=' . $cb_post_url . '" target="_blank">StumbleUpon</a>';
            $cb_output .= '</div>';
            $cb_output .= '</div>';

            echo $cb_output;

        }
    }
}

/*********************
POST TAGS
*********************/
if ( ! function_exists( 'cb_the_tags' ) ) {
    function cb_the_tags( $cb_post_id ) {

        the_tags('<div class="cb-tags cb-post-footer-block"><h3 class="cb-tags-title cb-footer-title cb-body-font">' . __( 'Tags', 'cubell' ) . '</h3> ', '', '</div>');

    }
}

/*********************
RELATED POSTS FUNCTION
*********************/
if ( ! function_exists( 'cb_related_posts_block' ) ) {
    function cb_related_posts_block() {

        global $post;
        $cb_post_id = $post->ID;
        $i = 1;
        $cb_related_posts_amount = floatval( ot_get_option( 'cb_related_posts_amount', '2' ) );
        $cb_related_posts_show = ot_get_option( 'cb_related_posts_show', 'both' );
        $cb_related_posts_order = ot_get_option( 'cb_related_posts_order', 'rand' );
        $cb_blog_style = ot_get_option( 'cb_related_posts_style', '2' );
        $cb_related_posts_amount_full = ( $cb_related_posts_amount * 1.5 );
        $cb_block_title = __( 'Related Articles', 'cubell');
        $cb_classes = 'cb-row-article clearfix cb-blog-style';

        if ( $cb_blog_style == 1 ) {

            $cb_posts_per_row = 1;
            $cb_width = '1400';
            $cb_height = '580';
            $cb_classes .= ' cb-row-1';
        } 

        if ( $cb_blog_style == 2 ) {

            $cb_posts_per_row = 2;
            $cb_width = '800';
            $cb_height = '550';
            $cb_classes .= ' cb-row-2';
        } 

        if ( $cb_blog_style == 3 ) {

            $cb_posts_per_row = 3;
            $cb_width = '550';
            $cb_height = '430';
            $cb_classes .= ' cb-row-3';
        }

        $cb_full_width_post = get_post_meta( $cb_post_id, 'cb_full_width_post', true );
        if ( $cb_full_width_post == 'nosidebar' ) { $cb_number_related = $cb_related_posts_amount_full; } else { $cb_number_related = $cb_related_posts_amount; }

            $cb_tags = wp_get_post_tags( $cb_post_id );
            $cb_tag_check = $cb_all_cats = $cb_related_args = $cb_related_posts = NULL;

            if ( ( $cb_related_posts_show == 'both' ) || ( $cb_related_posts_show == 'tags' ) ) {


                if ( $cb_tags != NULL ) {
                    foreach ( $cb_tags as $cb_tag ) { $cb_tag_check .= $cb_tag->slug . ','; }
                    $cb_related_args = array( 'numberposts' => $cb_number_related, 'tag' => $cb_tag_check, 'exclude' => $cb_post_id, 'post_status' => 'publish','orderby' => $cb_related_posts_order );
                    $cb_related_posts = get_posts( $cb_related_args );
                }

            }          

            if ( ( $cb_related_posts_show == 'both' ) || ( $cb_related_posts_show == 'cats' ) ) {

                if ( $cb_related_posts == NULL ) {
                    $cb_categories = get_the_category();
                    foreach ( $cb_categories as $cb_category ) { $cb_all_cats .= $cb_category->term_id  . ','; }
                    $cb_related_args = array( 'numberposts' => $cb_number_related, 'category' => $cb_all_cats, 'exclude' => $cb_post_id, 'post_status' => 'publish', 'orderby' => $cb_related_posts_order );
                    $cb_related_posts = get_posts( $cb_related_args );
                }

            }  

            if ( $cb_related_posts != NULL ) {

                echo '<div id="cb-related-posts" class="clearfix"><h3 class="cb-tags-title cb-body-font cb-footer-title">' . $cb_block_title  . '</h3>';
                foreach ( $cb_related_posts as $post ) {

                    $cb_post_id = $post->ID;
                    $cb_global_color = ot_get_option('cb_base_color', '#eb9812');
                    $cb_cat_id = get_the_category();

                    if ( function_exists('get_tax_meta') ) {

                            $cb_current_cat_id = $cb_cat_id[0]->term_id;
                            $cb_category_color = get_tax_meta($cb_current_cat_id, 'cb_color_field_id');

                            if (($cb_category_color == "#") || ($cb_category_color == NULL)) {
                                $cb_parent_cat_id = $cb_cat_id[0]->parent;

                                if ($cb_parent_cat_id != '0') {
                                    $cb_category_color = get_tax_meta($cb_parent_cat_id, 'cb_color_field_id');
                                }

                                if (($cb_category_color == "#") || ($cb_category_color == NULL)) {
                                    $cb_category_color = $cb_global_color;
                                }
                            }
                    } else {
                         $cb_category_color = NULL;
                    }
                    setup_postdata($post);
?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( $cb_classes ); ?> role="article">

                        <div class="cb-article-area">
                            <div class="cb-mask">
                                <?php cb_thumbnail( $cb_post_id,  $cb_width, $cb_height ); ?>
                            </div>
                            <?php cb_post_meta_wrap( $cb_post_id, $cb_like_count = 'on' ); ?>
                        </div>

                    </article>
    <?php
                            $i++;
                }

                echo '</div>';
                wp_reset_postdata();
            }
    }
}



/*********************
LIKE BLOCK
*********************/
if ( ! function_exists( 'cb_like_block' ) ) {
    function cb_like_block( $cb_post_id ) {

        $cb_like_article = ot_get_option('cb_like_article', NULL);

        if ( $cb_like_article != 'off' ) {

            $cb_like_count_current = get_post_meta( $cb_post_id, 'cb_post_like_count', true );
            $cb_like_symbol = ot_get_option( 'cb_like_symbol', 'cb-heart' );

            if ( $cb_like_symbol == 'cb-heart' ) {

                $cb_like_symbol = '<i class="fa fa-heart-o cb-empty"></i>';
                $cb_like_symbol_full = '<i class="fa fa-heart cb-full"></i>';

            } elseif ( $cb_like_symbol == 'cb-bolt' ) {

                $cb_like_symbol = '<i class="fa fa-bolt"></i>';
                $cb_like_symbol_full = '<i class="fa fa-bolt"></i>';

            } elseif ( $cb_like_symbol == 'cb-star' ) {

                $cb_like_symbol = '<i class="fa fa-star-o cb-empty"></i>';
                $cb_like_symbol_full = '<i class="fa fa-star cb-full"></i>';

            }

            if ( $cb_like_count_current == NULL ) {
                $cb_like_count_current = 0;
            }

            if ( isset( $_COOKIE['post_was_liked'] ) ) {
                $cb_already_liked = $_COOKIE['post_was_liked'];
            } else {
                $cb_already_liked = NULL;
            }

            if ( preg_match('/\b' . $cb_post_id . '\b/', $cb_already_liked ) ) {
                 $cb_class = ' class="cb-already-liked"';
            } else {
                 $cb_class = NULL;
            }

            $cb_output = '<div class="cb-like-block cb-post-footer-block">';
            $cb_output .= '<div id="cb-like-button"' . $cb_class . '>';
            $cb_output .= '<span id="cb-like-count"><span class="cb-like-stack">' . $cb_like_symbol . $cb_like_symbol_full . '</span><span class="cb-number-stack"><span class="cb-like-number cb-current">' . $cb_like_count_current . '</span><span class="cb-like-number cb-plus-one">' . ( $cb_like_count_current + 1 ) . '</span></span></span>';
            $cb_output .= '</div>';

            if ( function_exists( 'wp_nonce_field' ) ) {
                $cb_output .= wp_nonce_field( 'voting_nonce', 'voting_nonce', true, false );
            }

            $cb_output .= '</div>';
            echo $cb_output;

        }
    }
}

/*********************
LIKE BLOCK ADD 1
*********************/
if ( ! function_exists( 'cb_like_count_add_one' ) ) {
    function cb_like_count_add_one() {

        if ( ! wp_verify_nonce($_POST['nonce'], 'voting_nonce') ) {
            return;
        }

        $cb_post_id = $_POST['postid'];
        $cb_like_count_current = get_post_meta($cb_post_id, 'cb_post_like_count', true);

        if ( $cb_like_count_current == NULL ) {
             $cb_like_count_current = 0;
        }

        $cb_like_count_current = intval( $cb_like_count_current );
        $cb_like_count_new = $cb_like_count_current + 1;

        update_post_meta( $cb_post_id, 'cb_post_like_count', $cb_like_count_new );

        die( 0 );
    }
}
add_action('wp_ajax_cb_like_count_add_one', 'cb_like_count_add_one');
add_action('wp_ajax_nopriv_cb_like_count_add_one', 'cb_like_count_add_one');

if ( ! function_exists( 'cb_like_count_call' ) ) {
    function cb_like_count_call() {

        if ( is_single() == true ) {

            global $post;
            $cb_post_id = $post->ID;
?>
            <script type="text/javascript">
                (function($) {

                    var cbLikeButtonBlock = $('#cb-like-button'),
                        cb_nonce = $('input#voting_nonce').val(),
                        cb_action = { action: 'cb_like_count_add_one',  nonce: cb_nonce, postid: <?php echo $cb_post_id; ?> },
                        cbajaxurl = <?php echo '"' . admin_url( 'admin-ajax.php' ) . '"'; ?>;

                    cbLikeButtonBlock.click( function() {

                        if ( ! $(this).hasClass('cb-already-liked') ) {

                            $.post( cbajaxurl, cb_action, function( data ) {

                                if ( ( data !== '-1' ) && ( cookie.enabled() ) ) {

                                    var cb_checker = cookie.get( 'post_was_liked' ),
                                        cb_current_post;

                                    if ( ! cb_checker ) {
                                        cb_current_post = <?php echo $cb_post_id; ?>;
                                    } else {
                                        cb_current_post = cb_checker + ',' + <?php echo $cb_post_id; ?>;
                                    }

                                    cookie.set( 'post_was_liked', cb_current_post, { expires: 30 } );

                                }
                            });

                            $(this).addClass('cb-already-liked cb-just-liked');

                        }
                    });

                })(jQuery);
            </script>
<?php
        }
    }
}
add_action( 'wp_footer', 'cb_like_count_call' );

/*********************
LIKE COUNT RETURN
*********************/
if ( ! function_exists( 'cb_get_like_count' ) ) {
    function cb_get_like_count( $cb_post_id ) {

        $cb_like_article = ot_get_option( 'cb_like_article', NULL );
        $cb_output = NULL;

        if ( $cb_like_article != 'off' ) {

            $cb_like_count_current = get_post_meta( $cb_post_id, 'cb_post_like_count', true );
            $cb_like_symbol = ot_get_option( 'cb_like_symbol', 'cb-heart' );

            if ( $cb_like_symbol == 'cb-heart' ) {
                $cb_like_symbol = '<i class="fa fa-heart-o"></i>';
            } elseif ( $cb_like_symbol == 'cb-bolt' ) {
                $cb_like_symbol = '<i class="fa fa-bolt"></i>';
            } elseif ( $cb_like_symbol == 'cb-star' ) {
                $cb_like_symbol = '<i class="fa fa-star-o"></i>';
            }

            if ( $cb_like_count_current == NULL ) {
                $cb_like_count_current = 0;
            }

            $cb_output = '<span class="cb-like-count">' . $cb_like_symbol . ' ' . $cb_like_count_current . '</span>';
        }

        return $cb_output;

    }
}

/*********************
ARROW SCROLL DOWN
*********************/
if ( ! function_exists( 'cb_get_arrow_down' ) ) {
    function cb_get_arrow_down() {

        $cb_output = '<a href="#" class="cb-vertical-down"><i class="fa fa-angle-down"></i></a>';

        return $cb_output;
    }
}

/*********************
POSTS IN FRONTEND SEARCHES
*********************/
if ( ! function_exists( 'cb_clean_search' ) ) {
    function cb_clean_search($cb_query) {

         if ( ( is_admin() == false ) && ( $cb_query->is_search == true ) ) {

            $cb_cpt_output = cb_get_custom_post_types();

            $cb_query->set( 'post_type', $cb_cpt_output );
         }
         return $cb_query;
    }
}
add_filter('pre_get_posts','cb_clean_search');

/*********************
COMMENTS
*********************/
if ( ! function_exists( 'cb_comments' ) ) {
    function cb_comments($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>

        <li <?php comment_class(); ?> >

            <article id="comment-<?php comment_ID(); ?>" class="clearfix">

                <div class="cb-comment-body clearfix">

                    <header class="comment-author vcard">
                        <div class="cb-gravatar-image">
                            <?php echo get_avatar( $comment, 80 ); ?>
                        </div>
                        <time datetime="<?php comment_date(); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_date(); ?> </a></time>
                        <?php echo "<cite class='fn'>" . get_comment_author_link() . "</cite>"; ?>
                        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </header>
                    <?php edit_comment_link(__('(Edit)', 'cubell'),'  ','') ?>
                    <?php if ( $comment->comment_approved == '0' ) { ?>
                        <div class="alert info">
                            <p><?php _e('Your comment is awaiting moderation.', 'cubell') ?></p>
                        </div>
                    <?php } ?>
                    <section class="comment_content clearfix">
                        <?php comment_text(); ?>
                    </section>
                </div>

            </article>
<?php
    }
}

/*********************
GET CUSTOM POST TYPES
*********************/
if ( ! function_exists( 'cb_get_custom_post_types' ) ) {

    function cb_get_custom_post_types() {

        $cb_cpt_list = ot_get_option( 'cb_cpt', NULL );

        $cb_cpt_output = array( 'post' );

        if ( $cb_cpt_list != NULL ) {
            $cb_cpt = explode(',', str_replace(' ', '', $cb_cpt_list ) );

            foreach ( $cb_cpt as $cb_cpt_single ) {
                $cb_cpt_output[] = $cb_cpt_single;
            }
        }

        return $cb_cpt_output;
    }

}

/*********************
ADD SEARCH TO SIDEBAR MENU
*********************/
if ( ! function_exists( 'cb_add_extras_main_menu' ) ) {
    function cb_add_extras_main_menu( $cb_output, $args ) {

        $cb_sidebar_menu_search = ot_get_option('cb_search_in_menu', 'on' );

        if ( $cb_sidebar_menu_search != 'off' ) {

            $cb_menu_output = '<li class="cb-icon-search">' .  get_search_form( false ) . '</li>';

            if ( $args->theme_location == 'cb_main' ) {
                ob_start();
                echo $cb_menu_output;
                $cb_output =  ob_get_contents() . $cb_output ;

                ob_end_clean();
            }
        }

        return $cb_output;
    }
}
add_filter('wp_nav_menu_items','cb_add_extras_main_menu', 10, 2);

/*********************
ADD POSTS TO SIDEBAR
*********************/
if ( ! function_exists( 'cb_sidebar_post' ) ) {
    function cb_sidebar_post() {

        $cb_sidebar_posts = ot_get_option('cb_sidebar_posts', 'on' );
        $cb_sidebar_posts_title = ot_get_option('cb_sidebar_posts_title', NULL );
        $cb_sidebar_posts_filter = ot_get_option('cb_sidebar_posts_filter', 'rand' );
        $cb_sidebar_posts_number = ot_get_option('cb_sidebar_posts_number', '2' );
        $cb_sidebar_posts_likes = ot_get_option('cb_sidebar_posts_likes', 'on' );

        $cb_output = $cb_meta_value = NULL;

        if ( $cb_sidebar_posts == 'on' ) {

            if ( $cb_sidebar_posts_filter == 'meta_value_num' ) {
                $cb_meta_value = 'cb_post_like_count';
            }

            $cb_qry = new WP_Query( array( 'posts_per_page' => $cb_sidebar_posts_number, 'orderby' => $cb_sidebar_posts_filter, 'meta_key' => $cb_meta_value, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );

            if ( $cb_qry->have_posts() ) {

                $cb_post_classes = array( 'clearfix', 'cb-menu-post', 'cb-' . $cb_sidebar_posts_number );
                echo '<span class="cb-sidebar-post-title cb-sidebar-post-meta">' . $cb_sidebar_posts_title . '</span>';

                while ( $cb_qry->have_posts() ) {

                    $cb_qry->the_post();
                    global $post;
                    $cb_post_id = $post->ID;
            ?>
                    <div <?php post_class( $cb_post_classes ); ?>>
                        
                        <div class="cb-mask">
                            <?php cb_thumbnail( $cb_post_id, '550', '430', false ); ?>
                        </div>
                        <?php if ( $cb_sidebar_posts_likes == 'on' ) { echo cb_get_like_count( $cb_post_id); } ?>
                        <a href="<?php the_permalink(); ?>" class="cb-link-overlay"></a>

                    </div>
            <?php

                }

            }

            wp_reset_postdata();
        }

        echo $cb_output;

    }
}

/*********************
FOOTER BACKGROUND IMAGE/COLOR
*********************/
if ( ! function_exists( 'cb_footer_background_start_output' ) ) {
    function cb_footer_background_start_output() {

        $cb_footer_lower_bg = ot_get_option( 'cb_footer_lower_bg', array() );
        if ( array_key_exists( 'background-image', $cb_footer_lower_bg ) ) {
            echo '<span id="cb-footer-background"></span>';
        }

    }
}
add_filter( 'cb_footer_background_start', 'cb_footer_background_start_output' );

/*********************
DYNAMIC CSS
*********************/
if ( ! function_exists( 'cb_dynamic_css' ) ) {
    function cb_dynamic_css() {

        $cb_output = $cb_footer_bg_image = $cb_footer_bg_color = NULL;
        $cb_footer_lower_bg = ot_get_option( 'cb_footer_lower_bg', NULL );

        if ( $cb_footer_lower_bg != NULL ) {

            if ( array_key_exists( 'background-image', $cb_footer_lower_bg ) ) {

                $cb_footer_bg_image = '#cb-footer #cb-footer-background { ';

                foreach ( $cb_footer_lower_bg as $cb_key => $cb_value ) {

                    if ( $cb_value != NULL ) {

                        if ( $cb_key == 'background-image' ) {
                             $cb_footer_bg_image .= $cb_key . ': url(' . $cb_value . '); ';
                        }
                        
                    }

                }

                $cb_footer_bg_image .= '}';

            }

            if ( array_key_exists( 'background-color', $cb_footer_lower_bg ) ) {

                $cb_footer_bg_color = '#cb-footer { background-color: ' . $cb_footer_lower_bg['background-color'] . '; }';

            }
        }

        if ( $cb_footer_lower_bg != NULL ) {

            $cb_output .= '<style>' . $cb_footer_bg_image . $cb_footer_bg_color  . '</style>';

        }

        echo $cb_output;
    }
}
add_action( 'wp_head', 'cb_dynamic_css' );

/*********************
ADMIN FONTS
*********************/
if ( ! function_exists( 'cb_admin_fonts' ) ) {
    function cb_admin_fonts(){

        $cb_admin_font = '//fonts.googleapis.com/css?family=Merriweather:300,400, 700,400italic';
        wp_register_style( 'cb-font-body-stylesheet',  $cb_admin_font, array(), '1.0', 'all' );
        wp_enqueue_style('cb-font-body-stylesheet');

    }
}
add_action('admin_enqueue_scripts', 'cb_admin_fonts');

/*********************
EXCERPT MORE TEXT
*********************/
if ( ! function_exists( 'cb_excerpt_more_text' ) ) {
    function cb_excerpt_more_text( $more ) {
        $cb_output = '&hellip;' . wp_link_pages('before=<div class="cb-pagination clearfix">&after=</div>&next_or_number=number&pagelink=<span class="cb-page">%</span>&echo=0') . '<span class="cb-continue-reading"><a href="'. esc_url( get_permalink( get_the_ID() ) ) .'">' . __( 'Continue Reading', 'cubell' ) . '</a></span>';
        return $cb_output;
    }
}
add_filter( 'excerpt_more', 'cb_excerpt_more_text' );

/*********************
EXCERPT LENGTH
*********************/
if ( ! function_exists( 'cb_excerpt_length' ) ) {
    function cb_excerpt_length( $length ) {
        return 150;
    }
}
add_filter( 'excerpt_length', 'cb_excerpt_length', 999 );


/*********************
EXCERPT
*********************/
if ( ! function_exists( 'cb_clean_excerpt' ) ) {
    function cb_clean_excerpt () {

        $cb_excerpt_output = get_the_excerpt();
        $cb_excerpt_output = '<div class="cb-excerpt">' . $cb_excerpt_output . ' </div>';
        return $cb_excerpt_output;
    }
}

/*********************
BLOG HOMEPAGE PAGINATION WITH OFFSET
*********************/
if ( ! function_exists( 'cb_get_bloghome_offset' ) ) {
    function cb_get_bloghome_offset() {

        $cb_return = NULL;
        $cb_offset = ot_get_option( 'cb_hp_slider_offset', 'on' );
        $cb_hp_slider = ot_get_option( 'cb_hp_slider',  'off' );
        $cb_hp_slider_filter = ot_get_option( 'cb_hp_slider_filter',  'latest' );

        if ( ( $cb_hp_slider == 'on' ) && ( $cb_offset == 'on' ) && ( $cb_hp_slider_filter == 'latest' ) ) {

            $cb_return = ot_get_option( 'cb_hp_slider_count', '6' );

        }

        return $cb_return;
    }
}

/*********************
PAGINATION WITH OFFSET
*********************/
if ( ! function_exists( 'cb_pagination_offset' ) ) {
    function cb_pagination_offset( $found_posts, $query ) {
        
        if ( is_home() == true ) {

            $cb_offset_size = cb_get_bloghome_offset();
            $found_posts = $found_posts - $cb_offset_size;

        }

        return $found_posts ;
    }
}
add_filter('found_posts', 'cb_pagination_offset', 1, 2 );

/*********************
OFFSETTING QUERY VARIABLE['cb_offset_loop']
*********************/
if ( ! function_exists( 'cb_offset_loop_pre_get_posts' ) ) {
    function cb_offset_loop_pre_get_posts( $query ){

        if ( isset( $query->query_vars['cb_offset_loop'] ) && ( $query->query_vars['cb_offset_loop'] == 'on' ) ) {

            if ( is_home() == true ) { 
                $cb_offset_size = cb_get_bloghome_offset(); 
            }

            $cb_posts_per_page = get_option('posts_per_page');

            if ( $query->is_paged == true ) {

                $cb_page_offset = $cb_offset_size + ( ( $query->query_vars['paged'] - 1 ) * $cb_posts_per_page );
                $query->set( 'offset', $cb_page_offset );

            } else {

                $query->set( 'offset', $cb_offset_size );

            }
        }

        return $query;
    }
}
add_action( 'pre_get_posts', 'cb_offset_loop_pre_get_posts' );

/*********************
ADD QUERY VAR FOR OFFSET WP_QUERY
*********************/
if ( ! function_exists( 'cb_add_query_variable' ) ) {
    function cb_add_query_variable( $query_vars ){

        array_push($query_vars, 'cb_offset_loop');
        return $query_vars;

    }
}

add_filter( 'query_vars', 'cb_add_query_variable' );

/*********************
TYPOGRAPHY OPTION
*********************/
if ( ! function_exists( 'ot_type_typography' ) ) {
  
  function ot_type_typography( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-typography ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* allow fields to be filtered */
        $ot_recognized_typography_fields = apply_filters( 'ot_recognized_typography_fields', array( 
          'color',
          'font-family', 
          'font-size', 
          'font-style', 
          'text-align', 
          'font-weight', 
          'letter-spacing', 
          'line-height', 
          'text-decoration', 
          'text-transform' 
        ), $field_id );
        
        /* build font color */
        if ( in_array( 'color', $ot_recognized_typography_fields ) ) {
          
          /* build colorpicker */  
          echo '<div class="option-tree-ui-colorpicker-input-wrap">';
            
            /* colorpicker JS */      
            echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
            
            /* set background color */
            $background_color = isset( $field_value['color'] ) ? esc_attr( $field_value['color'] ) : '';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[color]" id="' . esc_attr( $field_id ) . '-picker" value="' . esc_attr( $background_color ) . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
          
          echo '</div>';
        
        }
        
        /* build font family */
        if ( in_array( 'font-family', $ot_recognized_typography_fields ) ) {
          $font_family = isset( $field_value['font-family'] ) ? $field_value['font-family'] : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-family]" id="' . esc_attr( $field_id ) . '-font-family" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-family</option>';
            foreach ( ot_recognized_font_families( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_family, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font size */
        if ( in_array( 'font-size', $ot_recognized_typography_fields ) ) {
          $font_size = isset( $field_value['font-size'] ) ? esc_attr( $field_value['font-size'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-size]" id="' . esc_attr( $field_id ) . '-font-size" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-size</option>';
            foreach( ot_recognized_font_sizes( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $font_size, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font style */
        if ( in_array( 'font-style', $ot_recognized_typography_fields ) ) {
          $font_style = isset( $field_value['font-style'] ) ? esc_attr( $field_value['font-style'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-style]" id="' . esc_attr( $field_id ) . '-font-style" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-style</option>';
            foreach ( ot_recognized_font_styles( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_style, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font variant */
        if ( in_array( 'text-align', $ot_recognized_typography_fields ) ) {
          $font_variant = isset( $field_value['text-align'] ) ? esc_attr( $field_value['text-align'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-align]" id="' . esc_attr( $field_id ) . '-text-align" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-align</option>';
            foreach ( ot_recognized_font_variants( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_variant, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font weight */
        if ( in_array( 'font-weight', $ot_recognized_typography_fields ) ) {
          $font_weight = isset( $field_value['font-weight'] ) ? esc_attr( $field_value['font-weight'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-weight]" id="' . esc_attr( $field_id ) . '-font-weight" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-weight</option>';
            foreach ( ot_recognized_font_weights( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_weight, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build letter spacing */
        if ( in_array( 'letter-spacing', $ot_recognized_typography_fields ) ) {
          $letter_spacing = isset( $field_value['letter-spacing'] ) ? esc_attr( $field_value['letter-spacing'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[letter-spacing]" id="' . esc_attr( $field_id ) . '-letter-spacing" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">letter-spacing</option>';
            foreach( ot_recognized_letter_spacing( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $letter_spacing, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build line height */
        if ( in_array( 'line-height', $ot_recognized_typography_fields ) ) {
          $line_height = isset( $field_value['line-height'] ) ? esc_attr( $field_value['line-height'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[line-height]" id="' . esc_attr( $field_id ) . '-line-height" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">line-height</option>';
            foreach( ot_recognized_line_heights( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $line_height, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text decoration */
        if ( in_array( 'text-decoration', $ot_recognized_typography_fields ) ) {
          $text_decoration = isset( $field_value['text-decoration'] ) ? esc_attr( $field_value['text-decoration'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-decoration]" id="' . esc_attr( $field_id ) . '-text-decoration" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-decoration</option>';
            foreach ( ot_recognized_text_decorations( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_decoration, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text transform */
        if ( in_array( 'text-transform', $ot_recognized_typography_fields ) ) {
          $text_transform = isset( $field_value['text-transform'] ) ? esc_attr( $field_value['text-transform'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-transform]" id="' . esc_attr( $field_id ) . '-text-transform" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-transform</option>';
            foreach ( ot_recognized_text_transformations( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_transform, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/*********************
VIDEO POST FORMAT OPTIONS
*********************/
if ( ! function_exists( 'cb_ot_meta_box_post_format_video' ) ) {
    function cb_ot_meta_box_post_format_video() { 
        return array(
            'id'        => 'ot-post-format-video',
            'title'     => 'Ness Post Format: Video',
            'desc'      => '',
            'pages'     => 'post',
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
            
            array(
                'id'          => 'cb_video_post_url',
                'label'       => 'Video Embed Code',
                'desc'        => 'To embed videos that overlay on top of the featured image, paste the video embed code',
                'std'         => '',
                'section'     => 'option_types',
                'type'        => 'textarea-simple',
                'rows'        => '1',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => '',
                'operator'    => 'and'
                ),
            )
        );
    }
}
add_filter( 'ot_meta_box_post_format_video', 'cb_ot_meta_box_post_format_video' );

/*********************
GALLERY POST FORMAT OPTIONS
*********************/
if ( ! function_exists( 'cb_ot_meta_box_post_format_gallery' ) ) {
    function cb_ot_meta_box_post_format_gallery() { 
        return array(

            'id'        => 'ot-post-format-gallery',
            'title'     => 'Ness Post Format: Gallery',
            'desc'      => '',
            'pages'     => 'post',
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(

                array(
                    'id'          => 'cb_gallery_post_images',
                    'label'       => '',
                    'desc'        => 'Upload/set images for gallery',
                    'std'         => '',
                    'type'        => 'gallery',
                    'section'     => 'option_types',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => '',
                    'operator'    => 'and'
                    ),
              
            )
        );
    }
}
add_filter( 'ot_meta_box_post_format_gallery', 'cb_ot_meta_box_post_format_gallery' );

/*********************
AUDIO POST FORMAT OPTIONS
*********************/
if ( ! function_exists( 'cb_ot_meta_box_post_format_audio' ) ) {
    function cb_ot_meta_box_post_format_audio() { 

        return array(
            'id'        => 'ot-post-format-audio',
            'title'     => __( 'Ness Post Format: Audio', 'option-tree' ),
            'desc'      => '',
            'pages'     => 'post',
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
              array(
                    'id'          => 'cb_audio_post_select',
                    'label'       => '',
                    'desc'        => '',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'select',
                    'rows'        => '1',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => '',
                    'operator'    => 'and',
                    'choices'     => array(
                                        array(
                                            'value'       => '',
                                            'label'       => __( '-- Choose One --', 'option-tree-theme' ),
                                            'src'         => ''
                                          ),
                                          array(
                                            'value'       => 'external',
                                            'label'       => 'External',
                                            'src'         => ''
                                          ),
                                          array(
                                            'value'       => 'selfhosted',
                                            'label'       => 'Self-Hosted',
                                            'src'         => ''
                                          ),
                                        ),
                    ),
                array(
                    'id'          => 'cb_audio_post_url',
                    'label'       => 'Audio Embed Code',
                    'desc'        => 'To add an audio embed to overlay the featured image, paste the audio embed code here. ',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'textarea-simple',
                    'rows'        => '3',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => 'cb_audio_post_select:is(external)',
                    'operator'    => 'and'
                    ),
                array(
                    'id'          => 'cb_audio_post_selfhosted_mp3',
                    'label'       => 'Self Hosted Mp3',
                    'desc'        => 'To add a .mp3 audio file use this option (most compatible filetype)',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'upload',
                    'rows'        => '1',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => 'cb_audio_post_select:is(selfhosted)',
                    'operator'    => 'and'
                    ),
                array(
                    'id'          => 'cb_audio_post_selfhosted_ogg',
                    'label'       => 'Self Hosted OGG file',
                    'desc'        => 'To add a .ogg audio file use this option',
                    'std'         => '',
                    'section'     => 'option_types',
                    'type'        => 'upload',
                    'rows'        => '1',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => 'cb_audio_post_select:is(selfhosted)',
                    'operator'    => 'and'
                    ),
            )
        );
    }
}
add_filter( 'ot_meta_box_post_format_audio', 'cb_ot_meta_box_post_format_audio' );

/*********************
ADMIN IMAGES URL
*********************/
if ( ! function_exists( 'cb_ot_type_radio_image_src' ) ) {
    function cb_ot_type_radio_image_src( $src ) { 
        return  get_template_directory_uri() . '/library/admin/images' . $src; 
    }
}
add_filter( 'ot_type_radio_image_src', 'cb_ot_type_radio_image_src' );

/*********************
INSERT TEXT
*********************/
if ( ! function_exists( 'cb_ot_upload_text' ) ) {
    function cb_ot_upload_text() { 
        return 'Insert'; 
    }
}
add_filter( 'ot_upload_text', 'cb_ot_upload_text' );

/*********************
OT VERSION
*********************/
if ( ! function_exists( 'cb_ot_header_version_text' ) ) {
    function cb_ot_header_version_text() { 
        return ''; 
    }
}
add_filter( 'ot_header_version_text', 'cb_ot_header_version_text' );

/*********************
ADMIN LOGO
*********************/
if ( ! function_exists( 'cb_ot_header_logo_link' ) ) {
    function cb_ot_header_logo_link() { 
        return '<img src="' . get_template_directory_uri() . '/library/admin/images/logo.png">';
    }
}
add_filter( 'ot_header_logo_link', 'cb_ot_header_logo_link' );

/*********************
ADMIN OT CSS
*********************/
if ( ! function_exists( 'cb_ot_css' ) ) {
    function cb_ot_css($hook) {

        global $wp_styles;
        wp_register_style( 'cb-admin-css',  get_template_directory_uri(). '/library/admin/cb-admin.css', array(), '' );
        wp_enqueue_style('cb-admin-css'); // enqueue it
        $wp_styles->add_data( 'cb-admin-css', 'rtl', true );
    }
}

add_action( 'ot_admin_styles_after', 'cb_ot_css' );

/*********************
POST BODY FONTS
*********************/
if ( ! function_exists( 'cb_ot_recognized_font_families' ) ) {
    function cb_ot_recognized_font_families() { 
        return array(
              'off'  => 'Use "General Body text font" option',
              '\'Merriweather\', serif;'     => 'Merriweather',
              '\'Open Sans\', sans-serif;'   => 'Open Sans',
              '\'Oswald\', sans-serif;' => 'Oswald',
              'other'  => 'Other Google Font',
            );
    }
}
add_filter( 'ot_recognized_font_families', 'cb_ot_recognized_font_families' );

/*********************
FONT VARIANTS
*********************/
if ( ! function_exists( 'cb_ot_recognized_font_variants' ) ) {
    function cb_ot_recognized_font_variants() { 
        return array(
              'justify'  => 'Justify',
              'left'     => 'Align Left',
              'center'   => 'Align Center',
            );
    }
}
add_filter( 'ot_recognized_font_variants', 'cb_ot_recognized_font_variants' );


/*********************
META FOR FEATURED IMAGE
*********************/
if ( ! function_exists( 'cb_meta_image_head' ) ) {
    function cb_meta_image_head() {

        if ( ( is_single() == true ) && ( ! class_exists( 'WPSEO_Admin' ) ) ) {
            if ( has_post_thumbnail() ) {
                global $post;
                $cb_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                echo '<meta property="og:image" content="' . $cb_featured_image[0] . '">';

            }
        }
    }
}
add_action('wp_head', 'cb_meta_image_head');

/*********************
CHECK IF ON WOOCOMMERCE PAGE
*********************/
if ( ! function_exists( 'cb_woocommerce_check' ) ) {
    function cb_woocommerce_check() {
        if ( ( class_exists('Woocommerce') )  && ( ( is_woocommerce() == true ) || ( is_cart() == true ) || ( is_account_page() == true ) || ( is_order_received_page() == true ) || ( is_checkout() == true ) ) ) {
            return true;
        } else {
            return false;
        }
    }
}
?>