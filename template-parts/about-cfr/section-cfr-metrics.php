<?php
$post = get_page_by_path("cfr-metrics");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="our-metrics">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/aboutus-css/cfrmetrics.css"); </style>
  <div class="container-border-components container-fluid" style="height: 500px;">
    <div class="heading-container">
    <?php
    echo "<div class='heading-overlay heading-overlay-white'>" . $doc->query( "//h2" )[0]->nodeValue . "</div>";
    echo "<div class='heading-watermark'>" . $doc->query( "//h1" )[0]->nodeValue . "</div>";?>
    </div>

    <!-- Background images and formatting -->
    <div class="border-components-row">

      <div class="full-row">
      </div>

      <div class="middle-row">
        <div class="align-self-center">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/about-cfr-easel0.svg">
        </div>

        <div class="middle-col align-self-center row">
            <div class="col-md-4">
              <div class="blue2">
                <h4><?php echo $doc->query( "//h3" )[0]->nodeValue;?></h4>
              </div>

              <div>
                <h6><?php echo $doc->query( "//p" )[0]->nodeValue;?></h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="red2">
                <h4 id='date'></h4>
              </div>

              <div>
                <h6><?php echo $doc->query( "//p" )[1]->nodeValue;?></h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="red4">
                <h4><?php echo $doc->query( "//h3" )[2]->nodeValue;?></h4>
              </div>

              <div>
                <h6><?php echo $doc->query( "//p" )[2]->nodeValue;?></h6>
              </div>
            </div>
        </div>

        <div class="align-self-center">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/about-cfr-easel1.svg">
        </div>
      </div>

      <div class="full-row align-self-center">

      </div>
    </div>
  </div>

  <script>
    var dateE = document.getElementById("date");
    var today = new Date(); 
    var foundedDate = new Date("06/11/2021");

    var difference= Math.abs(today-foundedDate);
    days = difference/(1000 * 3600 * 24);

    dateE.innerHTML = (Number(Math.round(parseFloat(days/365 + 'e' + 1)) + 'e-' + 1)).toString() + " years";
  </script>

</section>
