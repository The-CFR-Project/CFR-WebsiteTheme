<?php
/*
Template Name: Youtube Calculator
*/
?>

<?php get_header(); ?>

<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/assets/css/AVCharts.css"); </style>
<style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/assets/css/omni-slider.css"); </style>
<script src="<?php echo get_template_directory_uri(); ?>/js/AVCharts.js"></script>

<script src="<?php echo get_template_directory_uri() ?>/assets/js/d3.v4.min.js"></script>
<?php get_template_part("template-parts/section", "about-youtube-calculator"); ?>
<?php get_template_part("template-parts/section", "youtube-calculator-video-search"); ?>
<?php get_template_part("template-parts/section", "youtube-calculator-post"); ?>
<!-- <script src="<?php echo get_template_directory_uri() ?>/js/jquery-3.6.0.js"></script> -->
<script src="<?php echo get_template_directory_uri() ?>/assets/js/omni-slider.min.js"></script>
<script>
    // TODO: Make the Chart class work with functions (edits required in constructor)

    typeof $;

    class BarGraph {
        /**
         * Creates a chart object
         * Creates a chart in D3
         * 
         * @param {Number} height
         * @param {Number} width
         * @param {Number} maximumValue
         * @param {Number} data
         * @param {String} data
         */
        constructor(height, width, minimumValue, maximumValue, data) {
            // set the dimensions and margins of the graph
            const margin = {top: 100, right: 30, bottom: 70, left: 60};
            width = width - margin.left - margin.right;
            height = height - margin.top - margin.bottom;

            const graphJS = document.getElementById("graph");
            graphJS.innerHTML = "";
            const graph = d3.select("#graph");

            // append the svg object to the body of the page
            var svg = d3.select("#graph")
            .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
            .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");

            
            // sort data
            data.sort(function(b, a) {
                return a.carbonFootprint - b.carbonFootprint;
            });

            // X axis
            var x = d3.scaleBand()
                .range([ 0, width ])
                .domain(data.map(function(d) { return data.indexOf(d); }))
                .padding(0.2);
            svg.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x))
                .selectAll("text")
                .attr("transform", "translate(-10,0)rotate(-45)")
                .style("text-anchor", "end")
                .style("display", "none")

            console.log(x(0));

            // Label Images
            const imagesDiv = graph
                .append("div")
                    .attr(
                        "style",
                        `
                            transform: translate(0px, -${margin.bottom}px);
                            width: ${width}px;
                        `
                    )
        
            for(var i = 0; i < data.length; i++) {
                imagesDiv
                    .append("img")
                        .attr("src", data[i].thumbnail)
                        .attr(
                            "style",
                            `   
                                position: relative;
                                width: 120px;
                                height: 67.5px;         
                                left: ${27.5*i}px;
                                top: 10px;
                                transform: translateX(87.5px);
                            `
                        )
            }

            // Add Y axis
            var y = d3.scaleLinear()
                .domain([minimumValue, maximumValue])
                .range([ height, 0]);
            svg.append("g")
                .call(d3.axisLeft(y));

            // Bars
            svg.selectAll("bar")
                .data(data)
                .enter()
                .append("rect")
                .attr("x", (d) => { return x(data.indexOf(d)); })
                .attr("y", (d) => { return y(d.carbonFootprint); })
                .attr("width", x.bandwidth())
                .attr("height", (d) => { return height - y(d.carbonFootprint); })
                .attr("fill", "#69b3a2")
                .attr("class", "bar");
        }

        rerender() {
            document.getElementById("graph").innerHTML = "";

            // set the dimensions and margins of the graph
            const margin = {top: 100, right: 30, bottom: 70, left: 60};
            width = width - margin.left - margin.right;
            height = height - margin.top - margin.bottom;

            const graph = d3.select("#graph");

            // append the svg object to the body of the page
            var svg = d3.select("#graph")
            .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
            .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");

            // Parse the Data
            d3.json(dataPath, function(data) {

                // sort data
                data.sort(function(b, a) {
                    return a.carbonFootprint - b.carbonFootprint;
                });

                // X axis
                var x = d3.scaleBand()
                    .range([ 0, width ])
                    .domain(data.map(function(d) { return data.indexOf(d); }))
                    .padding(0.2);
                svg.append("g")
                    .attr("transform", "translate(0," + height + ")")
                    .call(d3.axisBottom(x))
                    .selectAll("text")
                    .attr("transform", "translate(-10,0)rotate(-45)")
                    .style("text-anchor", "end")
                    .style("display", "none")

                console.log(x(0));

                // Label Images
                const imagesDiv = graph
                    .append("div")
                        .attr(
                            "style",
                            `
                                transform: translate(0px, -${margin.bottom}px);
                                width: ${width}px;
                            `
                        )
            
                for(var i = 0; i < data.length; i++) {
                    imagesDiv
                        .append("img")
                            .attr("src", "https://i.ytimg.com/vi/oX3GVz4Bnzg/mqdefault.jpg")
                            .attr(
                                "style",
                                `   
                                    position: relative;
                                    width: 120px;
                                    height: 67.5px;
                                    left: ${27.5*i}px;
                                    top: 10px;
                                    transform: translateX(87.5px);
                                `
                            )
                }

                // Add Y axis
                var y = d3.scaleLinear()
                    .domain([minimumValue, maximumValue])
                    .range([ height, 0]);
                svg.append("g")
                    .call(d3.axisLeft(y));

                // Bars
                svg.selectAll("bar")
                    .data(data)
                    .enter()
                    .append("rect")
                    .attr("x", (d) => { return x(data.indexOf(d)); })
                    .attr("y", (d) => { console.log(d.carbonFootprint); return y(d.carbonFootprint); })
                    .attr("width", x.bandwidth())
                    .attr("height", (d) => { return height - y(d.carbonFootprint); })
                    .attr("fill", "#69b3a2")
                    .attr("class", "bar");

            })
        }
    }


    const videoUrlInput = document.getElementById("videoURL");
    const resolution = document.getElementById("resolution");
    const videoTitleE = document.getElementById("video-title");
    const channelTitleE = document.getElementById("channel-title");
    const thumbnailImg = document.getElementById("thumbnail-img");
    const videoWatched = document.getElementById("video-watched");
    const videoWatchedFromEnd = document.getElementById("video-watched-from-end");
    const totalVideoCarbonFootprint = document.getElementById(
        "total-video-carbon-footprint"
    );
    const totalVideoFileSizeE = document.getElementById("total-video-size");
    const totalVideoDurationE = document.getElementById("total-video-duration");
    const graph = document.getElementById("graph");

    var videoDetailsList = [];

    function fetchData(url, callback) {
        const http = new XMLHttpRequest();
        http.addEventListener("load", () => {
            callback(http);
        });
        http.open("GET", url);
        http.send();
    }

    function roundOff(num, places) {
        const x = Math.pow(10, places);
        return Math.round(num * x) / x;
    }

    function youtubeParser(url) {
        var regExp =
            /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return match && match[7].length == 11 ? match[7] : false;
    }

    function getAudioSize(
        videoSize,
        minVideoSize,
        maxVideoSize,
        minAudioSize,
        maxAudioSize,
        audioSizes
    ) {
        const t = (videoSize - minVideoSize) / (maxVideoSize - minVideoSize);
        const audioSize = (1 - t) * minVideoSize + t * maxVideoSize;

        var audioSizeDifferences = [];

        for (var i = 0; i < audioSizes.length; i++) {
            audioSizeDifferences.push(Math.abs(audioSize - audioSizes[i]));
        }
</script>

<!-- JavaScript -->
<script src="<?php echo get_template_directory_uri() ?>/assets/js/omni-slider.min.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/assets/js/AVCharts.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/assets/js/youtubeCalculator.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/assets/js/d3.v4.min.js"></script>

<?php get_footer(); ?>
