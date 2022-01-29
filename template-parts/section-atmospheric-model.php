<section id="atmospheric-model-page-header">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/projects-css/atmospheric-model.css"); </style>

  <?php
  $post = get_page_by_path("atmospheric-model");
  $doc = new DOMDocument();
  $doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
  $doc = new DOMXPath( $doc );
  ?>

  <div class="amp-header-container">

    <div class="heading-container">
      <div class="heading-watermark">climate</div>
      <div class="heading-overlay">atmospheric model</div>
    </div>
    <div class="row amp-header">
      <div class="col-md-4 amp-header-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/amp-header.svg" alt="">
      </div>
      <div class="col-md-8 amp-header-text">
        <p><?php echo $doc->query("//p")[0]->nodeValue; ?><p>
      </div>
    </div>

  </div>

</section>

<section id="atmospheric-model-page-body">

  <div class="heading-container">
    <div class="heading-overlay">enter your information </div>
  </div>

  <form class="amp-form" method="post">

    <div class="labels row">
      <label for="date" class="col-md-3">date</label>
      <label for="time" class="col-md-3">time</label>
      <label for="altitude" class="col-md-3">altitude</label>
      <label for="model" class="col-md-3">results</label>
    </div>

    <div class="inputs row">
      <input type="date" name="date" class="col-md-3" id="date">
      <input type="time" name="time" class="col-md-3" id="time">
      <input type="text" name="altitude" placeholder="___ m" class="col-md-3" id="altitude">
      <select class="col-md-3" name="model" id="model">
        <option value="pressure">pressure</option>
        <option value="temperature">temperature</option>
      </select>
    </div>

  </form>

  <div class="rendering-map">
    <div class="amp-map-container">
      <div id="background"></div>
      <svg id="amp-map-svg" width="800" height="450"></svg>
    </div>
    <div class="altitude-slider-container">
      <input type="range" min="0" max="18000" step="10" value="100" class="altitude-slider" id="myRange">
      <input type="number" value="100" min="0" max="18000"/>
    </div>
  </div>



  <!------------------------------- MAP RENDERING JS --------------------------->
  <script src="https://d3js.org/d3.v4.js"></script>
  <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
  <script src="https://d3js.org/d3-geo-projection.v2.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/amp-js.js"></script>
</section>
