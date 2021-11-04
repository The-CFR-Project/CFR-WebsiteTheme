<!---------------------- Youtube Calculator About Section ---------------------->

<?php
    $post = get_page_by_path("youtube-calculator");
    $doc = new DOMDocument();
    $doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
    $doc = new DOMXPath( $doc );
?>

<section id="about-youtube-calculator" style="padding-top: 100px;">
    <div class="home-post container-fluid">
        <div class="heading-container">
            <?php echo "<div class='heading-overlay'>" . $post->post_title . "</div>"; ?>
            <div class="heading-watermark">YouTube</div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div>
                    <a href="<?php echo $doc->query('//a')[1]->nodeValue;?>">
                        <div></div>
                    </a>
                </div>

                <img src="<?php echo get_template_directory_uri();?>/images/video-emissions-title-graphic.svg" width="500px" height="500px" style="margin: 75px;">
            </div>

            <div class="col-md-6 col-para text-justify">
                <?php
                    foreach ($doc->query('//p[not(a)]') as $node) {
                        echo $node->nodeValue;
                    }
                ?>
                <a href="<?php echo get_permalink( $post )?>">Read More</a>
            </div>
        </div>
    </div>
</section>
