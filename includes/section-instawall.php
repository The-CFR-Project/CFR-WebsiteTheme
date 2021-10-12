<?php
$post = get_page_by_path("social-introverts");
?>

<section>
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/homepage-css/instawall.css"); </style>
  <div class="instawall-section-container container-fluid">

    <div class="heading-container">
      <?php echo "<div class='heading-overlay'>" . $post->post_title . "</div>";?>
    </div>

    <?php echo apply_filters( 'the_content', $post->post_content );?>

    <div class="bedrock-container">
      <div>
        <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/images/instarock.svg">
      </div>
    </div>

  </div>
</section>
