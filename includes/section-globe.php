
<script type='text/javascript' src='http://d3js.org/d3.v3.min.js'></script>
<script type='text/javascript' src='http://d3js.org/topojson.v1.min.js'></script>
<script src="<?php echo get_template_directory_uri();?>/js/planetaryjs.js"></script>

<canvas id='emissions-globe' class="emissions-globe"></canvas>

<script>
(function() {
  var canvas = document.getElementById('emissions-globe');

  // Create our Planetary.js planet and set some initial values;
  // we use several custom plugins, defined at the bottom of the file
  var planet = planetaryjs.planet();
  planet.loadPlugin(autocenter({extraHeight: -120}));
  planet.loadPlugin(autoscale({extraHeight: -120}));
  planet.loadPlugin(planetaryjs.plugins.earth({
    topojson: { file:   '<?php echo get_template_directory_uri();?>/js/world-110m.json' },
    oceans:   { fill:   '#011320' },
    land:     { fill:   '#06304e' },
    borders:  { stroke: '#001320' }
  }));
  planet.loadPlugin(planetaryjs.plugins.pings());
  planet.loadPlugin(planetaryjs.plugins.zoom({
    scaleExtent: [50, 5000]
  }));
  planet.loadPlugin(planetaryjs.plugins.drag({
    onDragStart: function() {
      this.plugins.autorotate.pause();
    },
    onDragEnd: function() {
      this.plugins.autorotate.resume();
    }
  }));
  planet.loadPlugin(autorotate(5));
  planet.projection.rotate([100, -10, 0]);
  planet.draw(canvas);


  // Create a color scale for the various earthquake magnitudes; the
  // minimum magnitude in our data set is 2.5.
  var colors = d3.scale.pow()
    .exponent(3)
    .domain([2, 4, 6, 8, 10])
      .range(['white', 'yellow', 'orange', 'red', 'purple']);
  // Also create a scale for mapping magnitudes to ping angle sizes
  var angles = d3.scale.pow()
    .exponent(3)
    .domain([2.5, 10])
    .range([0.5, 15]);
  // And finally, a scale for mapping magnitudes to ping TTLs
  var ttls = d3.scale.pow()
    .exponent(3)
    .domain([2.5, 10])
    .range([2000, 5000]);

  // Create a key to show the magnitudes and their colors
  d3.select('#magnitudes').selectAll('li')
    .data(colors.ticks(9))
  .enter()
    .append('li')
    .style('color', colors)
    .text(function(d) {
      return "Magnitude " + d;
    });





  // Plugin to resize the canvas to fill the window and to
  // automatically center the planet when the window size changes
  function autocenter(options) {
    options = options || {};
    var needsCentering = false;
    var globe = null;

    var resize = function() {
      var width  = window.innerWidth + (options.extraWidth || 0);
      var height = window.innerHeight + (options.extraHeight || 0);
      globe.canvas.width = width;
      globe.canvas.height = height;
      globe.projection.translate([width / 2, height / 2]);
    };

    return function(planet) {
      globe = planet;
      planet.onInit(function() {
        needsCentering = true;
        d3.select(window).on('resize', function() {
          needsCentering = true;
        });
      });

      planet.onDraw(function() {
        if (needsCentering) { resize(); needsCentering = false; }
      });
    };
  };

  // Plugin to automatically scale the planet's projection based
  // on the window size when the planet is initialized
  function autoscale(options) {
    options = options || {};
    return function(planet) {
      planet.onInit(function() {
        var width  = window.innerWidth + (options.extraWidth || 0);
        var height = window.innerHeight + (options.extraHeight || 0);
        planet.projection.scale(Math.min(width, height) / 2);
      });
    };
  };

  // Plugin to automatically rotate the globe around its vertical
  // axis a configured number of degrees every second.
  function autorotate(degPerSec) {
    return function(planet) {
      var lastTick = null;
      var paused = false;
      planet.plugins.autorotate = {
        pause:  function() { paused = true;  },
        resume: function() { paused = false; }
      };
      planet.onDraw(function() {
        if (paused || !lastTick) {
          lastTick = new Date();
        } else {
          var now = new Date();
          var delta = now - lastTick;
          var rotation = planet.projection.rotate();
          rotation[0] += degPerSec * delta / 1000;
          if (rotation[0] >= 180) rotation[0] -= 360;
          planet.projection.rotate(rotation);
          lastTick = now;
        }
      });
    };
  };
})();
</script>
