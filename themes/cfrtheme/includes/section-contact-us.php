<?php
$post = get_page_by_path("contact-us");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="contact-us">
  <div class="contact-us-container">

    <div class="heading-container">
    <?php
      echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
      echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
    ?>
    </div>

  </div>
</section>
