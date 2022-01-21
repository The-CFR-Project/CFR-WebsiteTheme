<?php
/*
Template Name: Youtube Calculator
*/
?>

<?php get_header(); ?>

<!-- CSS -->
<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/css/AVCharts.css"); </style>
<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/css/omni-slider.css"); </style>

<!-- Wordpress Includes -->
<?php get_template_part("includes/section", "about-youtube-calculator"); ?>
<?php get_template_part("includes/section", "youtube-calculator-video-search"); ?>
<?php get_template_part("includes/section", "youtube-calculator-post"); ?>

<!-- JavaScript -->
<script src="<?php echo get_template_directory_uri() ?>/js/omni-slider.min.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/AVCharts.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/youtubeCalculator.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/d3.v4.min.js"></script>

<?php get_footer(); ?>
