<section>
  <div class="cards-section-container container-fluid">
    <div class="heading-container">
    <?php
      $post = get_posts( array( "category_name" => "Cards Post") )[0];
      echo "<div class='heading-overlay cards-heading'>" . $post->post_title . "</div>";
    ?>
    </div>

    <!-- Background images and formatting -->
    <div class="card-rows">

      <div class="card-edge-row">
        <div>
          <img src="<?php echo get_template_directory_uri();?>/images/card-icons/cards-border.svg" class='cards-bg-border'>
        </div>

        <div class="card-middle-col">
        </div>

        <div>
          <img src="<?php echo get_template_directory_uri();?>/images/card-icons/cfr-scrabble.svg" class="cards-bg-scrabble">
        </div>
      </div>

      <div class="card-middle-row">
        <div>
          <img src="<?php echo get_template_directory_uri();?>/images/card-icons/discs.svg" class="cards-bg-discs">
        </div>

        <div class="card-middle-col">
            <?php
            $doc = new DOMDocument();
            $doc->loadHTML(apply_filters( 'the_content', $post->post_content ));
            $doc = new DOMXPath($doc);

            $i = 0;
            $cards = $doc->query("//p");

            
            foreach ( $cards as $card) {
              
              
              if ($i % 2 == 0) { // Card Title
                echo ("<div class='Card' id=' card".(($i/2)+1)."' style='left:".($i * 26)."px'>");
                echo $card->nodeValue;
                echo "<br>";
              }
              else { // Card Content
                echo $card->nodeValue;
                echo "</div>";
              }
              

              $i += 1;
            }
            

            ?>
        </div>

        <div>
          <img src="<?php echo get_template_directory_uri();?>/images/card-icons/magic-5-ball.svg" class="cards-bg-magic-5">
        </div>
      </div>

      <div class="card-edge-row">
        <div>
          <img src="<?php echo get_template_directory_uri();?>/images/card-icons/stationary.svg" class="cards-bg-stationary">
        </div>
        
        <div class="card-middle-col">
        </div>

        <div>
          <img src="<?php echo get_template_directory_uri();?>/images/card-icons/dices.svg" class="cards-bg-dices">
        </div>
      </div>

    </div>



    <div class="cards-body">
        
    </div>



  </div>
</section>

<!------------------------------------- JavaScript ------------------------------------->

