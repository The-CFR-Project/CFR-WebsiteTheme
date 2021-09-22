<section>
  <div class="faq-container container-fluid">

    <div class="heading-container">
    <?php
      $post = get_posts( array( "category_name" => "Home Post 2 ") )[0];
      echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
      echo "<div class='heading-watermark'>" . get_the_tags($post->ID)[0]->name . "</div>";
    ?>
    </div>

    <form id="faq-form">
    </form>

    <div class="row faq-accordion">
      <div class='col-md-6'>
        <?php
        $doc = new DOMDocument();
        $doc->loadHTML(apply_filters( 'the_content', $post->post_content ));
        $doc = new DOMXPath($doc);

        $i = 0;
        $questions = $doc->query("//p");
        foreach ( $questions as $element) {
          if ($i == intdiv(sizeof($questions), 2)) {
            echo "</div>";
            echo "<div class='col-md-6'>";
          }

          if ($i % 2 == 0) {
            echo "  <div class='faq-accordion-item' id='question" . intdiv($i, 2) . "'>";
            echo "    <input type='checkbox' form='faq-form' class='faq-accordion-checkbox' id='faq-checkbox" . intdiv($i, 2) . "'/>";
            echo "      <label class='faq-accordion-btn' for='faq-checkbox" . intdiv($i, 2) . "'>";
            echo "        <p class='faq-accordion-link' href='#question" . intdiv($i,  2) . "'>";
            echo            $element->nodeValue;?>

                            <img class="plus-icon" src="<?php echo get_template_directory_uri()?>/images/plus.svg">
                            <img class="minus-icon" src="<?php echo get_template_directory_uri()?>/images/minus.svg">
          <?php
            echo "        </p>";
          }
          else { // is Answer
            echo "        <div class='faq-answer'>";
            echo "          <p class='text-justify'>";
            echo              $element->nodeValue;
            echo "        </div>";
            echo "      </label>";
            echo "  </div>";
          }

          $i += 1;
        }
        ?>
      </div>
    </div>

  </div>
</section>
