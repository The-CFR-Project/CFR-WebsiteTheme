<section id="flight-calculator-input">
    <script>
        function folding() {
            var x = document.getElementById("second-part");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
        function tablefolding() {
            var x = document.getElementById("results-table");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/flight-calc-input.css"); </style>
    <!-- First Part -->
    <body>
    <h1>Pick a plane</h1>
    <form id="flight-calculator-inputs-form">
        <div class="row" style="justify-content: center">
            <div style="width: 20%">
                <label for="aircraft-type">Aircraft Type</label><br>
                <input list="aircraft-type" name="aircraft_type" /></label>
                <datalist id="aircraft-type">
				<?php
				global $wpdb;
				$results = array_splice($wpdb->get_results( "SELECT DISTINCT aircraft_type FROM {$wpdb->prefix}ae" ),1);
				sort($results);
				foreach ($results as $row) {
					echo "<option value=$row->aircraft_type>"; }
				?>
				</datalist>
			</div>
			<div style="width: 20%">
				<label>Aircraft Category</label><br>
				<input list="aircraft-category" name="aircraft_category" /></label>
				<datalist id="aircraft-category">
                    <option>Amphibian</option>
                    <option>Gyrocopter</option>
                    <option>Helicopter</option>
                    <option>LandPlane</option>
                    <option>Seaplane</option>
                    <option>Tiltrotor</option>
				</datalist>
			</div>
			<div style="width: 20%">
				<label>Engine Manufacturer</label><br>
				<input list="engine-manufacturer" name="engine_manufacturer" /></label>
				<datalist id="engine-manufacturer">
				<?php
				global $wpdb;
				$results = array_splice($wpdb->get_results( "SELECT DISTINCT engine_manufacturer FROM {$wpdb->prefix}ae" ),1);
				sort($results);
				foreach ($results as $row) {
                    $stuff = $row->engine_manufacturer;
                    if (strpos($stuff, ";") === false) {
                        echo "<option value=$stuff>"; 
                    }
				}
				?>
				</datalist>
			</div>
	</div>
	<br>
	<div class="row" style="justify-content: center">
	<!-- Advanced Options -->
	<button type="button" onclick="folding()">Advanced Options</button>
	</div>
	<br>
	<!-- Second Part -->
	<div id="second-part">
		<!-- First Row -->		
		<div class="row" style="justify-content: center">
			<div style="width: 20%">
			<label for="manufacturer">Manufacturer</label><br>
			<input list="manufacturer" name="aircraft_manufacturer" /></label>
				<datalist id="manufacturer">
				<?php
				global $wpdb;
				$results = array_splice($wpdb->get_results( "SELECT DISTINCT manufacturer FROM {$wpdb->prefix}ae" ),1);
				sort($results);
				foreach ($results as $row) {
					echo "<option value=$row->manufacturer>";
				}
				?>
				</datalist>
			</div>
			<div style="width: 20%">
			<label for="body-type">Body Type</label><br>
			<input list="body-type" name="body_type" /></label>
				<datalist id="body-type">
                    <option>Freighter</option>
                    <option>Gyrocopter</option>
                    <option>Helicopter</option>
                    <option>Military</option>
                    <option>Narrow</option>
                    <option>Private</option>
                    <option>Regional</option>
                    <option>UAV</option>
                    <option>Utility</option>
                    <option>Wide</option>
				</datalist>
			</div>
			<div style="width: 20%">
			<label for="maximum-seats">Maximum Seats</label><br>
			<input list="maximum-seats" name="maximum_seats" /></label>
				<datalist id="maximum-seats">
                    <option>0</option>
                    <option>1</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                    <option>13</option>
                    <option>14</option>
                    <option>100</option>
                    <option>102</option>
                    <option>104</option>
                    <option>105</option>
                    <option>106</option>
                    <option>108</option>
                    <option>112</option>
                    <option>115</option>
                    <option>118</option>
                    <option>120</option>
                    <option>124</option>
                    <option>125</option>
                    <option>132</option>
                    <option>134</option>
                    <option>135</option>
                    <option>136</option>
                    <option>141</option>
				</datalist>
			</div>
		</div>
		<br>
        <!-- Second Row -->
		<div class="row" style="justify-content: center">
				<div style="width: 20%">
				<label for="engine-type">Engine Type</label><br>
				<input list="engine-type" name="engine_type" /></label>
					<datalist id="engine-type">
                        <option>Electric</option>
                        <option>Jet</option>
                        <option>Piston</option>
                        <option>Turboprop/Turboshaft</option>
					</datalist>
				</div>
				<div style="width: 20%">
					<label for="engine-count">Engine Count</label><br>
                        <div class="code-input" id="engine-count">
                            <input list="ec-1" name="ec1" maxlength="1" />
                                <datalist id="ec-1">
                                    <option>0</option>
                                    <option>1</option>
                                </datalist>
                            <input list="ec-2" name="ec2" maxlength="1" />
                                <datalist id="ec-2">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>6</option>
                                    <option>6</option>
                                </datalist>
                        </div>
				</div>
				<div style="width: 20%">
					<label for="wake-turbulence">Wake Turbulence Category</label><br>
					<input type="text" id="wake-turbulence" name="wake-turbulence">
				</div>
		</div>
	</div>
    <div class="row" style="justify-content: center">
        <input type="submit" onsubmit="func()">
    </div>
        <div class="row" style="justify-content: center">
            <table style="display: none" id="results-table">
                <thead>
                <tr>
                    <th>Aircraft Type</th>
                    <th>Aircraft Category</th>
                    <th>Engine Manufacturer</th>
                    <th>Manufacturer</th>
                    <th>Body Type</th>
                    <th>Maximum Seats</th>
                    <th>Engine Type</th>
                    <th>Engine Count</th>
                    <th>Wake Turbulence Category</th>
                </tr>
                </thead>
            </table>
        </div>
	</form>
    </body>
</section>