/// Input Handling ///
// Functions 
function getValue(element) {
    // console.log(element.value);
    return element.value;
}

const today = new Date();

// Todays Date 
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0
var yyyy = today.getFullYear();
cDay = yyyy + '-' + mm + '-' + dd;
// Todays Time
var cTime = String(today.getHours() + ":" + String(today.getMinutes()).padStart(2, "0"));

// Input Elements 
const dateE = document.getElementById("date");
const timeE = document.getElementById("time");
const altitudeE = document.getElementById("altitude");
const modelE = document.getElementById("model");
const sliderE = document.getElementById("myRange");

// Default Values
dateE.value = cDay;
timeE.value = cTime;
altitudeE.value = 100;

// Event Listeners 
dateE.addEventListener('change',function(){var date = getValue(this);});
timeE.addEventListener('change',function(){var time = getValue(this);});
altitudeE.addEventListener('change',function(){var altitude = getValue(this);});
modelE.addEventListener('change',function(){var model = getValue(this.selectedOptions[0]);});
sliderE.addEventListener('change',function(){var altitude = getValue(this);});

//Slider Functions
let parent = document.querySelector(".altitude-slider-container");
if(parent){
    let rangeSlide = parent.querySelectorAll("input[type=range]");
    let numberSlide = parent.querySelectorAll("input[type=number]");
    rangeSlide.forEach(function(el) {
        el.oninput = function() {
            let slide1 = parseFloat(rangeSlide[0].value);
            numberSlide[0].value = slide1;
            const left = ((rangeSlide[0].value - 0) / (18000 - 0)) * ((rangeSlide[0].offsetWidth) - 50);
            numberSlide[0].style.bottom = left + 'px';
        }
    });
    numberSlide.forEach(function(el) {
        el.oninput = function() {
            let number1 = parseFloat(numberSlide[0].value);
            rangeSlide[0].value = number1;
            const left = ((rangeSlide[0].value - 0) / (18000 - 0)) * ((rangeSlide[0].offsetWidth) - 50);
            numberSlide[0].style.bottom = left + 'px';
        }
    });
}
 

/// Map Drawing JS ///
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
















// function runBackupCode(){
//     const geojson = '<?php echo get_template_directory_uri();?>/js/world-110m.json';
//     const projection = d3.geoEquirectangular();
//     const geoGenerator = d3.geoPath()
//                         .projection(projection);
//     let canvas = d3.select('#amp-map')
//             .selectAll('path')
//             .attr('d', geoGenerator)
//             .data(geojson.objects)
//             .join('path');
//     var context = canvas.getContext("2d");
//     context.beginPath();
// }

// function drawMapCanvas() {
//     var canvas = document.getElementById('amp-map');

//     var width = canvas.offsetWidth;
//     var height = canvas.offsetHeight;

//     var projection = d3.geoEquirectangular()
//         .scale(width / 1.3 / Math.PI)
//         .translate([width / 2, height / 2]);

//     var ctx = canvas.getContext('2d');

//     const pathGenerator = d3.geoPath(projection, ctx);

//     d3.json('<?php echo get_template_directory_uri();?>/js/world-110m.json', function(data){

//     // initialize the path
//     ctx.beginPath();

//     // Got the positions of the path
//     pathGenerator(data.objects);

//     // Fill the paths
//     ctx.fillStyle = "#999";
//     ctx.fill();

//     // Add stroke
//     ctx.strokeStyle = "#69b3a2";
//     ctx.stroke();
//     })
// }
