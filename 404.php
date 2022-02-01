<?php get_header();?>

<div class="nav-bar-blue-rectangle">
</div>

<section>
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/404.css"); </style>
  <div class="main-404-container instawall-section-container container">
    <div class="row">
      <div class="col-md-6 align-self-center">
        <img class="beagle" src="<?php echo get_template_directory_uri();?>/assets/images/beagle.png">
      </div>

      <div class="col-md-6 align-self-center">
        <div class="main-text-404 blue2">
          <h1>404</h1>
        </div>
        <div>
          <p class="grey4">Oops! Blubby can't find the page you're looking for!</p>
        </div>
      </div>
    </div>

  </div>

  <div class="instawall-section-container container-fluid">
    <div class="bedrock-container">
      <div>
        <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/404rock.svg">
      </div>
    </div>
  </div>
</section>

<?php get_footer();?>
