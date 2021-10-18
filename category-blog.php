<?php

/*
Template Name: Blog
*/
?>

<?php get_header();?>

<?php get_template_part( "includes/blogs-archive/section", "blogs-carousel" );?>
<?php get_template_part( "includes/blogs-archive/section", "archive" );?>
<?php get_template_part( "includes/blogs-archive/section", "blog-series-archive" );?>

<?php get_footer();?>
