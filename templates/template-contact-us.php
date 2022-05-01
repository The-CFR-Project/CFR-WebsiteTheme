<?php

/*
Template Name: Contact Us
*/
?>

<?php get_header();?>

<?php
$post = get_page_by_path("contact-us");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="contact-us">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/contactus-css/contactus.css"); </style>
    <div class="contact-us-container">
        <div class="heading-container">
            <div class='heading-overlay heading-overlay-white' style='font-size:40px;'>reach out to us</div>
            <div class='heading-watermark'>contact</div>
        </div>
        <div class='row contactus-card-container'>
            <?php
            for ($i = 0; $i <= 2; $i++):
                echo "<div class='contactus-card contactus-card-" . ($i+1) . " col-md-3 card'>";
                echo "<h3 class='contactus-card-heading'>" . $doc->query("//h3")[$i]->nodeValue . "</h3>";
                echo "<p class='contactus-card-text'>" . $doc->query("//p")[$i]->nodeValue . "</p>";
                if ($i == 0){
                    echo "<a href='" . $doc->query("//a")[0]->nodeValue . "'><input type='button' class='contactus-card-button contactus-card-button-". ($i+1) ."' value='". $doc->query("//h4")[$i]->nodeValue ."'></a>";
                }
                else if ($i == 1){
                    echo "<a href='#contact-form'><input type='button' class='contactus-card-button contactus-card-button-". ($i+1) ."' value='". $doc->query("//h4")[$i]->nodeValue ."'></a>";
                }else if ($i == 2) {
                    echo "<a href='". $doc->query("//a")[1]->nodeValue ."'><input type='button' class='contactus-card-button contactus-card-button-". ($i+1) ."' value='". $doc->query("//h4")[$i]->nodeValue ."'></a>";
                }

                echo "</div>";
            endfor;
            ?>
        </div>

    </div>
</section>

<?php
$post = get_page_by_path("contact-form");
?>

<section id="contact-form" class="grey-section">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/contactus-css/contactusform.css"); </style>
    <div class="container-fluid">

        <div class="heading-container">
            <div class='heading-overlay heading-overlay-grey'>write to us!</div>
        </div>

        <?php echo apply_filters( 'the_content', $post->post_content );?>
    </div>
</section>

<section></section>

<section class="grey-section">
    <div id="postbox-container">
        <div>
        </div>

        <div>
            <img id="postbox" src="<?php echo get_template_directory_uri();?>/assets/images/postbox.svg">
        </div>
    </div>

    <div class="instawall-section-container container-fluid">
        <div class="bedrock-container">
            <div>
                <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/instarock.svg">
            </div>
        </div>
    </div>
</section>


<?php get_footer();?>
