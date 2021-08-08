<section>
  <div class="cards-section-container container-fluid">

    <div class="heading-container">
    <?php
      $post = get_posts( array( "category_name" => "Cards Post") )[0];
      echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
    ?>
    </div>

  </div>
</section>
