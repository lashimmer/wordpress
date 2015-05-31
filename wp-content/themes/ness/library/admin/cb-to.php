<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet */
  if ( ! function_exists( 'ot_settings_id' ) )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  $cb_docs_url = 'http://docs.cubellthemes.com/ness/';
  $cb_support_url = 'http://support.cubellthemes.com';
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'ot_general',
        'title'       => 'General'
      ),
      array(
        'id'          => 'cb_homepage',
        'title'       => 'Homepage'
      ),
      array(
        'id'          => 'cb_menus',
        'title'       => 'Menu'
      ),
      array(
        'id'          => 'cb_post_settings',
        'title'       => 'Posts'
      ),
      array(
        'id'          => 'ot_typography',
        'title'       => 'Typography'
      ),
      array(
        'id'          => 'ot_footer',
        'title'       => 'Footer'
      ),
      array(
        'id'          => 'ot_custom_code',
        'title'       => 'Custom Code'
      ),
      array(
        'id'          => 'cb_misc',
        'title'       => 'Misc.'
      ),
      array(
        'id'          => 'cb_help',
        'title'       => 'Theme Help'
      ),
    ),
    'settings'        => array( 
      array(
        'id'          => 'cb_logo_url',
        'label'       => 'Logo',
        'desc'        => 'Upload your logo. This logo appears on top of homepage slider, category/archive/author/etc cover images and post featured images. Logo that appears in sticky menu is set in "Theme Options -> Menus" section. (Recommended size: 130px x 30px).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_logo_url_retina',
        'label'       => 'Retina Logo',
         'desc'        => 'If you have created one, upload the Retina version of your logo (double size of normal logo).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_favicon_url',
        'label'       => 'Favicon',
        'desc'        => 'Upload your favicon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_lightbox_onoff',
        'label'       => 'Lightbox',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_responsive_onoff',
        'label'       => 'Responsive Theme',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_blog_style',
        'label'       => 'Homepage Post Layout',
        'desc'        => '',
        'std'         => 'excerpt1',
        'type'        => 'radio-image',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'One Post Per Line',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'excerpt1',
            'label'       => 'One Post Per Line With Excerpt',
            'src'         => '/blog_style_excerpt_a.png'
          ),
          array(
            'value'       => '2',
            'label'       => 'Two Posts Per Line',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => '3',
            'label'       => 'Three Posts Per Line',
            'src'         => '/blog_style_c.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_hp_infinite',
        'label'       => 'Pagination Style',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'infinite-load',
            'label'       => 'Infinite Scroll With Load More Button',
            'src'         => ''
          ),
          array(
            'value'       => 'infinite-scroll',
            'label'       => 'Infinite Scroll',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Number Pagination',
            'src'         => ''
          ),
        ),
      ),
      array(
        'id'          => 'cb_hp_slider',
        'label'       => 'Homepage Full-Screen Slider',
        'desc'        => 'Show a full-screen slider on the homepage',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_hp_slider_count',
        'label'       => 'Number of posts',
        'desc'        => 'Number of posts to appear in the slider',
        'std'         => '6',
        'type'        => 'numeric-slider',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '2,20,1',
        'class'       => 'cb-sub',
        'condition'   => 'cb_hp_slider:is(on)',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'cb_hp_slider_filter',
        'label'       => 'Posts in slider',
        'desc'        => 'What posts to show in the slider',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_hp_slider:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'latest',
            'label'       => 'Latest published',
            'src'         => ''
          ),
          array(
            'value'       => 'cat',
            'label'       => 'By Categories',
            'src'         => ''
          ),
          array(
            'value'       => 'tags',
            'label'       => 'By Tags',
            'src'         => ''
          ),
        )
      ),
      array(
        'id'          => 'cb_hp_slider_offset',
        'label'       => 'Homepage Slider Offset',
        'desc'        => 'If enabled, the slider will show posts 1-6, and the posts below the slider will show from post 7-end, this way no duplicates.',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_hp_slider_filter:is(latest),cb_hp_slider:is(on)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_hp_slider_cat',
        'label'       => 'Homepage Slider Category',
        'desc'        => '',
        'std'         => '',
        'type'        => 'category-checkbox',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_hp_slider_filter:is(cat),cb_hp_slider:is(on)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'tags_cb',
        'label'       => 'Tag Filter',
        'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_hp_slider_filter:is(tags),cb_hp_slider:is(on)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_homepage_cover',
        'label'       => 'Homepage Cover Image',
        'desc'        => 'Upload an image to set as the homepage cover image.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'cb_hp_slider:is(off)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_hp_ad_below',
        'label'       => 'Advertisement above posts list',
        'desc'        => 'Show an advertising block above the posts list (blog style) on your homepage.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'cb_menu_type',
        'label'       => 'Type of Menu',
        'desc'        => '',
        'std'         => 'cb-slide',
        'type'        => 'radio-image',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'cb-slide',
            'label'       => 'Slide-In',
            'src'         => '/cb-slide.png'
          ),
          array(
            'value'       => 'cb-standard',
            'label'       => 'Regular',
            'src'         => '/cb-regular.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_search_in_menu',
        'label'       => 'Show Search In Menu',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_sticky_nav',
        'label'       => 'Sticky Main Menu',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_menu_style',
        'label'       => 'Sticky Navigation Bar Style',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sticky_nav:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
           array(
            'value'       => 'cb-light',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
         
        )
      ),
      array(
        'id'          => 'cb_sticky_menu_logo',
        'label'       => 'Sticky Menu Logo',
        'desc'        => 'Logo to be used in sticky menu (Recommended size: 100px x 20px)',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sticky_nav:is(on)',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'cb_sticky_menu_logo_retina',
        'label'       => 'Sticky Menu Logo Retina',
         'desc'        => 'If you have created one, upload the Retina version of your logo (double size of normal logo).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sticky_nav:is(on)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_previous_next_onoff',
        'label'       => 'Show Next/Previous in sticky menu after scrolling',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sticky_nav:is(on),cb_menu_type:is(cb-slide)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_progress_bar_onoff',
        'label'       => 'Show percentage of progress when reading a post',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sticky_nav:is(on),cb_menu_type:is(cb-slide)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_sidebar_posts',
        'label'       => 'Show posts in sidebar menu',
        'desc'        => 'If using the regular menu, this only applies to mobile devices',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
      ),
      array(
        'id'          => 'cb_sidebar_posts_title',
        'label'       => 'Title above posts',
        'desc'        => 'The title to appear above the posts in the slide-in menu',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'cb_menus',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sidebar_posts:is(on)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_sidebar_posts_filter',
        'label'       => 'What posts to show',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sidebar_posts:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'rand',
            'label'       => 'Random',
          ),
          array(
            'value'       => 'meta_value_num',
            'label'       => 'Most Popular',
          ),
          array(
            'value'       => 'date',
            'label'       => 'Latest Published',
          )
        )
      ),
      array(
            'id'          => 'cb_sidebar_posts_number',
            'label'       => 'Number Of Posts To Show',
            'desc'        => 'How many posts to show in slide-in menu',
            'std'         => '2',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'section'     => 'cb_menus',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
           'condition'   => 'cb_sidebar_posts:is(on)',
            'class'       => 'cb-sub'
      ),
      array(
        'id'          => 'cb_sidebar_posts_likes',
        'label'       => 'Overlay Like Count',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sidebar_posts:is(on)',
        'operator'    => 'and',
      ),
      array(
        'id'          => 'cb_like_article',
        'label'       => 'Post Like System',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_like_symbol',
        'label'       => 'Like Symbol',
        'desc'        => '',
        'std'         => 'cb-heart',
        'type'        => 'radio-image',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_like_article:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'cb-heart',
            'label'       => 'Heart',
            'src'         => '/cb-heart.png'
          ),
          array(
            'value'       => 'cb-bolt',
            'label'       => 'Bolt',
            'src'         => '/cb-bolt.png'
          ),
          array(
            'value'       => 'cb-star',
            'label'       => 'Star',
            'src'         => '/cb-star.png'
          )
        )
      ),
      array(
        'id'          => 'cb_meta_onoff',
        'label'       => 'By Line',
        'desc'        => 'Show "Written by Author - Date - Category"',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',

      ),
      array(
        'id'          => 'cb_byline_author',
        'label'       => 'By Line: Show Author',
        'desc'        => 'Show "Written by Author" text',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_meta_onoff:not(off)',
      ),
      array(
        'id'          => 'cb_byline_author_prefix',
        'label'       => 'By Line: Author Prefix',
        'desc'        => 'Text to appear before author name',
        'std'         => 'Written by',
        'type'        => 'text',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_meta_onoff:not(off),cb_byline_author:not(off)',
      ),
      array(
        'id'          => 'cb_byline_date',
        'label'       => 'By Line: Show Date',
        'desc'        => 'Show date',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_meta_onoff:not(off)',
      ),
      array(
        'id'          => 'cb_byline_category',
        'label'       => 'By Line: Show Categories',
        'desc'        => 'Show category(s)',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_post_style_override_onoff',
        'label'       => 'Global Featured Image Style Override',
        'desc'        => 'Make all posts use a specific featured image stlye, however, each post has an option to ignore this override if desired.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
      ),
      array(
        'id'          => 'cb_post_style_override',
        'label'       => 'Global Featured Image Style',
        'desc'        => '',
        'std'         => 'full-background',
        'type'        => 'radio-image',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_post_style_override_onoff:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
           array(
              'value'       => 'full-background',
              'label'       => 'Full-Background',
              'src'         => '/img_fs.png'
              ),
           array(
              'value'       => 'parallax',
              'label'       => 'Parallax',
              'src'         => '/img_pa.png'
              ),
              array(
              'value'       => 'off',
              'label'       => 'Off',
              'src'         => '/img_off.png'
              ),
        )
      ),
      array(
        'id'          => 'cb_social_sharing',
        'label'       => 'Social Sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_comments_onoff',
        'label'       => 'Comments',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_related_onoff',
        'label'       => 'Show related posts',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
            'id'          => 'cb_related_posts_amount',
            'label'       => 'Number Of Related Posts To Show',
            'desc'        => 'How many related posts to show at the end of a post',
            'std'         => '2',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'section'     => 'cb_post_settings',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,9,1',
            'condition'   => 'cb_related_onoff:not(off)',
            'class'       => 'cb-sub'
      ),
      array(
        'id'          => 'cb_related_posts_style',
        'label'       => 'Related Post Layout',
        'desc'        => '',
        'std'         => '2',
        'type'        => 'radio-image',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(off)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'One Post Per Line',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'excerpt1',
            'label'       => 'One Post Per Line With Excerpt',
            'src'         => '/blog_style_excerpt_a.png'
          ),
          array(
            'value'       => '2',
            'label'       => 'Two Posts Per Line',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => '3',
            'label'       => 'Three Posts Per Line',
            'src'         => '/blog_style_c.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_related_posts_show',
        'label'       => 'Where to look for related posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(off)',
        'choices'     => array(
          array(
            'value'       => 'both',
            'label'       => 'Related by tags and if no posts found, show related by category',
            'src'         => ''
          ),
          array(
            'value'       => 'tags',
            'label'       => 'Only related by tags',
            'src'         => ''
          ),
          array(
            'value'       => 'cats',
            'label'       => 'Only related by category',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_related_posts_order',
        'label'       => 'Related Posts Order',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(off)',
        'choices'     => array(
          array(
            'value'       => 'rand',
            'label'       => 'Random',
            'src'         => ''
          ),
          array(
            'value'       => 'date',
            'label'       => 'Date (Latest Published)',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_posts_ad_below',
        'label'       => 'Advertisement after post content',
        'desc'        => 'Show an 768x90 advertising block after post content.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_links_color',
        'label'       => 'Links Color',
        'desc'        => 'Set a color for text links inside the post content area, text widgets, etc',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_body_font',
        'label'       => 'General body text font',
        'desc'        => 'Select the font to be used for general body text. Demo uses Raleway.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '\'Raleway\', sans-serif;',
            'label'       => 'Raleway',
            'src'         => ''
          ),
          array(
            'value'       => '\'Open Sans\', sans-serif;',
            'label'       => 'Open Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'Montserrat\', sans-serif;',
            'label'       => 'Montserrat',
            'src'         => ''
          ),
          array(
            'value'       => '\'Droid Sans\', sans-serif;',
            'label'       => 'Droid Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'PT Serif\', serif;',
            'label'       => 'PT Serif',
            'src'         => ''
          ),
          array(
            'value'       => '\'PT Sans\', sans-serif;',
            'label'       => 'PT Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'Vollkorn\', serif;',
            'label'       => 'Vollkorn',
            'src'         => ''
          ),
          array(
            'value'       => 'other',
            'label'       => 'Other Google Font',
            'src'         => ''
          )
        )
      ),      
    array(
        'id'          => 'cb_user_body_font',
        'label'       => 'Other Google Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts. Example of code that should be entered: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_body_font:is(other)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_body_text_style',
        'label'       => 'Post Body Text Style',
        'desc'        => 'Set a specific color/font/style/etc for the post content text (the actual article). All options are optional. Demo uses Merriweather font-family, 0.05em letter-spacing and Justify text-align.',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
    array(
        'id'          => 'cb_user_post_font',
        'label'       => 'Other Google Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts. Example of code that should be entered: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => '',
        'operator'    => 'and'
      ),
    array(
        'id'          => 'cb_header_font',
        'label'       => 'Font for Headings',
        'desc'        => 'Select the font of Headings (h1, h2, h3, h4, h5) and other important titles. Demo uses Raleway.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '\'Raleway\', sans-serif;',
            'label'       => 'Raleway',
            'src'         => ''
          ),
          array(
            'value'       => '\'Josefin Slab\', serif;',
            'label'       => 'Josefin Slab',
            'src'         => ''
          ),
          array(
            'value'       => '\'Lato\', sans-serif;',
            'label'       => 'Lato',
            'src'         => ''
          ),
          array(
            'value'       => '\'Arvo\', serif;',
            'label'       => 'Arvo',
            'src'         => ''
          ),
          array(
            'value'       => '\'Open Sans\', sans-serif;',
            'label'       => 'Open Sans',
            'src'         => ''
          ),
          array(
            'value'       => '\'Oswald\', sans-serif;',
            'label'       => 'Oswald',
            'src'         => ''
          ),
          array(
            'value'       => '\'Montserrat\', sans-serif;',
            'label'       => 'Montserrat',
            'src'         => ''
          ),
          array(
            'value'       => 'other',
            'label'       => 'Other Google Font',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'cb_user_header_font',
        'label'       => 'Other Google Font',
        'desc'        => 'Enter any Google Font Code from http://www.google.com/fonts for Headings. Example of code that should be entered: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_header_font:is(other)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_font_ext_lat',
        'label'       => 'Load Latin Extended Charset',
        'desc'        => 'Some languages use special characters that require extra charsets of the font to be loaded. Enable this to also load the Latin Extended character font set.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
      ),
      array(
        'id'          => 'cb_font_cyr',
        'label'       => 'Load Cyrillic Extended Charset',
        'desc'        => 'Some languages use special characters that require extra charsets of the font to be loaded. Enable this to also load the Cyrillic Extended character font set.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
      ),
        array(
        'id'          => 'cb_footer_layout',
        'label'       => 'Footer Layout',
        'desc'        => '',
        'std'         => 'cb-footer-2',
        'type'        => 'radio-image',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'cb-footer-1',
            'label'       => 'Layout 1',
            'src'         => '/footer_style_a.png'
          ),
          array(
            'value'       => 'cb-footer-2',
            'label'       => 'Layout 2',
            'src'         => '/footer_style_b.png'
          ),
          array(
            'value'       => 'cb-footer-3',
            'label'       => 'Layout 3',
            'src'         => '/footer_style_c.png',
          )
        )
      ),
      array(
        'id'          => 'cb_footer_lower_bg',
        'label'       => 'Footer Background Image/Color',
        'desc'        => 'Set a background image and/or color. If there is an image and color set, then the color will overlay the image and be semi-transparent.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'cb_to_top',
        'label'       => 'To Top Button',
        'desc'        => 'The top button appears just above the copyright line',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'cb_footer_copyright',
        'label'       => 'Footer Copyright Text',
        'desc'        => 'Appears at the end of the footer',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_footer',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'No need to hard-edit style.css anymore. All your CSS modifications can be done here so you do not lose them in future theme updates. (It is still recommended to save a backup of this custom CSS to a separate .txt file)',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'ot_custom_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_custom_head',
        'label'       => 'Code For  Head section',
        'desc'        => 'No need to hard-edit files anymore to add custom Javascript/code to your head. Code in this box will appear before the closing head tag.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_custom_footer',
        'label'       => 'Code For Footer section',
        'desc'        => 'No need to hard-edit files anymore to add custom Javascript/code to your footer. Code in this box will appear right before the closing body tag.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_cpt',
        'label'       => 'Custom Post Types',
        'desc'        => 'If you have "custom post types" and want to have Ness Post Options metabox appear in them, enter the names here (Separated by comma, example: books, movies)',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'cb_misc',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_misc_tag_pl',
        'label'       => 'Tags Pages Post Layout',
        'desc'        => '',
        'std'         => '2',
        'type'        => 'radio-image',
        'section'     => 'cb_misc',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'One Post Per Line',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'excerpt1',
            'label'       => 'One Post Per Line With Excerpt',
            'src'         => '/blog_style_excerpt_a.png'
          ),
          array(
            'value'       => '2',
            'label'       => 'Two Posts Per Line',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => '3',
            'label'       => 'Three Posts Per Line',
            'src'         => '/blog_style_c.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_misc_search_pl',
        'label'       => 'Search Results Pages Post Layout',
        'desc'        => '',
        'std'         => 'excerpt1',
        'type'        => 'radio-image',
        'section'     => 'cb_misc',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'One Post Per Line',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'excerpt1',
            'label'       => 'One Post Per Line With Excerpt',
            'src'         => '/blog_style_excerpt_a.png'
          ),
          array(
            'value'       => '2',
            'label'       => 'Two Posts Per Line',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => '3',
            'label'       => 'Three Posts Per Line',
            'src'         => '/blog_style_c.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_search_cover',
        'label'       => 'Search Pages Cover Image',
        'desc'        => 'Upload an image to set as the search pages cover image.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_misc',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_misc_archives_pl',
        'label'       => 'Archives Post Layout',
        'desc'        => '',
        'std'         => 'excerpt1',
        'type'        => 'radio-image',
        'section'     => 'cb_misc',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'One Post Per Line',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'excerpt1',
            'label'       => 'One Post Per Line With Excerpt',
            'src'         => '/blog_style_excerpt_a.png'
          ),
          array(
            'value'       => '2',
            'label'       => 'Two Posts Per Line',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => '3',
            'label'       => 'Three Posts Per Line',
            'src'         => '/blog_style_c.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_misc_author_pl',
        'label'       => 'Author Archives Post Layout',
        'desc'        => '',
        'std'         => '2',
        'type'        => 'radio-image',
        'section'     => 'cb_misc',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'One Post Per Line',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'excerpt1',
            'label'       => 'One Post Per Line With Excerpt',
            'src'         => '/blog_style_excerpt_a.png'
          ),
          array(
            'value'       => '2',
            'label'       => 'Two Posts Per Line',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => '3',
            'label'       => 'Three Posts Per Line',
            'src'         => '/blog_style_c.png'
          ),
        )
      ),
       array(
        'id'          => 'cb_help_title',
        'label'       => 'Having trouble setting up Ness?',
        'desc'        => 'Ness comes with extensive documentation that covers almost every aspect of the theme, therefore, most answers can be found there. The documentation can also be read online, <a href="' .  esc_url( $cb_docs_url ) . '" target="_new">click here to see it</a>. If an answer for your issue is not there try these steps:<ol><li>Disable all your plugins to see if the issues persists.</li><li>Check if you are using the latest version of the theme (Documentation has instructions on how to update theme)</li><li>Check the comments section of the theme in Themeforest, other users may have asked the same question already</li></ol> If none of that helps, you can submit a ticket in the support system for quickest response. Make your ticket as short as possible and include screenshots/urls if possible to make it easy to understand and get a fast response. <a href="' . esc_url( $cb_support_url ) . '" target="_new">Click here</a> to visit the support system',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'cb_help',
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
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}