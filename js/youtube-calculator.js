const videoUrlInput = document.getElementById("videoURL");
const resolution = document.getElementById("resolution");
const videoTitleE = document.getElementById("video-title");
const channelTitleE = document.getElementById("channel-title");
const thumbnailImg = document.getElementById("thumbnail-img");
const videoWatched = document.getElementById("video-watched");
const totalVideoCarbonFootprint = document.getElementById(
    "total-video-carbon-footprint"
);
const totalVideoFileSizeE = document.getElementById("total-video-size");
const totalVideoDurationE = document.getElementById("total-video-duration");

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

    var smallestDifferenceIndex = 0;
    for (var i = 0; i < audioSizeDifferences.length; i++) {
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
    var totalCO2 = 0;
    var totalVideoSize = 0;
    var totalVideoDuration = 0;

    var thumbnails = [];
    var carbonFootprints = [];
    var hoverBoxData = [];

    for (var i = 0; i < videoDetailsList.length; i++) {
        totalCO2 += videoDetailsList[i].carbonFootprint;
        totalVideoSize += videoDetailsList[i].videoSize;
        totalVideoDuration += videoDetailsList[i].duration;

        thumbnails.push(videoDetailsList[i].thumbnail);
        carbonFootprints.push(videoDetailsList[i].carbonFootprint);
        hoverBoxData.push(videoDetailsList[i].carbonFootprintInDiffResolutions);
    }

    totalVideoCarbonFootprint.innerHTML = roundOff(totalCO2, 2);
    totalVideoFileSizeE.innerHTML = roundOff(totalVideoSize, 2);
    totalVideoDurationE.innerHTML = roundOff(totalVideoDuration, 2);

    // Creating bar chart
    document.getElementById("bar-chart").innerHTML = "";
    newBarChart(document.getElementById("bar-chart"), {
        labels: thumbnails,
        values: carbonFootprints,
        hoverBoxData: hoverBoxData,
    });
    document.getElementById("chart-heading").style.display = "block";
}

function getVideoData() {
    fetchData(
        `http://cfrproject.test/cfr-youtube-API/?videoURL=${videoUrlInput.value}`,
        (http) => {
            console.log("completed getting video data request");
            const data = JSON.parse(http.responseText);
            var resolutionsHTML;
            for (var i = 0; i < data.data.videoVideo.length; i++) {
                resolutionsHTML =
                    resolutionsHTML +
                    `<option>${data.data.videoVideo[i].resolution}</option>`;
            }
            resolution.innerHTML = resolutionsHTML;

            fetchData(
                `https://www.googleapis.com/youtube/v3/videos?key=AIzaSyAXX7nPxis39wi00QOsuv-JQI13_80pO_4&id=${youtubeParser(
                    videoUrlInput.value
                )}&part=snippet`,
                (youtubeHttp) => {
                    const youtubeData = JSON.parse(youtubeHttp.responseText);
                    const videoTitle = youtubeData.items[0].snippet.title;
                    const channelTitle =
                        youtubeData.items[0].snippet.channelTitle;
                    const thumbnailURL =
                        youtubeData.items[0].snippet.thumbnails.medium.url;

                    videoTitleE.innerHTML = videoTitle;
                    channelTitleE.innerHTML = channelTitle;
                    thumbnailImg.setAttribute("src", thumbnailURL);
                }
            );
        }
    );
}

function addVideoToCalculations() {
    fetchData(
        `http://cfrproject.test/cfr-youtube-API/?videoURL=${videoUrlInput.value}`,
        (http) => {
            const data = JSON.parse(http.responseText);
            const durationPercent = videoWatched.value;
            const selectedResolution = resolution.selectedIndex;
            const audioSizes = [];
            for (var i = 0; i < data.data.videoAudio.length; i++) {
                audioSizes.push(data.data.videoAudio[i].fileSize.size);
            }
            const videoSizes = [];
            for (var i = 0; i < data.data.videoVideo.length; i++) {
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
            var videoFileSize = videoVideoFileSize + videoAudioFileSize;
            videoFileSize = (videoFileSize / 100) * durationPercent;

            const videoCarbonFootprintDiffResolutions = [];
            for (var i = 0; i < data.data.videoVideo.length; i++) {
                const videoVideoFileSize =
                    data.data.videoVideo[i].fileSize.size;
                const videoAudioFileSize = getAudioSize(
                    videoVideoFileSize,
                    Math.min(...videoSizes),
                    Math.max(...videoSizes),
                    Math.min(...audioSizes),
                    Math.max(...audioSizes),
                    audioSizes
                );
                var videoFileSize = videoVideoFileSize + videoAudioFileSize;
                (videoFileSize = (videoFileSize / 100) * durationPercent), 2;
                const videoCarbonFootprint = roundOff(videoFileSize * 1.219, 2);
                videoCarbonFootprintDiffResolutions.push({
                    resolution: data.data.videoVideo[i].resolution,
                    carbonFootprint: videoCarbonFootprint,
                });
            }

            var videoDuration;
            fetchData(
                `https://www.googleapis.com/youtube/v3/videos?key=AIzaSyAXX7nPxis39wi00QOsuv-JQI13_80pO_4&id=${youtubeParser(
                    videoUrlInput.value
                )}&part=contentDetails,snippet`,
                (youtubeHttp) => {
                    const youtubeData = JSON.parse(youtubeHttp.responseText);
                    videoDuration =
                        youtubeData.items[0].contentDetails.duration;
                    videoDuration = videoDuration.replace("PT", "");
                    videoDuration = videoDuration.replace("S", "");
                    videoDuration = videoDuration.split("M");
                    videoDuration =
                        parseInt(videoDuration[0]) +
                        parseInt(videoDuration[1]) / 60;
                    const thumbnailURL =
                        youtubeData.items[0].snippet.thumbnails.medium.url;

                    console.log(videoDuration);

                    const video = {
                        title: videoTitleE.innerHTML,
                        channelTitle: channelTitleE.innerHTML,
                        videoSize: videoFileSize,
                        carbonFootprint: videoFileSize * 1.219,
                        duration: videoDuration,
                        thumbnail: thumbnailURL,
                        carbonFootprintInDiffResolutions:
                            videoCarbonFootprintDiffResolutions,
                    };

                    videoDetailsList = videoDetailsList.concat([video]);
                    console.log("done with the addition");
                    updatePageDetails();
                }
            );
        }
    );
}
