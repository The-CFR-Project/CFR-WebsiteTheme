<?php
$post = get_page_by_path("meet-the-team");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>
<section id="meet-the-team">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/aboutus-css/meettheteam.css"); </style>

  <div class="meet-the-team-container container">

    <div class="heading-container">
      <?php echo "<div class='heading-overlay'>" . $post->post_title . "</div>";?>
    </div>

    <?php
    $leads = $doc->query("//h1");
	$leadroles = $doc->query("//h4");
	$cores = $doc->query("//h2");
    $coreroles = $doc->query("//h5");
    $memes = $doc->query("//h3");
	$imgs = $doc->query("//p");
	
	function create_divs($names, $class, $roles, $imgs, $start_i){
		$out = "";
		for ($i=0; $i< count($names); $i++){
			$html_1 = "<div class='" . $class . "'>\n\t<div>\n\t\t<div>\n\t\t\t<img class='dp' src='" . get_template_directory_uri() . "/assets/images/member-pics/" . $imgs[$start_i + $i]->nodeValue . "'></div>\n\t\t\t<div>\n\t\t\t\t<div><h6>" . $names[$i]->nodeValue . "</h6></div>";
			if ($roles){ $html_1 .= "<div><p>" . $roles[$i]->nodeValue . "</p></div>"; }
			$html_2 = "\n\t\t\t</div>\n\t\t</div>\n\t</div>\n";
			$out .= $html_1 . $html_2;
		}
		return $out;
	}
	
	echo '<div class="row large-row">' . create_divs($leads, "col-md-3", $leadroles, $imgs, 0) . "</div>";
	echo '<div class="row medium-row">' . create_divs($cores, "col-md-3", $coreroles, $imgs, count($leads)) . "</div>";
	echo '<div class="row small-row"><a class="arrow prev" onclick="changememe(memes, -1);">❮</a>' . create_divs($memes, "col-md-2", false, $imgs, count($leads) + count($cores)) . "<a class='arrow next' onclick='changememe(memes, 1);'>❯</a></div>";
	?>
  </div>
</section>
<script type = "text/javascript">
//meet the team on mobiles
const memes = Array.from(document.getElementsByClassName("col-md-2"));
var curr = 0;
var l = memes.length;
var to_rotate = false;
var changed = 0;
function nextmeme(memes, n){
	memes[curr].style.display = "none";
	curr += n;
	if (curr >= l){
		curr = 0;
	}else if (curr < 0){
		curr = l-1;
	}
	memes[curr].style.display = "block";
}
function changememe(memes, n){ nextmeme(memes, n); changed += 1; }
function autorotate(){
	if (to_rotate) {
		if (changed === 0){
			nextmeme(memes, 1);
		}else {changed = 0;}
		setTimeout(autorotate, 4000);
	}
}
function all_visible(memes){
	memes.forEach(meme => meme.style.display = "block");
}
function all_hidden(memes){
	memes.forEach(meme => meme.style.display = "none");
}
if (window.matchMedia("(max-width: 980px)").matches){
	to_rotate = true;
	autorotate();
}
var smallwin = window.matchMedia("(max-width: 980px)");
smallwin.addEventListener('change',function (e){
	if (e.matches) { all_hidden(memes); to_rotate = true; autorotate(); }
	else {all_visible(memes); to_rotate = false;}
});
let touchstartX = 0;
let touchendX = 0;

const slider = document.getElementsByClassName('small-row')[0];

function handleGesture() {
	if (touchendX < touchstartX){ //left swipe
		changememe(memes, -1);
	}
	if (touchendX > touchstartX){
		changememe(memes, 1);
	}
}
slider.addEventListener('touchstart', e => {
  touchstartX = e.changedTouches[0].screenX;
})
/*slider.addEventListener('touchmove', e => {
	console.log(e.changedTouches[0].screenX);
	let px = e.changedTouches[0].screenX - touchstartX;
	slider.style.transform = "translateX(" + px + "px)" ;
})*/
slider.addEventListener('touchend', e => {
  touchendX = e.changedTouches[0].screenX;
  handleGesture();
})

</script>
