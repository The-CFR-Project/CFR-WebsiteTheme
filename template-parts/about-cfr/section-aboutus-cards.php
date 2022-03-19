<?php
$post = get_page_by_path("about-us-cards");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="fact-cards">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/cards.css"); </style>
  <div class="container-border-components container-fluid">
    <div class="heading-container">
      <?php echo "<div class='heading-overlay cards-heading'>wanna play cards?</div>";?>
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

            $all_cards = $doc->query( "//p" );
            $numbers = range( 0, ( count( $all_cards ) / 2 - 1));
            // shuffle( $numbers );
            $displayed_cards = array_slice( $numbers, 0, 8 );

            $card_suits = array("♥", "♠", "♣", "♦");
            // $card_icon_colors = array('9B72AA', 'BD4B4B', 'DF711B',
            //                           '368B85', '3DB2FF', 'FFF47D');
            $card_icon_colors = array('35b0ab', '246b81', '004c65', 'f67280', 'c06c84', '6f5980', '3d2451');

            foreach ( $all_cards as $card ) {

              if ( in_array( intdiv( $i, 2 ), $displayed_cards )){

                if ( $i % 2 == 0 ) { // Card Title
                  $rand_suit = $card_suits[ array_rand( $card_suits ) ];
                  $rand_color = $card_icon_colors[ array_rand( $card_icon_colors ) ];

                  echo "<div class='fact-card-display' id='" . ( $d + 1 ) . "-dis-card' style='z-index: " . ( $d + 1 ) . "'>";

                  echo "<div class='card-suits' style='text-shadow: 0 0 0 #" . $rand_color . "'>";
                  echo    $rand_suit;
                  echo "</div>";

                  echo "<div class='card-suits-down' style='text-shadow: 0 0 0 #" . $rand_color . "'>";
                  echo    $rand_suit;
                  echo "</div>";

                  echo "<img src='".get_template_directory_uri()."/assets/images/card-icons/CFR-logo.png' class='card-bg-logo'>";

                  echo "<div class='card-heading' style='color: #" . $rand_color . "'>";
                  echo    $card->nodeValue;
                  echo "</div>";
                }
                else { // Card Content

                  echo   "<div class='card-content'>";
                  echo     $card->nodeValue;
                  echo   "</div>";
                  echo  '<input type="button" class="cards-focusin-input">';
                  echo "</div>";

                  $d++;
                }

              }
              else {
                if ( $i % 2 == 0 ) { // Card Title

                  $rand_suit = $card_suits[ array_rand( $card_suits ) ];
                  $rand_color = $card_icon_colors[ array_rand( $card_icon_colors ) ];

                  echo ("<div class='fact-card-hidden' id='" . ( $h + 1 ) . "-hid-card'>");

                  echo "<div class='card-suits' style='text-shadow: 0 0 0 #" . $rand_color . "'>";
                  echo    $rand_suit;
                  echo "</div>";

                  echo "<div class='card-suits-down' style='text-shadow: 0 0 0 #" . $rand_color . "'>";
                  echo    $rand_suit;
                  echo "</div>";

                  echo "<img src='".get_template_directory_uri()."/assets/images/card-icons/CFR-logo.png' class='card-bg-logo'>";

                  echo "<div class='card-heading' style='color: #" . $rand_color . "'>";
                  echo    $card->nodeValue;
                  echo "</div>";

                }
                else { // Card Content
                  echo    "<div class='card-content'>";
                  echo      $card->nodeValue;
                  echo    "</div>";
                  echo "</div>";

                  $h++;
                }
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
    

  <!-- JavaScript ------------------------------------->

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/cards.js"></script>


  </div>
</section>