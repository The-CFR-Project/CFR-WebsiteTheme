<?php
$post = get_page_by_path("about-cfr");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="about-cfr">
  <div class="about-cfr-container container">
    <div class="row">
      <div class="col-md-6 align-self-center">
        <h1 class="blue2">
          <?php echo $doc->query( "//h1" )[0]->nodeValue;?>
        </h1>
        <p><?php echo $doc->query( "//h3" )[0]->nodeValue;?></p>
      </div>

      <div class="col-md-6 align-self-center">
        <img class="about-cfr-img" src="<?php echo get_template_directory_uri();?>/images/about-cfr-graphic.svg">
      </div>
    </div>
  </div>
</section>
