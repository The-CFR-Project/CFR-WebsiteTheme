<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta http-equiv="Cache-control" content="no-cache"> -->
	<title><?php
		if ($args['title']){
			echo $args['title'];
		}
		else{
			echo "The CFR Project";
		}
		?></title>

	<?php wp_head();?>

</head>
<!-- <body onscroll="$('.nav-container').collapse('hide')"> -->
<body>	
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P4GJH55"
				  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<style rel = "preload" type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/header.css"); </style>
<header id = "topnav">
	<div class="nav-header-container">
		<div class="nav-logo-container">

			<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			?>

			<a href="<?php echo home_url();?>">
				<img class="logo" src="<?php echo $image[0];?>" alt="">
			</a>

		</div>

		<div class="nav-title-container">

		  <a href="<?php echo home_url();?>">
			<h1 class="green1"  id = "navbar-title">The Carbon Footprint Reduction Project</h1>
		  </a>

		</div>
	</div>
	<div id = "hamburger-container"><button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target=".nav-container" id = "hamburger">≡</button></div>
	<div class="nav-container">
	<?php
	  wp_nav_menu(
		array(
			"theme_location" => "nav-bar",
			"menu_class" => "nav-bar"
		)
	  );
	?>

	</div>
</header>

<script  type='text/javascript'>
var $ = jQuery;
var m = window.matchMedia("(max-width: 1000px)");
function f(x) {
	if(x.matches){ // If screen is small
		$("#navbar-title").html("CFR Project");
		$("#menu-navigation-bar")[0].id = "mobile-nav-container";
		$(".nav-container").addClass("collapse");
	}else{
		$("#navbar-title").html("The Carbon Footprint Reduction Project");
		try{
			$("#mobile-nav-container")[0].id = "menu-navigation-bar";
			$(".nav-container").removeClass("collapse");
		}catch{}
	}
}
f(m);
m.addListener(f);
</script>
