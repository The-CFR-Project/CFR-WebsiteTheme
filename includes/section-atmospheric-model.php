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

  <div class="rendering-map">
    <div class="amp-map-container">
      <svg id="amp-map-svg" width="800" height="450"></svg>
      <div id="background"></div>
    </div>
    <div class="altitude-slider-container">
      <input type="range" min="0" max="18000" value="50" class="altitude-slider" id="myRange">
    </div>
  </div>



  <!------------------------------- MAP RENDERING JS --------------------------->
  <script src="https://d3js.org/d3.v4.js"></script>
  <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
  <script src="https://d3js.org/d3-geo-projection.v2.min.js"></script>
  <script type="module">
    function drawMapSVG() {
      // The svg
      const svg = d3.select("svg"),
          width = +svg.attr("width"),
          height = +svg.attr("height");

      // Map and projection
      const projection = d3.geoCylindricalStereographic()
          .scale(width / 2.5 / Math.PI);
          // .translate([width / 10, height / 10]);

      // Load external data and boot
      d3.json("https://raw.githubusercontent.com/holtzy/D3-graph-gallery/master/DATA/world.geojson", function(data){

          // Draw the map
          const features = '<?php echo get_template_directory_uri(); ?>/js/features.json';
          svg.append("g")
              .selectAll("path")
              .data(data.features)
              .enter().append("path")
                  .attr("fill", "#004c65")
                  .attr("d", d3.geoPath()
                      .projection(projection)
                  )
                  .style("stroke", "#f0f0f0")
      });

    }

    drawMapSVG();
















    function runBackupCode(){
      const geojson = '<?php echo get_template_directory_uri();?>/js/world-110m.json';
      const projection = d3.geoEquirectangular();
      const geoGenerator = d3.geoPath()
                            .projection(projection);
      let canvas = d3.select('#amp-map')
               .selectAll('path')
               .attr('d', geoGenerator)
               .data(geojson.objects)
               .join('path');
      var context = canvas.getContext("2d");
      context.beginPath();
    }

    function drawMapCanvas() {
      var canvas = document.getElementById('amp-map');

      var width = canvas.offsetWidth;
      var height = canvas.offsetHeight;

      var projection = d3.geoEquirectangular()
          .scale(width / 1.3 / Math.PI)
          .translate([width / 2, height / 2]);

      var ctx = canvas.getContext('2d');

      const pathGenerator = d3.geoPath(projection, ctx);

      d3.json('<?php echo get_template_directory_uri();?>/js/world-110m.json', function(data){

        // initialize the path
        ctx.beginPath();

        // Got the positions of the path
        pathGenerator(data.objects);

        // Fill the paths
        ctx.fillStyle = "#999";
        ctx.fill();

        // Add stroke
        ctx.strokeStyle = "#69b3a2";
        ctx.stroke();
      })
    }

  </script>
</section>
