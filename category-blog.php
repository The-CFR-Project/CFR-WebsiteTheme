<?php

/*
Template Name: Blog
*/
?>

<?php get_header();?>

<?php
// global $wpdb;
// $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users", OBJECT );
// foreach ($results as $result) {
//   print_r($result->display_name);
// }
?>

<?php get_template_part( "template-parts/blogs-archive/section", "blogs-carousel" );?>
<?php get_template_part( "template-parts/blogs-archive/section", "archive" );?>
<?php get_template_part( "template-parts/section", "instawall" );?>

<?php get_footer();?>
