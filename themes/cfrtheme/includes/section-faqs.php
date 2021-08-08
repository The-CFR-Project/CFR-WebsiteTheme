<section>
  <div class="home-post container-fluid">

    <div class="heading-container">
    <?php
      $post = get_posts( array( "category_name" => "Home Post 2 ") )[0];
      echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
      echo "<div class='heading-watermark'>" . get_the_tags($post->ID)[0]->name . "</div>";
    ?>
    </div>

  </div>
</section>
