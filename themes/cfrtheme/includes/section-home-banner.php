  <div class="header-slideshow-container">

  <?php

  $bannerItems = wp_get_nav_menu_items(get_nav_menu_locations()['home-banner']);

  $i = 0;
  foreach ( $bannerItems as $navItem ) {
  ?>
    <div class="header-slide quick-fade">
      <img src="<?php echo get_template_directory_uri();?>/images/header-slideshow-image<?php echo $i?>.jpg">

      <div>
        <h3><?php echo $navItem->title;?></h3>

        <form action=<?php echo $navItem->url;?>>
          <input type="submit" value="Read More" />
        </form>

      </div>

    </div>

  <?php
    $i += 1;
    if ($i > 3) {
      $i = 0;
    }
  }
  ?>

    <a class="prev-slide" onclick="changeHeaderSlideshow(-1)">&#10094;</a>
    <a class="next-slide" onclick="changeHeaderSlideshow(1)">&#10095;</a>

    <div class="slideshow-dots-container">
    <?php for ($i = 0; $i < sizeof($bannerItems); $i++) {?>
      <span class="header-slideshow-dot<?php echo ($i == 0) ? ' header-slideshow-dot-active' : '';?>"
        onclick="setHeaderSlideshow(<?php echo $i;?>)"></span>
    <?php }?>
    </div>

    <script>
      var headerSlideIndex = 0;

      setHeaderSlideshow(headerSlideIndex);

      function changeHeaderSlideshow(n) {
        setHeaderSlideshow(headerSlideIndex + n);
      }

      function setHeaderSlideshow(n) {
        var i;
        var headerSlides = document.getElementsByClassName("header-slide");
        var headerSlideDots = document.getElementsByClassName("header-slideshow-dot");

        if (n >= headerSlides.length) {
          headerSlideIndex = 0;
        }
        else if (n < 0) {
          headerSlideIndex = headerSlides.length - 1;
        }
        else {
          headerSlideIndex = n;
        }

        for (i = 0; i < headerSlides.length; i++) {
          headerSlides[i].style.display = "none";
          headerSlideDots[i].className = "header-slideshow-dot";
        }

        headerSlides[headerSlideIndex].style.display = "block";
        headerSlideDots[headerSlideIndex].className += " header-slideshow-dot-active";
      }

    </script>

  </div>
