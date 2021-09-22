<section id="about-cfr">
  <div class="about-cfr-container container">
    <div class="row">
      <div class="col-md-6 align-self-center">
        <h1 class="blue2">
        <?php
        $doc = new DOMDocument();
        $doc->loadHTML(apply_filters( 'the_content', $post->post_content ));
        $doc = new DOMXPath( $doc );

        echo $doc->query( "//h1" )[0]->nodeValue;
        ?>
        </h1>
        <p><?php echo $doc->query( "//h3" )[0]->nodeValue;?></p>
      </div>

      <div class="col-md-6 align-self-center">
        <img class="about-cfr-img" src="<?php echo get_template_directory_uri();?>/images/about-cfr-graphic.svg">
      </div>
    </div>
  </div>
</section>

<section id="our-metrics">

  <div class="container-border-components container-fluid">
    <div class="heading-container">
    <?php
    echo "<div class='heading-overlay'>" . $doc->query( "//h2" )[0]->nodeValue . "</div>";
    echo "<div class='heading-watermark'>" . $doc->query( "//h1" )[1]->nodeValue . "</div>";?>
    </div>

    <!-- Background images and formatting -->
    <div class="border-components-row">

      <div class="full-row">
      </div>

      <div class="middle-row">
        <div class="align-self-center">
          <img src="<?php echo get_template_directory_uri();?>/images/about-cfr-easel0.svg">
        </div>

        <div class="middle-col align-self-center">
            <div class="col-md-4">
              <div class="blue2">
                <h4><?php echo $doc->query( "//h4" )[0]->nodeValue;?></h4>
              </div>

              <div>
                <h6><?php echo $doc->query( "//li" )[0]->nodeValue;?></h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="red2">
                <h4><?php echo $doc->query( "//h4" )[1]->nodeValue;?></h4>
              </div>

              <div>
                <h6><?php echo $doc->query( "//li" )[1]->nodeValue;?></h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="red4">
                <h4><?php echo $doc->query( "//h4" )[2]->nodeValue;?></h4>
              </div>

              <div>
                <h6><?php echo $doc->query( "//li" )[2]->nodeValue;?></h6>
              </div>
            </div>
        </div>

        <div class="align-self-center">
          <img src="<?php echo get_template_directory_uri();?>/images/about-cfr-easel1.svg">
        </div>
      </div>

      <div class="full-row align-self-center">

      </div>
    </div>
  </div>
</section>

<?php get_template_part( "includes/section", "cards" );?>

<section id="our-story">
  <div class="our-story-container container">

    <div class="heading-container">
    <?php
    echo "<div class='heading-overlay'>" . $doc->query( "//h2" )[1]->nodeValue . "</div>";
    echo "<div class='heading-watermark'>" . $doc->query( "//h1" )[2]->nodeValue . "</div>";?>
    </div>

    <?php
    $journey_titles = $doc->query( "//h5" );
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
