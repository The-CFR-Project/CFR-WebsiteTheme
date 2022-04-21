<div id = "air-conditioner">
	<h3>Calculate the emissions from your air conditioner, and get tips on how to reduce them!</h3>
	<form class="form-inline model-house-form" action="/model-house/air-conditioner" method = "post">
		<label for = "refcharge">Refrigerant charge: </label>
		<input type = "text" name = "refcharge" value = 0.7 id = "refcharge">
		
		<label for = "refrigerant">Refrigerant name: </label>
		<select name = "refrigerant" list = "refrigerants" id = "refrigerant">
			<option value = "r22">R22</option>
			<option value = "r32">R32</option>
			<option value = "r410a">R410A</option>
			<option value = "r134a">R134A</option>
		</select>
		<label for = "leakage">Leakage (percentage): </label>
		<input type = "text" name = "leakage" value = 30 id = "leakage">
		
		<label for = "t">Time unit is used for in a year: </label>
		<input type = "text" name = "t" value = 8760 id = "t">
		
		<label for = "numunits">Number of AC units: </label>
		<input type = "text" name = "numunits" value = 1 id = "numunits">
		
		<button type = "submit" class="btn btn-default calculate-btn">Calculate</button>
	</form>
	Calculated carbon dioxide emissions (in grams): <div class = "calculation-result"></div>
</div>
