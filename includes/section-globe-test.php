<script type='text/javascript' src='http://d3js.org/d3.v3.min.js'></script>
<script type='text/javascript' src='http://d3js.org/topojson.v1.min.js'></script>
<script src="<?php echo get_template_directory_uri();?>/js/planetaryjs.js"></script>

<div class="globe-container" style="margin:100px 0; display:flex; justify-content:center; align-items:center;">
    <canvas id='globe' width='800' height='800'
    style='width: 800px; height: 800px; cursor: move;'>
    </canvas>
    <div class="globe-container-again">
        <svg width="800px" height="400px">
        <g class="map"></g>
        </svg>
    </div>

</div>


<script>
    // Defining constants
    const cord1 = [11, 48]; // Dubai
    const cord2 = [74, 16]; // Mumbai

    // Making an instance of a globe
    var globe = planetaryjs.planet();

    // Built-in plugin init
    globe.loadPlugin(planetaryjs.plugins.earth({
        topojson: { file:   '<?php echo get_template_directory_uri();?>/js/world-110m.json' },
        oceans:   { fill:   '#011320' },
        land:     { fill:   '#06304e' },
        borders:  { stroke: '#001320' }
    }));
    globe.loadPlugin(planetaryjs.plugins.pings());
    globe.loadPlugin(planetaryjs.plugins.zoom({scaleExtent:[100, 300]}));
    globe.loadPlugin(planetaryjs.plugins.drag());

    // Custom Plugin init
    globe.loadPlugin(planetaryjs.plugins.points());
    globe.loadPlugin(planetaryjs.plugins.lines());

    // Set projection deets
    globe.projection.scale(175).translate([400, 400]); // Possibly add .rotate()

    // Actually project the globe
    var canvas = document.getElementById("globe");
    globe.draw(canvas);

    //  Creating instances of features (points and lines) on the globe and projecting them (using the plugins)
    var point1 = globe.plugins.points.add(cord1[0], cord1[1], { color: '#ddd', ttl: 1000, angle: 1, latitudeFirst : true});
    var point2 = globe.plugins.points.add(cord2[0], cord2[1], { color: '#ddd', ttl: 1000, angle: 1, latitudeFirst : true});

    var line = globe.plugins.lines.add(cord1, cord2, { color: '#eee', width: 2, latitudeFirst : true});

</script>