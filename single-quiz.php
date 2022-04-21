<?php
get_header('cfrtheme', ['title' => 'Quiz - The CFR Project']);
$title = get_the_title();
?>
<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/quiz-css/single-quiz.css");</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class = "container-fluid">
	<img src = "<?php echo get_field('banner-img')['url']; ?>">
	<div class = "pageheader">
		<h5>
			CFR Project Quiz | <?php echo get_the_date("j F Y"); ?>
		</h5>
		<h3 id = "quiztitle">
			<?php echo $title; ?>
		</h3>
	</div>
	<div id = "sharelinks">
		<button class = "btn fa fa-twitter"></button>
		<button class = "btn fa fa-facebook"></button>
		<button class = "btn fa fa-link"></button>
	</div>
</div>
<div id="link-copied-alert" style="display: none;">
	<strong>Link Copied To Clipboard!</strong>
	<span class="closebtn" onclick="this.parentElement.style.display='none';">×</span>
</div>
<?php
$questions = [];
for ($i = 1; $i < 10; $i++){
	if (get_field("q".$i)){
		$questions[$i-1] = [get_field("q".$i), explode("//", get_field("opt".$i)), get_field("corr".$i), get_field("exp".$i)];
	}
	else{
		break;
	}
}
?>
<div class = "quiz">
	<h4 id="quiz-tt">
		<?php echo $title; ?>
	</h4>
	<div class = "row">
		<span id ="nqs">START</span>
			<div class="col"><hr id = "hr-1"></div>
			<div class = "col-md-auto dots" style = "text-align:center;padding: 1px 0px 10px 0px">
			&ensp;
			<?php for ($n = 0; $n < $i-1; $n++){
				echo '<span class = "dot"></span>&ensp;';
			}
			?>
			</div>
			<div class = "col"><hr id = "hr-2"></div>
	</div>
	<div class = "start-quiz">
		<div class = "d-flex">
			<div id = "repr">
				<img src = "<?php echo get_field('repr-img')['url']; ?>">
			</div>
			<div id = "description">
				<?php echo get_field("quiz_desc"); ?><br>
			</div>
		</div>
		<div class = "btn-container text-center">
			<button id = "start-btn" class = "btn btn-danger button">START QUIZ</button>
			<br>
			<div class = "btntext"><?php echo $i-1; ?> questions</div>
		</div>
	</div>
	<div class = "questions">
		<?php foreach ($questions as $nq => $question): ?>
			<div class = 'question'>
				<div class = "qtext">
					<?php echo $question[0]; ?>
				</div>
				<br>
				<?php $lets = ["a", "b", "c", "d"];
				foreach ($question[1] as $n => $opt): ?>
					<div class = 'opt-container <?php
					if ($lets[$n] == $question[2]) { echo ' corr'; };?>'>
					<span class = "let"><?php echo $lets[$n] ; ?></span>	
					<span class = 'option'><?php echo $opt; ?></span>
					</div>
				<?php endforeach; ?>
				<div class = "exp">
					<?php
						echo $question[3];
					?>
				</div>
				<div class = "btn-container">
					<button class = "nextbtn btn btn-dark">NEXT</button>
				</div>
				<div class = "qsleft btntext">
					<?php
						$qsleft = $i-2-$nq;
						echo $qsleft . " ";
						if ($qsleft == 1){
							echo "question left";
						}
						else{
							echo "questions left";
						}
					?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div id = "end-quiz" class = "">
		<div id = "chart-container" class = "col-md-3">
			<canvas id="scorechart"></canvas>
			<div id = "scorepercentage"></div>
		</div>
		<div id = "end-msg" class = "col-md-9">
			<h3 style = "color: #fc6;"></h3>
			<div id = "score-msg">
				You got <span id = "nqs-corr"></span> out of <?php echo $i-1; ?> questions right
			</div>
			<div class = "btn-container" style = "padding-top:30px;">
				<button class = "btn btn-dark" style = "background-color:#013444;" onclick = "window.location.reload();">
					RETAKE
				</button>
				<a class = "btn btn-dark" style = "background-color:#fc6;margin-left:10px;" href = "/">FINISH</a>
			</div>
		</div>
	</div>
