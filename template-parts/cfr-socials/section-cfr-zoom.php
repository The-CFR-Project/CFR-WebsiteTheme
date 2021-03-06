<?php
$post = get_page_by_path("zoom");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="cfr-zoom">
    <style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/cfr-links.css");</style>
    <div class="heading-container">
        <?php
        echo "<div class='heading-overlay heading-overlay-white'>" . $post->post_title . "</div>";
        echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
        ?>
    </div>

    <div class="container">
        <div class="row justify-center">
            <div class="col-lg-6 zoom-container">
                <?php
                $times = $doc->query("//h4");
                $events = $doc->query("//p");
                $urls = $doc->query("//a");
                ?>
                <a href="<?php echo $urls[0]->nodeValue?>">
                    <div class="background">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/cfr-zoom.jpg">
                    </div>

                    <div class="foreground zoom-fg">
                        <div>
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/social-images/zoom-white.svg">
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-6 about-zoom-container">
                <div>
                    <h3><?php echo $doc->query("//h2")[0]->nodeValue;?></h3>
                    <p><?php echo $doc->query("//h3")[0]->nodeValue;?></p>
                    <h4>Scheduled Events</h4>
                    <?php
                    $i = 0;
                    foreach ($events as $event) {
                        echo '<a href="' . $urls[$i]->nodeValue . '"><p><strong>' . $times[$i]->nodeValue . '</strong>' . $event->nodeValue . '</p></a>';
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
