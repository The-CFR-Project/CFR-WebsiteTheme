<?php
$post = get_page_by_path("gameshow");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="gameshow-our-guests" style="padding: 0 18vw;">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/gameshow-our-guests.css"); </style>
    <div class="heading-container">
        <?php
            echo "<div class='heading-overlay'>" . $doc->query("//h2")[1]->nodeValue . "</div>";
        ?>
    </div>

    <div class="arrows">
        <button style="float: left;">
            <div class="arrow-left"></div>
        </button>
        <button style="float: right;">
            <div class="arrow-right"></div>
        </button>
    </div>

    <div class="guests row">
        <div class="guest guest-active col-md-3">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/author-placeholder.svg" alt="" class="guest-pfp">
            <div class="guest-name">Lorem Ipsum</div>
            <div class="guest-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad amet at debitis
                dignissimos minima modi quia veniam. Autem eos fuga incidunt
            </div>
        </div>
        <div class="guest guest-active col-md-3">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/author-placeholder.svg" alt="" class="guest-pfp">
            <div class="guest-name">Lorem Ipsum</div>
            <div class="guest-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci eos ex
                harum maxime nemo odit pariatur placeat quaerat repellendus sapiente
            </div>
        </div>
        <div class="guest guest-active col-md-3">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/author-placeholder.svg" alt="" class="guest-pfp">
            <div class="guest-name">Lorem Ipsum</div>
            <div class="guest-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A assumenda aut cum
                debitis delectus dolore doloribus dolorum eligendi
            </div>
        </div>
    </div>
</section>
