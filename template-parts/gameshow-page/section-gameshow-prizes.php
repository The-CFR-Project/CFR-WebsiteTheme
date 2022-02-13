<?php
$post = get_page_by_path("gameshow");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="flight-calculator">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/flights-calc.css"); </style>
    <div class="home-post container-fluid">
        <div class="heading-container">
            <?php
                echo "<div class='heading-overlay' style='font-size: 50px;'>" . $doc->query("//h2")[0]->nodeValue . "</div>";
                echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
            ?>
        </div>

        <div class="row" style="padding-top: 100px;">
            <div class="col-md-6">
                <img src="<?php echo get_template_directory_uri();?>/assets/images/gameshow-trophy.svg">
            </div>
            <div class="col-md-6 col-para text-justify">
                <?php
                    $para_no = 1;
                    foreach ($doc->query('//p[not(a)]') as $node) {
                        if ($para_no == 1) {
                            echo "<div class='gold' style='text-transform: uppercase; font-size: 23px;'><b>1st place</b></div>";
                        } else if ($para_no == 2) {
                            echo "<div class='silver' style='text-transform: uppercase; font-size: 23px;'><b>2nd place</b></div>";
                        } else if ($para_no == 3) {
                            echo "<div class='bronze' style='text-transform: uppercase; font-size: 23px;'><b>3rd place</b></div>";
                        } else if ($para_no == 4) {
                            echo "<div class='green2' style='text-transform: uppercase; font-size: 23px;'><b>Runner-ups</b></div>";
                        }
                        echo "<p>" . $node->nodeValue . "</p><br><br>";
                        $para_no = $para_no+1;
                    }
                ?>
                <!-- <a href="<?php echo get_permalink( $post )?>" class='line-lmao'>Read More</a> -->
            </div>
        </div>
    </div>
</section>

