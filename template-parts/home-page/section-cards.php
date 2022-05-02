<section id="fact-cards">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/cards.css"); </style>
  <div class="container-border-components container-fluid">
    <div class="heading-container">
      <div class='heading-overlay cards-heading heading-overlay-grey'>wanna play cards?</div>
    </div>

    <!-- Background images and formatting -->
    <div class="border-components-row">

      <div class="edge-row">
        <div>
          <img src="<?php echo get_template_directory_uri();?>/assets/images/card-icons/cards-border.svg" class='cards-bg-border'>
        </div>

        <div class="middle-col">
        </div>

        <div>
          <img src="<?php echo get_template_directory_uri();?>/assets/images/card-icons/cfr-scrabble.svg" class="cards-bg-scrabble">
        </div>
      </div>

      <div class="middle-row">
        <div class="align-self-center">
          <img src="<?php echo get_template_directory_uri();?>/assets/images/card-icons/discs.svg" class="cards-bg-discs">
        </div>

        <div class="middle-col" id = "middle-col">

            <?php
            $i = 0;
            $d = 0;
            $h = 0;

            $all_cards = array();
            foreach (get_posts( array('numberposts' => -1, 'post_type' => 'cfr_facts') ) as $post) {
                array_push($all_cards, apply_filters( 'the_content', $post->post_content ) );
            }

            $numbers = range( 0, count( $all_cards ));
            $displayed_cards = array_slice( $numbers, 0, 8 );

            $card_suits = array("♥", "♠", "♣", "♦");
            $card_icon_colors = array('35b0ab', '246b81', '004c65', 'f67280', 'c06c84', '6f5980', '3d2451');

            foreach ( $all_cards as $card ) {
              if ( in_array( $i, $displayed_cards )){
                  $rand_suit = $card_suits[ array_rand( $card_suits ) ];
                  $rand_color = $card_icon_colors[ array_rand( $card_icon_colors ) ];
                  $d++;
                  ?>
                  <div class='fact-card-display' id='<?php echo $d?>-dis-card' style='z-index: "<?php echo $d?>"'>
                    <div class='card-suits' style='text-shadow: 0 0 0 #<?php echo $rand_color?>'>
                        <?php echo $rand_suit;?>
                    </div>
                    <div class='card-suits-down' style='text-shadow: 0 0 0 #<?php echo $rand_color?>'>
                        <?php echo $rand_suit;?>
                    </div>
                    <img src='<?php echo get_template_directory_uri()?>/assets/images/card-icons/CFR-logo.png' class='card-bg-logo'>
                    <div class='card-heading' style='color: #<?php echo $rand_color?>'>Did you know?</div>
                    <div class='card-content'>
                      <?php echo $card?>
                    </div>
                    <input type="button" class="cards-focusin-input">
                  </div>

              <?php } else {
                  $rand_suit = $card_suits[ array_rand( $card_suits ) ];
                  $rand_color = $card_icon_colors[ array_rand( $card_icon_colors ) ];
                  $h++;
                  ?>
                  <div class='fact-card-hidden' id='<?php echo $h;?>-hid-card'>
                    <div class='card-suits' style='text-shadow: 0 0 0 #<?php echo $rand_color?>'>
                        <?php echo $rand_suit;?>
                      </div>
                    <div class='card-suits-down' style='text-shadow: 0 0 0 #<?php echo $rand_color?>'>
                          <?php echo $rand_suit;?>
                      </div>
                    <img src='<?php echo get_template_directory_uri()?>/assets/images/card-icons/CFR-logo.png' class='card-bg-logo'>
                    <div class='card-heading' style='color: #<?php echo $rand_color?>'>Did you know?</div>
                    <div class='card-content'>
                       <?php echo $card?>
                    </div>
                  </div>
                    <?php
              }
              $i++;
            }
          ?>

        </div>

        <div class="align-self-center">
          <div class="magic-ball-container">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/card-icons/magic-5-ball.svg" class="cards-bg-magic-5">
          </div>
        </div>
      </div>

      <div class="edge-row">
        <div>
          <img src="<?php echo get_template_directory_uri();?>/assets/images/card-icons/stationary.svg" class="cards-bg-stationary">
        </div>

        <div class="middle-col">
        </div>

        <div>
          <img src="<?php echo get_template_directory_uri();?>/assets/images/card-icons/dices.svg" class="cards-bg-dices">
        </div>
      </div>

    </div>

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/cards.js"></script>

  </div>
</section>
