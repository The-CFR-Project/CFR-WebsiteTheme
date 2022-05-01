<?php

/*
Template Name: CFR Links
*/
?>

<?php get_header();?>

<?php //get_template_part( "template-parts/cfr-socials/section", "cfr-zoom" );?>

<section id="cfr-socials">
    <style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/cfr-links.css");</style>
    <div class="heading-container">
        <div class='heading-overlay heading-overlay-white'>blubby's socials</div>
        <div class='heading-watermark'>socials</div>
    </div>

    <div class="container socials-grid">
        <div class="row">
            <div class="col-md-4 social-media-container">
                <a href="https://www.instagram.com/cfrproject">
                    <div class="background">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/cfr-insta.jpg">
                    </div>

                    <div class="foreground">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/instagram-white.svg">
                    </div>
                </a>
            </div>


            <div class="col-md-4 social-media-container">
                <a href="https://www.youtube.com/channel/UCC4Pbxf1OppMBmg3jLomAag">
                    <div class="background">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/cfr-youtube.jpg">
                    </div>

                    <div class="foreground">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/youtube-white.svg">
                    </div>
                </a>
            </div>


            <div class="col-md-4 social-media-container">
                <a href="https://github.com/The-CFR-Project">
                    <div class="background">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/cfr-github.jpg">
                    </div>

                    <div class="foreground">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/github-white.svg">
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section id="cfr-discord">
    <div class="heading-container">
        <div class='heading-overlay heading-overlay-grey'>we need to talk.</div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <iframe src="https://discord.com/widget?id=875421745551638557&theme=dark" style="margin: auto;" width="100%" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
            </div>

            <div class="col-md-7">
                <div class="discord-header">
                    <a class="discord-logo" style="background: url(<?php echo get_template_directory_uri();?>/assets/images/social-images/discord-logo.svg) 50% no-repeat;" href="https://discord.com?utm_source=Discord%20Widget&amp;utm_medium=Logo" target="_blank"></a>
                </div>

                <div class="discord-body">
                    <h5>Apply for the Team</h5>
                    <p>We're always looking for more members! Researchers, writers, programmers, designers, & more!</p>
                    <h5>Chat with Us!</h5>
                    <p>CFR is ready to talk about interesting topics! Join if you just want to be part of the conversation</p>
                    <h5>Join the Gameshow</h5>
                    <p>"Getting Played", the CFR Gameshow fuses pop culture & climate action - join to form a team!</p>
                </div>

                <div class="widgetFooter-1l6LHW">
                    <span class="widgetFooterInfo-3sJWsY">Join the CFR Project Server!</span>
                    <a class="widgetBtnConnect-2fvtGa" href="https://discord.com/invite/qzAprv6f?utm_source=Discord%20Widget&amp;utm_medium=Connect" target="_blank">Join Server</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part( "template-parts/home-page/section", "instawall" );?>

<?php get_footer();?>
