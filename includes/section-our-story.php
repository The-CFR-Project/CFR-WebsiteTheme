<?php
$post = get_page_by_path("our-story");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="our-story">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/aboutus-css/ourstory.css"); </style>
  <div class="our-story-container container">

    <div class="heading-container">
    <?php
    echo "<div class='heading-overlay'>" . $doc->query( "//h2" )[0]->nodeValue . "</div>";
    echo "<div class='heading-watermark'>" . $doc->query( "//h1" )[0]->nodeValue . "</div>";?>
    </div>

    <?php
    $journey_titles = $doc->query( "//h3" );
    $journey_paras = $doc->query( "//p" );

    $i = 0;

    foreach ( $journey_titles as $title ) {
      echo "<div class='row'>";
      if ($i % 2) {
        echo "<div class='col-md-5 align-self-center'>";
        echo    "<img src=" . get_template_directory_uri() . "/images/our-story" . $i % 3 . ".svg>";
        echo "</div>";

        echo "<div class='col-md-7 align-self-center'>";
        echo    "<div><h5>";
        echo      $title->nodeValue;
        echo    "</h5></div><div><p class='grey3 text-justify'>";
        echo      $journey_paras[$i]->nodeValue;
        echo "</p></div></div>";
      }
      else {
        echo "<div class='col-md-7 align-self-center'>";
        echo    "<div><h5>";
        echo      $title->nodeValue;
        echo    "</h5></div><div><p class='grey3 text-justify'>";
        echo      $journey_paras[$i]->nodeValue;
        echo "</p></div></div>";

        echo "<div class='col-md-5 align-self-center'>";
        echo    "<img src=" . get_template_directory_uri() . "/images/our-story" . $i % 3 . ".svg>";
        echo "</div>";
      }
      echo "</div>";
      $i++;
    }?>

  </div>
</section>
