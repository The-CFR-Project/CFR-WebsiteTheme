<?php

// Load stylesheets
function load_css() {
  wp_register_style( "bootstrap", get_template_directory_uri() . "/css/bootstrap.min.css", array(), false, "all" );
  wp_enqueue_style( "bootstrap" );

  wp_register_style( "main", get_template_directory_uri() . "/css/main.css", array(), false, "all" );
  wp_enqueue_style( "main" );
  wp_register_style( "mobile", get_template_directory_uri() . "/css/mobile.css", array(), false, "all" );
  wp_enqueue_style("mobile");
}

// Load Javascript
function load_js() {
  wp_enqueue_script( "jquery" );

  wp_register_script( "bootstrap", get_template_directory_uri() . "/js/bootstrap.min.js", "jquery", false, true );
  wp_enqueue_script( "bootstrap" );

  wp_register_script( "planetary", get_template_directory_uri() . "/js/planetaryjs.js", array(), false, true );
  wp_enqueue_script( "planetary" );
}

add_action( "wp_enqueue_scripts", "load_css" );
add_action( "wp_enqueue_scripts", "load_js" );


// Theme Options
add_theme_support( "menus" );
add_theme_support( "post-thumbnails" );
add_theme_support( "widgets" );


// Filters
add_filter( 'excerpt_length', 'your_prefix_excerpt_length' );
function your_prefix_excerpt_length() {
    return 25;
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
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments')
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