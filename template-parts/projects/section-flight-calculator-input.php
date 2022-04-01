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
    </script>
    <!-- THIS LINE -->
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/jquery-3.6.0.js"></script>
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/projects-css/flight-calc-input.css"); </style>
    <!-- First Part -->
    <body>
    <h1 style="margin:100px;">Pick a plane</h1>
    <form id="flight-calculator-inputs-form" method="post" action="">
        <div class="row" style="justify-content: center">
            <div style="width: 20%">
                <label for="aircraft-type">Aircraft Type</label><br>
                <input list="aircraft-type" name="aircraft_type" /></label>
                <datalist id="aircraft-type">
				<?php
				// iterates through a database query to show the results. Only for drop down menus with many options
				global $wpdb;
				$results = array_splice($wpdb->get_results( "SELECT DISTINCT aircraft_type FROM {$wpdb->prefix}ae" ),1);
				sort($results);
				foreach ($results as $row) {
                    echo "<option>". $row->aircraft_type . "</option>";
				}
				?>
				</datalist>
			</div>
			<div style="width: 20%">
				<label>Aircraft Category</label><br>
				<input list="aircraft-category" name="aircraft_category" />
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
				<input list="engine-manufacturer" name="engine_manufacturer" />
				<datalist id="engine-manufacturer">
				<?php
				global $wpdb;
				$results = $wpdb->get_results( "SELECT DISTINCT engine_manufacturer FROM {$wpdb->prefix}ae ORDER BY engine_manufacturer ASC" );
                foreach($results as $result) {
                    $stuff = $result->engine_manufacturer;
                    if (strpos($stuff, ';') === false) {
                        echo "<option>". $stuff . "</option>";
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
			<input list="manufacturer" name="aircraft_manufacturer" />
				<datalist id="manufacturer">
				<?php
				global $wpdb;
				$results = array_splice($wpdb->get_results( "SELECT DISTINCT manufacturer FROM {$wpdb->prefix}ae" ),1);
				sort($results);
				foreach ($results as $row) {
					echo "<option>". $row->manufacturer . "</option>";
				}
				?>
				</datalist>
			</div>
			<div style="width: 20%">
			<label for="body-type">Body Type</label><br>
			<input list="body-type" name="body_type" />
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
			<input list="maximum-seats" name="maximum_seats" />
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
				<input list="engine-type" name="engine_type" />
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
                            <input list="ec-1" name="ec1" />
                                <datalist id="ec-1">
                                    <option>0</option>
                                    <option>1</option>
                                </datalist>
                            <input list="ec-2" name="ec2" />
                                <datalist id="ec-2">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>6</option>
                                </datalist>
                        </div>
				</div>
		</div>
	</div>
    <div class="row" style="justify-content: center">
		<input type="submit" name="submitbtn">
	</div>
</form>	
	<?php
		if (isset($_POST['submitbtn'])) {
			// collecting the data on submitting the button
			global $wpdb;
			$aircraft_type=$_POST['aircraft_type'];
			$aircraft_category=$_POST['aircraft_category'];
			$engine_manufacturer=$_POST['engine_manufacturer'];
			$aircraft_manufacturer=$_POST['aircraft_manufacturer'];
			$body_type=$_POST['body_type'];
			$maximum_seats=$_POST['maximum_seats'];
			$engine_type=$_POST['engine_type'];
			$engine_count=$_POST['ec1'].$_POST['ec2'];
			$query = "SELECT * FROM {$wpdb->prefix}ae WHERE ";
			$subqueries = [];
			// if conditions to check if the values are not empty and add part of
			// an sql query to the main one
			if( !empty( $aircraft_type )) {
				$subquery = "aircraft_type=\"$aircraft_type\" ";
				array_push($subqueries, $subquery);
			}
			if( !empty( $aircraft_category )) {
				$subquery = "aircraft_category=\"$aircraft_category\" ";
				array_push($subqueries, $subquery);
			} 
			if( !empty( $engine_manufacturer )) {
				$subquery = "engine_manufacturer=\"$engine_manufacturer\" ";
				array_push($subqueries, $subquery);
			} 
			if( !empty( $aircraft_manufacturer )) {
				$subquery = "manufacturer=\"$aircraft_manufacturer\" ";
				array_push($subqueries, $subquery);
			} 
			if( !empty( $body_type )) {
				$subquery = "body_type=\"$body_type\" ";
				array_push($subqueries, $subquery);
			} 
			if( !empty( $maximum_seats )) {
				$subquery = "max_seats=\"$maximum_seat\" ";
				array_push($subqueries, $subquery);
			} 
			if( !empty( $engine_type )) {
				$subquery = "engine_type=\"$engine_type\" ";
				array_push($subqueries, $subquery);
			} 
			if( !empty( $engine_count )) {
				$subquery = "engine_count=\"$engine_count\" ";
				array_push($subqueries, $subquery);
			} 
			$fq = join("AND ", $subqueries);
			$results = $wpdb->get_results($query.$fq);
			echo "<table class=\"results-table\">";
			echo "<tr>";
			echo "<th style=\"background-color: #35B0AB;\">Model</th>";
			echo "<th style=\"background-color: #EC7E8A;\">Manufacturer</th>";
			echo "<th style=\"background-color: #35B0AB;\">Engine Manufacturer</th>";
			echo "<th style=\"background-color: #6F5980;\">Engine Model</th>";
			echo "<th style=\"background-color: #C06D85;\">Description</th>";
			echo "<th style=\"background-color: #C06D85;\">Max Seats</th>";
			echo "<th style=\"background-color: #EC7E8A;\">Body Type</th>";
			echo "</tr>";
			for ($i=0; $i < count($results); $i++) {
                $hidden = 'demo'.strval($i);
                $id = '#demo'.strval($i);
				echo "<tr data-bs-toggle='collapse' data-bs-target=$id class='accordion-toggle'>";
				echo "<td>";echo $results[$i]->model;echo "</td>";
				echo "<td>";echo $results[$i]->manufacturer;echo "</td>";
				echo "<td>";echo $results[$i]->engine_manufacturer;echo "</td>";
				echo "<td>";echo $results[$i]->engine_model;echo "</td>";
				echo "<td>Description</td>";
				echo "<td>";echo $results[$i]->max_seats;echo "</td>";
				echo "<td>";echo $results[$i]->body_type;echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='7'>";
                echo "<div class='accordion-body collapse' id=$hidden>";
                echo "More information about the plane";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
			}
			echo "</table>";
		}
	?>
</section>