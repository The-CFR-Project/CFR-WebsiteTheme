<?php

/*
Template Name: About Us
*/
?>

<?php get_header();?>

<section></section>
<?php get_template_part( "template-parts/about-cfr/section", "about-cfr" );?>
<?php get_template_part( "template-parts/about-cfr/section", "meet-the-team" );?>
<section></section>
<?php get_template_part( "template-parts/about-cfr/section", "cfr-metrics" );?>
<?php get_template_part( "template-parts/home-page/section", "cards" );?>
<?php get_template_part( "template-parts/about-cfr/section", "our-story" );?>
<section></section>
<?php get_template_part( "template-parts/home-page/section", "faqs" );?>
<?php get_template_part( "template-parts/home-page/section", "instawall" );?>

<?php get_footer();?>
