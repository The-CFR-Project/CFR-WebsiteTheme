<section>
  <div class="instawall-section-container container-fluid">

    <div class="heading-container">
    <?php $post = get_posts( array( "category_name" => "Instawall") )[0];
          echo "<div class='heading-overlay'>" . $post->post_title . "</div>";?>
    </div>

    <?php echo apply_filters( 'the_content', $post->post_content );?>

    <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/images/instarock.svg">

  </div>
</section>
