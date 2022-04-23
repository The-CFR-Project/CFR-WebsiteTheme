<?php
$post = get_page_by_path("links");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="cfr-discord">
    <div class="heading-container">
        <?php echo "<div class='heading-overlay'>" . "we need to talk." . "</div>";?>
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

<section id="cfr-socials">
    <style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/cfr-links.css");</style>
    <div class="heading-container">
        <?php
        echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
        echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
        ?>
    </div>

    <div class="container socials-grid" style="padding-top:3%">
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
