<?php
	global $post;
	$sol = $post->post_name;
?>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<?php
/*$fields = get_fields();
$formula = strtolower(get_field('gco2'));
foreach ($_POST as $field => $val){
	//$formula = str_replace($field, "\$fields[\$$field]", $formula);
	${$field} = $val;
}
//echo $formula;
eval("echo $formula;");*/
switch ($sol){
	case "air-conditioner":
		$gwps = [
					"r22" => 1810,
					"r32" => 675,
					"r410a" => 2088,
					"r134a" => 1300
				];
		echo round(floatval($_POST["refcharge"])* $gwps[strtolower($_POST["refrigerant"])] * floatval($_POST["leakage"] / 100) * floatval($_POST["t"] / 8760) * floatval($_POST["numunits"]), 5);
		break;
}
?>

<?php else: ?>

<?php get_header();?>

<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/model-house-css/single-model-house.css");</style>

<section id = "solution-section">
	<?php get_template_part("template-parts/model-house/section", $sol); ?>
</section>

<script type = "text/javascript">
$(".model-house-form>input,.model-house-form>select").on("input", function(e) {
	e.preventDefault();
	var form = $(".model-house-form");
	var url = form.attr("action");
	$.post(url, form.serialize(), function(data){
		$(".calculation-result").text(data);
	});
});
</script>

<?php get_footer();?>

<?php endif ?>
