<?php
/*
Template Name: Gameshow Page
*/
?>
<?php get_header();

function get_first_paragraph(): string {
    $str = wpautop(get_the_content());
    return '<p>' . substr($str, 0, strpos($str, '</p>') + 4) . '</p>';
}
?>

<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/gameshow.css");</style>
<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/faqs.css");</style>

<section id='gameshow-banner'>
    <div class='gameshow-banner-container'>
        <div class="gameshow-banner-text">
            <h1>Getting Played</h1>
            <h3>The CFR Gameshow</h3>
            <a href='#about-gameshow'><button>Learn More</button></a>
        </div>
        <div style="height: 100%; width: 100%; position: absolute; overflow: hidden;">
            <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(), 'full' );?>" alt="gameshow-banner-img">
        </div>
    </div>
</section>

<section></section>

<section id="about-gameshow">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 trailer-embed-container">
                <div>
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/old-tv.svg" class="about-gameshow-tv">
                    <iframe width="560" height="315" src="<?php the_field( "video_url" );?>" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6 about-gameshow-container">
                <?php echo get_first_paragraph();?>
            </div>
        </div>
    </div>
</section>

<section id='faqs'>
    <div class="faq-container container-fluid">
        <div class="heading-container">
            <div class='heading-overlay'>frequently asked questions</div>
            <div class='heading-watermark'>faqs</div>
        </div>

        <form id="faq-form">
        </form>

        <div class="row faq-accordion">
            <div class='col-md-6'>
                <?php

                $post = get_page_by_path("gameshow");
                $doc = new DOMDocument();
                $doc->loadHTML(apply_filters('the_content', $post->post_content));
                $doc = new DOMXPath($doc);

                $i = 0;

                $questions = $doc->query("//h3");
                $answers = $doc->query("//p");

                foreach ( $questions as $question ) {
                    if ( $i == intdiv( sizeof( $questions ), 2 ) ) {
                        echo "</div>";
                        echo "<div class='col-md-6'>";
                    } ?>
                    <div class='faq-accordion-item' id='question<?php echo $i?>'>
                        <input type='checkbox' form='faq-form' class='faq-accordion-checkbox' id='faq-checkbox<?php echo $i?>'/>
                        <label class='faq-accordion-btn' for='faq-checkbox<?php echo $i?>'>
                            <p class='faq-accordion-link' href='#question<?php echo $i?>'>
                                <?php echo $question->nodeValue?>
                                <img class="plus-icon" src="<?php echo get_template_directory_uri()?>/assets/images/plus.svg">
                                <img class="minus-icon" src="<?php echo get_template_directory_uri()?>/assets/images/minus.svg">
                            </p>
                            <div class='faq-answer'>
                                <p class='text-justify'>
                                    <?php echo $answers[$i + 1]->nodeValue;?>
                                    <input class='faqs-focusin-input'>
                                </p>
                            </div>
                        </label>
                    </div>
                <?php $i += 1; } ?>
            </div>
        </div>
    </div>
</section>

<?php
wp_reset_query();
$loop = new WP_Query(array('posts_per_page' => -1, 'post_type' => 'cfr_people', 'tax_query' => array(array(
    'taxonomy' => 'cfr_role',
    'field' => 'slug',
    'terms' => get_term_by("name", "Gameshow Guest", "cfr_role")->slug))));

$guests = array();
$episodes = array();
$index = array();

if ($loop->have_posts()) { ?>
    <section id="our-guests" style="padding: 0 5vw;">
        <div class="heading-container">
            <div class='heading-overlay'>our guests!</div>
            <div class='heading-watermark'>experts</div>
        </div>

        <div class="row">
            <?php
            while ( $loop->have_posts() ) : $loop->the_post();
                if ( count( get_the_terms( get_the_ID(), "cfr_role" ) ) == 1 ) {
                    $guests[] = get_the_ID();
                    $episode = get_field( 'episode' );
                    $episodes[] = $episode;

                    $index[] = get_field( "episode_number", $episode );
                }
            endwhile;
            array_multisort( $index, $guests, $episodes );

            global $post;

            $i = 0;
            if ($guests) {
                foreach ( $guests as $guest ) {
                    $post = get_post( $guest );
                    setup_postdata( $guest );?>
                    <div class='col-12 col-sm-6 col-md-4 col-lg-3'>
                        <div>
                            <div class='episode-color' style='background: linear-gradient(to bottom right, <?php the_field( "colour1", $episodes[$i] )?>, <?php the_field( "colour2", $episodes[$i] )?>)'>
                                <div class='guest-pfp'>
                                    <a href="<?php the_permalink();?>">
                                        <img src='<?php the_field('photo')?>' alt='<?php the_title()?>'>
                                    </a>
                                </div>
                            </div>
                            <div class='about-guest'>
                                <div class='guest-name'><a href="<?php the_permalink();?>"><?php the_title()?></a></div>
                                <div class='guest-role'><?php the_field( 'organisation' )?></div>
                                <div class='guest-description'><?php the_field( 'bio' )?></div>
                            </div>

                            <div class='row guest-socials'>
                                <?php
                                foreach (["linkedin", "instagram", "facebook", "website"] as $site) {
                                    $value = get_field( $site );
                                    if ( strlen( $value ) > 0 ) {?>
                                        <div class='col-3'>
                                            <a href='<?php echo $value;?>' target='_blank'>
                                                <img src='<?php echo get_template_directory_uri();?>/assets/images/<?php echo $site?>-icon.svg' alt='' width='35px'>
                                            </a>
                                        </div>
                                    <?php } } ?>
                            </div>
                        </div>
                    </div>
            <?php $i++; } }?>
        </div>
    </section>
<?php }?>

<section id="gameshow-our-sponsors" style="padding: 0 18vw;">
    <div class="heading-container" style="height: 200px">
        <div class='heading-overlay'>our supporters!</div>
    </div>
    <div class="sponsors container">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <a href="https://thepopmovement.org/">
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/collaborators/pop-logo.jpg" alt="">
                </a>
            </div>
            <div class="col-12 col-sm-4 col-lg-3">
                <a href="https://www.ervisfoundation.org/">
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/collaborators/ervis-logo.jpg" alt="">
                </a>
            </div>
            <div class="col-12 col-sm-4 col-lg-3">
                <a href="https://natconference.wordpress.com/">
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/collaborators/natcon-logo.jpg" alt="">
                </a>
            </div>
            <div class="col-12 col-sm-4 col-lg-3">
                <a href="https://www.instagram.com/resilience2020_/">
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/collaborators/resilience2020-logo.jpg" alt="">
                </a>
            </div>
            <div class="col-12 col-sm-8 col-lg-4">
                <a href="https://www.whiskaffair.com/">
                    <img src="<?php echo get_template_directory_uri();?>/assets/images/collaborators/whiskaffair-logo.jpg" alt="">
                </a>
            </div>
        </div>
    </div>
</section>

<div class="instawall-section-container container-fluid">
    <div class="bedrock-container">
        <div>
            <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/instarock.svg">
        </div>
    </div>
</div>

<?php get_footer(); ?>
