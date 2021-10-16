<?php
$post = get_page_by_path("faqs");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id='faqs'>
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/homepage-css/faqs.css"); </style>
  <div class="faq-container container-fluid">

    <div class="heading-container">
    <?php
      echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
      echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
    ?>
    </div>

    <form id="faq-form">
    </form>

    <div class="row faq-accordion">
      <div class='col-md-6'>
        <?php
        $i = 0;

        $questions = $doc->query("//h3");
        $answers = $doc->query("//p");

        foreach ( $questions as $question ) {
          if ( $i == intdiv( sizeof( $questions ), 2 ) ) {
            echo "</div>";
            echo "<div class='col-md-6'>";
          }

          echo "  <div class='faq-accordion-item' id='question" . $i . "'>";
          echo "    <input type='checkbox' form='faq-form' class='faq-accordion-checkbox' id='faq-checkbox" . $i . "'/>";
          echo "      <label class='faq-accordion-btn' for='faq-checkbox" . $i . "'>";
          echo "        <p class='faq-accordion-link' href='#question" . $i . "'>";
          echo            $question->nodeValue;?>

                          <img class="plus-icon" src="<?php echo get_template_directory_uri()?>/images/plus.svg">
                          <img class="minus-icon" src="<?php echo get_template_directory_uri()?>/images/minus.svg">
          <?php
          echo "        </p>";

          echo "        <div class='faq-answer'>";
          echo "          <p class='text-justify'>";
          echo              $answers[$i]->nodeValue;
          echo "        </div>";
          echo "      </label>";
          echo "  </div>";

          $i += 1;
        }
        ?>
      </div>
    </div>

  </div>
</section>
