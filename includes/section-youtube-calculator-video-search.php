<section id="youtube-calculator-video-search">
    <style type="text/css"> @import url("<?php echo get_template_directory_uri(); ?>/css/youtube-calculator-css/youtube-calculator-video-search.css"); </style>

    <div class="heading-container">
        <div class="heading-overlay">Calculate Your Video Footprint</div>
    </div>

    <div class="content">
        <div class="search-container">
            <input type="text" class="search-bar" id="videoURL" placeholder="Enter the URL of your YouTube video"/>
            <button type="submit" class="search-button" onclick="getVideoData()">
                <img src="<?php echo get_template_directory_uri();?>/images/search.svg" style="filter: brightness(0) invert(1);">
            </button>
        </div>

        <div class="video-stats-container">
            <div class="row">
                <div class="col">
                    <img src="<?php echo get_template_directory_uri() ?>/images/placeholder-image.svg" alt="" id="thumbnail-img" class="thumbnail-img">
                    <input type="range" min="0" max="100" value="100" class="duration-video-watched" id="video-watched">
                    <button class="add-to-calculations-button" onclick="addVideoToCalculations()">Add to Calculations</button>
                </div>
                <div class="col">
                    <div class="field">
                        <div class="field-name">Video Title</div>
                        <div class="field-value" id="video-title">N/A</div>
                    </div>
                    <div class="field">
                        <div class="field-name">Channel Name</div>
                        <div class="field-value" id="channel-title">N/A</div>
                    </div>
                    <div class="field">
                        <div class="field-name">Video Resolution</div>
                        <div class="field-value">
                            <select class="resolutions" name="resolution" id="resolution">
                                <option>No resolutions available</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="chart-heading" class="heading-container" style="width: 100vh; display: none;">
            <div class="heading-overlay">Carbon Footprint (gCO<sub>2</sub>)</div>
        </div>
        <div class="charts-container">
            <div id="bar-chart"></div>
        </div>
    </div>

    <br>
    <br>
</section>
