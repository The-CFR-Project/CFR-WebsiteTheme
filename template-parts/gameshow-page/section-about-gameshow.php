<?php
$post = get_page_by_path("about-gameshow");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );

$trailerLink = $doc->query('//a')[0]->nodeValue;
$description = $doc->query('//h3')[0]->nodeValue;
?>
<section id='gameshow-banner'>
<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/about-gameshow.css"); </style>
    <div class='gameshow-banner-container'>
        <div class="gameshow-banner-text">
            <h1>Getting Played</h1>
            <h3>The CFR Gameshow</h3>
            <a href='#about-gameshow'><button>Learn More</button></a>
        </div>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gameshow-banner-img.jpeg" alt="gameshow-banner-img">
    </div>
</section>

<section id="about-gameshow">
<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/about-gameshow.css"); </style>
<div class="row">
    <div class="col-md-6 trailer-embed-container">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Old_TV_Plain.svg" alt="" class="about-gameshow-tv">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/XqZsoesa55w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>    
    </div>
    <div class="col-md-6 about-gameshow-container">
        <p><?php echo $description; ?></p>
    </div>
</div>

<script>
    var tv = document.getElementsByClassName("about-gameshow-tv");
    var video = document.querySelector("iframe");
    var pos = 0;

    tv[0].addEventListener('click', function(){
        if (pos == 0) {
            video.style.zIndex = '3';
            pos = 1;
        } else {
            video.style.zIndex = '0';
            pos = 0;
        }
    });
</script>

</section>