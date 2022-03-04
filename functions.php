<?php

// Load stylesheets
function load_css() {
  wp_register_style( "bootstrap", get_template_directory_uri() . "/assets/css/bootstrap.min.css", array(), false, "all" );
  wp_enqueue_style( "bootstrap" );

  wp_register_style( "main", get_template_directory_uri() . "/assets/css/main.css", array(), false, "all" );
  wp_enqueue_style( "main" );
  wp_register_style( "mobile", get_template_directory_uri() . "/assets/css/mobile.css", array(), false, "all" );
  wp_enqueue_style("mobile");
}

// Load Javascript
function load_js() {
  wp_enqueue_script( "jquery" );

  wp_register_script( "bootstrap", get_template_directory_uri() . "/assets/js/bootstrap.min.js", "jquery", false, true );
  wp_enqueue_script( "bootstrap" );

  wp_register_script( "planetary", get_template_directory_uri() . "/assets/js/planetaryjs.js", array(), false, true );
  wp_enqueue_script( "planetary" );
}

add_action( "wp_enqueue_scripts", "load_css" );
add_action( "wp_enqueue_scripts", "load_js" );


// Theme Options
add_theme_support( "menus" );
add_theme_support( "post-thumbnails" );
add_theme_support( "widgets" );
add_theme_support( "html5", array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption') );


// Filters
add_filter( 'excerpt_length', 'your_prefix_excerpt_length' );
function your_prefix_excerpt_length() {
    return 25;
}
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
   return '...';  // add your string or symbol you want here...
}

// Menus
register_nav_menus(
  array(
      "nav-bar" => "Navigation Bar Location",
      "home-banner" => "Home Banner Location",
      "footer" => "Footer Location",
      "footer-social" => "Footer Socials Location"
  )
);

// Register Sidebars
function my_sidebars() {
  register_sidebar(
    array (
      'name' => 'General Sidebar',
      'id' => 'general-sidebar',
      'before-title' => '<h4 class="sidebar-title">',
      'after-title' => '</h4>',   
    )
  );
  register_sidebar(
    array (
      'name' => 'Blog Single Sidebar',
      'id' => 'blog-single-sidebar',
      'before-title' => '<h4 class="sidebar-title">',
      'after-title' => '</h4>',   
    )
  );
  register_sidebar(
    array (
      'name' => 'Blog Series Sidebar',
      'id' => 'blog-series-sidebar',
      'before-title' => '<h4 class="sidebar-title">',
      'after-title' => '</h4>',   
    )
  );
}
add_action('widgets_init', 'my_sidebars');

// Logos

add_theme_support( 'custom-logo', array(
	'height'      => 171,
	'width'       => 183,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );


// Custom Post Types
function blogs_series_post_type(){ //Custom Post
  $args = array(
    'labels' => array (
      'name' => 'Blog Series',
      'singular_name' => 'Blog Series',
    ),
    'hierarchical' => false,
    'menu-icon' => 'dashicons-images-alt2',
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments'),
    'exclude_from_search'   => false,
  );
  register_post_type('blog_series', $args);
}
add_action('init', 'blogs_series_post_type');

function people_post_type(){ //Custom Post
    $args = array(
        'labels' => array (
            'name' => 'People',
            'singular_name' => 'Person',
        ),
        'hierarchical' => false,
        'menu-icon' => 'dashicons-images-alt2',
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments'),
        'exclude_from_search'   => false,
    );
    register_post_type('blog_series', $args);
}
add_action('init', 'blogs_series_post_type');

function blogs_series_title(){ //Custom Category 
  $args = array(
    'labels' => array(
      'name' => 'Series Title',
      'singular_name' => 'Series Title',
    ),
    'public' => true,
    'hierarchical' => true,
  );
  register_taxonomy('series_name', array('blog_series'), $args);
}
add_action('init', 'blogs_series_title');


/**
 * Register the custom CFR post types
 */
function register_cfr_post_types() {
    register_post_type( 'cfr_people', [
        'labels' => array('name' => __('CFR People', 'textdomain'), 'singular_name' => __('CFR Person', 'textdomain') ),
        'description' => 'Individuals associated with the CFR Project',
        'public' => true,
        'menu_icon' => 'dashicons-groups',
        'rewrite' => array( 'slug' => 'people' ),
        'supports' => array( 'title', 'editor', 'custom-fields', 'author' ),
        'taxonomies' => array( 'cfr_role' )
    ] );

    register_post_type( 'cfr_events', [
        'labels' => array('name' => __('CFR Events', 'textdomain'), 'singular_name' => __('CFR Event', 'textdomain') ),
        'description' => 'Events planned by the CFR Project',
        'public' => true,
        'menu_icon' => 'dashicons-calendar',
        'rewrite' => array( 'slug' => 'events' ),
        'supports' => array( 'title', 'editor', 'custom-fields', 'author' ),
        'taxonomies' => array( 'cfr_event_type' )
    ] );

    register_post_type( 'cfr_sponsors', [
        'labels' => array('name' => __('CFR Sponsors', 'textdomain'), 'singular_name' => __('CFR Sponsor', 'textdomain') ),
        'description' => 'Organisations that Sponsor the Project',
        'public' => true,
        'menu_icon' => 'dashicons-calendar',
        'rewrite' => array( 'slug' => 'sponsors' ),
        'supports' => array( 'title', 'editor', 'custom-fields', 'author' )
    ] );
}

function register_cfr_taxonomies() {
    register_taxonomy("cfr_role", "cfr_people", array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'CFR Role', 'taxonomy general name' ),
            'singular_name' => _x( 'CFR Role', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Roles' ),
            'all_items' => __( 'All Roles' ),
            'parent_item' => __( 'Parent Role' ),
            'parent_item_colon' => __( 'Parent Role:' ),
            'edit_item' => __( 'Edit Role' ),
            'update_item' => __( 'Update Role' ),
            'add_new_item' => __( 'Add New Role' ),
            'new_item_name' => __( 'New Role Name' ),
            'menu_name' => __( 'CFR Roles' )
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'roles',
            'with_front' => false,
            'hierarchical' => true
        ),));

    register_taxonomy("cfr_event_type", "cfr_events", array(
        'hierarchical' => false,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'CFR Event', 'taxonomy general name' ),
            'singular_name' => _x( 'CFR Event', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Events' ),
            'all_items' => __( 'All Events' ),
            'edit_item' => __( 'Edit Event' ),
            'update_item' => __( 'Update Event' ),
            'add_new_item' => __( 'Add New Event' ),
            'new_item_name' => __( 'New Event Name' ),
            'menu_name' => __( 'CFR Events' )
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'events',
            'with_front' => false,
        ),));
}

add_action( 'init', 'register_cfr_post_types', 0 );
add_action( 'init', 'register_cfr_taxonomies', 0 );


/**
 * This function modifies the main WordPress query to include an array of 
 * post types instead of the default 'post' post type.
 *
 * @param object $query The main WordPress query.
 */
function tg_include_custom_post_types_in_search_results( $query ) {
  if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
      $query->set( 'post_type', array( 'post', 'blog_series' ) );
  }
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_search_results' );
