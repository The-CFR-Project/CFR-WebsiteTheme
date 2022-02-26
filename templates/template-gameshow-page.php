<?php
/*
Template Name: Gameshow Page
*/
?>
<?php get_header(); ?>

<?php get_template_part( "template-parts/gameshow-page/section", "about-gameshow" );?>
<?php get_template_part( "template-parts/gameshow-page/section", "gameshow-faqs" );?>
<?php get_template_part( "template-parts/gameshow-page/section", "gameshow-prizes" );?>
<?php get_template_part( "template-parts/gameshow-page/section", "gameshow-our-guests" );?>
<section></section>
<?php get_template_part( "template-parts/gameshow-page/section", "gameshow-our-sponsors" );?>
<section></section>
<?php get_template_part( "template-parts/contact-us/section", "contact-us" );?>
<?php get_template_part( "template-parts/home-page/section", "instawall" );?>

<?php get_footer(); ?>
