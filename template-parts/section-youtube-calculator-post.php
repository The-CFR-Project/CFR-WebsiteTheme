<!---------------------- Youtube Calculator About Section ---------------------->

<?php
    $post = get_page_by_path("youtube-calculator-post");
    $doc = new DOMDocument();
    $doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
    $doc = new DOMXPath( $doc );
?>

<section id="youtube-calculator-post">
    <style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/assets/css/youtube-calculator-css/youtube-calculator-post.css"); </style>

    <div class="row fields">
        <div class="col field">
            <div class="field-value blue-text" id="total-video-carbon-footprint">NaN</div>
            <div class="field-name">Grams of CO<sub>2</sub> emitted</div>
        </div>
        <div class="col field">
            <div class="field-value pink-text" id="total-video-size">NaN</div>
            <div class="field-name">MB of data used</div>
        </div>
        <div class="col field">
            <div class="field-value purple-text" id="total-video-duration">NaN</div>
            <div class="field-name">Minutes Total</div>
        </div>
    </div>

    <div class="post">
        <div class="heading-container">
            <?php echo "<div class='heading-overlay blue-text'>" . $post->post_title . "</div>"; ?>
        </div>
        <div style="padding-left: 100px; padding-right: 100px; line-height: 30px;">
            <?php
                foreach ($doc->query('//p[not(a)]') as $node) {
                    echo $node->nodeValue;
                    echo "<br>";
                }
            ?>
        </div>
    </div>

    <br>
    <br>
    <br>
</section>
