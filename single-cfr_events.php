<?php get_header();?>

<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/single-episode.css");</style>

<section></section>
<section id="episode-banner" style="background-color: <?php the_field( "colour1" );?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2" style="background-color: <?php the_field( "colour2" );?>">
                <div class="cross-container">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
                <div class="cross-container cross-container-n">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
                <div class="cross-container cross-container-n">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
                <div class="cross-container cross-container-n">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
            </div>

            <div class="col-sm-8">
                <h2>The one with</h2>
                <h1>Magic</h1>
                <h3>Welcome to Platform 9¾</h3>
            </div>

            <div class="col-sm-2" style="background-color: <?php the_field( "colour2" );?>">
                <div class="cross-container">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
                <div class="cross-container cross-container-n">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
                <div class="cross-container cross-container-n">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
                <div class="cross-container cross-container-n">✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖✖</div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="heading-container">
        <div class='heading-overlay'>gameshow episode</div>
        <div class='heading-watermark'>EPISODE</div>
    </div>
</section>

<?php get_footer();?>
