class BarGraph {
    /**
     * Creates a chart object
     * Creates a chart in D3
     *
     * @param {Number} height
     * @param {Number} width
     * @param {Number} minimumValue
     * @param {Number} maximumValue
     * @param {Number} data
     * @param {String} data
     */
    constructor(height, width, minimumValue, maximumValue, data) {
        console.log(data);
        // set the dimensions and margins of the graph
        const margin = { top: 100, right: 30, bottom: 70, left: 60 };
        width = width - margin.left - margin.right;
        height = height - margin.top - margin.bottom;

        const graphJS = document.getElementById("graph");
        graphJS.innerHTML = "";
        const graph = d3.select("#graph");

        // append the svg object to the body of the page
        let svg = d3
            .select("#graph")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr(
                "transform",
                "translate(" + margin.left + "," + margin.top + ")"
            );

        // sort data
        data.sort(function (b, a) {
            return a.carbonFootprint - b.carbonFootprint;
        });

        // X axis
        let x = d3
            .scaleBand()
            .range([0, width])
            .domain(
                data.map(function (d) {
                    return data.indexOf(d);
                })
            )
            .padding(0.2);
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x))
            .selectAll("text")
            .attr("transform", "translate(-10,0)rotate(-45)")
            .style("text-anchor", "end")
            .style("display", "none");

        console.log(x(0));

        // Label Images
        const imagesDiv = graph.append("div").attr(
            "style",
            `
                    transform: translate(${margin.left}px, -${margin.bottom}px);
                    width: ${width}px;
                    height: 20px;
                `
        );

        for (let i = 0; i < data.length; i++) {
            imagesDiv
                .append("img")
                .attr("src", data[i].thumbnail)
                .attr(
                    "style",
                    `   
                        position: absolute;
                        width: 120px;
                        height: 67.5px;
                        top: 10px;
                        left: calc(${
                            (100 / (data.length + 1)) * (i + 1)
                        }% - 60px);
                    `
                );
        }

        // Add Y axis
        let y = d3
            .scaleLinear()
            .domain([minimumValue, maximumValue])
            .range([height, 0]);
        svg.append("g").call(d3.axisLeft(y));

        // Bars
        svg.selectAll("bar")
            .data(data)
            .enter()
            .append("rect")
            .attr("x", (d) => {
                return x(data.indexOf(d));
            })
            .attr("y", (d) => {
                return y(d.carbonFootprint);
            })
            .attr("width", x.bandwidth())
            .attr("height", (d) => {
                return height - y(d.carbonFootprint);
            })
            .attr("fill", "#69b3a2")
            .attr("class", "bar");
    }

    rerender() {
        document.getElementById("graph").innerHTML = "";

        // set the dimensions and margins of the graph
        const margin = { top: 100, right: 30, bottom: 70, left: 60 };
        const width = width - margin.left - margin.right;
        const height = height - margin.top - margin.bottom;

        const graph = d3.select("#graph");

        // append the svg object to the body of the page
        let svg = d3
            .select("#graph")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr(
                "transform",
                "translate(" + margin.left + "," + margin.top + ")"
            );

        // Parse the Data
        d3.json(dataPath, function (data) {
            // sort data
            data.sort(function (b, a) {
                return a.carbonFootprint - b.carbonFootprint;
            });

            // X axis
            let x = d3
                .scaleBand()
                .range([0, width])
                .domain(
                    data.map(function (d) {
                        return data.indexOf(d);
                    })
                )
                .padding(0.2);
            svg.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x))
                .selectAll("text")
                .attr("transform", "translate(-10,0)rotate(-45)")
                .style("text-anchor", "end")
                .style("display", "none");

            console.log(x(0));

            // Label Images
            const imagesDiv = graph.append("div").attr(
                "style",
                `
                                transform: translate(0px, -${margin.bottom}px);
                                width: ${width}px;
                            `
            );

            for (let i = 0; i < data.length; i++) {
                imagesDiv
                    .append("img")
                    .attr(
                        "src",
                        "https://i.ytimg.com/vi/oX3GVz4Bnzg/mqdefault.jpg"
                    )
                    .attr(
                        "style",
                        `   
                                    position: relative;
                                    width: 120px;
                                    height: 67.5px;
                                    left: ${27.5 * i}px;
                                    top: 10px;
                                    transform: translateX(87.5px);
                                `
                    );
            }

            // Add Y axis
            let y = d3
                .scaleLinear()
                .domain([minimumValue, maximumValue])
                .range([height, 0]);
            svg.append("g").call(d3.axisLeft(y));

            // Bars
            svg.selectAll("bar")
                .data(data)
                .enter()
                .append("rect")
                .attr("x", (d) => {
                    return x(data.indexOf(d));
                })
                .attr("y", (d) => {
                    console.log(d.carbonFootprint);
                    return y(d.carbonFootprint);
                })
                .attr("width", x.bandwidth())
                .attr("height", (d) => {
                    return height - y(d.carbonFootprint);
                })
                .attr("fill", "#69b3a2")
                .attr("class", "bar");
        });
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
const videosSelectedE = document.getElementById("videos-selected");

