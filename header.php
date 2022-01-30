<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-control" content="no-cache">
	<title>The CFR Project</title>

	<?php wp_head();?>

</head>
<body onscroll="document.getElementById('sidenav').className='hide collapse';">
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/header.css"); </style>
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
<div id = "sidenav" class = "collapse hide">
	<div class = "mobile-nav-container" id = "mobile-nav-container"></div>
</div>
<div class="container-fluid">