</div>
<script type = "text/javascript">
var sharetxt = "Take this quiz on the CFR Project Website: " + $("#quiztitle").text();
$(document).ready(function(){
	$(".fa-twitter").click(function(){
		window.open("http://twitter.com/share?text=" + sharetxt + "&url=" + encodeURIComponent(window.location.href));
	});
	$(".fa-facebook").click(function(){
		window.open("https://www.facebook.com/sharer.php?u=" + encodeURIComponent(window.location.href));
	});
	$(".fa-link").click(function(){
		navigator.clipboard.writeText(window.location.href);
		$("#link-copied-alert").show();
	});
});
const len = $(".question").length;
var score = 0;
let qs = $(".question");
var n = 0;
var msgs = [
	"Better luck next time!",
	"Good effort!",
	"You're almost there!",
	"Well done!",
	"Well done!"
];
var colours = [
	"#f67280",
	"#fc6",
	"#88d172",
	"#88d172"
];
$("#start-btn").on("click", function (e){
	$(".start-quiz").hide();
	qs[0].className = "question current";
	n=0;
	$("#quiz-tt").text($(".current>.qtext").text());
	$("#nqs").text("1/" + len);
});
console.log("N: "+n);
const dots = $(".dot");
$(".option").on("click", function (){
	if (!$(".current").hasClass("attempted") && !$(".current").hasClass("trans")){
		$(".current").addClass("trans");
		$(this).parent().addClass("clicked");
		if ($(this).parent().hasClass("corr")){
			console.log("L");
			dots[n].className = "dot green";
			score++;
		}
		else{
			dots[n].className = "dot red";
		}
		setTimeout(function (){
			$(".current").removeClass("trans");
			$(".current").addClass("attempted");
			console.log("N: "+n);
			n++;
		}, 1000);
	}
})
$(".nextbtn").click(function (e){
	if (n !== len){
		$(".current").removeClass("current");
		qs[n].className += " current";
		$("#nqs").text(n+1 + "/3");
		$("#quiz-tt").text($(".current>.qtext").text());
		if (n === len-1){
			$(".nextbtn").text("FINISH");
			$(".qsleft").hide();
		}
	}
	else{
		var colour = colours[Math.ceil(3 * score / len) -1];
		if (score !== 0){
			var colour2 = 'rgb(1, 52, 68)';
		}
		else{
			colour = "#f67280";
			var colour2 = '#f67280';
		}
		$("#quiz-tt").text($("#quiztitle").text());
		$("#nqs").text("FINISH");
		$("#nqs-corr").text(score);
		$("#end-msg>h3").text(msgs[Math.floor(4 * score / len)]);
		$(".questions").hide();
		$("#end-quiz").addClass("show");
		$("#scorepercentage").text((score / len * 100).toFixed(2) + "%");
		$("#scorepercentage")[0].style.color = colour;
		$("#end-msg>h3")[0].style.color = colour;
		$("#end-msg a").css("background-color", colour);
		$(".score").text(score + "/" + len);
		const data = {
			labels: [
				'Correct',
				'Incorrect'
			],
			datasets: [{
				data: [score, len-score],
				backgroundColor: [
					colour,
					colour2,
				],
				hoverOffset: 4
			}]
		};
		const config = {
			type: 'doughnut',
			data: data,
			options: {
				plugins: {
					legend: {
						display: false
					},
					tooltip: {
						enabled: false,
					}
				},
				rotation: -90,
				circumference: 180,
				maintainAspectRatio: false,
			},
		};
		var myChart = new Chart(
			document.getElementById('scorechart'),
			config
		);
	}
});
</script>
<?php
get_footer();
?>
