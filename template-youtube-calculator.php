<?php
/*
Template Name: Youtube Calculator
*/
?>

<?php get_header(); ?>

<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/css/AVCharts.css"); </style>
<script src="<?php echo get_template_directory_uri(); ?>/js/AVCharts.js"></script>
<?php get_template_part("includes/section", "about-youtube-calculator"); ?>
<?php get_template_part("includes/section", "youtube-calculator-video-search"); ?>
<?php get_template_part("includes/section", "youtube-calculator-post"); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/youtube-calculator.js"></script>

<?php get_footer(); ?>


