<?php
$post = get_page_by_path("gameshow");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="gameshow-our-sponsors" style="padding: 0 18vw;">
    <style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/gameshow-our-sponsors.css"); </style>
    <div class="heading-container">
        <?php
            echo "<div class='heading-overlay'>" . $doc->query("//h2")[2]->nodeValue . "</div>";
        ?>
    </div>
    <div class="sponsors">
        <div class="sponsors-wrapper">
            <div class="row">
                <div class="col sponsor-img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/pop-logo.png" alt="" style="width: 100%;"></div>
                <div class="col sponsor-img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/ervis-logo.jpg" alt="" style="width: 100%;"></div>
                <div class="col sponsor-img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/natcon-logo.png" alt="" style="width: 100%;"></div>
            </div>
            <div class="whisk-affair-logo-wrapper">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/whisk-affair-logo.png" alt="">
            </div>
        </div>
    </div>
</section>