let videoDetailsList = [];

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
    let regExp =
        /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    let match = url.match(regExp);
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

    let audioSizeDifferences = [];

    for (let i = 0; i < audioSizes.length; i++) {
        audioSizeDifferences.push(Math.abs(audioSize - audioSizes[i]));
    }

    let smallestDifferenceIndex = 0;
    for (let i = 0; i < audioSizeDifferences.length; i++) {
        if (
            audioSizeDifferences[i] <
            audioSizeDifferences[smallestDifferenceIndex]
        ) {
            smallestDifferenceIndex = i;
        }
    }

    return audioSizes[smallestDifferenceIndex];
}

function updatePageDetails() {
    let totalCO2 = 0;
    let totalVideoSize = 0;
    let totalVideoDuration = 0;

    let thumbnails = [];
    let carbonFootprints = [];
    let hoverBoxData = [];

    let videosSelectedEInnerHtml = "";

    for (let i = 0; i < videoDetailsList.length; i++) {
        totalCO2 += videoDetailsList[i].carbonFootprint;
        totalVideoSize += videoDetailsList[i].videoSize;
        totalVideoDuration += videoDetailsList[i].duration;

        thumbnails.push(videoDetailsList[i].thumbnail);
        carbonFootprints.push(videoDetailsList[i].carbonFootprint);
        hoverBoxData.push(videoDetailsList[i].carbonFootprintInDiffResolutions);

        let videoSelectedE = document.createElement("div");
        videoSelectedE.classList.add("video-selected");
        videoSelectedE.innerHTML = `
            <img src="${videoDetailsList[i].thumbnail}" alt="" class="video-selected-image">
            <div class="video-selected-remove-wrapper">
                <button class="video-selected-remove" onclick="
                    videoDetailsList.splice(${i}, 1);
                    updatePageDetails();
                ">&times;</button>
            </div>
            <div class="video-selected-title">${videoDetailsList[i].title}</div>
        `;

        videosSelectedEInnerHtml =
            videosSelectedEInnerHtml +
            `
            <div class='video-selected'>
                <img src="${videoDetailsList[i].thumbnail}" alt="" class="video-selected-image">
                <div class="video-selected-remove-wrapper">
                    <button class="video-selected-remove" onclick="
                        videoDetailsList.splice(${i}, 1);
                        updatePageDetails();
                    ">&times;</button>
                </div>
                <div class="video-selected-title">${videoDetailsList[i].title}</div>
            </div>
        `;

        console.log(videoDetailsList);
    }

    videosSelectedE.innerHTML = videosSelectedEInnerHtml;

    totalVideoCarbonFootprint.innerHTML = roundOff(totalCO2, 2);
    totalVideoFileSizeE.innerHTML = roundOff(totalVideoSize, 2);
    totalVideoDurationE.innerHTML = roundOff(totalVideoDuration, 2);

    console.log(videoDetailsList);

    // Creating bar chart
    document.getElementById("graph").innerHTML = "";
    if (videoDetailsList.length > 0) {
        document.getElementById("chart-heading").style.display = "block";
        newBarChart(document.getElementById("graph"), {
            values: carbonFootprints,
            labels: thumbnails,
            hoverBoxData: hoverBoxData,
        });
    } else {
        document.getElementById("chart-heading").style.display = "none";
    }
}

let currentVideoCFRYoutubeAPIData = {};
let currentVideoYoutubeAPIData = {};

function getVideoData() {
    document.getElementById("youtube-calculator-video-search").style.cursor =
        "wait";
    fetchData(
        `http://cfrproject.test/cfr-youtube-API/?videoURL=${videoUrlInput.value}`,
        (http) => {
            console.log("completed getting video data request");
            const data = JSON.parse(http.responseText);
            currentVideoCFRYoutubeAPIData = data;
            let resolutionsHTML;
            for (let i = 0; i < data.data.videoVideo.length; i++) {
                resolutionsHTML =
                    resolutionsHTML +
                    `<option>${data.data.videoVideo[i].resolution}</option>`;
            }
            resolution.innerHTML = resolutionsHTML;

            fetchData(
                `https://www.googleapis.com/youtube/v3/videos?key=AIzaSyAXX7nPxis39wi00QOsuv-JQI13_80pO_4&id=${youtubeParser(
                    videoUrlInput.value
                )}&part=snippet,contentDetails`,
                (youtubeHttp) => {
                    const youtubeData = JSON.parse(youtubeHttp.responseText);
                    currentVideoYoutubeAPIData = youtubeData;
                    const videoTitle = youtubeData.items[0].snippet.title;
                    const channelTitle =
                        youtubeData.items[0].snippet.channelTitle;
                    const thumbnailURL =
                        youtubeData.items[0].snippet.thumbnails.medium.url;

                    videoTitleE.innerHTML = videoTitle;
                    channelTitleE.innerHTML = channelTitle;
                    thumbnailImg.setAttribute("src", thumbnailURL);
                    document.getElementById(
                        "youtube-calculator-video-search"
                    ).style.cursor = "default";
                }
            );
        }
    );
}

