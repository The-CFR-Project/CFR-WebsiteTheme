<section>
  <div class="home-post container-fluid">
    <div class="heading-container">
    <?php
      $post = get_posts( array( "category_name" => "Home ost 1") )[0];
      echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
      echo "<div class='heading-watermark'>" . get_the_tags($post->ID)[0]->name . "</div>";
    ?>
      <img src="<?php echo get_template_directory_uri();?>/images/flight-symbol.svg">
    </div>

    <?php
      $doc = new DOMDocument();
      $doc->loadHTML(apply_filters( 'the_content', $post->post_content ));
      $doc = new DOMXPath($doc);
    ?>

    <form action="<?php echo $doc->query('//ol/li')[1]->nodeValue;?>">
      <input type="submit" value="<?php echo $doc->query('//ol/li')[0]->nodeValue;?>">
    </form>

    <div class="full-row">
      <img src="<?php echo get_template_directory_uri();?>/images/balloon2.svg">
    </div>

    <div class="row">

      <div class="col-md-6">
        <div>
          <a href="<?php echo $doc->query('//ol/li')[2]->nodeValue;?>">
            <div></div>
          </a>
        </div>

        <img src="<?php echo get_template_directory_uri();?>/images/balloon1.svg">
      </div>

      <div class="col-md-6 col-para">
        <?php
        $firstp = true;
        foreach ($doc->query('//p') as $node) {
          echo ($firstp ? "<p>" : "<br><br><p>") . $node->nodeValue . "</p>";
          $firstp = false;
        }?>
        <a href="<?php echo get_permalink( $post )?>">Read More</a>
      </div>

      <div class="background-image">
        <img src="<?php echo get_template_directory_uri();?>/images/flight-watermark.svg">
      </div>

    </div>

  </div>
</section>
