	<script>
		function folding() {
			var x = document.getElementById("second-part");
			var y = document.getElementById("advanced-btn");
			
			function advancedOptionsTransition(){
				x.style.setProperty("opacity","100%","important")
				y.classList.add("advanced-btn-expanded");
			}
			
			if (x.style.display === "none") {
				x.style.display = "block";
				setTimeout(advancedOptionsTransition, 100)
			} else {
				x.style.display = "none";
				y.classList.remove("advanced-btn-expanded");
				x.style.setProperty("opacity","0%","important")
			}
		}
	</script>
	<!-- THIS LINE -->
	<script src="/assets/js/bootstrap.js"></script>
	<script src="/assets/js/jquery-3.6.0.js"></script>
	<style type="text/css">
		@import url("<?php echo get_template_directory_uri(); ?>/assets/css/projects-css/flight-calc-input.css");
	</style>
	<!-- First Part -->

	<body>
		<section class="grey-bg">
		<div class="heading-container">	
			<div class="heading-overlay heading-overlay-gr" style="color:#9079A2;">pick a plane</div>
		</div>
			<form id="flight-calculator-inputs-form" method="post" action="">
				<div class="row justify-center">
					<div class="aircraft-options">
						<div class="aircraft-option-container">
							<label for="aircraft-type">Aircraft Type</label><br>
							<input list="aircraft-type" name="aircraft_type" tabindex="0" />
							<datalist id="aircraft-type">
								<?php
								// iterates through a database query to show the results. Only for drop down menus with many options
								global $wpdb;
								$results = array_splice($wpdb->get_results("SELECT DISTINCT aircraft_type FROM {$wpdb->prefix}ae"), 1);
								sort($results);
								foreach ($results as $row) {
									echo "<option>" . $row->aircraft_type . "</option>";
								}
								?>
							</datalist>
						</div>
						<div class="aircraft-option-container">
								<label>Aircraft Category</label><br>
								<input list="aircraft-category" name="aircraft_category" tabindex="0"/>
								<datalist id="aircraft-category">
									<option>Amphibian</option>
									<option>Gyrocopter</option>
									<option>Helicopter</option>
									<option>LandPlane</option>
									<option>Seaplane</option>
									<option>Tiltrotor</option>
								</datalist>
						</div>
						<div class="aircraft-option-container">
							<label>Engine Manufacturer</label><br>
							<input list="engine-manufacturer" name="engine_manufacturer" tabindex="0"/>
							<datalist id="engine-manufacturer">
								<?php
								global $wpdb;
								$results = $wpdb->get_results("SELECT DISTINCT engine_manufacturer FROM {$wpdb->prefix}ae ORDER BY engine_manufacturer ASC");
								foreach ($results as $result) {
									$stuff = $result->engine_manufacturer;
									if (strpos($stuff, ';') === false) {
										echo "<option>" . $stuff . "</option>";
									}
								}
								?>
							</datalist>
						</div>
					</div>
						
				</div>
				<br>
				<div class="row" style="justify-content: center">
					<!-- Advanced Options -->
						<button class="advanced-btn" tabindex="0" role="button" id="advanced-btn" type="button" onclick="folding()">Advanced Options</button>
				</div>
				<br>
				<!-- Second Part -->
				<div id="second-part" style="display:none; margin-bottom:20px;">
					<!-- First Row -->
					<div class="row justify-center">
						<div class="aircraft-options">
							<div class="aircraft-option-container">
								<label for="manufacturer">Manufacturer</label><br>
								<input list="manufacturer" name="aircraft_manufacturer" tabindex="0"/>
								<datalist id="manufacturer">
									<?php
									global $wpdb;
									$results = array_splice($wpdb->get_results("SELECT DISTINCT manufacturer FROM {$wpdb->prefix}ae"), 1);
									sort($results);
									foreach ($results as $row) {
										echo "<option>" . $row->manufacturer . "</option>";
									}
									?>
								</datalist>
							</div>
							<div class="aircraft-option-container">
								<label for="body-type">Body Type</label><br>
								<input list="body-type" name="body_type" tabindex="0"/>
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
							<div class="aircraft-option-container">
								<label for="maximum-seats">Maximum Seats</label><br>
								<input list="maximum-seats" name="maximum_seats" tabindex="0"/>
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
					</div>
					<br>
					<!-- Second Row -->
					<div class="row justify-center">
						<div class="aircraft-options">
							<div class="aircraft-option-container">
								<label for="engine-type">Engine Type</label><br>
								<input list="engine-type" name="engine_type" tabindex="0"/>
								<datalist id="engine-type">
									<option>Electric</option>
									<option>Jet</option>
									<option>Piston</option>
									<option>Turboprop/Turboshaft</option>
								</datalist>
							</div>
								<div class="aircraft-option-container">
								<label for="engine-count">Engine Count</label><br>

									<input list="ec-1" name="ec1" tabindex="0"/>
									<datalist id="ec-1">
										<option>0</option>
										<option>1</option>
									</datalist>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row" style="justify-content: center">
					<input class="submit-btn" type="submit" name="submitbtn" tabindex="0">
				</div>
			</form>
		</section>	
		<?php
		if (isset($_POST['submitbtn'])) {
			// collecting the data on submitting the button
			global $wpdb;
			$aircraft_type = $_POST['aircraft_type'];
			$aircraft_category = $_POST['aircraft_category'];
			$engine_manufacturer = $_POST['engine_manufacturer'];
			$aircraft_manufacturer = $_POST['aircraft_manufacturer'];
			$body_type = $_POST['body_type'];
			$maximum_seats = $_POST['maximum_seats'];
			$engine_type = $_POST['engine_type'];
			$engine_count = $_POST['ec1'] . $_POST['ec2'];
			$query = "SELECT * FROM {$wpdb->prefix}ae WHERE ";
			$subqueries = [];
			// if conditions to check if the values are not empty and add part of
			// an sql query to the main one
			if (!empty($aircraft_type)) {
				$subquery = "aircraft_type=\"$aircraft_type\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($aircraft_category)) {
				$subquery = "aircraft_category=\"$aircraft_category\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($engine_manufacturer)) {
				$subquery = "engine_manufacturer=\"$engine_manufacturer\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($aircraft_manufacturer)) {
				$subquery = "manufacturer=\"$aircraft_manufacturer\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($body_type)) {
				$subquery = "body_type=\"$body_type\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($maximum_seats)) {
				$subquery = "max_seats=\"$maximum_seats\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($engine_type)) {
				$subquery = "engine_type=\"$engine_type\" ";
				array_push($subqueries, $subquery);
			}
			if (!empty($engine_count)) {
				$subquery = "engine_count=\"$engine_count\" ";
				array_push($subqueries, $subquery);
			}
			$fq = join("AND ", $subqueries);
			$results = $wpdb->get_results($query . $fq);
		}
		?>
		<div class="table">
		<table class="table-results" id="results-table">
			<tr class="no-border">
				<th style="background-color: var(--blue2)">Model</th>
				<th style="background-color: var(--red2)">Manufacturer</th>
				<th style="background-color: var(--red3)">Engine Manufacturer</th>
				<th style="background-color: var(--red4)">Engine Model</th>
				<th style="background-color: var(--blue2)">Description</th>
				<th style="background-color: var(--red2)">Max Seats</th>
				<th style="background-color: var(--red3)">Body Type</th>
			</tr>
			<?php for ($i = 0; $i < count($results); $i++) : ?>
				<tr data-bs-toggle='collapse' data-bs-target=<?= '#demo' . strval($i); ?> class='accordion-toggle results results-display'>
					<td><?= $results[$i]->model; ?></td>
					<td><?= $results[$i]->manufacturer; ?></td>
					<td><?= $results[$i]->engine_manufacturer; ?></td>
					<td><?= $results[$i]->engine_model; ?></td>
					<td><?= $results[$i]->description; ?></td>
					<td><?= $results[$i]->max_seats; ?></td>
					<td><?= $results[$i]->body_type; ?></td>
				</tr>
				<tr class="no-border">
					<td colspan='7' class="grey-bg">
						<div class='container'>
							<div class='accordion-body collapse' id=<?= 'demo' . strval($i); ?>>
								<div class='row'>
									<div class='col-md-8' style="margin-bottom:10px;">
										<p style='font-size:20px;color:#C67E93;text-transform:lowercase;margin-bottom:10px;'>Engine Models</p>
										<p style='padding: 5px; background-color:#FFFFFF; width:25%'><?= $results[$i]->engine_model; ?></p>
										<br>
									</div>
									<div class='col-md-4'>
									</div>
								</div>
								<div class='row'>
									<div class='col-md-3'>
										<p style='font-size:20px; color:#44B5B1;text-transform:lowercase;'>Aircraft Type</p>
										<p style='color:#44B5B1; font-size:32px'><?= $results[$i]->aircraft_type; ?></p>
										<p style='color:grey; font-size:15px; text-transform:lowercase; '><?= $results[$i]->aircraft_category; ?></p>
									</div>
									<div class='col-md-3'>
										<p style='font-size:20px; color:#C06E86;text-transform:lowercase;'>Max. Seats</p>
										<p style='color: #C06E86; font-size:32px'><?= $results[$i]->max_seats; ?></p>
									</div>
									<div class='col-md-3'>
										<p style='font-size:20px; color:#877495;text-transform:lowercase;'>Aircraft Category</p>
										<p style='color:#877495; font-size:32px;text-transform:lowercase;;'><?= $results[$i]->aircraft_category; ?></p>
									</div>
									<div class='col-md-3'>
									</div>
								</div>
								<div class='row aircraft-description'>
									<div class='col-md-3'>
										<p style='font-size:12px;color:#6F5980;text-transform:lowercase;'>Aircraft Description</p>
										<p style='color:#6F5980; font-size:60px;font-weight:bolder;'><?= $results[$i]->description; ?></p>
									</div>
									<div class='col-md-3 aircraft-description-part'>
										<div class="large-letter">
											<p class="align-center" style='font-weight:bolder;'><?= substr($results[$i]->aircraft_category, 0, 1); ?></p>
										</div>
											<p class="align-center" style="text-transform:lowercase;font-size:20px; margin-left:15px"><?= $results[$i]->aircraft_category; ?></p>
									</div>
									<div class='col-md-3 aircraft-description-part'>
										<div class="large-letter">
											<p class="align-center" style='font-weight:bolder;'><?= $results[$i]->engine_count ?></p>
										</div>	
											<p class="align-center" style="text-transform:lowercase;font-size:20px; margin-left:15px"><?= $results[$i]->engine_count . " engine(s)"; ?></p>
									</div>
									<div class='col-md-3 aircraft-description-part'>
										<div class="large-letter" style='font-weight:bolder;'>
											<p class="align-center"><?= substr($results[$i]->engine_type, 0, 1); ?></p>
										</div>	
											<p class="align-center" style="text-transform:lowercase;font-size:20px; margin-left:15px"><?= $results[$i]->engine_type; ?></p>
									</div>
								</div>
							</div>
					</td>
				</tr>
			<?php endfor; ?>
		</table>
		</div>
	</body>
