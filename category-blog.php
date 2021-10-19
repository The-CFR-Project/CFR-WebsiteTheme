<?php

/*
Template Name: Blog
*/
?>

<?php get_header();?>

<?php
global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users", OBJECT );
foreach ($results as $result) {
  print_r($result);
}
?>

<?php get_template_part( "includes/blogs-archive/section", "blogs-carousel" );?>
<?php get_template_part( "includes/blogs-archive/section", "archive" );?>
<?php get_template_part( "includes/blogs-archive/section", "blog-series-archive" );?>

<?php get_footer();?>
