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
<?php get_template_part( "template-parts/about-cfr/section", "aboutus-cards" );?>
<?php get_template_part( "template-parts/about-cfr/section", "our-story" );?>
<section></section>
<?php get_template_part( "template-parts/home-page/section", "faqs" );?>

<!-- Bedrock Image -->
<div class="instawall-section-container container-fluid">
    <div class="bedrock-container">
        <div>
            <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/instarock.svg">
        </div>
    </div>
</div>    

<?php get_footer();?>
