<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The CFR Project</title>

    <?php wp_head();?>

</head>
<body>

<header>
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
        <h1 class="green1">The Carbon Footprint Reduction Project</h1>
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

<div class="nav-bar-translucent-rectangle">
</div>

<div class="container-fluid">
