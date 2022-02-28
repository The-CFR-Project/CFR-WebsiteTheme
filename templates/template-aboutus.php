<?php

/*
Template Name: About Us
*/
?>

<?php get_header();?>

<section></section>
<?php get_template_part( "template-parts/about-cfr/section", "about-cfr" );?>

<section id="meet-the-team">
    <?php
    wp_reset_query();
    $loop = new WP_Query(array('posts_per_page'   => -1, 'post_type' => 'cfr_people', 'tax_query' => array( array(
            'taxonomy' => 'cfr_role',
            'field' => 'slug',
            'terms' => get_term_by( "name", "CFR Member", "cfr_role" )->slug ) ) ) );
    $members = array();
    $role_priority = array();

    if($loop->have_posts()) {
        while($loop->have_posts()) : $loop->the_post();
            $members[] = get_the_ID();

            $role = get_field('position');
            if ( $role == "CFR Lead" ) {
                $role_priority[] = 0;}
            else if ( $role == "CFR Co-Lead" ) {
                $role_priority[] = 1;}
            else if ( $role == "CFR Core Member" ) {
                $role_priority[] = 2;}
            else if ( $role == "CFR Member" ) {
                $role_priority[] = 3;}
            else {
                throw new Exception($role);}

        endwhile;
        array_multisort($role_priority, $members);
        $offset = 0;
        ?>
        <style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/aboutus-css/meettheteam.css");</style>
        <div class="meet-the-team-container container">
            <div class="heading-container">
                <div class='heading-overlay'>meet our team!</div>
            </div>

            <div class="row large-row justify-content-evenly">
                <?php
                for ($i = 0; $i < (array_count_values($role_priority)[0] ?? 0) + (array_count_values($role_priority)[1] ?? 0); $i++) {?>
                    <div class="col-md-4">
                        <a href="<?php echo get_permalink( $members[$i + $offset] )?>">
                            <div class="dp-container">
                                <img class="dp" src="<?php the_field( "photo", $members[$i + $offset] );?>">
                            </div>
                            <div class="title-container">
                                <h6><?php echo get_the_title( $members[$i + $offset] );?></h6>
                                <p><?php the_field( "position", $members[$i + $offset] );?></p>
                            </div>
                        </a>
                    </div>
                <?php }
                $offset += $i;
                ?>
            </div>
            <div class="row medium-row justify-content-evenly">
                <?php
                for ($i = 0; $i < (array_count_values($role_priority)[2] ?? 0); $i++) {?>
                    <div class="col-6 col-md-3">
                        <a href="<?php echo get_permalink( $members[$i + $offset] )?>">
                            <div class="dp-container">
                                <img class="dp" src="<?php the_field( "photo", $members[$i + $offset] );?>">
                            </div>
                            <div class="title-container">
                                <h6><?php echo get_the_title( $members[$i + $offset] );?></h6>
                                <p><?php the_field( "position", $members[$i + $offset] );?></p>
                            </div>
                        </a>
                    </div>
                <?php }
                $offset += $i;
                ?>
            </div>

            <div class="row small-row justify-content-evenly">
                <?php
                for ($i = 0; $i < (array_count_values($role_priority)[3] ?? 0); $i++) {?>
                    <div class="col-6 col-sm-4 col-md-2">
                        <a href="<?php echo get_permalink( $members[$i + $offset] )?>">
                            <div class="dp-container">
                                <img class="dp" src="<?php the_field( "photo", $members[$i + $offset] );?>">
                            </div>
                            <div class="title-container">
                                <h6><?php echo explode(' ', get_the_title( $members[$i + $offset] ) )[0];?></h6>
                                <p><?php the_field( "position", $members[$i + $offset] );?></p>
                            </div>
                        </a>
                    </div>
                <?php }
                $offset += $i;
                ?>
            </div>
        </div>
    <?php } ?>
</section>

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
