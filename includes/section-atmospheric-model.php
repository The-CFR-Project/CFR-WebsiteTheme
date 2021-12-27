<section id="atmospheric-model-page-header">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/projects-css/atmospheric-model.css"); </style>

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
        <img src="<?php echo get_template_directory_uri(); ?>/images/amp-header.svg" alt="">
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
      <input type="date" name="date" class="col-md-3">
      <input type="time" name="time" class="col-md-3">
      <input type="text" name="altitude" placeholder="___ m" class="col-md-3">
      <select class="col-md-3" name="model">
        <option value="">pressure</option>
        <option value="">temperature</option>
      </select>
    </div>

  </form>

  <div class="amp-map-container">
    <canvas id="amp-map" width="300" height="300"></canvas>
  </div>


  <!------------------------------- MAP RENDERING JS --------------------------->
  <script src='http://d3js.org/d3.v3.min.js'></script>
  <script src='http://d3js.org/topojson.v1.min.js'></script>
  <script type="module">
    import d3Geo from 'https://cdn.skypack.dev/d3-geo';
    //const geojson = '<?php //echo get_template_directory_uri();?>///js/world-110m.json';
    //const projection = d3.geo.equirectangular();
    //const geoGenerator = d3.geo.path()
    //                       .projection(projection);
    //let u = d3.select('#amp-map')
    //          .selectAll('path')
    //          .data(geojson.objects)
    //          .join('path')
    //          .attr('d', geoGenerator);
  </script>
</section>
