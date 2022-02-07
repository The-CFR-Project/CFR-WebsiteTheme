<section id="blogs-carousel">
<div class="header-slideshow-container">
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/home-banner.css"); </style>
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/blog-carousel.css"); </style>
  <?php

  $category_id = get_cat_ID('Banner-Blogs');
  $q = 'cat=' . $category_id;
  $bannerItems = (query_posts($q));






  $i = 0;
  while (have_posts()) : the_post();
  ?>
    <div class="header-slide quick-fade">

      <?php if(has_post_thumbnail()): ?>
        <img class="archive-carousel-image" src="<?php echo the_post_thumbnail_url(); ?>">
      <?php endif; ?>
      <div id="blogs-archive-slide-text">
        <a href = "<?php the_permalink(); ?>"><h1><?php the_title();?></h1></a>
        <p><?php echo the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>" class="readmore">
          <h4 class="special-underline read-more-precious">Read More</h4>
          <div class="blogs-carousel-readmore-arrow-line"></div>
          <div class="blogs-carousel-readmore-arrow"></div>
        </a>
      </div>

    </div>

  <?php
    $i += 1;
    if ($i > (count($bannerItems)-1)) {
      $i = 0;
    }
  endwhile;

  ?>


    <a class="prev-slide" onclick="changeHeaderSlideshow(-1)">&#10094;</a>
    <a class="next-slide" onclick="changeHeaderSlideshow(1)">&#10095;</a>

    <div class="slideshow-dots-container">
    <?php for ($i = 0; $i < sizeof($bannerItems); $i++) {?>
      <button class="header-slideshow-dot<?php echo ($i == 0) ? ' header-slideshow-dot-active' : '';?>"
        onclick="setHeaderSlideshow(<?php echo $i;?>)"></button>
    <?php }?>
    </div>

    <script>
      var headerSlideIndex = 0;
      var resetCarousel = 0;

      reloadSlideshow(headerSlideIndex);
      carousel();

      function changeHeaderSlideshow(n) {
        reloadSlideshow(headerSlideIndex + n);
        resetCarousel = 2;
      }

      function setHeaderSlideshow(n) {
        reloadSlideshow(n);
        resetCarousel = 2;
      }

      function reloadSlideshow(n) {
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

      function carousel() {
        if (resetCarousel > 0) {
          resetCarousel -= 1;
        }
        else if (document.activeElement.id != "read-more") {
          reloadSlideshow(headerSlideIndex + 1);
        }
        setTimeout(carousel, 6000); // Change image every 4 seconds
      }

    </script>

  </div>
</section>
