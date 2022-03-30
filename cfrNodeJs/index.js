const express = require("express");
var cors = require("cors");
const { exec } = require("child_process");
const app = express();
const PORT = 3000;

app.use(cors());

app.get("/", (req, res, next) => {
    // Executing the command to get data
    exec(
        `${__dirname + "/youtube-dl.exe"} -F ${req.query.videoURL}`,
        (error, stdout, stderr) => {
            // Error logging
            if (error) {
                console.log(`[ERROR] ${error.message}`);
                res.status(500);
                return res.send("An error occurred while running command");
            }

            // Error logging
            if (stderr) {
                console.log(`[ERROR] ${stderr}`);
                res.status(500);
                return res.send("An error occurred while running command");
            }

            var data = stdout.split("\n"); // Converting data into an Array

            /* console.log(data); */
            data = data.filter((element) => {
                return element != null;
            });

            // Calculating video size with audio included
            var videoAudio = data.filter((element) => {
                return element.includes("audio only");
            });
            var videoVideo = data.filter((element) => {
                return element.includes("video only");
            });

            // Processing Video Audio
            for (var i = 0; i < videoAudio.length; i++) {
                videoAudio[i] = videoAudio[i].split(" ");
                videoAudio[i] = videoAudio[i].filter((element) => {
                    return element != "";
                });

                const audioSize = videoAudio[i][videoAudio[i].length - 1];
                let size = parseInt(audioSize.replace("/[^.d]/g", ""));
                const unit = audioSize.slice(-3);
                if (unit == "KiB") {
                    size = size / 1000;
                } else if (unit == "GiB") {
                    size = size * 1000;
                }

                videoAudio[i] = {
                    fileSize: {
                        size: size,
                        unit: unit,
                    },
                };
            }

            console.log(videoAudio);

            // Processing Video Video
            for (var i = 0; i < videoVideo.length; i++) {
                if (!videoVideo[i].includes("webm")) {
                    videoVideo[i] = null;
                }
            }

            videoVideo = videoVideo.filter((element) => {
                return element != null;
            });

            for (var i = 0; i < videoVideo.length; i++) {
                videoVideo[i] = videoVideo[i].split(" ");
                videoVideo[i] = videoVideo[i].filter((element) => {
                    return element != "";
                });

                const videoVideoSize = videoVideo[i][videoVideo[i].length - 1];
                const size = parseInt(videoVideoSize.replace("/[^.d]/g", ""));
                const unit = videoVideoSize.slice(-3);
                const resolution = videoVideo[i][videoVideo[i].length - 11];
                videoVideo[i] = {
                    resolution: resolution,
                    fileSize: {
                        size: size,
                        unit: unit,
                    },
                };
            }

            // Processing data
            for (var i = 0; i < data.length; i++) {
                data[i] = data[i].split(" "); // Breaking down each value by spaces
                data[i] = data[i].filter((element) => {
                    // Filtering out empty values
                    return element != "";
                });
                /* console.log(data[i]); */ // Logging the value to the console

                // Processing data so it only has resolution and file size
                if (data[i].length == 13) {
                    data[i] = { resolution: data[i][3], fileSize: data[i][12] };
                    continue;
                }
                data[i] = { resolution: data[i][3], fileSize: data[i][13] };

                /* console.log(data[i]); */ // Logging the value to the console
            }

            /* console.log(data); */ // Logging full data
            return res.json({
                // returning a response
                data: {
                    videoAudio: videoAudio,
                    videoVideo: videoVideo,
                },
            });
        }
    );
});

app.listen(PORT, () => {
    console.log(`[INFO] listening at http://localhost:${PORT}`);
});