const element = document.getElementById("slider");
const options = {
    min: 0,
    max: 100,
};
const mySlider = new Slider(element, options);

function addVideoToCalculations() {
    const data = currentVideoCFRYoutubeAPIData;
    console.log(data);
    const durationPercent = mySlider.getInfo().right - mySlider.getInfo().left;
    const selectedResolution = resolution.selectedIndex;
    const audioSizes = [];
    for (let i = 0; i < data.data.videoAudio.length; i++) {
        audioSizes.push(data.data.videoAudio[i].fileSize.size);
    }
    const videoSizes = [];
    for (let i = 0; i < data.data.videoVideo.length; i++) {
        videoSizes.push(data.data.videoVideo[i].fileSize.size);
    }
    const videoVideoFileSize =
        data.data.videoVideo[selectedResolution].fileSize.size;
    const videoAudioFileSize = getAudioSize(
        videoVideoFileSize,
        Math.min(...videoSizes),
        Math.max(...videoSizes),
        Math.min(...audioSizes),
        Math.max(...audioSizes),
        audioSizes
    );
    const videoFileSize =
        ((videoVideoFileSize + videoAudioFileSize) / 100) * durationPercent;

    const videoCarbonFootprintDiffResolutions = [];
    for (let i = 0; i < data.data.videoVideo.length; i++) {
        const videoVideoFileSize = data.data.videoVideo[i].fileSize.size;
        const videoAudioFileSize = getAudioSize(
            videoVideoFileSize,
            Math.min(...videoSizes),
            Math.max(...videoSizes),
            Math.min(...audioSizes),
            Math.max(...audioSizes),
            audioSizes
        );
        let videoFileSizePerVideo = videoVideoFileSize + videoAudioFileSize;
        (videoFileSizePerVideo = (videoFileSize / 100) * durationPercent), 2;
        const videoCarbonFootprint = roundOff(videoFileSize * 1.219, 2);
        videoCarbonFootprintDiffResolutions.push({
            resolution: data.data.videoVideo[i].resolution,
            carbonFootprint: videoCarbonFootprint,
        });
    }

    let videoDuration;
    const youtubeData = currentVideoYoutubeAPIData;
    console.log(currentVideoYoutubeAPIData);
    videoDuration = youtubeData.items[0].contentDetails.duration;
    videoDuration = videoDuration.replace("PT", "");
    videoDuration = videoDuration.replace("S", "");
    videoDuration = videoDuration.split("M");
    videoDuration =
        parseInt(videoDuration[0]) + parseInt(videoDuration[1]) / 60;
    const thumbnailURL = youtubeData.items[0].snippet.thumbnails.medium.url;

    console.log(videoDuration);

    const video = {
        title: videoTitleE.innerHTML,
        channelTitle: channelTitleE.innerHTML,
        videoSize: videoFileSize,
        carbonFootprint: videoFileSize * 1.219,
        duration: videoDuration,
        thumbnail: thumbnailURL,
        carbonFootprintInDiffResolutions: videoCarbonFootprintDiffResolutions,
    };

    videoDetailsList = videoDetailsList.concat([video]);
    console.log("done with the addition");
    updatePageDetails();

    graph.scrollIntoView();
}

/*function showValueOnThumbnail(element) {
    const value = element.value;
    const inputsCol = document.getElementById("inputs-col");

    const originalHeightInputsCol = inputsCol.offsetHeight;

    const timeDiv = inputsCol.childNodes[1];
    timeDiv.style.display = "flex";
    timeDiv.innerHTML = `<div style="font-weight: bold; font-size: 50px;">${value}%</div>`;

    inputsCol.style.height = `${originalHeightInputsCol}px`;
}*/

/* function hideValueOnThumbnail(element) {
    const inputsCol = document.getElementById("inputs-col");

    const timeDiv = inputsCol.childNodes[1];
    timeDiv.style.display = "none";
} */
